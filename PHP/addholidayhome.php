<?php 
session_start();
include('dbconnection.php');

if (!isset($_SESSION['Aid'])) {
	echo "<script>window.alert('Please Sign In First!')</script>";
	echo "<script>window.location='adminsignin.php'</script>";
}

$username=$_SESSION['Uname'];
$Apfp=$_SESSION['Apfp'];

if (isset($_POST['btnAdd'])) {
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

    $selectquery="SELECT * FROM holidayhometb WHERE HolidayHomeName='$HHname'";
    $runselect=mysqli_query($connect, $selectquery);
    $rowcount=mysqli_num_rows($runselect);
    if ($rowcount>0) {
    	echo "<script>window.alert('Holiday Home Already Existed!')</script>";
    }
    // else if ($HHtype === "") {
    //     echo "Please Select a Holiday Home Type!";
    // }
    else
    {
    	$HHimg1=$_FILES['HHimg1']['name'];
        $copyfolder="images/";
        $filename1=$copyfolder.uniqid()."_".$HHimg1;
        $copy=copy($_FILES['HHimg1']['tmp_name'], $filename1);
        if (!$copy) 
        {
            echo "<p>Holiday Home Image 1 cannot be uploaded. Please try again!</p>";
            exit();
        }

        $HHimg2=$_FILES['HHimg2']['name'];
        $copyfolder="images/";
        $filename2=$copyfolder.uniqid()."_".$HHimg2;
        $copy=copy($_FILES['HHimg2']['tmp_name'], $filename2);
        if (!$copy) 
        {
            echo "<p>Holiday Home Image 2 cannot be uploaded. Please try again!</p>";
            exit();
        }

        $HHimg3=$_FILES['HHimg3']['name'];
        $copyfolder="images/";
        $filename3=$copyfolder.uniqid()."_".$HHimg3;
        $copy=copy($_FILES['HHimg3']['tmp_name'], $filename3);
        if (!$copy) 
        {
            echo "<p>Holiday Home Image 3 cannot be uploaded. Please try again!</p>";
            exit();
        }
        
        $HHimg4=$_FILES['HHimg4']['name'];
        $copyfolder="images/";
        $filename4=$copyfolder.uniqid()."_".$HHimg4;
        $copy=copy($_FILES['HHimg4']['tmp_name'], $filename4);
        if (!$copy) 
        {
            echo "<p>Holiday Home Image 4 cannot be uploaded. Please try again!</p>";
            exit();
        }

        $HHimg5=$_FILES['HHimg5']['name'];
        $copyfolder="images/";
        $filename5=$copyfolder.uniqid()."_".$HHimg5;
        $copy=copy($_FILES['HHimg5']['tmp_name'], $filename5);
        if (!$copy) 
        {
            echo "<p>Holiday Home Image 5 cannot be uploaded. Please try again!</p>";
            exit();
        }

        $insert="INSERT INTO holidayhometb (HolidayHomeName, HolidayHomeLocation, HolidayHomeMap, HolidayHomeDescription, PricePerNight, NumberOfBed, NumberOfBathroom, NumberOfGuest, HolidayHomeTypeID, HolidayHomeImage1, HolidayHomeImage2, HolidayHomeImage3, HolidayHomeImage4, HolidayHomeImage5, Wifi, Kitchen, PetFriendly, SelfCheckIn, Washer, Toiletries)
        VALUES('$HHname', '$HHlocation', '$HHmap',  '$HHdesc', '$HHprice', '$HHbed', '$HHbathroom', '$HHguest', '$HHtype', '$filename1', '$filename2', '$filename3', '$filename4', '$filename5', '$cbowifi', '$cbokitchen', '$cbopet', '$cboselfcheckin', '$cbowasher', '$cbotoiletries')";
        $runinsert=mysqli_query($connect,$insert);
        if ($runinsert)
        {
            echo "<script>window.alert('Holiday Home Added Successfully!')</script>";
            echo "<script>window.location='dashboard.php'</script>";
        }
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
 	<title>ADD HOLIDAY HOME | AUTUNNO</title>
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
                <h2>Add Holiday Home</h2>                
                <form class="adminadddataform" action="addholidayhome.php" method="POST" enctype="multipart/form-data">
                    <div class="sidebysidediv">
                        <div>
                            <label>Holiday Home Name</label>
                            <input type="text" name="txtHHname" class="textbox" placeholder="Enter Name of Holiday Home" required>

                            <label>Holiday Home Type</label>
                            <select  name="slHHtype" required>
                                <option value="">Select a Holiday Home Type</option>
                                <?php
                                    $select="SELECT * FROM holidayhometypetb";
                                    $query=mysqli_query($connect, $select);
                                    $count=mysqli_num_rows($query);
                                    for ($i=0; $i < $count ; $i++) 
                                    { 
                                        $row=mysqli_fetch_array($query);
                                        $HTid=$row['HolidayHomeTypeID'];
                                        $HTname=$row['HolidayHomeTypeName'];
                                        echo "<option value='$HTid'>$HTname</option>";
                                    }
                                ?>
                            </select>

                            <label>Location</label>
                            <input type="text" name="txtHHlocation" class="textbox" placeholder="Enter Location of Holiday Home" required>

                            <label>Map</label>
                            <textarea name="txtHHmap" placeholder="Enter Google Map URL" required></textarea>
                            
                            <label>Description</label>
                            <textarea name="txtHHdesc" placeholder="Write a Description for Holiday Home" required></textarea>

                            <label>Price Per Night</label>
                            <input type="number" step="0.01" name="txtHHprice" class="textbox" placeholder="Price Per Night of Holiday Home" required>

                            <div class="sidebysidediv">
                                <div>
                                    <input type="checkbox" name="cbowifi" value="1"><label class="forcheckbox">Wifi</label>
                                    <br>

                                    <input type="checkbox" name="cbokitchen" value="1"><label class="forcheckbox">Kitchen</label>
                                    <br>

                                    <input type="checkbox" name="cbowasher" value="1"><label class="forcheckbox">Washer</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="cbopet" value="1"><label class="forcheckbox">Pet Friendly</label>
                                    <br>

                                    <input type="checkbox" name="cboselfcheckin" value="1"><label class="forcheckbox">Self Check In</label>
                                    <br>

                                    <input type="checkbox" name="cbotoiletries" value="1"><label class="forcheckbox">Toiletries</label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label>Number Of Bed</label>
                            <input type="number" step="1" name="txtHHbed" class="textbox" placeholder="Number of Bed in Holiday Home" required>

                            <label>Number Of Bathroom</label>
                            <input type="number" step="1" name="txtHHbathroom" class="textbox" placeholder="Number of Bathroom in Holiday Home" required>

                            <label>Number Of Maximum Guest</label>
                            <input type="number" step="1" name="txtHHguest" class="textbox" placeholder="Number of Maximum Guest" required>

                            <label>Holiday Home Image 1</label>
                            <input type="file" name="HHimg1" required>

                            <label>Holiday Home Image 2</label>
                            <input type="file" name="HHimg2" required>

                            <label>Holiday Home Image 3</label>
                            <input type="file" name="HHimg3" required>

                            <label>Holiday Home Image 4</label>
                            <input type="file" name="HHimg4" required>

                            <label>Holiday Home Image 5</label>
                            <input type="file" name="HHimg5" required>
                        </div>
                    </div>

                    <input class="btnAdd" name="btnAdd" type="submit" value="Add">
                </form>
            </div>
        </div>        
    </section>
 </body>
 </html>