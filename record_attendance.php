<?php
include 'db.php';

if(isset($_GET['member_id'])){

$member_id = $_GET['member_id'];

// latest service
$service = $conn->query("SELECT id FROM services ORDER BY service_date DESC LIMIT 1");
$row = $service->fetch_assoc();
$service_id = $row['id'];

$stmt = $conn->prepare("INSERT INTO attendance (member_id, service_id) VALUES (?,?)");
$stmt->bind_param("ii",$member_id,$service_id);
$stmt->execute();

echo "Attendance Recorded!";
}
?>