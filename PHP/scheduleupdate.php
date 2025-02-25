<?php 
session_start();
include('dbconnection.php');

if (!isset($_SESSION['Aid'])) {
	echo "<script>window.alert('Please Sign In First!')</script>";
	echo "<script>window.location='adminsignin.php'</script>";
}

$username=$_SESSION['Uname'];
$Apfp=$_SESSION['Apfp'];
$firstname=$_SESSION['Fname'];

if (isset($_GET['Sid']))
{
	$ScheduleId=$_GET['Sid'];
	$Supdate="SELECT * FROM scheduletb WHERE ScheduleID = '$ScheduleId'";
	$Squery=mysqli_query($connect, $Supdate);

	$array=mysqli_fetch_array($Squery);
	$ScId=$array['ScheduleID'];
	$Aid=$array['AdministratorID'];
    $SCDATE=$array['ScheduleCreatedDate'];
}

if (isset($_POST['btnUpdate'])) 
{
	$Sid=$_POST['txtID'];
    $Aid=$_POST['slAdmin'];
    $Sdate=$_POST['scdate'];
	
	$update="UPDATE scheduletb SET AdministratorID='$Aid', ScheduleCreatedDate='$Sdate' WHERE ScheduleID='$Sid'";
	$updatequery=mysqli_query($connect, $update);

	if ($updatequery){
		echo "<script>window.alert('Schedule Updated Successfully!')</script>";
    	echo "<script>window.location='Dashboard.php'</script>";
	}
	else{
    	echo "<script>window.alert('Something went wrong. Please try again!')</script>";
    	echo "<script>window.location='Dashboard.php'</script>";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>UPDATE SCHEDULE | AUTUNNO</title>
</head>
<body>
    <header>
        <div class="Dtop">
            <div class="topleft">
            <i id="bars" class="fa-solid fa-bars" onclick="opensidenav()"></i>
            <i id="xmark" class="fa-solid fa-xmark" onclick="closesidenav()"></i>
                <img src="images/AutunnoLogo2.png" alt="Autunno Logo">
                <h3>Autunno</h3>
            </div>
            <div class="topright">
                <img src="<?php echo $Apfp; ?>">
                <div class="accinfo">
                    <b><?php echo $username; ?></b>
                    <br>
                    <span>Administrator</span>
                </div>
            </div>
        </div>
        <script>
            function opensidenav() {
                document.getElementById("sidenav").style.display='block';
                document.getElementById("bars").style.display='none';
                document.getElementById("xmark").style.display='block';
            }
            function closesidenav() {
                document.getElementById("sidenav").style.display='none';
                document.getElementById("bars").style.display='block';
                document.getElementById("xmark").style.display='none';
            }
            function handleResize() {
                if (window.innerWidth > 992) {
                    document.getElementById("bars").style.display = 'none';
                    document.getElementById("xmark").style.display = 'none';
                } 
                else if (document.getElementById("sidenav").style.display === 'block') {
                    document.getElementById("bars").style.display = 'none';
                    document.getElementById("xmark").style.display = 'block';
                }
                else {
                    document.getElementById("bars").style.display = 'block';
                    document.getElementById("xmark").style.display = 'none';
                }
            }

            window.addEventListener('resize', handleResize);

            handleResize();
        </script>
    </header>
    <section>
        <div class="sidebysidediv">
            <div id="sidenav" class="sidenav">
                <a class="pagelink" href="dashboard.php"><img src="images/dashboardicon.png" alt="dashboard icon"/>Dashboard</a>
                <a class="pagelink" href="addholidayhometype.php"><img src="images/categoryicon.png" alt="Holiday Home Type Icon"/>Add Holiday Home Type</a>
                <a class="pagelink" href="addholidayhome.php"><img class="HHicon" src="images/holidayhomeicon.png" alt="Holiday Home Icon"/>Add Holiday Home</a>
                <a class="pagelink" href="addpaymentmethod.php"><img src="images/paymentmethodicon.png" alt="Payment Method Icon"/>Add Payment Method</a>
                <a class="pagelink" href="addschedule.php"><img src="images/calendaricon.png" alt="Calendar Icon"/>Add Schedule</a>
                <a class="pagelink" href="adminsignout.php"><img src="images/signouticon2.png" alt="Sign Out Icon">Sign Out</a>
                <a class="manuallink" href="usermanuals/AdministratorManual.pdf" target="blank">Administrator Manual &nearr;</a>
            </div>
            <div class="dashboardcontent">
                <h2>Update Schedule</h2>
                <form class="adminadddataform" action="scheduleupdate.php" method="POST">
                    <label>Schedule ID</label>
                    <input type="text" name="txtID" class="readonlytxt" value="<?php echo $ScId ?>" readonly>
                    
                    <label>Administrator</label>
                    <select  name="slAdmin" required>
                        <?php
                            $select="SELECT * FROM administratortb";
                            $query=mysqli_query($connect, $select);
                            $count=mysqli_num_rows($query);
                            for ($i=0; $i < $count ; $i++) 
                            { 
                                $row=mysqli_fetch_array($query);
                                $AmId=$row['AdministratorID'];
                                $Uname=$row['Username'];

                                if ($AmId == $Aid) {
                                    echo "<option value='$AmId' selected>$Uname</option>";
                                } 
                                else {
                                    echo "<option value='$AmId'>$Uname</option>";
                                }
                            }
                        ?>
                    </select>

                    
                    <div class="updatedateinputs">
                        <label>Schedule Created Date</label><input type="date" name="scdate" value="<?php echo $SCDATE ?>" required>
                    </div>
                    

                    <input class="btnAdd" name="btnUpdate" type="submit" value="Update">
                </form>
                <a class="btnback" href="dashboard.php">&lt; Back</a>
            </div>
        </div>
    </section>
</body>
</html>