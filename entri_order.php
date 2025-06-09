<!DOCTYPE html>

<?php
include "database/koneksi.php";
session_start();
ob_start();

$id = $_SESSION['id_user'];

if(isset($_SESSION['edit_menu'])){
  echo $_SESSION['edit_menu'];
  unset($_SESSION['edit_menu']);

}

if(isset ($_SESSION['username'])){
  
  $query = "select * from tb_user natural join tb_level where id_user = $id";

  mysqli_query($conn, $query);
  $sql = mysqli_query($conn, $query);

  while($r = mysqli_fetch_array($sql)){
    
    $nama_user = $r['nama_user'];

?>

<html lang="en">
<head>
<title>Entri Order</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="template/dashboard/css/bootstrap.min.css" />
<link rel="stylesheet" href="template/dashboard/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="template/dashboard/css/fullcalendar.css" />
<link rel="stylesheet" href="template/dashboard/css/matrix-style.css" />
<link rel="stylesheet" href="template/dashboard/css/matrix-media.css" />
<link href="template/dashboard/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="template/dashboard/css/jquery.gritter.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<style>
:root {
            --primary-dark: #2c3e50; /* Dark Blue Gray */
            --primary-medium: #34495e; /* Medium Blue Gray */
            --primary-light: #f4f7f6; /* Off-white / Light Gray */
            --accent-blue: #3498db; /* Bright Blue */
            --accent-green: #2ecc71; /* Emerald Green */
            --accent-orange: #e67e22; /* Carrot Orange */
            --accent-red: #e74c3c; /* Alizarin Red */
            --accent-purple: #9b59b6; /* Amethyst Purple */
            --text-light: #ffffff;
            --text-dark: #333333;
            --border-light: #e0e0e0;
            --card-bg: #ffffff;
            --border-radius: 8px;
            --box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Softer, larger shadow */
            --transition-speed: 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--primary-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* General Adjustments for better spacing and typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            color: var(--text-dark);
        }
        a {
            text-decoration: none;
            color: var(--accent-blue);
            transition: color var(--transition-speed);
        }
        a:hover {
            color: #2980b9;
        }

        /* Header */
        #header {
            background-color: var(--primary-dark) !important;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            height: 60px; /* Consistent height */
            box-shadow: var(--box-shadow);
            z-index: 1000; /* Ensure it's on top */
            position: relative;
        }
        #header img {
            height: 40px; /* Adjusted logo size, now more appropriate */
            width: auto;
            margin-right: 10px; /* Mengurangi margin sedikit */
        }
        /* Custom .brand styling for the logo text */
        #header a.brand {
            font-size: 24px; /* Ukuran font standar */
            font-weight: 700;
            color: var(--text-light);
            margin: 0;
            white-space: nowrap; /* Prevent text wrapping */
            display: flex; /* Use flexbox for logo and text alignment */
            align-items: center;
            flex-shrink: 0; /* Pastikan brand tidak menyusut terlalu banyak */
            padding-right: 5px; /* Tambahkan sedikit padding kanan agar tidak terlalu mepet */
        }
        #header a.brand span {
            margin-left: 0; /* Mengurangi margin-left jika sebelumnya ada negatif */
            font-size: 22px; /* Coba kurangi ukuran font untuk teks di dalam span */
        }


        /* User Navigation */
        #user-nav {
            background-color: var(--primary-dark) !important;
            border-bottom: 1px solid var(--primary-medium);
            position: absolute; /* Position relative to header */
            right: 0;
            top: 0;
            height: 100%;
            display: flex;
            align-items: center;
            padding-right: 20px;
        }
        #user-nav .nav > li > a {
            color: var(--primary-light) !important;
            transition: background-color var(--transition-speed), color var(--transition-speed);
            padding: 10px 15px;
            line-height: 20px;
            font-size: 14px;
        }
        #user-nav .nav > li > a:hover, #user-nav .nav > li.open > a {
            background-color: var(--primary-medium) !important;
            color: var(--text-light) !important;
            border-radius: var(--border-radius);
        }
        #user-nav .dropdown-menu {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow);
            margin-top: 10px;
            padding: 5px 0;
        }
        #user-nav .dropdown-menu li > a {
            color: var(--text-dark) !important;
            padding: 8px 15px;
            transition: background-color var(--transition-speed), color var(--transition-speed);
            display: block;
        }
        #user-nav .dropdown-menu li > a:hover {
            background-color: var(--accent-blue) !important;
            color: var(--text-light) !important;
            border-radius: var(--border-radius);
        }
        #user-nav .dropdown-menu .divider {
            margin: 5px 0;
            border-top: 1px solid var(--border-light);
        }

        /* Sidebar */
        #sidebar {
            background-color: var(--primary-dark);
            width: 220px; /* Fixed width */
            position: fixed;
            top: 60px; /* Below header */
            left: 0;
            bottom: 0;
            padding-top: 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto; /* Scrollable sidebar */
            z-index: 999;
        }
        #sidebar > ul {
            list-style: none;
            padding: 0;
            margin: 0;
            border-bottom: none;
        }
        #sidebar > ul > li {
            border-top: 1px solid var(--primary-medium);
            border-bottom: none;
            position: relative;
        }
        #sidebar > ul > li:first-child {
            border-top: none;
        }
        #sidebar > ul > li > a {
            color: var(--text-light);
            padding: 15px 20px;
            display: block;
            font-size: 15px;
            transition: background-color var(--transition-speed), border-left var(--transition-speed), color var(--transition-speed);
            border-left: 5px solid transparent; /* Prepare for active border */
            position: relative;
        }
        #sidebar > ul > li > a > .icon {
            color: var(--text-light);
            font-size: 18px;
            margin-right: 15px;
            width: 20px; /* Align icons */
            text-align: center;
        }
        #sidebar > ul > li.active > a {
            background-color: var(--primary-medium);
            color: var(--text-light);
            border-left: 5px solid var(--accent-blue); /* Stronger active indicator */
        }
        #sidebar > ul > li > a:hover {
            background-color: var(--primary-medium);
            color: var(--text-light);
            border-left: 5px solid var(--accent-blue);
        }
        #sidebar > a.visible-phone {
            display: none; /* Hide default mobile toggle button */
        }

        /* Content Area */
        #content {
            margin-left: 220px; /* Offset by sidebar width */
            padding: 20px;
            padding-top: 80px; /* Space for fixed header */
            transition: margin-left var(--transition-speed);
        }

        /* Content Header */
        #content-header {
            background-color: var(--card-bg);
            padding: 20px 25px;
            border-bottom: 1px solid var(--border-light);
            margin-bottom: 25px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap; /* Allow wrapping on smaller screens */
        }
        #content-header h1 {
            font-size: 28px;
            color: var(--text-dark);
            margin: 0;
            flex-grow: 1;
        }
        #breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
            text-align: right;
            line-height: 28px; /* Align with h1 */
        }
        #breadcrumb a {
            color: #777;
            text-decoration: none;
            font-size: 14px;
        }
        #breadcrumb a:hover {
            color: var(--accent-blue);
        }
        #breadcrumb .current {
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Widget Box / Card */
        .widget-box {
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 25px;
            border: none;
            background-color: var(--card-bg);
            overflow: hidden;
        }
        .widget-title {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-light);
            padding: 15px 20px;
            font-size: 18px;
            color: var(--text-dark);
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        .widget-title .icon {
            margin-right: 12px;
            font-size: 20px;
            color: var(--accent-blue);
        }
        .widget-title.bg_lg {
            background-color: var(--accent-green) !important;
            color: var(--text-light);
            border-bottom: none;
        }
        .widget-title.bg_lg .icon {
            color: var(--text-light);
        }
        .widget-content {
            padding: 20px;
        }
        .widget-content.nopadding {
            padding: 0;
        }

        /* Quick Actions / Stats Boxes */
        /* Tidak diperlukan di entri_referensi, tapi tetap disertakan untuk konsistensi CSS */
        .quick-actions {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px; /* Gap between grid items */
            justify-content: center; /* Center items if they don't fill the row */
        }
        .quick-actions li {
            padding: 25px;
            border-radius: var(--border-radius);
            text-align: center;
            color: var(--text-light);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform var(--transition-speed), box-shadow var(--transition-speed);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 120px; /* Minimum height for consistency */
        }
        .quick-actions li:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .quick-actions li .icon {
            font-size: 42px;
            margin-bottom: 10px;
            opacity: 0.95;
            display: block;
        }
        .quick-actions li strong {
            display: block;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
            line-height: 1;
        }
        .quick-actions li small {
            font-size: 15px;
            opacity: 0.9;
        }
        /* Custom Colors for Quick Actions */
        .bg_lb { background-color: #5DADE2 !important; } /* Light Blue */
        .bg_ly { background-color: #F8C471 !important; } /* Light Yellow-Orange */
        .bg_lg { background-color: #58D68D !important; } /* Light Green */
        .bg_ls { background-color: #EC7063 !important; } /* Light Red-ish */
        .bg_lo { background-color: #AF7AC5 !important; } /* Light Purple-ish */

        /* Table Styling */
        .table {
            width: 100%;
            border-collapse: separate; /* Use separate for border-radius on cells if needed */
            border-spacing: 0; /* Remove default cell spacing */
            border-radius: var(--border-radius);
            overflow: hidden; /* Ensures rounded corners are applied */
            box-shadow: var(--box-shadow);
        }
        .table thead th {
            background-color: var(--primary-medium); /* Darker header */
            color: var(--text-light);
            font-weight: 600;
            padding: 15px 20px;
            text-align: left;
            border-bottom: none; /* No individual bottom borders on header */
        }
        .table tbody td {
            padding: 12px 20px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-light); /* Only bottom border for rows */
            background-color: var(--card-bg);
        }
        .table tbody tr:last-child td {
            border-bottom: none; /* No border on last row */
        }
        .table-striped tbody tr:nth-of-type(odd) td {
            background-color: #f9fbfb; /* Slightly different background for odd rows */
        }
        .table tbody tr:hover td {
            background-color: #eef1f3;
            transition: background-color 0.2s ease;
        }
        .table .btn-mini {
            padding: 6px 12px;
            font-size: 13px;
            border-radius: 5px;
            margin-right: 5px; /* Space between buttons */
        }
        .table .label {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 12px;
        }

        /* Buttons */
        .btn {
            border-radius: 5px;
            transition: all var(--transition-speed);
            border: none;
            color: white !important;
            padding: 8px 15px;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-warning { background-color: var(--accent-orange); }
        .btn-warning:hover { background-color: #d66c1f; }
        .btn-info { background-color: var(--accent-blue); }
        .btn-info:hover { background-color: #2980b9; }
        .btn-danger { background-color: var(--accent-red); }
        .btn-danger:hover { background-color: #c0392b; }
        .btn-success { background-color: var(--accent-green); }
        .btn-success:hover { background-color: #27ae60; }


        /* Alert Styling */
        .alert-orange {
            background-color: #fff3e0; /* Very light orange */
            color: #e65100; /* Darker orange text */
            border: 1px solid #ffb74d; /* Medium orange border */
            padding: 25px;
            border-radius: var(--border-radius);
            text-align: center;
            box-shadow: var(--box-shadow);
            font-size: 16px;
        }
        .alert-orange h4 {
            color: #e65100;
            margin-bottom: 15px;
            font-size: 28px;
            font-weight: 700;
        }

        /* Footer */
        #footer {
            background-color: var(--card-bg);
            border-top: 1px solid var(--border-light);
            padding: 20px 0;
            color: #777;
            text-align: center;
            margin-top: 40px;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            box-shadow: 0 -2px 8px rgba(0,0,0,0.05);
        }

        /* Thumbnail / Gambar Makanan - DISINI PERUBAHAN UTAMANYA */
        .thumbnails {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); /* Responsive grid for items */
            gap: 25px; /* Spacing between grid items */
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .thumbnails li {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden; /* Ensure rounded corners */
            transition: transform var(--transition-speed), box-shadow var(--transition-speed);
            position: relative;
            display: flex; /* Use flexbox for inner content */
            flex-direction: column; /* Stack content vertically */
            min-height: 420px; /* Menentukan tinggi minimum kartu, pertahankan ini */
        }
        .thumbnails li:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .thumbnails li img {
            width: 100%;
            height: 180px; /* Fixed height for consistency */
            object-fit: cover; /* Cover the area, crop if necessary */
            border-bottom: 1px solid var(--border-light);
        }
        /* Hapus styling untuk .thumbnails li .actions */
        /* .thumbnails li .actions {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 180px;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity var(--transition-speed);
        }
        .thumbnails li:hover .actions {
            opacity: 1;
        } */
        .thumbnails li .table {
            margin-bottom: 0; /* Remove margin-bottom from table */
            border-radius: 0; /* Remove top border radius */
            box-shadow: none; /* Remove shadow */
            border: none;
            flex-grow: 1; /* Pastikan tabel mengisi ruang vertikal yang tersedia */
            width: 100%; /* Penting: Pastikan tabel mengisi lebar penuh */
            display: flex; /* Gunakan flexbox untuk mengatur baris tabel */
            flex-direction: column; /* Tata letak baris secara vertikal */
        }
        .thumbnails li .table tbody {
            display: flex; /* Gunakan flexbox untuk tbody juga */
            flex-direction: column; /* Tata letak baris tbody secara vertikal */
            flex-grow: 1; /* Biarkan tbody tumbuh untuk mengisi ruang */
        }
        .thumbnails li .table tbody tr {
            display: flex; /* Gunakan flexbox untuk setiap baris */
            flex-wrap: wrap; /* Izinkan konten baris untuk membungkus jika terlalu panjang */
            /* Add this to distribute vertical space within rows if needed */
            /* align-items: stretch; */ 
        }
        .thumbnails li .table tbody td {
            padding: 8px 15px;
            border-bottom: 1px solid var(--border-light);
            vertical-align: top;
            flex-grow: 1; /* Biarkan td tumbuh mengisi ruang horizontal */
            /* If you want specific columns to have fixed widths, adjust flex-grow or add width */
        }
        .thumbnails li .table tbody tr:first-child td {
            font-weight: 600;
            font-size: 1.1em;
            padding-top: 15px;
            padding-bottom: 10px;
            text-align: center; /* Pusatkan nama masakan */
            width: 100%; /* Pastikan nama masakan mengambil seluruh lebar baris */
        }
        .thumbnails li .table tbody tr:nth-child(2) td,
        .thumbnails li .table tbody tr:nth-child(3) td {
            width: 50%; /* Bagi dua kolom untuk harga dan stok */
            box-sizing: border-box; /* Pastikan padding tidak membuat lebar melebihi 50% */
            /* Add vertical-align: middle; if you want content within these cells to be vertically centered */
            vertical-align: middle;
        }
        .thumbnails li .table tbody tr:last-child td {
            border-bottom: none;
            text-align: center; /* Pusatkan tombol Lihat Gambar */
            width: 100%; /* Pastikan tombol mengambil seluruh lebar baris */
            padding-bottom: 15px; /* Add padding to the last row before buttons */
        }
        /* Styling untuk tombol Lihat yang baru */
        .thumbnails li .btn-lihat {
            display: inline-block;
            padding: 6px 12px;
            font-size: 13px;
            border-radius: 5px;
            background-color: var(--accent-blue);
            color: var(--text-light) !important;
            text-align: center;
            transition: background-color var(--transition-speed);
            margin-top: 5px;
        }
        .thumbnails li .btn-lihat:hover {
            background-color: #2980b9;
        }

        .thumbnails li form {
            padding: 15px;
            display: flex;
            justify-content: center;
            gap: 10px;
            border-top: 1px solid var(--border-light);
            margin-top: auto; /* PENTING: Mendorong form ke bawah */
            width: 100%; /* Pastikan form mengambil lebar penuh */
            box-sizing: border-box; /* Sertakan padding dalam lebar */
        }


        /* Responsive adjustments */
        @media (max-width: 767px) {
            body { padding-left: 0 !important; } /* Remove body padding */
            #sidebar {
                left: -220px; /* Hide sidebar by default */
                transition: left var(--transition-speed);
            }
            #sidebar.visible {
                left: 0; /* Show sidebar when toggled */
            }
            #content {
                margin-left: 0; /* No left margin on mobile */
                padding-top: 70px; /* Adjust for header */
            }
            #header {
                padding: 10px;
                justify-content: space-between;
            }
            #header img {
                height: 35px; /* Slightly smaller logo on mobile */
                margin-right: 8px; /* Mengurangi margin lebih lanjut untuk mobile */
            }
            #header a.brand {
                font-size: 18px; /* Lebih kecil lagi di mobile */
                flex-grow: 1; /* Allow brand to take available space */
                text-align: left;
                padding-right: 0;
            }
            #header a.brand span {
                font-size: 16px; /* Font teks di dalam span lebih kecil lagi untuk mobile */
            }
            #user-nav {
                position: static; /* Allow user-nav to flow */
                height: auto;
                padding-right: 0;
                /* On small screens, hide full user-nav and let toggle handle it */
                display: none;
            }
            /* Add a mobile menu toggle button */
            #header .toggle-sidebar {
                display: block;
                color: var(--text-light);
                font-size: 24px;
                cursor: pointer;
                margin-right: 15px;
            }
            .thumbnails {
                grid-template-columns: 1fr; /* Single column on very small screens */
            }
            .thumbnails li {
                min-height: auto; /* Reset min-height for mobile if needed, or adjust */
            }
        }
        @media (min-width: 768px) {
            #header .toggle-sidebar {
                display: none; /* Hide toggle button on desktop */
            }
            #user-nav {
                display: flex; /* Ensure user-nav is visible on desktop */
            }
        }
    </style>
