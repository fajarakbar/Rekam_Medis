<?php
// Load file koneksi.php
include "koneksi.php";
session_start();

if ($_SESSION['akses'] ==  "petugas") {
  $link = "http://localhost:8080/klinik_sehat/login_petugas.php";
}
elseif ($_SESSION['akses'] ==  "admin") {
  $link = "http://localhost:8080/klinik_sehat/login_admin.php";
}
?>

<html>
<head>
  <link rel="icon" href="img/ikon.ico" type="image/ico">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Button used to open the contact form - fixed at the bottom of the page */
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  right: 28px;
  width: 280px;
}

/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>
    <title>Data Rekam Medis</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/resume.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugin/jquery-ui/jquery-ui.min.css" /> <!-- Load file css jquery-ui -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script> <!-- Load file jquery -->
</head>
<body id="page-top">
  <!-- <nav clas="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color:#35a82d"="sideNav">
    <a class="navbar-brand js-scroll-trigger" href="#page-top">
    <span class="d-block d-lg-none">Data Rekam Medis</span>
  </a>
  </nav> -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color:#35a82d" id="sideNav">
    <a class="navbar-brand js-scroll-trigger" href="#page-top">
      <span class="d-block d-lg-none">Klinik Sehat</span>
      <span class="d-none d-lg-block">
        <?php
          $user = $_SESSION['username'];
          $result_user  = mysqli_query($conn, "SELECT nama FROM tb_petugas WHERE username = '$user'");
          while ($row = $result_user-> fetch_assoc()) {
         ?>
        <span class="btn btn-success"><marquee>Selamat Datang Petugas : <?php echo $row['nama'];} ?>  </marquee></span><br><br>
        <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="img/logo1.png" alt="">
      </span>
    </a>
    <br>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#tampil">Tampil Data Rekam Medis</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#isidata">Isi Data Rekam Medis</a>
        </li>
        <li class="nav-item">
          <!-- <a class="btn btn-danger js-scroll-trigger" href="#logout">Log Out</a> -->
        </li>
      </ul>
    </div>
  </nav>
    <h2>Data Rekam Medis</h2><hr>

    <form method="get" action="">
        <label>Filter Berdasarkan</label><br>
        <select name="filter" id="filter">
            <option value="">Pilih</option>
            <option value="2">Per Bulan</option>
            <option val1ue="3">Per Tahun</option>
        </select>
        <br /><br/>

        <div id="form-bulan">
            <label>Bulan</label><br>
            <select name="bulan">
                <option value="">Pilih</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            <br /><br />
        </div>

        <div id="form-tahun">
            <label>Tahun</label><br>
            <select name="tahun">
                <option value="">Pilih</option>
                <?php
                $query = "SELECT YEAR(tgl_masuk) AS tahun FROM tb_rekam_medis GROUP BY YEAR(tgl_masuk)"; // Tampilkan tahun sesuai di tabel transaksi
                $sql = mysqli_query($conn, $query); // Eksekusi/Jalankan query dari variabel $query

                while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
                    echo '<option value="'.$data['tahun'].'">'.$data['tahun'].'</option>';
                }
                ?>
            </select>
            <br /><br />
        </div>

        <button type="submit">Tampilkan</button>
        <a href="report.php">Reset Filter</a>
        <!-- <button type="submit">Kembali</button> -->
        <a href="<?php echo $link; ?>" >Kembali</a>
    </form>
    <hr />

    <?php
    if(isset($_GET['filter']) && ! empty($_GET['filter'])){ // Cek apakah user telah memilih filter dan klik tombol tampilkan
      $filter = $_GET['filter']; // Ambil data filder yang dipilih user

      if($filter == '2'){ // Jika filter nya 2 (per bulan)
            $nama_bulan = array('', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

            echo '<b>Data Rekam Medis Bulan '.$nama_bulan[$_GET['bulan']].' '.$_GET['tahun'].'</b><br /><br />';
            echo '<a href="print.php?filter=2&bulan='.$_GET['bulan'].'&tahun='.$_GET['tahun'].'">Cetak PDF</a><br /><br />';

            $query = "SELECT * FROM tb_rekam_medis WHERE MONTH(tgl_masuk)='".$_GET['bulan']."' AND YEAR(tgl_masuk)='".$_GET['tahun']."'"; // Tampilkan data transaksi sesuai bulan dan tahun yang diinput oleh user pada filter
        }else{ // Jika filter nya 3 (per tahun)
            echo '<b>Data Rekam Medis Tahun '.$_GET['tahun'].'</b><br /><br />';
            echo '<a href="print.php?filter=3&tahun='.$_GET['tahun'].'">Cetak PDF</a><br /><br />';

            $query = "SELECT * FROM tb_rekam_medis WHERE YEAR(tgl_masuk)='".$_GET['tahun']."'"; // Tampilkan data transaksi sesuai tahun yang diinput oleh user pada filter
        }
    }else{ // Jika user tidak mengklik tombol tampilkan
        echo '<b>Semua Data Rekam Madis</b><br /><br />';
        echo '<a href="print.php">Cetak PDF</a><br /><br />';

        $query = "SELECT * FROM tb_rekam_medis ORDER BY tgl_masuk"; // Tampilkan semua data transaksi diurutkan berdasarkan tanggal
    }
    ?>
<div class="container-fluid p-0">
  <hr class="m-0">
  <section class="resume-section p-3 p-lg-5 d-flex flex-column" id="tampil">
  <div class="myy-auto">
    <table border="1" cellspacing="0" cellpadding="8">
      <thead class="bg-dark">
    <!-- <tr> -->
      <th>TANGGAL</th>
      <th>REKAM MEDIS</th>
      <th>NAMA</th>
      <th>DIAGNOSA</th>
      <th>TINDAKAN</th>
      <th>POLI</th>
      <th>DOKTER</th>
    </thead>
    <!-- </tr> -->

    <?php
    $sql = mysqli_query($conn, $query); // Eksekusi/Jalankan query dari variabel $query
    $row = mysqli_num_rows($sql); // Ambil jumlah data dari hasil eksekusi $sql

    if($row > 0){ // Jika jumlah data lebih dari 0 (Berarti jika data ada)
        while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
            $tgl = date('d-M-Y', strtotime($data['tgl_masuk'])); // Ubah format tanggal jadi dd-mm-yyyy

            echo "<tr>";
            echo "<td>".$data['tgl_masuk']."</td>";
            echo "<td>".$data['rm_lama']."</td>";
            echo "<td>".$data['nama_pasien']."</td>";
            echo "<td>".$data['diagnosa']."</td>";
            echo "<td>".$data['tindakan']."</td>";
            echo "<td>".$data['poli']."</td>";
            echo "<td>".$data['dokter']."</td>";
            echo "</tr>";
        }
    }else{ // Jika data tidak ada
        echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
    }
    ?>
    </table>
  </div>
