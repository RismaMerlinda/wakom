<?php
	include "database/koneksi.php"; // Pastikan path ini benar
	session_start();
	ob_start(); // Tetap gunakan ob_start untuk header redirection

	// Pastikan session 'id_user' ada sebelum digunakan
	if (!isset($_SESSION['id_user']) || !isset($_SESSION['username'])) {
		header('location: logout.php');
		exit; // Hentikan eksekusi jika tidak ada session
	}

	$id = $_SESSION['id_user'];

	// Query utama untuk data user
	$query_user = "SELECT * FROM tb_user NATURAL JOIN tb_level WHERE id_user = $id";
	$sql_user = mysqli_query($conn, $query_user);

	// Periksa apakah user ditemukan
	if (mysqli_num_rows($sql_user) == 0) {
		header('location: logout.php');
		exit;
	}

	$r = mysqli_fetch_array($sql_user);
	$nama_user = $r['nama_user'];
	$id_level = $r['id_level'];

	// Fungsi untuk menghitung jumlah user berdasarkan level
	function count_users($conn, $level_id) {
		$query = "SELECT count(*) AS jumlah FROM tb_user WHERE id_level = $level_id AND status = 'aktif'";
		$sql = mysqli_query($conn, $query);
		$result = mysqli_fetch_array($sql);
		return $result['jumlah'];
	}

	// Hitung jumlah user (hanya jika diperlukan, misal oleh admin)
    $result_adm = ($id_level == 1) ? count_users($conn, 1) : 0;
    $result_wtr = ($id_level == 1 || $id_level == 2 || $id_level == 3) ? count_users($conn, 2) : 0;
    $result_ksr = ($id_level == 1 || $id_level == 3) ? count_users($conn, 3) : 0;
    $result_own = ($id_level == 1) ? count_users($conn, 4) : 0;
    $result_plg = ($id_level == 1) ? count_users($conn, 5) : 0;

    // Proses Aksi (Hapus, Validasi, Unvalidasi)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['hapus_user'])){
            $id_user_to_action = $_POST['hapus_user'];
            $query_action = "DELETE FROM tb_user WHERE id_user = $id_user_to_action";
        } else if(isset($_POST['validasi'])){
            $id_user_to_action = $_POST['validasi'];
            $query_action = "UPDATE tb_user SET status = 'aktif' WHERE id_user = $id_user_to_action";
        } else if(isset($_POST['unvalidasi'])){
            $id_user_to_action = $_POST['unvalidasi'];
            $query_action = "UPDATE tb_user SET status = 'nonaktif' WHERE id_user = $id_user_to_action";
        }

        if (isset($query_action) && mysqli_query($conn, $query_action)) {
            header('location: beranda.php');
            exit;
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Beranda - Warkom</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="template/dashboard/css/bootstrap.min.css" />
    <link rel="stylesheet" href="template/dashboard/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="template/dashboard/css/fullcalendar.css" />
    <link rel="stylesheet" href="template/dashboard/css/matrix-style.css" />
    <link rel="stylesheet" href="template/dashboard/css/matrix-media.css" />
    <link href="template/dashboard/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="template/dashboard/css/jquery.gritter.css" />
    <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap' rel='stylesheet'>

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
            /* Hapus atau nonaktifkan ini jika teks terpotong karena lebar sempit */
            /* overflow: hidden; */
            /* text-overflow: ellipsis; */
            display: flex; /* Use flexbox for logo and text alignment */
            align-items: center;
            flex-shrink: 0; /* Pastikan brand tidak menyusut terlalu banyak */
            padding-right: 5px; /* Tambahkan sedikit padding kanan agar tidak terlalu mepet */
        }
        #header a.brand span {
            margin-left: 0; /* Mengurangi margin-left jika sebelumnya ada negatif */
            font-size: 22px; /* Coba kurangi ukuran font untuk teks di dalam span */
            /* Jika masih terpotong, bisa coba kecilkan lagi menjadi 20px atau 18px */
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

