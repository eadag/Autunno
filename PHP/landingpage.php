<?php
include('dbconnection.php');
session_start();

if (isset($_SESSION['Mid'])) 
{
	$MemID=$_SESSION['Mid'];
	$Username=$_SESSION['Username'];
	$Mimage=$_SESSION['Mpfp'];
}

if (isset($_POST['btnsub'])) 
{
    if (!isset($MemID)) 
    {
        echo "<script>window.alert('Sorry! You Must Be Signed In To Subscribe To Our Newsletter.')</script>";
        echo "<script>window.location='landingpage.php'</script>";
    }
    else
    {
        $MemID=$_SESSION['Mid'];
        $EmailAddress=$_POST['emailinput'];
        
        $selectquery="SELECT * FROM newslettersubscriptiontb WHERE MemberEmail='$EmailAddress'";
        $runselect=mysqli_query($connect, $selectquery);
        $rowcount=mysqli_num_rows($runselect);
        if ($rowcount>0) {
            echo "<script>window.alert('This Email Is Already Subscribed To Our Newsletter!')</script>";
            echo "<script>window.location='landingpage.php'</script>";
        }
        else
        {
            $insert="INSERT INTO newslettersubscriptiontb (MemberID, MemberEmail, SubscribeDate) 
            Values ('$MemID', '$EmailAddress', NOW())";
            
            $runinsert=mysqli_query($connect, $insert);

            if ($runinsert) 
            {
                echo "<script>window.alert('Newsletter Subscription Successful!')</script>";
                echo "<script>window.location='landingpage.php'</script>";
            }
        }
    }
}

