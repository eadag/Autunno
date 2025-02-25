<?php 
include('dbconnection.php');

$HhomeID=$_GET['HHid'];
$HHdelete="DELETE FROM holidayhometb WHERE HolidayHomeID = '$HhomeID'";
$HHquery=mysqli_query($connect, $HHdelete);

if ($HHquery) {
	echo "<script>window.alert('Holiday Home Deleted Successfully!')</script>";
    echo "<script>window.location='dashboard.php'</script>";
}
else {
	echo "<script>window.alert('Something Went Wrong. Please Try Again!')</script>";
    echo "<script>window.location='dashboard.php'</script>";
}
 ?>