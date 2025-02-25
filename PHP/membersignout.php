<?php
include('dbconnection.php');
session_start();
session_destroy(); 

echo "<script>window.alert('Successfully Sign Out!')</script>";
echo "<script>window.location='landingpage.php'</script>";

?>