</head>
<body>

<div id="header">
    <a href="#" class="toggle-sidebar"><i class="icon-reorder"></i></a> <a class="brand" href="beranda.php">
        <img src="template/masuk/images/logo_warmindo.png" alt="Logo Warkom">
        <span>Warkom</span>
    </a>
    <div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav">
            <li class="dropdown" id="profile-messages">
                <a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle">
                    <i class="icon icon-user"></i>
                    <span class="text">Welcome <?php echo $r['nama_user'];?></span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#"><i class="icon-info-sign"></i> <?php echo "&nbsp;&nbsp;".$r['nama_level'];?></a></li>
                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="icon-key"></i> Log Out</a></li>
                </ul>
            </li>
            <li class="">
                <a title="" href="logout.php">
                    <i class="icon icon-share-alt"></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<!--close-top-serch-->
<!--sidebar-menu-->
<div id="sidebar"><a href="entri_order.php" class="visible-phone"><i class="icon shopping-cart"></i> <span>Entri Order</span></a>
  <ul>
    <?php
    if($r['id_level'] == 1){
  ?>
    <li> <a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li> <a href="entri_referensi.php"><i class="icon icon-tasks"></i> <span>Entri Referensi</span></a> </li>
    <li class="active"> <a href="entri_order.php"><i class="icon icon-shopping-cart"></i> <span>Entri Order</span></a> </li>
    <li> <a href="entri_transaksi.php"><i class="icon icon-inbox"></i> <span>Entri Transaksi</span></a> </li>
    <li> <a href="generate_laporan.php"><i class="icon icon-print"></i> <span>Generate Laporan</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    } else if($r['id_level'] == 2){
  ?>
    <li><a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li class="active"> <a href="entri_order.php"><i class="icon icon-shopping-cart"></i> <span>Entri Order</span></a> </li>
    <li> <a href="generate_laporan.php"><i class="icon icon-print"></i> <span>Generate Laporan</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    } else if($r['id_level'] == 3){
  ?>
    <li><a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li> <a href="entri_transaksi.php"><i class="icon icon-inbox"></i> <span>Entri Transaksi</span></a> </li>
    <li> <a href="generate_laporan.php"><i class="icon icon-print"></i> <span>Generate Laporan</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    } else if($r['id_level'] == 4){
  ?>
    <li><a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li> <a href="generate_laporan.php"><i class="icon icon-print"></i> <span>Generate Laporan</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    } else if($r['id_level'] == 5){
  ?>
    <li><a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li class="active"> <a href="entri_order.php"><i class="icon icon-shopping-cart"></i> <span>Entri Order</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    }
  ?>
  </ul>
