#include <ESP_SR.h>
#include <esp32-hal-sr.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <WiFiManager.h>
#include <UniversalTelegramBot.h>
#include <WiFiClientSecure.h>

#define buzzer 25
#define MQ135_PIN 34

LiquidCrystal_I2C lcd(0x27, 16, 2); // Ganti 0x27 dengan alamat I2C yang benar jika berbeda

const char* host = "192.168.0.107"; // Alamat IP komputer atau URL webhost

// Telegram Bot Config
const char* BOT_TOKEN = "8080823584:AAGWLIHVj0O3WSI_Eolu47baCc8T4a7d_gg";
const String CHAT_ID = "6300109027";

WiFiClientSecure client;
UniversalTelegramBot bot(BOT_TOKEN, client);

void setup() {
  pinMode(buzzer, OUTPUT);

  // Inisialisasi LCD
  lcd.init();
  lcd.backlight();
  lcd.setCursor(0, 0);
  lcd.print("MQ-135 Sensor");

  // Inisialisasi Serial Monitor
  Serial.begin(115200);
  delay(1000);
  lcd.clear();

  // Inisialisasi WiFiManager
  WiFiManager wm;

  // Menjalankan portal Wi-Fi Manager untuk menghubungkan Wi-Fi
  if (!wm.autoConnect("Esp32", "12345678")) {  // Nama SSID dan PASSWORD dari AP Esp32 
    Serial.println("Gagal Terhubung ke WiFi");
    lcd.print("WiFi Failed!");
    delay(1000);
    ESP.restart();  // Restart ESP jika gagal
  }

  // Jika terhubung
  Serial.println("Terhubung ke WiFi");
  lcd.setCursor(0, 0);
  lcd.print("WiFi Connected");
  delay(2000);  // Beri jeda agar pesan dapat terbaca

  client.setCACert(TELEGRAM_CERTIFICATE_ROOT); // Diperlukan untuk HTTPS
}

void loop() {
  // Baca nilai dari sensor MQ-135
  int mq135Value = analogRead(MQ135_PIN);
  float voltage = mq135Value * (3.3 / 4095.0);
  float Gas = mq135Value * 0.04;

  // Menampilkan nilai di Serial Monitor
  Serial.print("MQ-135 Value: ");
  Serial.println(Gas);
  Serial.print("Voltage: ");
  Serial.println(voltage);

  // Menampilkan nilai pada LCD
  lcd.setCursor(0, 0);
  lcd.print("Gas Level: ");
  lcd.print(Gas);
  lcd.setCursor(0, 1);
  lcd.print("Voltage: ");
  lcd.print(voltage, 2); // Tampilkan 2 digit desimal

  // Aktifkan buzzer jika gas level melebihi ambang batas 
  if (Gas > 100) {
    digitalWrite(buzzer, HIGH);
    delay(300);
    digitalWrite(buzzer, LOW);
    delay(300);

    // Kirim notifikasi ke Telegram
    String message = "Peringatan! Level gas melebihi batas aman.\nGas Level: " + String(Gas) + "\nVoltage: " + String(voltage, 2);
    bot.sendMessage(CHAT_ID, message, "");
    Serial.println("Notifikasi Telegram dikirim.");
  }
  
  else {
    digitalWrite(buzzer, LOW);
  }

  // Koneksi ke server lokal
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;
    String Link = "http://" + String(host) + "/SensorMQ135/kirimdata.php?Gas=" + String(Gas);
    http.begin(Link);

    int httpResponseCode = http.GET();
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.print("Response: ");
      Serial.println(response);
    } else {
      Serial.print("Error in HTTP request, code: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  }

  // Tunggu 1 detik sebelum pembacaan berikutnya
  delay(1000);
}
