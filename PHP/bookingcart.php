<?php 
session_start();
include('dbconnection.php');
include('bookingcartfunction.php');

if (isset($_SESSION['Mid'])) 
{
	$MemID=$_SESSION['Mid'];
	$Username=$_SESSION['Username'];
	$Mimage=$_SESSION['Mpfp'];
}
else 
{
    echo "<script>window.alert('You Must Be Signed In To View This Page!')</script>";
    echo "<script>window.location='membersignin.php'</script>";
}

if(isset($_REQUEST['Action'])) 
{
    $Action=$_REQUEST['Action'];
    if($Action === "Remove")
    {
        $HolidayHomeID=$_REQUEST['HolidayHomeID'];
        RemoveBookingCart($HolidayHomeID);
    }
    else
    {
        ClearBookingCart();
    }
}
else
{
    $Action="";
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

    <title>BOOKING CART | AUTUNNO - Book Holiday Homes With Fair Prices</title>
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
                    echo "<div><img class='Upfp' src='$Mimage' alt='Favourite Icon'><span class='usernametooltip'>$Username</span></div>";
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
        <form class="Bcartform" action="bookingcart.php" method="GET">
            <div class="Bcartformcontent">
                <div class="Bcartformleft">
                    <fieldset>
                        <legend>
                            <h2><i id="carticon" class="fa-solid fa-cart-flatbed-suitcase"></i> Your Booking Cart</h2>
                        </legend>
                        <?php
                            if (!isset($_SESSION['BookingCartFunction']) || count($_SESSION['BookingCartFunction']) == 0) {
                                echo "<p>Booking Cart Is Empty</p>";
                                echo "<a href='holidayhomes.php'>Start Booking &rarr;</a>";
                            } 
                            else {
                        ?>
                        <table>
                            <tr>
                                <th>Holiday Home</th>
                                <th>Check-In Date</th>
                                <th>Check-Out Date</th>
                                <th>Total Nights</th>
                                <th>Total Guests</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                            <?php
                                $size = count($_SESSION['BookingCartFunction']);
                                for ($i = 0; $i < $size; $i++) {
                                    $HolidayHomeImage = $_SESSION['BookingCartFunction'][$i]['HolidayHomeImage1'];
                                    $HolidayHomeName = $_SESSION['BookingCartFunction'][$i]['HolidayHomeName'];
                                    $CheckInDate = $_SESSION['BookingCartFunction'][$i]['CheckInDate'];
                                    $CheckOutDate = $_SESSION['BookingCartFunction'][$i]['CheckOutDate'];
                                    $TotalNights = $_SESSION['BookingCartFunction'][$i]['TotalNights'];
                                    $NoG = $_SESSION['BookingCartFunction'][$i]['NumberOfGuests'];
                                    $TotalPrice = $_SESSION['BookingCartFunction'][$i]['TotalPrice'];
                                    $HolidayHomeID = $_SESSION['BookingCartFunction'][$i]['HolidayHomeID'];

                                    echo "<tr>";
                                    echo "<td><img src='$HolidayHomeImage' alt='Holiday Home Image'><p>$HolidayHomeName</p></td>";
                                    echo "<td>$CheckInDate</td>";
                                    echo "<td>$CheckOutDate</td>";
                                    echo "<td>$TotalNights Night(s)</td>";
                                    echo "<td>$NoG Guest(s)</td>";
                                    echo "<td>&euro; $TotalPrice</td>";
                                    echo "<td><a href='bookingcart.php?HolidayHomeID=$HolidayHomeID&Action=Remove'><i class='fa-regular fa-square-minus'></i></a></td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                        <?php } ?>
                    </fieldset>            
                </div>
                <div class="Bcartformright">
                    <div>
                        <a href="bookingcart.php?Action=ClearAll">
                            <i class="fa-solid fa-xmark"></i> Clear Cart
                        </a>
                    </div>
                    <div>
                        <a href="holidayhomes.php">
                            <i class="fa-solid fa-cart-plus"></i> Continue Booking
                        </a>
                    </div>    
                    <div>
                        <a href="checkout.php">
                            <i class="fa-regular fa-credit-card"></i> Check Out
                        </a>
                    </div>
                </div>    
            </div>
        </form>
    </section>
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
