<?php 
include('dbconnection.php');

$Htypeid=$_GET['HTid'];
$HTdelete="DELETE FROM holidayhometypetb WHERE HolidayHomeTypeID = '$Htypeid'";
$HTquery=mysqli_query($connect, $HTdelete);

if ($HTquery) {
	echo "<script>window.alert('Holiday Home Type Deleted Successfully!')</script>";
    echo "<script>window.location='Dashboard.php'</script>";
}
else {
	echo "<script>window.alert('Something Went Wrong. Please Try Again!')</script>";
    echo "<script>window.location='Dashboard.php'</script>";
}
 ?>