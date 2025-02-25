<?php
include('dbconnection.php');
session_start();

if (!isset($_SESSION['Mid'])) {
    echo "<script>window.alert('You must be signed in to view this page!')</script>";
    echo "<script>window.location='landingpage.php'</script>";
    exit();
}

$MemID = $_SESSION['Mid'];
$HomeId = $_GET['HomeId'];

$deleteQuery = "DELETE FROM favouritetb WHERE MemberID = '$MemID' AND HolidayHomeID = '$HomeId'";
$deleteResult = mysqli_query($connect, $deleteQuery);

if ($deleteResult) {
    echo "<script>window.alert('Holiday home removed from favourites successfully!')</script>";
} else {
    echo "<script>window.alert('Failed to remove holiday home from favourites.')</script>";
}

echo "<script>window.location='favourites.php'</script>";
?>