</div>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="entri_order.php" title="Go to here" class="tip-bottom"><i class="icon icon-tasks"></i> Entri Order</a></div>
  </div>
<!--End-breadcrumbs-->
  
<!--Action boxes-->
  <div class="container-fluid">
    
    <?php
      if($r['id_level'] == 1 || $r['id_level'] == 2 || $r['id_level'] == 5){
    ?>
      <p></p>
      <?php
        $order = array();
        $query_lihat_order = "select * from tb_order";
        $sql_lihat_order = mysqli_query($conn, $query_lihat_order);
        while($r_dt_order = mysqli_fetch_array($sql_lihat_order)){
          if($r_dt_order['status_order'] != 'sudah bayar'){
            array_push($order, $r_dt_order['id_pengunjung']);
          }
        }
        if(in_array($id, $order)){
      ?>
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box span12">
          <div class="widget-title"> <span class="icon"> <i class="icon-hand-right"></i> </span>
            <h5>Notifications</h5>
          </div>
          <div class="widget-content">
            <div class="alert alert-info alert-block">
              <h4 class="alert-heading">Informasi !</h4>
              Terimakasih, Anda telah melakukan pemesanan.<br>
              Silahkan tunggu pesanan tiba di meja saudara. Apabila selesai menyantap hidangan, silahkan lakukan proses pembayaran di kasir !
            </div>
          </div>
        </div>
      </div>
      <div class="span6">
        <div class="widget-box span12">
          <div class="widget-title"> <span class="icon"> <i class="icon-shopping-cart"></i> </span>
            <h5>Menu yang dipesan</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-invoice-full">
              <thead>
                <tr>
                  <th class="head0">No.</th>
                  <th class="head1">Menu</th>
                  <th class="head0 right">Jumlah</th>
                  <th class="head1 right">Harga</th>
                  <th class="head0 right">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $no_order_fiks = 1;
                  $query_order_fiks = "select * from tb_pesan natural join tb_masakan where id_user = $id and status_pesan != 'sudah'";
                  $sql_order_fiks = mysqli_query($conn, $query_order_fiks);
                  //echo $query_order_fiks;
                  while($r_order_fiks = mysqli_fetch_array($sql_order_fiks)){
                ?>
                <tr>
                  <td><center><?php echo $no_order_fiks++; ?>. </center></td>
                  <td><?php echo $r_order_fiks['nama_masakan'];?></td>
                  <td class="right"><center><?php echo $r_order_fiks['jumlah'];?></center></td>
                  <td class="right">Rp. <?php echo $r_order_fiks['harga'];?>,-</td>
                  <td class="right">
                    <strong>
                      Rp.
                      <?php 
                        $hasil = $r_order_fiks['harga'] * $r_order_fiks['jumlah'];
                        echo $hasil;
                      ?>,-
                    </strong>
                  </td>
                </tr>
                <?php
                  }
                  $query_harga = "select * from tb_order where id_pengunjung = $id and status_order = 'belum bayar'";
                  $sql_harga = mysqli_query($conn, $query_harga);
                  $result_harga = mysqli_fetch_array($sql_harga);
                ?>

                <tr>
                  <td></td>
                  <td><strong><center>Total</center></strong></td>
                  <td class="right"></td>
                  <td class="right"></td>
                  <td class="right"><strong>Rp. <?php echo $result_harga['total_harga'];?>,-</strong></td>
                </tr>
                <tr>
                  <td></td>
                  <td><strong><center>No. Meja</center></strong></td>
                  <td class="right"></td>
                  <td class="right"></td>
                  <td class="right"><center><strong><?php echo $result_harga['no_meja'];?></strong></center></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
      <?php
        } else {
      ?>
    <div class="row-fluid">
      <div class="span8">
        <div class="widget-box span12">
          <div class="widget-title bg_lg"><span class="icon"><i class="icon-th-large"></i></span>
            <h5>Menu Makanan</h5>
          </div>
          <div class="widget-content" >
            <ul class="thumbnails">
              <div class="btn-icon-pg">
                <ul>
                  <!--Looping-->
                  <?php
                    $pesan = array();

                    $query_lihat_pesan = "select * from tb_pesan where id_user = $id and status_pesan != 'sudah'";
                    $sql_lihat_pesan = mysqli_query($conn, $query_lihat_pesan);

                    while($r_dt_pesan = mysqli_fetch_array($sql_lihat_pesan)){
                      array_push($pesan, $r_dt_pesan['id_masakan']);
                    }

                    $query_data_makanan = "select * from tb_masakan where stok > 0 order by id_masakan desc";
                    $sql_data_makanan = mysqli_query($conn, $query_data_makanan);
                    $no_makanan = 1;

                    while($r_dt_makanan = mysqli_fetch_array($sql_data_makanan)){
                  ?>
                      <li class="span2"> 
                        <a> <img src="gambar/<?php echo $r_dt_makanan['gambar_masakan']?>" alt="" > </a>
                        <div class="actions">
                          <a class="lightbox_trigger" href="gambar/<?php echo $r_dt_makanan['gambar_masakan'];?>"><i class="icon-search"></i>&nbsp;Lihat</a> 
                        </div>
                        <table class="table table-bordered">
                          <tbody>
                            <tr>
                              <td><?php echo $r_dt_makanan['nama_masakan'];?></td>
                            </tr>
                            <tr>
                              <td>Harga / Porsi</td>
                              <td>Rp. <?php echo $r_dt_makanan['harga'];?>,-</td>
                            </tr>
                            <tr>
                              <td>Stok</td>
                              <td><?php echo $r_dt_makanan['stok'];?> Porsi</td>
                            </tr>
                          </tbody>
                        </table>
                        <form action="" method="post">
                          <?php
                            if(in_array($r_dt_makanan['id_masakan'], $pesan)){
                          ?>
                              <button type="submit" value="<?php echo $r_dt_makanan['id_masakan'];?>" name="tambah_pesan" class="btn btn-danger btn-mini" disabled>
                                <i class='icon-shopping-cart'></i>&nbsp;&nbsp;Telah dipesan &nbsp;&nbsp;
                              </button>
                          <?php
                            } else {
                          ?>
                              <button type="submit" value="<?php echo $r_dt_makanan['id_masakan'];?>" name="tambah_pesan" class="btn btn-success btn-mini">
                                <i class='icon-shopping-cart'></i>&nbsp;&nbsp;Pesan &nbsp;&nbsp;
                              </button>
                          <?php
                            }
                          ?>
                        </form>
                      </li>
                    <?php
                      }
                      if(isset($_REQUEST['tambah_pesan'])){
                        //echo $_REQUEST['hapus_menu'];
                        $id_masakan = $_REQUEST['tambah_pesan'];

                        $query_tambah_pesan = "insert into tb_pesan values('', '$id', '', '$id_masakan', '', '')";
                        $sql_tambah_pesan= mysqli_query($conn, $query_tambah_pesan);

                        $query_lihat_pesannya = "select * from tb_pesan order by id_pesan desc limit 1";
                        $sql_lihat_pesannya = mysqli_query($conn, $query_lihat_pesannya);
                        $result_lihat_pesannya = mysqli_fetch_array($sql_lihat_pesannya);

                        $id_pesannya = $result_lihat_pesannya['id_pesan'];

                        $query_olah_stok = "insert into tb_stok values('', '$id_pesannya', '', 'belum cetak')";
                        $sql_olah_stok= mysqli_query($conn, $query_olah_stok);

                        //echo $query_tambah_pesan;
                        if($sql_tambah_pesan){
                          header('location: entri_order.php');
                        }
                      }
                    ?>
                  <!--End Looping-->
                </ul>
              </div>
            </ul>
          </div>
        </div>
      </div>
      <div class="span4">
      <form action="" method="post">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-shopping-cart"></i> </span>
            <h5>Keranjang Pemesanan</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 50%">Menu Pesanan</th>
                  <th style="width: 30%">Jumlah</th>
                  <th style="width: 20%">Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $query_draft_pesan = "select * from tb_pesan natural join tb_masakan where id_user = $id and status_pesan != 'sudah'";
                $sql_draft_pesan = mysqli_query($conn, $query_draft_pesan);

                while($r_draft_pesan = mysqli_fetch_array($sql_draft_pesan)){
              ?>
                <tr class="odd gradeX">
                  <td><span id="<?php echo "nama".$r_draft_pesan['id_pesan']; ?>"><?php echo $r_draft_pesan['nama_masakan'];?></span></td>
                  <input id="<?php echo "harga".$r_draft_pesan['id_pesan']; ?>" class="span8" type="hidden" value="<?php echo $r_draft_pesan['harga'];?>"/>
                  <td>
                    <center>
                      <input id="<?php echo "jumlah".$r_draft_pesan['id_pesan']; ?>" class="span8" name="jumlah<?php echo $r_draft_pesan['id_masakan']; ?>" type="number" value="" placeholder="" onchange="return operasi()"/>
                    </center>
                  </td>
                  <td>
                    <form action="" method="post">
                      <button type="submit" value="<?php echo $r_draft_pesan['id_pesan'];?>" name="hapus_pesan" class="btn btn-danger btn-mini">
                        <i class='icon-trash'></i>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php
                }
              ?>
                <tr class="odd gradeX">
                  <td>No. Meja</td>
                  <td>
                    <center>
                      <input class="span8" name="no_meja" type="number" value="" placeholder="" />
                    </center>
                  </td>
                  <td>
                    
                  </td>
                </tr>
                <tr class="odd gradeX">
                  <td>Total Harga</td>
                  <td>
                    <center>
                      <span class="label label-success">&nbsp;Rp. <span id="total_harga">0</span>,-&nbsp;</span>
                      <input class="span8" id="tot" name="total_harga" type="hidden" value="" placeholder="" />
                    </center>
                  </td>
                  <td>
                    
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <br>
          <center>
            <button type="submit" value="" name="proses_pesan" class="btn btn-mini btn-info">
              <i class='icon-share'></i> &nbsp;&nbsp;Proses Pesanan
            </button>
          </center>
          <hr>
        </div>
      </form>
      </div>
    </div>
      <?php
        }
          if(isset($_POST['hapus_pesan'])){
            $id_pesan = $_POST['hapus_pesan'];
            $query_hapus_pesan = "delete from tb_pesan where id_pesan = $id_pesan";
            $sql_hapus_pesan = mysqli_query($conn, $query_hapus_pesan);

            if($sql_hapus_pesan){
              header('location: entri_order.php');
            }
          }

          if(isset($_POST['proses_pesan'])){
            $id_admin = '';
            $id_pengunjung = $id;
            $no_meja = $_POST['no_meja'];
            $total_harga = $_POST['total_harga'];
            $uang_bayar = '';
            $uang_kembali = '';
            $status_order = 'belum bayar';

            date_default_timezone_set('Asia/Jakarta');
            $time = Date('YmdHis');
            echo $time;
            $query_simpan_order = "insert into tb_order values('', '$id_admin', '$id_pengunjung', $time, '$no_meja', '$total_harga', '$uang_bayar', '$uang_kembali', '$status_order')";
            $sql_simpan_order = mysqli_query($conn, $query_simpan_order);

            $query_tampil_order = "select * from tb_order where id_pengunjung = $id order by id_order desc limit 1";
            $sql_tampil_order = mysqli_query($conn, $query_tampil_order);
            $result_tampil_order = mysqli_fetch_array($sql_tampil_order);

            $id_ordernya = $result_tampil_order['id_order'];

            $query_ubah_jumlah = "select * from tb_pesan left join tb_masakan on tb_pesan.id_masakan = tb_masakan.id_masakan where id_user = $id and status_pesan != 'sudah'";
            $sql_ubah_jumlah = mysqli_query($conn, $query_ubah_jumlah);
            while($r_ubah_jumlah = mysqli_fetch_array($sql_ubah_jumlah)){
              $tahu = $r_ubah_jumlah['id_masakan'];
              $tempe = $_POST['jumlah'.$tahu];
              $id_pesan = $r_ubah_jumlah['id_pesan'];
              $query_stok = "select * from tb_masakan where id_masakan = $tahu";
              $sql_stok = mysqli_query($conn, $query_stok);
              $result_stok = mysqli_fetch_array($sql_stok);
              $sisa_stok = $result_stok['stok'] - $tempe;
              //echo $tempe;
              $query_proses_ubah = "update tb_pesan set jumlah = $tempe, id_order = $id_ordernya where id_masakan = $tahu and id_user = $id and status_pesan != 'sudah'";
              $query_kurangi_stok = "update tb_masakan set stok = $sisa_stok where id_masakan = $tahu";
              
              $query_kelola_stok = "update tb_stok set jumlah_terjual = $tempe where id_pesan = $id_pesan";

              $sql_kelola_stok = mysqli_query($conn, $query_kelola_stok);
              $sql_kurangi_stok = mysqli_query($conn, $query_kurangi_stok);
              $sql_proses_ubah = mysqli_query($conn, $query_proses_ubah);
            }

            if($sql_simpan_order){
              header('location: entri_order.php');
            }
          }

        }
      ?>
    </div>