<div id="sidebar">
  <a href="beranda.php" class="visible-phone"><i class="icon icon-home"></i> Beranda</a>
  <ul>
  <?php
    $current_page = basename($_SERVER['PHP_SELF']); // Get current page name
    function nav_item($link, $icon, $text, $current_page) {
        $active = ($link == $current_page) ? ' class="active"' : '';
        echo "<li{$active}><a href='{$link}'><i class='icon {$icon}'></i> <span>{$text}</span></a></li>";
    }

    nav_item('beranda.php', 'icon-home', 'Beranda', $current_page);

    if($id_level == 1){ // Administrator
        nav_item('entri_referensi.php', 'icon-tasks', 'Entri Referensi', $current_page);
        nav_item('entri_order.php', 'icon-shopping-cart', 'Entri Order', $current_page);
        nav_item('entri_transaksi.php', 'icon-inbox', 'Entri Transaksi', $current_page);
        nav_item('generate_laporan.php', 'icon-print', 'Generate Laporan', $current_page);
    } else if($id_level == 2){ // Waiter
        nav_item('entri_order.php', 'icon-shopping-cart', 'Entri Order', $current_page);
        nav_item('generate_laporan.php', 'icon-print', 'Generate Laporan', $current_page);
    } else if($id_level == 3){ // Kasir
        nav_item('entri_transaksi.php', 'icon-inbox', 'Entri Transaksi', $current_page);
        nav_item('generate_laporan.php', 'icon-print', 'Generate Laporan', $current_page);
    } else if($id_level == 4){ // Owner
        nav_item('generate_laporan.php', 'icon-print', 'Generate Laporan', $current_page);
    } else if($id_level == 5){ // Pelanggan
        nav_item('entri_order.php', 'icon-shopping-cart', 'Entri Order', $current_page);
    }
    // Logout item should ideally be separated or handled differently if it's the last item,
    // but keeping consistent with original structure for now.
    nav_item('logout.php', 'icon-signout', 'Logout', $current_page); // Using sign-out icon
  ?>
  </ul>
</div>

