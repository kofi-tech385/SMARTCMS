<?php
include 'header.php';
include 'db.php';

// Fetch stats
$total_members = $conn->query("SELECT COUNT(*) as count FROM members")->fetch_assoc()['count'];
$total_services = $conn->query("SELECT COUNT(*) as count FROM services")->fetch_assoc()['count'];
$total_attendance = $conn->query("SELECT COUNT(*) as count FROM attendance")->fetch_assoc()['count'];
$total_fundraising = $conn->query("SELECT COUNT(*) as count FROM fundraising_contributions")->fetch_assoc()['count'];
?>

<h2 class="mb-4">Dashboard</h2>

<div class="row g-4">

<!-- Members Card -->
<div class="col-md-3">
<div class="card text-white bg-primary shadow-lg border-0 h-100 dashboard-card">
<div class="card-body text-center">
<div class="fs-1 mb-2">👥</div>
<h5 class="card-title">Members</h5>
<h2 class="fw-bold"><?php echo $total_members; ?></h2>
</div>
</div>
</div>

<!-- Services Card -->
<div class="col-md-3">
<div class="card text-white shadow-lg border-0 h-100 dashboard-card services-card">
<div class="card-body text-center">
<div class="fs-1 mb-2">⛪</div>
<h5 class="card-title">Services</h5>
<h2 class="fw-bold"><?php echo $total_services; ?></h2>
</div>
</div>
</div>

<!-- Attendance Card -->
<div class="col-md-3">
<div class="card text-white bg-warning shadow-lg border-0 h-100 dashboard-card">
<div class="card-body text-center">
<div class="fs-1 mb-2">📋</div>
<h5 class="card-title">Attendance</h5>
<h2 class="fw-bold"><?php echo $total_attendance; ?></h2>
</div>
</div>
</div>

<!-- Fundraising Card -->
<div class="col-md-3">
<div class="card text-white shadow-lg border-0 h-100 dashboard-card fundraising-card">
<div class="card-body text-center">
<div class="fs-1 mb-2">💰</div>
<h5 class="card-title">Fundraising</h5>
<h2 class="fw-bold"><?php echo $total_fundraising; ?></h2>
</div>
</div>
</div>

</div>

<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="p-4 bg-light rounded shadow-sm">
            <h1 class="display-4 text-primary">Welcome to CMCS</h1>
            <p class="lead">Manage your church members, services, attendance, and finances efficiently.</p>
        </div>
    </div>
</div>



<hr class="my-5">

<h4 class="mb-3">Quick Actions</h4>

<div class="row g-3">

<div class="col-md-3">
<a href="add_member.php" class="btn btn-outline-primary w-100">➕ Add Member</a>
</div>

<div class="col-md-3">
<a href="services.php" class="btn btn-outline-services w-100">➕ Add Service</a>
</div>

<div class="col-md-3">
<a href="attendance.php" class="btn btn-outline-warning w-100">📋 Mark Attendance</a>
</div>

<div class="col-md-3">
<a href="fundraising.php" class="btn btn-outline-fundraising w-100">💰 Add Contribution</a>
</div>

</div>


<?php include 'footer.php'; ?>