<!--End-Action boxes-->    
  </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date('Y'); ?> &copy; Warkom Restaurant <a href="#">by warkom</a> </div>
</div>

<!--end-Footer-part-->

<script type="text/javascript">
  function operasi(){
    var pesan = new Array();
    var jumlah = new Array();
    var total = 0;
    for(var a = 0; a < 1000; a++){
      pesan[a] = $("#harga"+a).val();
      jumlah[a] = $("#jumlah"+a).val();
    } 
    for(var a = 0; a < 1000; a++){
      if(pesan[a] == null || pesan[a] == ""){
        pesan[a] = 0;
        jumlah[a] = 0;
      }
      total += Number(pesan[a] * jumlah[a]);
    }
    
    //alert(total);
    $("#total_harga").text(total);
    $("#tot").val(total);
  }
</script>

<script src="template/dashboard/js/excanvas.min.js"></script> 
<script src="template/dashboard/js/jquery.min.js"></script> 
<script src="template/dashboard/js/jquery.ui.custom.js"></script> 
<script src="template/dashboard/js/bootstrap.min.js"></script> 
<script src="template/dashboard/js/jquery.flot.min.js"></script> 
<script src="template/dashboard/js/jquery.flot.resize.min.js"></script> 
<script src="template/dashboard/js/jquery.peity.min.js"></script> 
<script src="template/dashboard/js/fullcalendar.min.js"></script> 
<script src="template/dashboard/js/matrix.js"></script> 
<script src="template/dashboard/js/matrix.dashboard.js"></script> 
<script src="template/dashboard/js/jquery.gritter.min.js"></script> 
<script src="template/dashboard/js/matrix.interface.js"></script> 
<script src="template/dashboard/js/matrix.chat.js"></script> 
<script src="template/dashboard/js/jquery.validate.js"></script> 
<script src="template/dashboard/js/matrix.form_validation.js"></script> 
<script src="template/dashboard/js/jquery.wizard.js"></script> 
<script src="template/dashboard/js/jquery.uniform.js"></script> 
<script src="template/dashboard/js/select2.min.js"></script> 
<script src="template/dashboard/js/matrix.popover.js"></script> 
<script src="template/dashboard/js/jquery.dataTables.min.js"></script> 
<script src="template/dashboard/js/matrix.tables.js"></script> 

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {
      
          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();            
          } 
          // else, send page to designated URL            
          else {  
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>
<?php
  }
} else {
  header('location: logout.php');
}
ob_flush();
?>
