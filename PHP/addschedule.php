<?php 
session_start();
include('dbconnection.php');
include('ScheduleFunction.php');

if (!isset($_SESSION['Aid'])) {
	echo "<script>window.alert('Please Sign In First!')</script>";
	echo "<script>window.location='adminsignin.php'</script>";
}

$username=$_SESSION['Uname'];
$Apfp=$_SESSION['Apfp'];

if (isset($_GET['btnSave'])) {
    if (!isset($_SESSION['schedulefunction']) || count($_SESSION['schedulefunction']) == 0) {
        echo "<script>window.alert('Schedule List is Empty. Try Saving After Scheduling.')</script>";
        echo "<script>window.location='addschedule.php'</script>";
        exit();
    }
    $admin=$_SESSION['Aid'];
    $createddate=date('y-m-d');
    $insertschedule=
    "INSERT INTO scheduletb (AdministratorID, ScheduleCreatedDate)
    VALUES ('$admin', '$createddate')";
    if(mysqli_query($connect, $insertschedule)) {
        $scheduleid = mysqli_insert_id($connect);
        foreach ($_SESSION['schedulefunction'] as $schedule) {
            $HHid = $schedule['HolidayHomeID'];
            $Sstartdate = $schedule['ScheduleStartDate'];
            $Senddate = $schedule['ScheduleEndDate'];

            $insertSdetails = 
            "INSERT INTO scheduledetailstb (ScheduleID, HolidayHomeID, ScheduleStartDate, ScheduleEndDate)
            VALUES ('$scheduleid', '$HHid', '$Sstartdate', '$Senddate')";

            mysqli_query($connect, $insertSdetails);
        }

        unset($_SESSION['schedulefunction']);
        
        echo "<script>window.alert('Schedule Saved Successfully!')</script>";
        echo "<script>window.location='addschedule.php'</script>";
    }
    else {
        echo "<script>window.alert('Error saving schedule. Please try agin!')</script>";
    }
}

if (isset($_GET['action'])) 
{
	$action=$_GET['action'];
	if ($action==='add') 
	{
        $HHomeID=$_GET['slHHome'];
		$SstartDate=$_GET['Sdateinput'];
		$SendDate=$_GET['Edateinput'];
		AddSchedule($HHomeID, $SstartDate, $SendDate);
	}
	elseif ($action==='remove') 
	{
		$HHomeID=$_GET['HolidayHomeID'];
		RemoveSchedule($HHomeID);
	}
}
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
 	<title>ADD SCHEDULE | AUTUNNO</title>
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
                <h2>Add Schedule</h2>
                <div class="adminadddataform">
                    <form action="addschedule.php" method="GET">
                        <input type="hidden" name="action" value="add">
                        <div class="scheduleformgroup">
                            <div class="HHselect">
                                <label>Holiday Home</label>
                                <select  name="slHHome" required>
                                    <option value="">Select a Holiday Home</option>
                                    <?php
                                        $select="SELECT * FROM holidayhometb";
                                        $query=mysqli_query($connect, $select);
                                        $count=mysqli_num_rows($query);
                                        for ($i=0; $i < $count ; $i++) 
                                        { 
                                            $row=mysqli_fetch_array($query);
                                            $HHid=$row['HolidayHomeID'];
                                            $HHname=$row['HolidayHomeName'];
                                            echo "<option value='$HHid'>$HHname</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="ScheduleDates">
                                <label>Schedule Start Date</label>
                                <input type="date" name="Sdateinput" value="<?php echo date('Y-m-d')?>" required>

                                <label for="">Schedule End Date</label>
                                <input type="date" name="Edateinput" value="<?php echo date('Y-m-d')?>" required>
                            </div>

                            <input class="btnAdd" name="btnAdd" type="submit" value="Add">
                        </div>
                    </form>
                    <form action="addschedule.php" method="GET">
                        <fieldset>
                            <legend>Schedule List</legend>
                            <?php
                                if (!isset($_SESSION['schedulefunction']) || count($_SESSION['schedulefunction']) == 0) {
                                    echo "<p align='center'>Schedule List is Empty.</p>";
                                } 
                                else {
                            ?>
                                <table>
                                    <tr>
                                        <th>Holiday Home Image</th>
                                        <th>Holiday Home Name</th>
                                        <th>Schedule Start Date</th>
                                        <th>Schedule End Date</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php
                                    $size = count($_SESSION['schedulefunction']);
                                    for ($i = 0; $i < $size; $i++) {
                                        $HHid = $_SESSION['schedulefunction'][$i]['HolidayHomeID'];
                                        $HHname = $_SESSION['schedulefunction'][$i]['HolidayHomeName'];
                                        $startdate = $_SESSION['schedulefunction'][$i]['ScheduleStartDate'];
                                        $enddate = $_SESSION['schedulefunction'][$i]['ScheduleEndDate'];
                                        $HHimage = $_SESSION['schedulefunction'][$i]['HolidayHomeImage1'];

                                        echo "<tr>";
                                        echo "<td><img src='$HHimage' alt='Holiday Home Image'></td>";
                                        echo "<td>$HHname</td>";
                                        echo "<td>$startdate</td>";
                                        echo "<td>$enddate</td>";
                                        echo "<td><a href='addschedule.php?action=remove&HolidayHomeID=$HHid'>Remove</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="5">
                                            <input type="submit" class="btnAdd" name="btnSave" value="Save">
                                        </td>
                                    </tr>
                                </table>
                            <?php } ?>
                        </fieldset>
                    </form>    
                </div>
            </div>
        </div>        
    </section>
 </body>
 </html>