</section>
  </div>

    <script>
    $(document).ready(function(){ // Ketika halaman selesai di load
        $('.input-tanggal').datepicker({
            dateFormat: 'yy-mm-dd' // Set format tanggalnya jadi yyyy-mm-dd
        });

        $('#form-tanggal, #form-bulan, #form-tahun').hide(); // Sebagai default kita sembunyikan form filter tanggal, bulan & tahunnya

        $('#filter').change(function(){ // Ketika user memilih filter
            if($(this).val() == '1'){ // Jika filter nya 1 (per tanggal)
                $('#form-bulan, #form-tahun').hide(); // Sembunyikan form bulan dan tahun
                $('#form-tanggal').show(); // Tampilkan form tanggal
            }else if($(this).val() == '2'){ // Jika filter nya 2 (per bulan)
                $('#form-tanggal').hide(); // Sembunyikan form tanggal
                $('#form-bulan, #form-tahun').show(); // Tampilkan form bulan dan tahun
            }else{ // Jika filternya 3 (per tahun)
                $('#form-tanggal, #form-bulan').hide(); // Sembunyikan form tanggal dan bulan
                $('#form-tahun').show(); // Tampilkan form tahun
            }

            $('#form-tanggal input, #form-bulan select, #form-tahun select').val(''); // Clear data pada textbox tanggal, combobox bulan & tahun
        })
    })
    </script>
    <script src="plugin/jquery-ui/jquery-ui.min.js"></script> <!-- Load file plugin js jquery-ui -->
</body>
</html>
