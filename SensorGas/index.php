<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Sensor MQ135</title>

    <!-- jQuery -->
    <script type="text/javascript" src="jquery/jquery.min.js"></script>

    <!-- Load otomatis -->
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function() {
          $("#cekgas").load("cekgas.php");
        }, 1000);
      });
    </script>

    <style>
      body, html {
        height: 100%;
        margin: 0;
      }
      .container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }
      .card {
        width: 60%;
      }
      img {
        margin-top: 10px; /* Mengatur jarak dari card */
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 400px;
        height: auto;
      }
      body {
        background-image: url('images/background.jpeg'); /* Lokasi gambar */
        background-size: cover; /* Agar gambar memenuhi seluruh halaman */
        background-position: center; /* Agar gambar berada di tengah */
        background-repeat: no-repeat; /* Agar gambar tidak berulang */
      }
    </style>
  </head>
  <body>
    <div class="container" style="text-align: center;">
      <h2>Monitoring Kebocoran Gas <br> Dengan Sensor MQ135</h2>
      <!-- Tampilan untuk data sensor -->
      <div class="card text-center">
        <div class="card-header" style="font-size: 30px; font-weight: bold; background-color: blue; color: white">
          Nilai Gas
        </div>
        <div class="card-body">
          <h1> <span id="cekgas"> 0 </span> </h1>
        </div>
      </div>
      <img src="images/SistemKomputer.png" width="500" height="200">
    </div>
    
    <!-- Optional JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>
