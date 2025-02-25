<?php 
session_start();
include('dbconnection.php');
include('bookingcartfunction.php');

if (isset($_GET['HHid'])) 
{
	$HhId=$_GET['HHid'];
	$query="SELECT * FROM holidayhometb h
    JOIN holidayhometypetb ht ON h.HolidayHomeTypeID = ht.HolidayHomeTypeID
    JOIN scheduledetailstb sd ON h.HolidayHomeID = sd.HolidayHomeID
    WHERE h.HolidayHomeID = '$HhId'";
    $result=mysqli_query($connect, $query);

    if ($data=mysqli_fetch_array($result)) {
        $Hid=$data['HolidayHomeID'];
        $Hname=$data['HolidayHomeName'];
        $Himg=$data['HolidayHomeImage1'];
        $Htype=$data['HolidayHomeTypeName'];
        $Hlocation=$data['HolidayHomeLocation'];
        $Hprice=$data['PricePerNight'];
        $NoG=$data['NumberOfGuest'];

        $schedules = [];

        do {
            $schedules[] = [
                'start' => $data['ScheduleStartDate'],
                'end' => $data['ScheduleEndDate']
            ];
        } 
        while ($data = mysqli_fetch_array($result));
    }
}

if (isset($_SESSION['Mid'])) 
{
	$MemID=$_SESSION['Mid'];
	$Username=$_SESSION['Username'];
	$Mimage=$_SESSION['Mpfp'];
}
else 
{
    echo "<script>window.alert('You Must Be Signed In To Book Holiday Home!')</script>";
    echo "<script>window.location='membersignin.php'</script>";
}

