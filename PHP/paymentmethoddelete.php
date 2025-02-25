<?php 
include('dbconnection.php');

$Pid=$_GET['PMid'];
$PMdelete="DELETE FROM paymentmethodtb WHERE PaymentMethodID = '$Pid'";
$PMquery=mysqli_query($connect, $PMdelete);

if ($PMquery) {
	echo "<script>window.alert('Payment Method Deleted Successfully!')</script>";
    echo "<script>window.location='dashboard.php'</script>";
}
else {
	echo "<script>window.alert('Something Went Wrong. Please Try Again!')</script>";
    echo "<script>window.location='dashboard.php'</script>";
}
 ?>