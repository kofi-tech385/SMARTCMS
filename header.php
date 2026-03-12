<?php
// Include database connection
require_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Church Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    /* Force active link to stay white on dark navbar */
    .navbar-dark .navbar-nav .nav-link.active {
        color: #fff !important;
    }
    /* Sidebar styles */
    .sidebar {
        width: 200px;
        background-color: #343a40;
        color: white;
        min-height: 100vh;
        overflow-y: auto;
        transition: width 0.3s ease;
    }
    .sidebar.hidden {
        width: 0;
        overflow: hidden;
    }
    .sidebar .nav-link {
        color: rgba(255,255,255,.75);
        padding: 0.75rem 1rem;
    }
    .sidebar .nav-link:hover {
        color: white;
        background-color: rgba(255,255,255,.1);
    }
    .sidebar .nav-link.active {
        color: white;
        background-color: #0d6efd;
    }
    .main-content {
        flex-grow: 1;
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }
    .top-bar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 56px;
        background-color: #343a40;
        color: white;
        z-index: 1010;
        display: flex;
        align-items: center;
        padding: 0 1rem;
    }
    .main-content {
        padding-top: 76px; /* top-bar height + padding */
    }
    </style>
</head>
<body>

<!-- Top Bar -->
<div class="top-bar">
    <button class="btn btn-dark me-3" type="button" onclick="toggleSidebar()">☰</button>
    <h5 class="mb-0">Church Management System</h5>
</div>

<div class="d-flex min-vh-100" style="padding-top: 56px;">

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="p-3">
        <h4 class="text-center">CMCS</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='dashboard.php'?'active':'' ?>" href="dashboard.php">📊 Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='add_member.php'?'active':'' ?>" href="add_member.php">👥 Members</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='view_qr.php'?'active':'' ?>" href="view_qr.php">📱 QR Codes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='services.php'?'active':'' ?>" href="services.php">⛪ Services</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='attendance.php'?'active':'' ?>" href="attendance.php">📋 Attendance</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='attendance_report.php'?'active':'' ?>" href="attendance_report.php">📈 Attendance Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='service_finance.php'?'active':'' ?>" href="service_finance.php">💰 Service Finance</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='service_finance_report.php'?'active':'' ?>" href="service_finance_report.php">📊 Finance Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='fundraising.php'?'active':'' ?>" href="fundraising.php">🎉 Fundraising</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='fundraising_report.php'?'active':'' ?>" href="fundraising_report.php">📋 Fundraising Report</a>
            </li>
        </ul>
    </div>
</div>

<!-- Main content wrapper -->
<div class="main-content">