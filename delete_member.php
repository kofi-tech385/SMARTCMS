<?php
include 'db.php';

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = (int) $_GET['id']; // cast to integer for safety

    // Prepare statement
    $stmt = $conn->prepare("DELETE FROM members WHERE id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        // Redirect with success message
        header("Location: add_member.php?msg=deleted");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error deleting member: ".$conn->error."</div>";
    }
} else {
    // If id is missing or invalid, redirect back safely
    header("Location: add_member.php");
    exit;
}
?>