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

if (isset($_GET['HHid']))
{
	$HhomeID=$_GET['HHid'];
	$HHupdate="SELECT * FROM holidayhometb WHERE HolidayHomeID = '$HhomeID'";
	$HHquery=mysqli_query($connect, $HHupdate);

	$array=mysqli_fetch_array($HHquery);
	$HHname=$array['HolidayHomeName'];
    $HHlocation=$array['HolidayHomeLocation'];
    $HHmap=$array['HolidayHomeMap'];
    $HHdesc=$array['HolidayHomeDescription'];
    $HHprice=$array['PricePerNight'];
    $bed=$array['NumberOfBed'];
    $bathroom=$array['NumberOfBathroom'];
    $guest=$array['NumberOfGuest'];
    $HHtypeID=$array['HolidayHomeTypeID'];
    $wifi=$array['Wifi'];
    $kitchen=$array['Kitchen'];
    $pet=$array['PetFriendly'];
    $selfcheckin=$array['SelfCheckIn'];
    $washer=$array['Washer'];
    $toiletries=$array['Toiletries'];
}

if (isset($_POST['btnUpdate'])) 
{
    $HHId=$_POST['txtID'];
	$HHname=mysqli_real_escape_string($connect, $_POST['txtHHname']);
    $HHlocation=$_POST['txtHHlocation'];
    $HHmap=$_POST['txtHHmap'];
    $HHdesc=mysqli_real_escape_string($connect, $_POST['txtHHdesc']);
    $HHprice=$_POST['txtHHprice'];
    $HHbed=$_POST['txtHHbed'];
    $HHbathroom=$_POST['txtHHbathroom'];
    $HHguest=$_POST['txtHHguest'];
    $HHtype=$_POST['slHHtype'];
    $cbowifi=isset($_POST['cbowifi']) ? 1 : 0;
    $cbokitchen=isset($_POST['cbokitchen']) ? 1 : 0;
    $cbowasher=isset($_POST['cbowasher']) ? 1 : 0;
    $cbopet=isset($_POST['cbopet']) ? 1 : 0;
    $cboselfcheckin=isset($_POST['cboselfcheckin']) ? 1 : 0;
    $cbotoiletries=isset($_POST['cbotoiletries']) ? 1 : 0;

	$update="UPDATE holidayhometb SET HolidayHomeName='$HHname', HolidayHomeLocation='$HHlocation', HolidayHomeMap='$HHmap', HolidayHomeDescription='$HHdesc', PricePerNight='$HHprice', NumberOfBed='$HHbed', NumberOfBathroom='$HHbathroom', NumberOfGuest='$HHguest', HolidayHomeTypeID='$HHtype', Wifi='$cbowifi', Kitchen='$cbokitchen', PetFriendly='$cbopet', SelfCheckIn='$cboselfcheckin', Washer='$cbowasher', Toiletries='$cbotoiletries' WHERE HolidayHomeID='$HHId'";
	$updatequery=mysqli_query($connect, $update);

	if ($updatequery){
		echo "<script>window.alert('Holiday Home Updated Successfully!')</script>";
    	echo "<script>window.location='dashboard.php'</script>";
	}
	else{
    	echo "<script>window.alert('Something went wrong. Please try again!')</script>";
    	echo "<script>window.location='dashboard.php'</script>";
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
    <title>UPDATE HOLIDAY HOME | AUTUNNO</title>
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
                <h2>Update Holiday Home </h2>
                <form class="adminadddataform" action="holidayhomeupdate.php" method="POST" enctype="multipart/form-data">
                    <div class="sidebysidediv">
                        <div>
                            <label>Holiday Home ID</label>
                            <input type="text" name="txtID" class="readonlytxt" value="<?php echo $HhomeID ?>" readonly>             

                            <label>Holiday Home Name</label>
                            <input type="text" name="txtHHname" class="textbox" value="<?php echo $HHname ?>" required>

                            <label>Holiday Home Type</label>
                            <select  name="slHHtype" required>
                                <?php
                                    $select="SELECT * FROM holidayhometypetb";
                                    $query=mysqli_query($connect, $select);
                                    $count=mysqli_num_rows($query);
                                    for ($i=0; $i < $count ; $i++) 
                                    { 
                                        $row=mysqli_fetch_array($query);
                                        $HTid=$row['HolidayHomeTypeID'];
                                        $HTname=$row['HolidayHomeTypeName'];

                                        if ($HTid == $HHtypeID) {
                                            echo "<option value='$HTid' selected>$HTname</option>";
                                        } else {
                                            echo "<option value='$HTid'>$HTname</option>";
                                        }
                                    }
                                ?>
                            </select>

                            <label>Location</label>
                            <input type="text" name="txtHHlocation" class="textbox" value="<?php echo $HHlocation ?>" required>

                            <label>Map</label>
                            <textarea name="txtHHmap" required><?php echo $HHmap ?></textarea>
                            
                            <label>Description</label>
                            <textarea name="txtHHdesc" required><?php echo $HHdesc ?></textarea>

                        </div>
                        <div>
                        <label>Price Per Night</label>
                            <input type="number" step="0.01" name="txtHHprice" class="textbox" value="<?php echo $HHprice ?>" required>

                            <div class="sidebysidediv">
                                <div>
                                    <input type="checkbox" name="cbowifi" value="1" <?php if($wifi == 1) echo "checked"; ?>><label class="forcheckbox">Wifi</label>
                                    <br>

                                    <input type="checkbox" name="cbokitchen" value="1" <?php if($kitchen == 1) echo "checked"; ?>><label class="forcheckbox">Kitchen</label>
                                    <br>

                                    <input type="checkbox" name="cbowasher" value="1" <?php if($washer == 1) echo "checked"; ?>><label class="forcheckbox">Washer</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="cbopet" value="1" <?php if($pet == 1) echo "checked"; ?>><label class="forcheckbox">Pet Friendly</label>
                                    <br>

                                    <input type="checkbox" name="cboselfcheckin" value="1" <?php if($selfcheckin == 1) echo "checked"; ?>><label class="forcheckbox">Self Check In</label>
                                    <br>

                                    <input type="checkbox" name="cbotoiletries" value="1" <?php if($toiletries == 1) echo "checked"; ?>><label class="forcheckbox">Toiletries</label>
                                </div>
                            </div>

                            <label>Number Of Bed</label>
                            <input type="number" step="1" name="txtHHbed" class="textbox" value="<?php echo $bed ?>" required>

                            <label>Number Of Bathroom</label>
                            <input type="number" step="1" name="txtHHbathroom" class="textbox" value="<?php echo $bathroom ?>" required>

                            <label>Number Of Maximum Guest</label>
                            <input type="number" step="1" name="txtHHguest" class="textbox" value="<?php echo $guest ?>" required>
                        </div>
                    </div>

                    <input class="btnAdd" name="btnUpdate" type="submit" value="Update">
                </form>
                <a class="btnback" href="dashboard.php">&lt; Back</a>
            </div>
        </div>
    </section>
 </body>
 </html>