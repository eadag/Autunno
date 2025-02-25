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

$search = '';

if (isset($_GET['btnSearch'])) {
    $search = $_GET['txtSearch'];

    $safe_search = mysqli_real_escape_string($connect, $search);

    function highlight($text, $safe_search) {
        return str_ireplace($safe_search, "<span class='highlight'>" . $safe_search . "</span>", $text);
    }
    
    $results = [];

    $HTsearchquery = "
        SELECT * FROM holidayhometypetb
        WHERE HolidayHomeTypeID LIKE '%$safe_search%' 
        OR HolidayHomeTypeName LIKE '%$safe_search%'
    ";
    $HTresults = mysqli_query($connect, $HTsearchquery);
    $results['holidayhometypetb'] = $HTresults;

    $HHsearchquery = "
        SELECT * FROM holidayhometb
        WHERE HolidayHomeID LIKE '%$safe_search%' 
        OR HolidayHomeName LIKE '%$safe_search%'
        OR HolidayHomeTypeID LIKE '%$safe_search%'
        OR HolidayHomeLocation LIKE '%$safe_search%'
        OR PricePerNight LIKE '%$safe_search%'
        OR NumberOfBed LIKE '%$safe_search%'
        OR NumberOfBathroom LIKE '%$safe_search%'
        OR NumberOfGuest LIKE '%$safe_search%'
        OR Wifi LIKE '%$safe_search%'
        OR Kitchen LIKE '%$safe_search%'
        OR PetFriendly LIKE '%$safe_search%'
        OR SelfCheckIn LIKE '%$safe_search%'
        OR Washer LIKE '%$safe_search%'
        OR Toiletries LIKE '%$safe_search%'
    ";
    $HHsearchresults = mysqli_query($connect, $HHsearchquery);
    $results['holidayhometb'] = $HHsearchresults;

    $PMsearchquery = "
        SELECT * FROM paymentmethodtb
        WHERE PaymentMethodID LIKE '%$safe_search%' 
        OR PaymentMethodName LIKE '%$safe_search%'
    ";
    $PMsearchresults = mysqli_query($connect, $PMsearchquery);
    $results['paymentmethodtb'] = $PMsearchresults;

    $Mbsearchquery = "
        SELECT * FROM membertb
        WHERE MemberID LIKE '%$safe_search%' 
        OR Username LIKE '%$safe_search%'
        OR FirstName LIKE '%$safe_search%'
        OR LastName LIKE '%$safe_search%'
        OR Email LIKE '%$safe_search%'
        OR ContactNumber LIKE '%$safe_search%'
    ";
    $Mbsearchresults = mysqli_query($connect, $Mbsearchquery);
    $results['membertb'] = $Mbsearchresults;

    $Schedulesearchquery = "
        SELECT * FROM scheduletb
        WHERE ScheduleID LIKE '%$safe_search%' 
        OR AdministratorID LIKE '%$safe_search%'
        OR ScheduleCreatedDate LIKE '%$safe_search%'
    ";
    $Schedulesearchresults = mysqli_query($connect, $Schedulesearchquery);
    $results['scheduletb'] = $Schedulesearchresults;

    $SDsearchquery = "
        SELECT * FROM scheduledetailstb
        WHERE ScheduleID LIKE '%$safe_search%' 
        OR HolidayHomeID LIKE '%$safe_search%'
        OR ScheduleStartDate LIKE '%$safe_search%'
        OR ScheduleEndDate LIKE '%$safe_search%'
    ";
    $SDsearchresults = mysqli_query($connect, $SDsearchquery);
    $results['scheduledetailstb'] = $SDsearchresults;

    $Bookingsearchquery = "
        SELECT * FROM bookingtb
        WHERE BookingID LIKE '%$safe_search%' 
        OR MemberID LIKE '%$safe_search%'
        OR PaymentDate LIKE '%$safe_search%'
        OR GrandTotalPrice LIKE '%$safe_search%'
        OR PaymentMethodID LIKE '%$safe_search%'
    ";
    $Bookingsearchresults = mysqli_query($connect, $Bookingsearchquery);
    $results['bookingtb'] = $Bookingsearchresults;

    $BDsearchquery = "
        SELECT * FROM bookingdetailstb
        WHERE BookingID LIKE '%$safe_search%' 
        OR HolidayHomeID LIKE '%$safe_search%'
        OR CheckInDate LIKE '%$safe_search%'
        OR CheckOutDate LIKE '%$safe_search%'
        OR TotalPrice LIKE '%$safe_search%'
        OR TotalGuests LIKE '%$safe_search%'
    ";
    $BDsearchresults = mysqli_query($connect, $BDsearchquery);
    $results['bookingdetailstb'] = $BDsearchresults;

}