<div id="content">
    <div id="content-header">
        <h1>Beranda</h1>
        <div id="breadcrumb">
            <a href="beranda.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
            <a href="#" class="current">Beranda</a>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
        <?php
          // Tampilkan blok ini hanya untuk Admin, Waiter, dan Kasir (sesuai kode asli)
          if($id_level == 1 || $id_level == 2 || $id_level == 3){
        ?>
            <div class="widget-box">
                <div class="widget-title bg_lg">
                    <span class="icon"><i class="icon-dashboard"></i></span> <h5>Ringkasan & Data Pengguna</h5>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span12">
                            <ul class="quick-actions">
                                <li class="bg_lb"><i class="icon-user-md"></i> <strong><?php echo $result_adm; ?></strong> <small>Administrator</small></li>
                                <li class="bg_ly"><i class="icon-coffee"></i> <strong><?php echo $result_wtr; ?></strong> <small>Total Waiter</small></li>
                                <li class="bg_lg"><i class="icon-money"></i> <strong><?php echo $result_ksr; ?></strong> <small>Total Kasir</small></li>
                                <li class="bg_ls"><i class="icon-briefcase"></i> <strong><?php echo $result_own; ?></strong> <small>Total Owner</small></li>
                                <li class="bg_lo"><i class="icon-group"></i> <strong><?php echo $result_plg; ?></strong> <small>Total Pelanggan</small></li>
                            </ul>
                        </div>
                    </div>
                     <hr>
                     <div class="row-fluid">
                        <div class="span12">
                            <?php
                                // Fungsi untuk menampilkan tabel data pengguna
                                function display_user_table($conn, $level_id, $title) {
                                    $query = "SELECT * FROM tb_user WHERE id_level = $level_id ORDER BY nama_user ASC"; // Order by name
                                    $sql = mysqli_query($conn, $query);
                                    $no = 1;
                            ?>
                                    <div class="widget-box">
                                        <div class="widget-title"> <span class="icon"> <i class="icon-table"></i> </span>
                                            <h5><?php echo $title; ?></h5>
                                        </div>
                                        <div class="widget-content nopadding">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%">No.</th>
                                                        <th style="width:25%">Nama</th>
                                                        <th style="width:30%">Username</th>
                                                        <th style="width:20%">Status</th>
                                                        <th style="width:20%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(mysqli_num_rows($sql) > 0) { ?>
                                                    <?php while($r_dt = mysqli_fetch_array($sql)) { ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no++; ?>.</td>
                                                            <td><?php echo $r_dt['nama_user']; ?></td>
                                                            <td><?php echo $r_dt['username']; ?></td>
                                                            <td>
                                                                <span class="label <?php echo ($r_dt['status'] == 'aktif') ? 'label-success' : 'label-important'; ?>">
                                                                    <?php echo ucfirst($r_dt['status']); ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <form action="beranda.php" method="post" style="margin:0; display:inline-block;">
                                                                    <?php if($r_dt['status'] == 'aktif') { ?>
                                                                        <button name="unvalidasi" value="<?php echo $r_dt['id_user']; ?>" class="btn btn-warning btn-mini" title="Nonaktifkan">
                                                                            <i class='icon icon-lock'></i> </button>
                                                                    <?php } else { ?>
                                                                        <button name="validasi" value="<?php echo $r_dt['id_user']; ?>" class="btn btn-info btn-mini" title="Aktifkan">
                                                                            <i class='icon icon-unlock-alt'></i> </button>
                                                                        <button name="hapus_user" value="<?php echo $r_dt['id_user']; ?>" class="btn btn-danger btn-mini" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus user ini?');">
                                                                            <i class='icon icon-trash'></i>
                                                                        </button>
                                                                    <?php } ?>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center">Tidak ada data pengguna untuk level ini.</td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            <?php
                                } // Akhir fungsi display_user_table

                                // Tampilkan tabel berdasarkan level user yang login (Admin bisa lihat semua)
                                if ($id_level == 1) {
                                    display_user_table($conn, 2, "Data Waiter");
                                    display_user_table($conn, 3, "Data Kasir");
                                    display_user_table($conn, 4, "Data Owner");
                                    display_user_table($conn, 5, "Data Pelanggan");
                                } else if ($id_level == 2) {
                                     display_user_table($conn, 5, "Data Pelanggan"); // Contoh: Waiter mungkin perlu lihat pelanggan
                                } else if ($id_level == 3) {
                                    display_user_table($conn, 5, "Data Pelanggan"); // Contoh: Kasir mungkin perlu lihat pelanggan
                                }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
          } else { // Jika bukan Admin, Waiter, atau Kasir
        ?>
            <div class="alert alert-orange alert-block">
                <center>
                    <h4 class="alert-heading">SELAMAT DATANG, **<?php echo $nama_user; ?>**!</h4>
                    <p>Di Sistem Pelayanan Restaurant Cepat Saji Warkom. <br> Semoga Hari Anda Menyenangkan.</p>
                </center>
            </div>
        <?php
          }
        ?>
        </div>
    </div>
</div>
<div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date('Y'); ?> &copy; Warkom Restaurant - Modernized <a href="#">by warkom</a> </div>
</div>
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
  // Fungsi ini mungkin tidak lagi terlalu relevan jika navigasi sudah jelas
  // Tapi bisa disimpan jika ada menu dropdown 'go to page'
  function goPage (newURL) {
      if (newURL != "") {
          if (newURL == "-" ) {
              resetMenu();
          } else {
            document.location.href = newURL;
          }
      }
  }

  function resetMenu() {
     // Sesuaikan jika masih ada menu 'gomenu'
     // document.gomenu.selector.selectedIndex = 2;
  }

  // Aktifkan tooltips bootstrap jika digunakan
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('.tip-bottom').tooltip({ placement: 'bottom' });

    // New: Mobile sidebar toggle
    $('.toggle-sidebar').on('click', function(e) {
        e.preventDefault();
        $('#sidebar').toggleClass('visible');
    });
  });
</script>

</body>
</html>
<?php
	ob_flush(); // Kirim output ke browser
?>
