<?php 
include('dbconnection.php');

$ScheduleId=$_GET['Sid'];
$Sdelete="DELETE FROM scheduletb WHERE ScheduleID = '$ScheduleId'";
$Squery=mysqli_query($connect, $Sdelete);

if ($Squery) {
	echo "<script>window.alert('Schedule Deleted Successfully!')</script>";
    echo "<script>window.location='Dashboard.php'</script>";
}
else {
	echo "<script>window.alert('Something Went Wrong. Please Try Again!')</script>";
    echo "<script>window.location='Dashboard.php'</script>";
}
 ?>