if (isset($_POST['btnFav'])) {
    $HHid=$_POST['favHHid'];
    $Mid=$_SESSION['Mid'];
    $insert="INSERT INTO favouritetb (MemberID, HolidayHomeID) Values ('$Mid', '$HHid')";
    
    $runinsert=mysqli_query($connect, $insert);

    if ($runinsert) 
    {
        echo "<script>window.alert('Added Holiday Home To Favourite Successfully!')</script>";
        echo "<script>window.location='holidayhomes.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
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

    <title>HOME | AUTUNNO - Book Holiday Homes With Fair Prices</title>
</head>
<body>
    <header class="lpheader">
        <nav id="defaultnav">
            <div class="logo">
                <a href="landingpage.php">
                    <img class="logoimg" src="images/AutunnoLogo2.png" alt="Autunno Logo">
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

        <div class="headercontent">
            <h1>Welcome!</h1>
            <p><span>Autunno</span>, where every <span>stay</span> becomes a <span>story</span>.</p>
            <a href="holidayhomes.php"><i class="fa-solid fa-magnifying-glass"></i> Search Holiday Homes</a>
        </div>
    </header>
    <section>
        <div class="servicescontainer">
            <h1>Our Services</h1>
            <div class="services">
                <div>
                    <h2>Booking</h2>
                    <p>
                        We provide a simple 24/7 booking service, 
                        letting you reserve your ideal holiday home anytime with real-time availability updates. 
                        Enjoy a smooth booking experience with instant confirmation and secure payment options for your stay.
                    </p>
                </div>
                <div>
                    <h2>Best Pricing</h2>
                    <p>
                        We provide holiday homes at fair prices, 
                        ensuring you get excellent value for your money. 
                        Our pricing reflects our commitment to affordability while maintaining high-quality accommodations. 
                        Enjoy a comfortable stay without stretching your budget.
                    </p>
                </div>
                <div>
                    <h2>Newsletter</h2>
                    <p>Subscribe to our newsletter to be notified about promotions.</p>
                    <form action="landingpage.php" method="POST">
                        <?php
                            if (!isset($MemID)) 
                            {
                                echo "<input class='emailinput' type='email' placeholder='Enter Your Email Address'>";
                                echo "<button class='btnsub' type='button' onclick='alert(\"Sorry! You Must Be Signed In To Subscribe To Our Newsletter.\")'>Subscribe</button>";
                            }
                            else
                            {
                                echo "<input name='emailinput' class='emailinput' type='email' placeholder='Enter Your Email Address' required>";
                                echo "<input class='btnsub' name='btnsub' type='submit' value='Subscribe'>";
                            }
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="Htypes">
            <h1>Holiday Home Categories</h1>
            <p>We believe that home is where you feel most comfortable, 
            which is why we offer a variety of holiday homes to suit your needs. <br>
            Wherever you choose to stay, we’re here to make it feel like your own welcoming space.</p>
            <br>
            <div class="typecardcontainer">
                <div class="typecard">
                    <img src="images/apartment.jpg" alt="Apartment Image">
                    <p>Apartment</p>
                </div>
                <div class="typecard">
                    <img src="images/beachhouse.jpg" alt="Beach House Image">
                    <p>Beach House</p>
                </div>
                <div class="typecard">
                    <img src="images/cabin.jpg" alt="Cabin Image">
                    <p>Cabin</p>
                </div>
                <div class="typecard">
                    <img src="images/cottage2.jpg" alt="Cottage Image">
                    <p>Cottage</p>
                </div>
                <div class="typecard">
                    <img src="images/villa.png" alt="Villa Image">
                    <p>Villa</p>
                </div>
            </div>
        </div>
        <div class="lpHHcontainer">
            <h1>Popular Holiday Homes</h1>
            <?php
                $query = "SELECT hh.*, ht.HolidayHomeTypeName 
                FROM holidayhometb hh
                JOIN holidayhometypetb ht ON hh.HolidayHomeTypeID = ht.HolidayHomeTypeID
                ORDER BY RAND()
                LIMIT 3";

                $result = mysqli_query($connect, $query);
                $count = mysqli_num_rows($result);

                if ($count == 0) {
                    echo "<p>No Holiday Home Available</p>";
                } else {
                    echo "<div class='HHcontainer'>";
                    while ($array = mysqli_fetch_array($result)) {
                        $HHid = $array['HolidayHomeID'];
                        $HHname = $array['HolidayHomeName'];
                        $HHtype = $array['HolidayHomeTypeName'];
                        $HHimg1 = $array['HolidayHomeImage1'];
                        $HHlocation = $array['HolidayHomeLocation'];
                        $HHprice = $array['PricePerNight'];
                        $guest = $array['NumberOfGuest'];
                        $bath = $array['NumberOfBathroom'];
                        
                        $isFavourited = false;
                        if (isset($MemID)) {
                            $selectFavQuery = "SELECT * FROM favouritetb WHERE HolidayHomeID='$HHid' AND MemberID='$MemID'";
                            $runFavSelect = mysqli_query($connect, $selectFavQuery);
                            $isFavourited = mysqli_num_rows($runFavSelect) > 0;
                        }
                        ?>

                        <div class="HHdiv">
                            <div class="HHtop">
                                <?php if (isset($MemID)): ?>
                                    <?php if ($isFavourited): ?>
                                        <img class="favedicon" src="images/favouriteicon1.png" alt="Added to Favourites">
                                    <?php else: ?>
                                        <form action="landingpage.php" method="POST">
                                            <input type="hidden" name="favHHid" value="<?php echo $HHid; ?>">
                                            <input type="submit" name="btnFav" class="btnFav" value="">
                                        </form>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <img class="favicon" onclick="alert('You Must Be Signed In To Add Holiday Homes To Favourite!')" src="images/favouriteicon2.png" alt="Add to Favourites">
                                <?php endif; ?>

                                <img class="HHimg" src="<?php echo $HHimg1 ?>" alt="Holiday Home Image">
                            </div>
                            <div class="HHinfo">
                                <?php echo $HHtype; ?>
                                <br>
                                <br>

                                <h3><?php echo $HHname; ?></h3>
                                <?php echo $HHlocation; ?>

                                <div class="HHbreifinfo">
                                    <div>
                                        <i class="fa-solid fa-user" style="color: #c03551;"></i>
                                        <?php echo $guest ?>
                                    </div>
                                    <div>
                                        <p> <b>&euro; <?php echo $HHprice; ?></b> / Night</p>
                                    </div>
                                </div>

                                <div class="btnview">
                                    <a href="holidayhomedetails.php?HomeId=<?php echo $HHid; ?>">View</a>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <?php 
                    }
                    echo "</div>";
                }
            ?>
            <div class="btndiscover">
                <a href="holidayhomes.php">Discover All &rarr;</a>
            </div>
        </div>
        <div class="reviewssection">
            <h1>Reviews</h1>
            <div class="mainreviewdiv">
                <?php
                    $query = "SELECT r.*, m.FirstName, m.ProfileImage  FROM reviewtb r, membertb m
                    WHERE r.MemberID = m.MemberID
                    ORDER BY RAND()
                    LIMIT 2";

                    $result = mysqli_query($connect, $query);
                    $count = mysqli_num_rows($result);

                    if ($count == 0) {
                        echo "<p>No Review Found.</p>";
                    } 
                    else {
                        echo "<div class='reviewscontainer'>";
                        while ($array = mysqli_fetch_array($result)) {
                            $review = $array['Review'];
                            $rating = $array['Rating'];
                            $membname = $array['FirstName'];
                            $membimg = $array['ProfileImage'];
                ?>
                <div class="review">
                    <div class="reviewtext">
                        <i class="fa-solid fa-quote-left"></i>
                        <p> <?php echo $review ?></p>
                    </div>
                    <div class="reviewernrating">
                        <div class="stars">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                $class = ($i <= $rating) ? 'star selected' : 'star';
                                echo "<span class=\"$class\">&#9733;</span>";
                            }
                            ?>
                        </div>
                        <div class="reviewer">
                            <h3>- <?php echo $membname ?></h3>
                            <img src="<?php echo $membimg ?>" alt="Member Profile Image">
                        </div>
                    </div>
                </div>
                <?php 
                    }
                    echo "</div>";
                    }
                ?>
                <div class="btnread">
                    <a href="reviewform.php"><b>Share Your Experience &rarr; </b></a>
                </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nav = document.getElementById('defaultnav');
            const barsicon = document.getElementById('bars');
            const logoimg = document.querySelector (".logoimg");
            const logoname = document.querySelector(".logoname");
            const pagelinks = document.querySelectorAll(".pagelinks");
            const btnSignUp = document.querySelector(".btnSignUp");
            const btnSignIn = document.querySelector(".btnSignIn");
            const btnSignOut = document.querySelector(".btnSignOut");
            const pfp = document.querySelector(".Upfp");
            const favicon = document.querySelector(".favicon");

            window.addEventListener('scroll', () => {
                if (window.scrollY > 0) {
                    nav.style.backgroundColor = "#e9efe6";
                    barsicon.style.color="#c03551";
                    barsicon.addEventListener("mouseover", function() {
                        barsicon.style.color = "#b0304a";
                    });
                    barsicon.addEventListener("mouseout", function() {
                        barsicon.style.color = "#c03551";
                    });
                    logoimg.src = "images/AutunnoLogo1.png";
                    logoname.style.color = "#c03551";
                    pagelinks.forEach(link => {
                        link.style.color = "#c03551";
                        link.addEventListener("mouseover", function() {
                            link.style.borderBottomColor = "#c03551";
                        });
                        link.addEventListener("mouseout", function() {
                            link.style.borderBottomColor = "transparent";
                        });
                    });

                    btnSignUp.style.backgroundColor = "#658859";
                    btnSignUp.style.color = "#f6e0e0";
                    btnSignUp.addEventListener("mouseover", function() {
                        btnSignUp.style.backgroundColor = "#526F49";
                    });
                    btnSignUp.addEventListener("mouseout", function() {
                        btnSignUp.style.backgroundColor = "#658859";
                    });

                    btnSignIn.style.backgroundColor = "#c03551";
                    btnSignIn.style.color = "#f6e0e0";
                    btnSignIn.addEventListener("mouseover", function() {
                        btnSignIn.style.backgroundColor = "#b0304a";
                    });
                    btnSignIn.addEventListener("mouseout", function() {
                        btnSignIn.style.backgroundColor = "#c03551";
                    });
                }

                else {
                    nav.style.backgroundColor = "transparent";
                    barsicon.style.color="#f6e0e0";
                    barsicon.addEventListener("mouseover", function() {
                        barsicon.style.color = "#edc0c0";
                    });
                    barsicon.addEventListener("mouseout", function() {
                        barsicon.style.color = "#f6e0e0";
                    });
                    logoimg.src = "images/AutunnoLogo2.png";
                    logoname.style.color = "#f6e0e0";
                    pagelinks.forEach(link => {
                        link.style.color = "#f6e0e0";
                        link.addEventListener("mouseover", function() {
                            link.style.borderBottomColor = "#f6e0e0";
                        });
                        link.addEventListener("mouseout", function() {
                            link.style.borderBottomColor = "transparent";
                        });
                    });

                    btnSignUp.style.backgroundColor = "#dee7da";
                    btnSignUp.style.color = "#c03551";
                    btnSignUp.addEventListener("mouseover", function() {
                        btnSignUp.style.backgroundColor = "#bccfb5";
                    });
                    btnSignUp.addEventListener("mouseout", function() {
                        btnSignUp.style.backgroundColor = "#dee7da";
                    });

                    btnSignIn.style.backgroundColor = "#f6e0e0";
                    btnSignIn.style.color = "#c03551";
                    btnSignIn.addEventListener("mouseover", function() {
                        btnSignIn.style.backgroundColor = "#edc0c0";
                    });
                    btnSignIn.addEventListener("mouseout", function() {
                        btnSignIn.style.backgroundColor = "#f6e0e0";
                    });
                };
            });
        });
    </script>
</body>
</html>