if (isset($_GET['btnAdd']))
{
	$Hid=$_GET['txtHid'];
	$NoG=$_GET['txtGuest'];
    $totalnights=$_GET['totalnights'];
    $totalprice=$_GET['totalprice'];

    if (empty($_GET['checkin']) || empty($_GET['checkout'])) {
        $HhId = $_GET['txtHid'];
        echo "<script>window.alert('Please Select Both Check In and Check out Dates!')</script>";
        echo "<script>window.location='bookingform.php?HHid=$HhId'</script>";
        exit();
    }
    else {
        $checkindate=$_GET['checkin'];
        $checkoutdate=$_GET['checkout'];
        AddBookingCart($Hid, $NoG, $checkindate, $checkoutdate, $totalnights, $totalprice);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cus.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <title>BOOKING FORM | AUTUNNO - Book Holiday Homes With Fair Prices</title>
</head>
<body>
    <header class="npheader">
        <nav id="defaultnav">
            <div class="logo">
                <a href="landingpage.php">
                    <img class="logoimg" src="images/AutunnoLogo1.png" alt="Autunno Logo">
                    <h2 class="logoname">Autunno</h2>
                </a>
            </div>
            <div class="barsicon">
                <i id="bars" class="fa-solid fa-bars" onclick="openrespnav()"></i>
            </div>
            <div id="navrightcontent">
                <a class="pagelinks" href="holidayhomes.php">Holiday Homes</a>
                <a class="pagelinks" href="aboutus.php">About Us</a>
                <a class="pagelinks" href="contact.php">Contact</a>

                <?php
                if (!isset($MemID)) 
                {
                    echo "<a class='btnSignUp' href='membersignup.php'>Sign Up</a>";
                    echo "<a class='btnSignIn' href='membersignin.php'>Sign In</a>";
                }
                else
                {
                    echo "<div><a href='favourites.php'><img class='favicon' src='images/favouriteicon1.png' alt='Favourite Icon'><span class='favtooltip'>Favourites</span></a></div>";
                    echo "<div><a href='bookingcart.php'><i id='carticon' class='fa-solid fa-cart-flatbed-suitcase'></i><span class='bookingcarttooltip'>Booking Cart</span></a></div>";
                    echo "<div><img class='Upfp' src='$Mimage' alt='Member Profile Image'><span class='usernametooltip'>$Username</span></div>";
                    echo "<a class='btnSignOut' href='membersignout.php'>Sign Out</a>";
                }
                ?>
            </div>
        </nav>
        <nav id="respnav">
            <i id="xmark" class="fa-solid fa-xmark" onclick="closerespnav()"></i>
            <a href="holidayhomes.php">Holiday Homes</a>
            <a href="aboutus.php">About Us</a>
            <a href="contact.php">Contact</a>
            <?php
                if (!isset($MemID)) 
                {
                    echo "<a class='btnSignUp' href='membersignup.php'>Sign Up</a>";
                    echo "<a class='btnSignIn' href='membersignin.php'>Sign In</a>";
                }
                else
                {
                    echo "<div><a href='favourites.php'><img class='favicon' src='images/favouriteicon2.png' alt='Favourite Icon'><span class='favtooltip'>Favourites</span></a></div>";
                    echo "<div><a href='bookingcart.php'><i id='carticon' class='fa-solid fa-cart-flatbed-suitcase'></i><span class='bookingcarttooltip'>Booking Cart</span></a></div>";
                    echo "<div><img class='Upfp' src='$Mimage' alt='Member Profile Image'><span class='usernametooltip'>$Username</span></div>";
                    echo "<a class='btnSignOut' href='membersignout.php'>Sign Out</a>";
                }
            ?>
        </nav>
        <script>
            function openrespnav() {
                document.getElementById("respnav").style.display='block';
                document.getElementById("bars").style.display='none';
                document.getElementById("xmark").style.display='block';
                document.body.classList.add('no-scroll');
            }
            function closerespnav() {
                document.getElementById("respnav").style.display='none';
                document.getElementById("bars").style.display='block';
                document.getElementById("xmark").style.display='none';
                document.body.classList.remove('no-scroll');
            }
            function handleResize() {
                if (window.innerWidth > 992) {
                    document.getElementById("bars").style.display = 'none';
                    document.getElementById("respnav").style.display = 'none';
                    document.getElementById("xmark").style.display = 'none';
                    document.body.classList.remove('no-scroll');
                } 
                else if (document.getElementById("respnav").style.display === 'block') {
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
	<section class="npsection">
        <a class="backlink"  href="holidayhomedetails.php?HomeId=<?php echo $Hid; ?>">&lt; Back</a>
        <div class="bookingformcontainer">
            <form action="bookingform.php" method="GET">
                <div class="bookingformcontent">
                    <h2>Booking Form</h2>
                    <div class="Bformtop">
                        <div class="Bformimg">
                            <img src="<?php echo $Himg ?>" alt="Holiday Home Image">
                            <div class="Bformimgtext">
                                <h2><?php echo $Hname ?></h2>
                                <p><?php echo $Htype ?> in <?php echo $Hlocation ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="Bforminputs">
                        <div class="Bformrows">
                            <div class="rowgroup">
                                <span>Number of Guest</span>
                                <input type="number" step="1" min="1" max="<?php echo $NoG ?>" name="txtGuest" placeholder="0" required>
                            </div>
                        </div>
                        <div class="Bformrows">
                            <div class="rowgroup">
                                <label for="checkin"><i class="fa-regular fa-calendar"></i> Check In</label>
                                <input type="text" id="checkin" name="checkin" placeholder="YYYY-MM-DD" required>
                            </div>
                            <div class="rowgroup">
                                <label for="checkout"><i class="fa-regular fa-calendar"></i> Check Out</label>
                                <input type="text" id="checkout" name="checkout" placeholder="YYYY-MM-DD" required>
                            </div>
                        </div>
                        <div class="Bformrows">
                            <div class="calculation">    
                                <fieldset>
                                    <legend>Price Calculation</legend>
                                        <div>
                                            <label>Price Per Night : &euro; <span id="pricePerNight"><?php echo $Hprice ?></span></label>
                                            <label>Total Nights: <span id="totalnights">0</span></label>
                                            <label>Total Price: &euro; <span id="totalprice">0.00</span></label>
                                        </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="addtobc">
                            <input type="hidden" name="txtHid" value="<?php echo $Hid ?>">
                            <input type="hidden" id="hiddenTotalNights" name="totalnights">
                            <input type="hidden" id="hiddenTotalPrice" name="totalprice">
                            <input type="submit" name="btnAdd" value="Add To Booking Cart">
                        </div>
                    </div>    
                </div>
            </form>
        </div>
	</section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var schedules = <?php echo json_encode($schedules); ?>;

            function getavailabledates(schedules) {
                let availabledates = [];
                let today = new Date();
                today.setHours(0, 0, 0, 0);

                schedules.forEach(function (schedule) {
                    let start = new Date(schedule.start);
                    let end = new Date(schedule.end);

                    start.setHours(0, 0, 0, 0);
                    end.setHours(0, 0, 0, 0);

                    while (start <= end) {
                        if (start >= today) {
                            availabledates.push(start.toISOString().split('T')[0]);
                        }
                        start.setDate(start.getDate() + 1);
                    }
                });
                return availabledates;
            }

            var availabledates = getavailabledates(schedules);

            function isdateavailable(date) {
                return availabledates.includes(date);
            }

            function handledateselection(dateStr, instance) {
                let checkindate = instance.element.id === 'checkin' ? dateStr : instance.input.value;
                let checkoutdate = instance.element.id === 'checkout' ? dateStr : instance.input.value;
            }

            flatpickr("#checkin", {
                dateFormat: "Y-m-d",
                enable: availabledates,
                minDate: new Date(),
                onDayCreate: function (dObj, dStr, fp, dayElem) {
                    let date = dayElem.dateObj.toISOString().split('T')[0];
                    if (isdateavailable(date)) {
                        dayElem.classList.add('available');
                        dayElem.classList.remove('unavailable');
                    } else {
                        dayElem.classList.add('unavailable');
                        dayElem.classList.remove('available');
                    }
                },
                onChange: function (selecteddates, dateStr, instance) {
                    handledateselection(dateStr, instance);
                    document.getElementById("checkout")._flatpickr.set("minDate", dateStr);
                }
            });

            flatpickr("#checkout", {
                dateFormat: "Y-m-d",
                enable: availabledates,
                minDate: new Date(),
                onDayCreate: function (dObj, dStr, fp, dayElem) {
                    let date = dayElem.dateObj.toISOString().split('T')[0];
                    if (isdateavailable(date)) {
                        dayElem.classList.add('available');
                    } 
                    else {
                        dayElem.classList.add('unavailable');
                    }
                },
                onChange: function (selecteddates, dateStr, instance) {
                    handledateselection(dateStr, instance);
                }
            });

            var pricePerNight = parseFloat(document.getElementById("pricePerNight").textContent);

            function calculatetotal() {
                var checkindate = document.getElementById('checkin').value;
                var checkoutdate = document.getElementById('checkout').value;

                if (!checkindate || !checkoutdate) return;

                var checkIn = new Date(checkindate);
                var checkOut = new Date(checkoutdate);

                if (checkOut <= checkIn) {
                    alert("Check In Date and Check Out Date cannot be the same!");
                    document.getElementById("checkout").value = "";
                }

                var totalNights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
                var totalPrice = pricePerNight * totalNights;

                document.getElementById('totalnights').textContent = totalNights;
                document.getElementById('totalprice').textContent = totalPrice.toFixed(2);

                document.getElementById("hiddenTotalNights").value = totalNights;
                document.getElementById("hiddenTotalPrice").value = totalPrice.toFixed(2);
            }

            document.getElementById('checkin').addEventListener('change', calculatetotal);
            document.getElementById('checkout').addEventListener('change', calculatetotal);
        });
    </script>
    <footer>
        <div class="footercontainer">
            <div class="footerabout">
                <img src="images/autunnologo2.png" alt="Autunno Logo">
                <div>
                    <h1>Autunno</h1>
                    <p>Stay For A Story</p>
                </div>
            </div>
            <div class="footercontact">
                <h3>Get In Touch</h3>
                <p>stayatautunno@gmail.com</p>
                <p>+123 456789</p>
                <div class="sociallinks">
                    <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-square-facebook"></i></a>
                    <a href="https://twitter.com/" target="_blank"><i class="fa-brands fa-square-x-twitter"></i></a>
                    <a href="https://www.linkedin.com/" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                </div>
            </div>
            <div class="addinfofooter">
                <a href="privacypolicy.php"target="blank">Privacy Policy &nearr;</a>
                <a href="usermanuals/MemberManual.pdf" target="blank">Member Manual &nearr;</a>
                <p>Availability and Pricing are not guaranteed until Booking is confirmed.</p>
                <p class="copyright">&#169; Autunno 2024 | All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html> 