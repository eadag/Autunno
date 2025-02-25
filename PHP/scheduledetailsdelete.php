<?php 
include('dbconnection.php');

$Sid=$_GET['Sid'];
$Hid=$_GET['Hid'];
$HSdelete="DELETE FROM scheduledetailstb WHERE ScheduleID='$Sid' AND HolidayHomeID = '$Hid'";
$SDquery=mysqli_query($connect, $HSdelete);

if ($SDquery) {
	echo "<script>window.alert('Schedule Details Deleted Successfully!')</script>";
    echo "<script>window.location='Dashboard.php'</script>";
}
else {
	echo "<script>window.alert('Something Went Wrong. Please Try Again!')</script>";
    echo "<script>window.location='Dashboard.php'</script>";
}
 ?>