?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
 	<title>DASHBOARD | AUTUNNO</title>
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
            <div class="maindashboard">
                <div class="greeting">
                    <h1>Welcome To Administrator Dashboard, <?php echo $firstname; ?>!</h1>
                </div>
                <div class="searchcontainer">
                    <form class="searchform" action="dashboard.php" method="GET">
                        <div class="searchbarnbtn">
                            <input class="searchbar" type="text" name="txtSearch" placeholder="Search Something" value ="<?php echo htmlspecialchars($search); ?>" required>
                            <input class="btnSearch" type="submit" name="btnSearch" value="Search">

                            <?php if (isset($_GET['btnSearch'])) {
                                echo "<a href='dashboard.php'><i id='xmark' class='fa-solid fa-xmark'></i> Clear All</a>";
                            } ?>
                        </div>
                    </form>
                    <div class="searchresults">
                        <?php
                            if (isset($_GET['btnSearch'])) {
                                echo "<h2>Search Results</h2>";
                            }
                        ?>

                        <?php if (isset($results['holidayhometypetb']) && mysqli_num_rows($results['holidayhometypetb']) > 0) { ?>
                            <h3>From Holiday Home Types, </h3>
                            <table>
                                <tr>
                                    <th>Holiday Home Type ID</th>
                                    <th>Holiday Home Type</th>
                                    <th>Action</th>
                                </tr>
                                <?php while ($row = mysqli_fetch_assoc($results['holidayhometypetb'])) { ?>
                                    <tr>
                                        <td><?php echo highlight($row['HolidayHomeTypeID'], $safe_search)?></td>
                                        <td><?php echo highlight($row['HolidayHomeTypeName'], $safe_search)?></td>
                                        <td>
                                            <a title="Update" href="holidayhometypeupdate.php?HTid=<?php echo $row['HolidayHomeTypeID']; ?>"><i class="fa-solid fa-pen"></i></a>
                                            <a title="Delete" href="holidayhometypedelete.php?HTid=<?php echo $row['HolidayHomeTypeID']; ?>"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } 
                        else if (isset($results['holidayhometypetb'])) { ?>
                            <h3><i class="fa-regular fa-face-frown"></i> No Results From Holiday Home Types.</h3>
                        <?php } ?>
                        
                        <?php if (isset($results['holidayhometb']) && mysqli_num_rows($results['holidayhometb']) > 0) { ?>
                            <h3>From Holiday Homes, </h3>
                            <table>
                            <tr>
                                <th>Holiday Home ID</th>
                                <th>Holiday Home Name</th>
                                <th>Location</th>
                                <th>Map</th>
                                <th>Price Per Night</th>
                                <th>Number of Bed</th>
                                <th>Number of Bathoom</th>
                                <th>Number of Guest</th>
                                <th>Holiday Home Type ID</th>
                                <th>Image 1</th>
                                <th>Image 2</th>
                                <th>Image 3</th>
                                <th>Image 4</th>
                                <th>Image 5</th>
                                <th>Wifi</th>
                                <th>Kitchen</th>
                                <th>Pet Friendly</th>
                                <th>Self Check In</th>
                                <th>Washer</th>
                                <th>Toiletries</th>
                                <th>Action</th>
                            </tr>
                                <?php while ($row = mysqli_fetch_assoc($results['holidayhometb'])) { ?>
                                    <tr>
                                        <td><?php echo highlight($row['HolidayHomeID'], $safe_search); ?></td>
                                        <td><?php echo highlight($row['HolidayHomeName'], $safe_search); ?></td>
                                        <td><?php echo highlight($row['HolidayHomeLocation'], $safe_search); ?></td>
                                        <td><iframe src="<?php echo $row['HolidayHomeMap']; ?>"></iframe></td>
                                        <td><?php echo highlight($row['PricePerNight'], $safe_search); ?></td>
                                        <td><?php echo highlight($row['NumberOfBed'], $safe_search); ?></td>
                                        <td><?php echo highlight($row['NumberOfBathroom'], $safe_search); ?></td>
                                        <td><?php echo highlight($row['NumberOfGuest'], $safe_search); ?></td>
                                        <td><?php echo highlight($row['HolidayHomeTypeID'], $safe_search); ?></td>
                                        <td><img src="<?php echo $row['HolidayHomeImage1']; ?>" alt="Holiday Home Image 1"></td>
                                        <td><img src="<?php echo $row['HolidayHomeImage2']; ?>" alt="Holiday Home Image 2"></td>
                                        <td><img src="<?php echo $row['HolidayHomeImage3']; ?>" alt="Holiday Home Image 3"></td>
                                        <td><img src="<?php echo $row['HolidayHomeImage4']; ?>" alt="Holiday Home Image 4"></td>
                                        <td><img src="<?php echo $row['HolidayHomeImage5']; ?>" alt="Holiday Home Image 5"></td>
                                        <td><?php echo highlight($row['Wifi'], $safe_search); ?></td>
                                        <td><?php echo highlight($row['Kitchen'], $safe_search); ?></td>
                                        <td><?php echo highlight($row['PetFriendly'], $safe_search); ?></td>
                                        <td><?php echo highlight($row['SelfCheckIn'], $safe_search); ?></td>
                                        <td><?php echo highlight($row['Washer'], $safe_search); ?></td>
                                        <td><?php echo highlight($row['Toiletries'], $safe_search); ?></td>
                                        <td>
                                            <a title="Update" href="holidayhomeupdate.php?<?php echo $row['HolidayHomeID']; ?>"><i class="fa-solid fa-pen"></i></a>
                                            <a title="Delete" href="holidayhomedelete.php?<?php echo $row['HolidayHomeID']; ?>"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } 
                        else if (isset($results['holidayhometb'])) { ?>
                            <h3><i class="fa-regular fa-face-frown"></i> No Results From Holiday Homes.</h3>
                        <?php } ?>
                        
                        <?php if (isset($results['paymentmethodtb']) && mysqli_num_rows($results['paymentmethodtb']) > 0) { ?>
                            <h3>From Payment Methods, </h3>
                            <table>
                                <tr>
                                    <th>Payment Method ID</th>
                                    <th>Payment Method</th>
                                    <th>Action</th>
                                </tr>
                                <?php while ($row = mysqli_fetch_assoc($results['paymentmethodtb'])) { ?>
                                    <tr>
                                        <td><?php echo highlight($row['PaymentMethodID'], $safe_search)?></td>
                                        <td><?php echo highlight($row['PaymentMethodName'], $safe_search)?></td>
                                        <td>
                                            <a title="Update" href="paymentmethodupdate.php?PMid=<?php echo $row['PaymentMethodID']; ?>"><i class="fa-solid fa-pen"></i></a>
                                            <a title="Delete" href="paymentmethoddelete.php?PMid=<?php echo $row['PaymentMethodID']; ?>"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } 
                        else if (isset($results['paymentmethodtb'])) { ?>
                            <h3><i class="fa-regular fa-face-frown"></i> No Results From Payment Methods.</h3>
                        <?php } ?>

                        <?php if (isset($results['scheduletb']) && mysqli_num_rows($results['scheduletb']) > 0) { ?>
                            <h3>From Schedules, </h3>
                            <table>
                                <tr>
                                    <th>Schedule ID</th>
                                    <th>Administrator ID</th>
                                    <th>Schedule Created Date</th>
                                    <th>Action</th>
                                </tr>
                                <?php while ($row = mysqli_fetch_assoc($results['scheduletb'])) { ?>
                                    <tr>
                                        <td><?php echo highlight($row['ScheduleID'], $safe_search)?></td>
                                        <td><?php echo highlight($row['AdministratorID'], $safe_search)?></td>
                                        <td><?php echo highlight($row['ScheduleCreatedDate'], $safe_search)?></td>
                                        <td>
                                            <a title="Update" href="scheduleupdate.php?Sid=<?php echo $row['ScheduleID']; ?>"><i class="fa-solid fa-pen"></i></a>
                                            <a title="Delete" href="scheduledelete.php?Sid=<?php echo $row['ScheduleID']; ?>"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } 
                        else if (isset($results['scheduletb'])) { ?>
                            <h3><i class="fa-regular fa-face-frown"></i> No Results From Schedules.</h3>
                        <?php } ?>

                        <?php if (isset($results['scheduledetailstb']) && mysqli_num_rows($results['scheduledetailstb']) > 0) { ?>
                            <h3>From Schedule Details, </h3>
                            <table>
                                <tr>
                                    <th>Schedule ID</th>
                                    <th>Holiday Home ID</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                                <?php while ($row = mysqli_fetch_assoc($results['scheduledetailstb'])) { ?>
                                    <tr>
                                        <td><?php echo highlight($row['ScheduleID'], $safe_search)?></td>
                                        <td><?php echo highlight($row['HolidayHomeID'], $safe_search)?></td>
                                        <td><?php echo highlight($row['ScheduleStartDate'], $safe_search)?></td>
                                        <td><?php echo highlight($row['ScheduleEndDate'], $safe_search)?></td>
                                        <td>
                                            <a title="Update" href="scheduledetailsupdate.php?Sid=<?php echo $row['ScheduleID']; ?>"><i class="fa-solid fa-pen"></i></a>
                                            <a title="Delete" href="scheduledetailsdelete.php?Sid=<?php echo $row['ScheduleID']; ?>"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } 
                        else if (isset($results['scheduledetailstb'])) { ?>
                            <h3><i class="fa-regular fa-face-frown"></i> No Results From Schedule Details.</h3>
                        <?php } ?>

                        <?php if (isset($results['membertb']) && mysqli_num_rows($results['membertb']) > 0) { ?>
                            <h3>From Members, </h3>
                            <table>
                                <tr>
                                    <th>Member ID</th>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Profile Image</th>
                                </tr>
                                <?php while ($row = mysqli_fetch_assoc($results['membertb'])) { ?>
                                    <tr>
                                        <td><?php echo highlight($row['MemberID'], $safe_search)?></td>
                                        <td><?php echo highlight($row['Username'], $safe_search)?></td>
                                        <td><?php echo highlight($row['FirstName'], $safe_search)?></td>
                                        <td><?php echo highlight($row['LastName'], $safe_search)?></td>
                                        <td><?php echo highlight($row['Email'], $safe_search)?></td>
                                        <td><?php echo highlight($row['ContactNumber'], $safe_search)?></td>
                                        <td><img class="Mpfp" src="<?php echo $row['ProfileImage'] ?>" alt="Member Profile Image"></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } 
                        else if (isset($results['membertb'])) { ?>
                            <h3><i class="fa-regular fa-face-frown"></i> No Results From Members.</h3>
                        <?php } ?>

                        <?php if (isset($results['bookingtb']) && mysqli_num_rows($results['bookingtb']) > 0) { ?>
                            <h3>From Bookings, </h3>
                            <table>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Member ID</th>
                                    <th>Payment Date</th>
                                    <th>Grand Total Price</th>
                                    <th>Payment Method ID</th>
                                </tr>
                                <?php while ($row = mysqli_fetch_assoc($results['bookingtb'])) { ?>
                                    <tr>
                                        <td><?php echo highlight($row['BookingID'], $safe_search)?></td>
                                        <td><?php echo highlight($row['MemberID'], $safe_search)?></td>
                                        <td><?php echo highlight($row['PaymentDate'], $safe_search)?></td>
                                        <td><?php echo highlight($row['GrandTotalPrice'], $safe_search)?></td>
                                        <td><?php echo highlight($row['PaymentMethodID'], $safe_search)?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } 
                        else if (isset($results['bookingtb'])) { ?>
                            <h3><i class="fa-regular fa-face-frown"></i> No Results From Bookings.</h3>
                        <?php } ?>

                        <?php if (isset($results['bookingdetailstb']) && mysqli_num_rows($results['bookingdetailstb']) > 0) { ?>
                            <h3>From Bookings Details, </h3>
                            <table>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Holiday Home ID</th>
                                    <th>Check In Date</th>
                                    <th>Check Out Date</th>
                                    <th>Total Price</th>
                                    <th>Total Guests</th>
                                </tr>
                                <?php while ($row = mysqli_fetch_assoc($results['bookingdetailstb'])) { ?>
                                    <tr>
                                        <td><?php echo highlight($row['BookingID'], $safe_search)?></td>
                                        <td><?php echo highlight($row['HolidayHomeID'], $safe_search)?></td>
                                        <td><?php echo highlight($row['CheckInDate'], $safe_search)?></td>
                                        <td><?php echo highlight($row['CheckOutDate'], $safe_search)?></td>
                                        <td><?php echo highlight($row['TotalPrice'], $safe_search)?></td>
                                        <td><?php echo highlight($row['TotalGuests'], $safe_search)?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } 
                        else if (isset($results['bookingdetailstb'])) { ?>
                            <h3><i class="fa-regular fa-face-frown"></i> No Results From Booking Details.</h3>
                        <?php } ?>
                    </div>
                </div>
                <div class="totalsection">
                    <div class="totalcard">
                        <span>
                            <?php
                            $countHH = "SELECT COUNT(*) AS total FROM holidayhometb";
                            $runcount = mysqli_query($connect, $countHH);
                            
                            $row = mysqli_fetch_assoc($runcount);
                            
                            $totalHH = $row['total'];
                            
                            echo $totalHH;
                            ?>
                        </span>
                        <b>Holiday Homes</b>
                    </div>
                    <div class="totalcard">
                        <span>
                            <?php
                            $countMb = "SELECT COUNT(*) AS total FROM membertb";
                            $runcount = mysqli_query($connect, $countMb);
                            
                            $row = mysqli_fetch_assoc($runcount);
                            
                            $totalMb = $row['total'];
                            
                            echo $totalMb;
                            ?>
                        </span>
                        <b>Members</b>
                    </div>
                    <div class="totalcard">
                        <span>
                            <?php
                            $countB = "SELECT COUNT(*) AS total FROM bookingdetailstb";
                            $runcount = mysqli_query($connect, $countB);
                            
                            $row = mysqli_fetch_assoc($runcount);
                            
                            $totalBookings = $row['total'];
                            
                            echo $totalBookings;
                            ?>
                        </span>
                        <b>Bookings</b>
                    </div>
                    <div class="totalcard">
                        <span>
                            <?php
                            $countNS = "SELECT COUNT(*) AS total FROM newslettersubscriptiontb";
                            $runcount = mysqli_query($connect, $countNS);
                            
                            $row = mysqli_fetch_assoc($runcount);
                            
                            $totalNS = $row['total'];
                            
                            echo $totalNS;
                            ?>
                        </span>
                        <b>Subscriptions</b>
                    </div>
                    <div class="totalcard">
                        <span>
                            <?php
                            $countRv = "SELECT COUNT(*) AS total FROM reviewtb";
                            $runcount = mysqli_query($connect, $countRv);
                            
                            $row = mysqli_fetch_assoc($runcount);
                            
                            $totalRv = $row['total'];
                            
                            echo $totalRv;
                            ?>
                        </span>
                        <b>Reviews</b>
                    </div>
                </div>
                <div class="datamanagement">
                    <div class="dmtables">
                        <h2>Holiday Home Type Management</h2>
                        <table>
                            <tr>
                                <th>
                                    Holiday Home Type ID
                                </th>
                                <th>
                                    Holiday Home Type Name
                                </th>
                                <th>Action</th>
                            </tr>
                            <?php 

                            $HTselect="SELECT * FROM holidayhometypetb";
                            $runselect=mysqli_query($connect, $HTselect);

                            $count=mysqli_num_rows($runselect);

                            for ($i=0; $i < $count; $i++) 
                            { 
                                $HTarray=mysqli_fetch_array($runselect);
                                $HTid=$HTarray['HolidayHomeTypeID'];
                                $HTname=$HTarray['HolidayHomeTypeName'];

                                echo "<tr>";
                                    echo "<td>$HTid</td>";
                                    echo "<td>$HTname</td>";
                                    echo "<td>
                                    <a title='Update' href='holidayhometypeupdate.php?HTid=$HTid'><i class='fa-solid fa-pen'></i></a>
                                    <a title='Delete' href='holidayhometypedelete.php?HTid=$HTid'><i class='fa-solid fa-trash-can'></i></a>
                                    </td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <div class="dmtables">
                        <h2>Holiday Home Management</h2>
                        <table>
                            <tr>
                            <th>Holiday Home ID</th>
                                <th>Holiday Home Name</th>
                                <th>Location</th>
                                <th>Map</th>
                                <th>Description</th>
                                <th>Price Per Night</th>
                                <th>Number of Bed</th>
                                <th>Number of Bathoom</th>
                                <th>Number of Guest</th>
                                <th>Holiday Home Type ID</th>
                                <th>Image 1</th>
                                <th>Image 2</th>
                                <th>Image 3</th>
                                <th>Image 4</th>
                                <th>Image 5</th>
                                <th>Wifi</th>
                                <th>Kitchen</th>
                                <th>Pet Friendly</th>
                                <th>Self Check In</th>
                                <th>Washer</th>
                                <th>Toiletries</th>
                                <th>Action</th>
                            </tr>
                            <?php 

                            $HHselect="SELECT * FROM holidayhometb";
                            $runselect=mysqli_query($connect, $HHselect);

                            $count=mysqli_num_rows($runselect);

                            for ($i=0; $i < $count; $i++) 
                            { 
                                $HHarray=mysqli_fetch_array($runselect);
                                $HHid=$HHarray['HolidayHomeID'];
                                $HHname=$HHarray['HolidayHomeName'];
                                $location=$HHarray['HolidayHomeLocation'];
                                $map=$HHarray['HolidayHomeMap'];
                                $desc=$HHarray['HolidayHomeDescription'];

                                $shortenDesc = substr($desc, 0, 100);

                                $price=$HHarray['PricePerNight'];
                                $bed=$HHarray['NumberOfBed'];
                                $bath=$HHarray['NumberOfBathroom'];
                                $guest=$HHarray['NumberOfGuest'];
                                $htid=$HHarray['HolidayHomeTypeID'];
                                $img1=$HHarray['HolidayHomeImage1'];
                                $img2=$HHarray['HolidayHomeImage2'];
                                $img3=$HHarray['HolidayHomeImage3'];
                                $img4=$HHarray['HolidayHomeImage4'];
                                $img5=$HHarray['HolidayHomeImage5'];
                                $wifi=$HHarray['Wifi'];
                                $kitchen=$HHarray['Kitchen'];
                                $pet=$HHarray['PetFriendly'];
                                $selfcheckin=$HHarray['SelfCheckIn'];
                                $washer=$HHarray['Washer'];
                                $toiletries=$HHarray['Toiletries'];

                                echo "<tr>";
                                    echo "<td>$HHid</td>";
                                    echo "<td>$HHname</td>";
                                    echo "<td>$location</td>";
                                    echo "<td><iframe src='$map'></iframe></td>";
                                    echo "<td>
                                            <div class='description'>
                                                <span class='shortdesc'>$shortenDesc...</span>
                                                <span class='fulldesc' style='display:none;'>$desc</span>
                                                <a href='javascript:void(0);' onclick='ShowFullDescription(this)'>Show more</a>
                                            </div>
                                        </td>";
                                    echo "<td>$price</td>";
                                    echo "<td>$bed</td>";
                                    echo "<td>$bath</td>";
                                    echo "<td>$guest</td>";
                                    echo "<td>$htid</td>";
                                    echo "<td><img src='$img1'></td>";
                                    echo "<td><img src='$img2'></td>";
                                    echo "<td><img src='$img3'></td>";
                                    echo "<td><img src='$img4'></td>";
                                    echo "<td><img src='$img5'></td>";
                                    echo "<td>$wifi</td>";
                                    echo "<td>$kitchen</td>";
                                    echo "<td>$pet</td>";
                                    echo "<td>$selfcheckin</td>";
                                    echo "<td>$washer</td>";
                                    echo "<td>$toiletries</td>";
                                    echo "<td>
                                    <a title='Update' href='holidayhomeupdate.php?HHid=$HHid'><i class='fa-solid fa-pen'></i></a>
                                    <a title='Delete' href='holidayhomedelete.php?HHid=$HHid'><i class='fa-solid fa-trash-can'></i></a>
                                    </td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <script>
                        function ShowFullDescription(link) {
                            var shortdesc = link.parentElement.querySelector('.shortdesc');
                            var fulldesc = link.parentElement.querySelector('.fulldesc');

                            if (shortdesc.style.display === 'none') {
                                shortdesc.style.display = 'inline';
                                fulldesc.style.display = 'none';
                                link.textContent = 'Show more';
                            }
                            else {
                                shortdesc.style.display = 'none';
                                fulldesc.style.display = 'inline';
                                link.textContent = 'Show less';
                            }
                        }
                    </script>
                    <div class="dmtables">
                        <h2>Payment Method Management</h2>
                        <table>
                            <tr>
                                <th>
                                    Payment Method ID
                                </th>
                                <th>
                                    Payment Method Name
                                </th>
                                <th>Action</th>
                            </tr>
                            <?php 

                            $Pselect="SELECT * FROM paymentmethodtb";
                            $runselect=mysqli_query($connect, $Pselect);

                            $count=mysqli_num_rows($runselect);

                            for ($i=0; $i < $count; $i++) 
                            { 
                                $Parray=mysqli_fetch_array($runselect);
                                $Pid=$Parray['PaymentMethodID'];
                                $Pname=$Parray['PaymentMethodName'];

                                echo "<tr>";
                                    echo "<td>$Pid</td>";
                                    echo "<td>$Pname</td>";
                                    echo "<td>
                                    <a title='Update' href='paymentmethodupdate.php?PMid=$Pid'><i class='fa-solid fa-pen'></i></a>
                                    <a title='Delete' href='paymentmethoddelete.php?PMid=$Pid'><i class='fa-solid fa-trash-can'></i></a>
                                    </td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <div class="dmtables">
                        <h2>Schedule Management</h2>
                        <table>
                            <tr>
                                <th>
                                    Schedule ID
                                </th>
                                <th>
                                    Administrator ID
                                </th>
                                <th>
                                    Schedule Created Date
                                </th>
                                <th>Action</th>
                            </tr>
                            <?php 

                            $Sselect="SELECT * FROM scheduletb";
                            $runselect=mysqli_query($connect, $Sselect);

                            $count=mysqli_num_rows($runselect);

                            for ($i=0; $i < $count; $i++) 
                            { 
                                $Sarray=mysqli_fetch_array($runselect);
                                $Sid=$Sarray['ScheduleID'];
                                $Aid=$Sarray['AdministratorID'];
                                $Sdate=$Sarray['ScheduleCreatedDate'];

                                echo "<tr>";
                                    echo "<td>$Sid</td>";
                                    echo "<td>$Aid</td>";
                                    echo "<td>$Sdate</td>";
                                    echo "<td>
                                    <a title='Update' href='scheduleupdate.php?Sid=$Sid'><i class='fa-solid fa-pen'></i></a>
                                    <a title='Delete' href='scheduledelete.php?Sid=$Sid'><i class='fa-solid fa-trash-can'></i></a>
                                    </td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <div class="dmtables">
                        <h2>Schedule Details Management</h2>
                        <table>
                            <tr>
                                <th>
                                    Schedule ID
                                </th>
                                <th>
                                    Holiday Home ID
                                </th>
                                <th>
                                    Start Date
                                </th>
                                <th>
                                    End Date
                                </th>
                                <th>Action</th>
                            </tr>
                            <?php 

                            $SDselect="SELECT * FROM scheduledetailstb";
                            $runselect=mysqli_query($connect, $SDselect);

                            $count=mysqli_num_rows($runselect);

                            for ($i=0; $i < $count; $i++) 
                            { 
                                $SDarray=mysqli_fetch_array($runselect);
                                $Sid=$SDarray['ScheduleID'];
                                $HHid=$SDarray['HolidayHomeID'];
                                $startdate=$SDarray['ScheduleStartDate'];
                                $enddate=$SDarray['ScheduleEndDate'];

                                echo "<tr>";
                                    echo "<td>$Sid</td>";
                                    echo "<td>$HHid</td>";
                                    echo "<td>$startdate</td>";
                                    echo "<td>$enddate</td>";
                                    echo "<td>
                                    <a title='Update' href='scheduledetailsupdate.php?Sid=$Sid&Hid=$HHid'><i class='fa-solid fa-pen'></i></a>
                                    <a title='Delete' href='scheduledetailsdelete.php?Sid=$Sid&Hid=$HHid'><i class='fa-solid fa-trash-can'></i></a>
                                    </td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <div class="dmtables">
                        <h2>Member List</h2>
                        <table>
                            <tr>
                                <th>Member ID</th>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Profile Image</th>
                            </tr>
                            <?php 

                            $Mselect="SELECT * FROM membertb";
                            $runselect=mysqli_query($connect, $Mselect);

                            $count=mysqli_num_rows($runselect);

                            for ($i=0; $i < $count; $i++) 
                            { 
                                $Marray=mysqli_fetch_array($runselect);
                                $Mid=$Marray['MemberID'];
                                $username=$Marray['Username'];
                                $fn=$Marray['FirstName'];
                                $ln=$Marray['LastName'];
                                $email=$Marray['Email'];
                                $phnum=$Marray['ContactNumber'];
                                $pfp=$Marray['ProfileImage'];

                                echo "<tr>";
                                    echo "<td>$Mid</td>";
                                    echo "<td>$username</td>";
                                    echo "<td>$fn</td>";
                                    echo "<td>$ln</td>";
                                    echo "<td>$email</td>";
                                    echo "<td>$phnum</td>";
                                    echo "<td><img class='Mpfp' src='$pfp'></td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <div class="dmtables">
                        <h2>Booking List</h2>
                        <table>
                            <tr>
                                <th>
                                    Booking ID
                                </th>
                                <th>
                                    Member ID
                                </th>
                                <th>
                                    Payment Date
                                </th>
                                <th>
                                    Grand Total Price
                                </th>
                                <th>
                                    Payment Method ID
                                </th>
                            </tr>
                            <?php 

                            $Bselect="SELECT * FROM bookingtb";
                            $runselect=mysqli_query($connect, $Bselect);

                            $count=mysqli_num_rows($runselect);

                            for ($i=0; $i < $count; $i++) 
                            { 
                                $Barray=mysqli_fetch_array($runselect);
                                $Bid=$Barray['BookingID'];
                                $Mid=$Barray['MemberID'];
                                $Pdate=$Barray['PaymentDate'];
                                $grandtotal=$Barray['GrandTotalPrice'];
                                $paymentmethod=$Barray['PaymentMethodID'];

                                echo "<tr>";
                                    echo "<td>$Bid</td>";
                                    echo "<td>$Mid</td>";
                                    echo "<td>$Pdate</td>";
                                    echo "<td>$grandtotal</td>";
                                    echo "<td>$paymentmethod</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <div class="dmtables">
                        <h2>Booking Details</h2>
                        <table>
                            <tr>
                                <th>
                                    Booking ID
                                </th>
                                <th>
                                    Holiday Home ID
                                </th>
                                <th>
                                    Check In Date
                                </th>
                                <th>
                                    Check Out Date
                                </th>
                                <th>
                                    Total Price
                                </th>
                                <th>
                                    Total Guests
                                </th>
                            </tr>
                            <?php 

                            $BDselect="SELECT * FROM bookingdetailstb";
                            $runselect=mysqli_query($connect, $BDselect);

                            $count=mysqli_num_rows($runselect);

                            for ($i=0; $i < $count; $i++) 
                            { 
                                $BDarray=mysqli_fetch_array($runselect);
                                $Bid=$BDarray['BookingID'];
                                $HHid=$BDarray['HolidayHomeID'];
                                $CIdate=$BDarray['CheckInDate'];
                                $COdate=$BDarray['CheckOutDate'];
                                $totalprice=$BDarray['TotalPrice'];
                                $totalguests=$BDarray['TotalGuests'];

                                echo "<tr>";
                                    echo "<td>$Bid</td>";
                                    echo "<td>$HHid</td>";
                                    echo "<td>$CIdate</td>";
                                    echo "<td>$COdate</td>";
                                    echo "<td>$totalprice</td>";
                                    echo "<td>$totalguests</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <div class="dmtables">
                        <h2>Newsletter Subscriber List</h2>
                        <table>
                            <tr>
                                <th>Subscription ID</th>
                                <th>Member ID</th>
                                <th>Member Email</th>
                            </tr>
                            <?php 

                            $Nselect="SELECT * FROM newslettersubscriptiontb";
                            $runselect=mysqli_query($connect, $Nselect);

                            $count=mysqli_num_rows($runselect);

                            for ($i=0; $i < $count; $i++) 
                            { 
                                $Narray=mysqli_fetch_array($runselect);
                                $Nid=$Narray['SubscriptionID'];
                                $Mid=$Narray['MemberID'];
                                $Memail=$Narray['MemberEmail'];

                                echo "<tr>";
                                    echo "<td>$Nid</td>";
                                    echo "<td>$Mid</td>";
                                    echo "<td>$Memail</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <div class="dmtables">
                        <h2>Review List</h2>
                        <table>
                            <tr>
                                <th>Review ID</th>
                                <th>Member ID</th>
                                <th>Review</th>
                                <th>Rating</th>
                            </tr>
                            <?php 

                            $Rselect="SELECT * FROM reviewtb";
                            $runselect=mysqli_query($connect, $Rselect);

                            $count=mysqli_num_rows($runselect);

                            for ($i=0; $i < $count; $i++) 
                            { 
                                $Rarray=mysqli_fetch_array($runselect);
                                $Rid=$Rarray['ReviewID'];
                                $Mid=$Rarray['MemberID'];
                                $review=$Rarray['Review'];
                                $rating=$Rarray['Rating'];

                                echo "<tr>";
                                    echo "<td>$Rid</td>";
                                    echo "<td>$Mid</td>";
                                    echo "<td>$review</td>";
                                    echo "<td>$rating</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
    </section>
 </body>
 </html>