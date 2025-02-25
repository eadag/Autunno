<?php 
session_start();
include('dbconnection.php');

if (isset($_GET['HomeId'])) 
{
	$HhId=$_GET['HomeId'];
	$query="SELECT * FROM holidayhometb h, holidayhometypetb ht
    WHERE h.HolidayHomeTypeID=ht.HolidayHomeTypeID
    AND HolidayHomeID='$HhId'";
    $result=mysqli_query($connect, $query);
    $data=mysqli_fetch_array($result); 
    $Hid=$data['HolidayHomeID'];
}

if (isset($_SESSION['Mid'])) 
{
	$MemID=$_SESSION['Mid'];
	$Username=$_SESSION['Username'];
	$Mimage=$_SESSION['Mpfp'];
}

$amenities = [
    'Wifi' => 'fa-wifi',
    'Kitchen' => 'fa-utensils',
    'PetFriendly' => 'fa-paw',
    'SelfCheckIn' => 'fa-key',
    'Washer' => 'fa-tshirt',
    'Toiletries' => 'fa-pump-soap'
];

if (isset($_POST['btnFav'])) {
    $HHid = $_POST['favHHid'];
    $Mid = $_SESSION['Mid'];
    $insert = "INSERT INTO favouritetb (MemberID, HolidayHomeID) VALUES ('$Mid', '$HHid')";
    $runinsert = mysqli_query($connect, $insert);

    if ($runinsert) {
        echo "<script>window.alert('Added Holiday Home To Favourite Successfully!')</script>";
        echo "<script>window.location='holidayhomedetails.php?HomeId=$HHid';</script>";
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

    <title>HOLIDAY HOME DETAILS | AUTUNNO - Book Holiday Homes With Fair Prices</title>
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
                    echo "<div><img class='Upfp' src='$Mimage' class='Member Profile Image'><span class='usernametooltip'>$Username</span></div>";
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
        <a class="backlink"  href="holidayhomes.php">&lt; Back</a>
        <div class="slideimgcontainer">
            <div>
                <div class="slideimg">
                    <img src="<?php echo $data['HolidayHomeImage1']; ?>" alt="Holiday Home Image 1">
                </div>
                <div class="slideimg">
                    <img src="<?php echo $data['HolidayHomeImage2']; ?>" alt="Holiday Home Image 2">
                </div>
                <div class="slideimg">
                    <img src="<?php echo $data['HolidayHomeImage3']; ?>" alt="Holiday Home Image 3">
                </div>
                <div class="slideimg">
                    <img src="<?php echo $data['HolidayHomeImage4']; ?>" alt="Holiday Home Image 4">
                </div>
                <div class="slideimg">
                    <img src="<?php echo $data['HolidayHomeImage5']; ?>" alt="Holiday Home Image 5">
                </div>    
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <div>
                <div class="row">
                    <div class="column">
                        <img class="demo cursor" src="<?php echo $data['HolidayHomeImage1']; ?>" onclick="currentSlide(1)" alt="Holiday Home Image 1">
                    </div>
                    <div class="column">
                        <img class="demo cursor" src="<?php echo $data['HolidayHomeImage2']; ?>" onclick="currentSlide(2)" alt="Holiday Home Image 2">
                    </div>
                    <div class="column">
                        <img class="demo cursor" src="<?php echo $data['HolidayHomeImage3']; ?>" onclick="currentSlide(3)" alt="Holiday Home Image 3">
                    </div>
                    <div class="column">
                        <img class="demo cursor" src="<?php echo $data['HolidayHomeImage4']; ?>" onclick="currentSlide(4)" alt="Holiday Home Image 4">
                    </div>
                    <div class="column">
                        <img class="demo cursor" src="<?php echo $data['HolidayHomeImage5']; ?>" onclick="currentSlide(5)" alt="Holiday Home Image 5">
                    </div>
                </div>
            </div>
        </div>
        <script>
            let slideIndex = 1;
            showSlides(slideIndex);
            function plusSlides(n) {
            showSlides(slideIndex += n);
            }
            function currentSlide(n) {
            showSlides(slideIndex = n);
            }
            function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("slideimg");
            let dots = document.getElementsByClassName("demo");
            let captionText = document.getElementById("caption");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
            captionText.innerHTML = dots[slideIndex-1].alt;
            }
        </script>
        <div class="HHdetailscontainer">
            <div class="HHdetails">
                <div class="HHdetailsleft">
                <h1><?php echo $data['HolidayHomeName']; ?></h1>
                <?php echo $data['HolidayHomeTypeName']; ?> in <?php echo $data['HolidayHomeLocation']; ?>
                <div class="homecomponents">
                        <div>
                        <i class="fa-solid fa-user"></i> <b><?php echo $data['NumberOfGuest']; ?></b> <p>Guest(s)</p>
                        </div>
                        <div>
                            <i class="fa-solid fa-bed"></i> <b><?php echo $data['NumberOfBed']; ?></b> <p>Bed(s)</p>
                        </div>
                        <div>
                            <i class="fa-solid fa-bath"></i> <b><?php echo $data['NumberOfBathroom']; ?></b> <p>Bathroom(s)</p>
                        </div>
                    </div>
                    <b>Description</b>
                    <p>
                        <?php echo $data['HolidayHomeDescription']; ?>
                    </p>
                </div>
                <div class="HHdetailsright">
                    <div class="floatright">
                        <?php 
                            $isFavourited = false;
                            if (isset($MemID)) {
                                $selectFavQuery = "SELECT * FROM favouritetb WHERE HolidayHomeID='$HhId' AND MemberID='$MemID'";
                                $runFavSelect = mysqli_query($connect, $selectFavQuery);
                                $isFavourited = mysqli_num_rows($runFavSelect) > 0;
                            } 
                        ?>
                        <?php if (isset($MemID)): ?>
                            <?php if ($isFavourited): ?>
                                <img class="favedicon" src="images/favouriteicon1.png" alt="Added to Favourites">
                            <?php else: ?>
                                <form action="holidayhomedetails.php?HomeId=<?php echo $HhId; ?>" method="POST">
                                <input type="hidden" name="HomeId" value="<?php echo $HhId; ?>">
                                <input type="hidden" name="favHHid" value="<?php echo $HhId; ?>">
                                    <input type="submit" name="btnFav" class="btnFav" value="" title="Add To Favourites">
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <img class="favicon" onclick="alert('You Must Be Signed In To Add Holiday Homes To Favourite!')" src="images/favouriteicon2.png" alt="Add to Favourites">
                        <?php endif; ?>
                        <h3>&euro; <?php echo $data['PricePerNight']; ?> / Night</h3>
                    </div>
                    
                    <h3>Amenities</h3>
                    <div class="amenitiescontainer">
                        
                        <div>
                            <b>Included</b>
                            <?php 
                            foreach ($amenities as $amenity => $icon) {
                                if ($data[$amenity] == 1) { ?>
                                    <div class="amenity">
                                        <i class="fa-solid <?php echo $icon; ?>"></i>
                                        <span><?php echo $amenity; ?></span>
                                    </div>
                                <?php } 
                            } ?>
                        </div>
                        <div>
                            <b>Not Included</b>
                            <?php 
                            foreach ($amenities as $amenity => $icon) {
                                if ($data[$amenity] == 0) { ?>
                                    <div class="amenity hidden">
                                        <i class="fa-solid <?php echo $icon; ?>"></i>
                                        <span><?php echo $amenity; ?></span>
                                        <div class="overlay"></div>
                                    </div>
                                <?php } 
                            } ?>
                        </div>
                    </div>
                    <div class="mapheading">
                        <i class="fa-solid fa-location-dot"></i><h3>Explore The Area</h3>
                    </div>
                    <div>
                        <iframe src="<?php echo $data['HolidayHomeMap']; ?>" frameborder="0"></iframe>
                    </div>
                    <p>Exact location will be provided after booking.</p>
                </div>
            </div>
            <div class="bookbuttondiv">
                <a href="bookingform.php?HHid=<?php echo $Hid; ?>">Book Now</a>
            </div>
        </div>
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