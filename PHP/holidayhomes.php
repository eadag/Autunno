<?php
include('dbconnection.php');
session_start();

if (isset($_SESSION['Mid'])) 
{
	$MemID=$_SESSION['Mid'];
	$Username=$_SESSION['Username'];
	$Mimage=$_SESSION['Mpfp'];
}

$search = '';
$HHtype = '';
$minprice = '';
$maxprice = '';
$guest = '';

if (isset($_GET['btnSearch'])) {
    $search = $_GET['txtSearch'];
    $HHtype = $_GET['slHHtype'];
    $minprice = $_GET['txtMinPrice'];
    $maxprice = $_GET['txtMaxPrice'];
    $guest = $_GET['txtGuest'];

    $searchquery = 
    "SELECT hh.*, ht.HolidayHomeTypeName 
    FROM holidayhometb hh
    JOIN holidayhometypetb ht ON hh.HolidayHomeTypeID = ht.HolidayHomeTypeID
    WHERE hh.HolidayHomeName LIKE '%" . mysqli_real_escape_string($connect, $search) . "%'";

    if (!empty($HHtype)) {
        $searchquery .= " AND hh.HolidayHomeTypeID = '" . mysqli_real_escape_string($connect, $HHtype) . "'";
    }
    if (!empty($minprice)) {
        $searchquery .= " AND hh.PricePerNight >= " . intval($minprice);
    }
    if (!empty($maxprice)) {
        $searchquery .= " AND hh.PricePerNight <= " . intval($maxprice);
    }
    if (!empty($guest)) {
        $searchquery .= " AND hh.NumberOfGuest = " . intval($guest);
    }

    $searchquery .= " ORDER BY hh.HolidayHomeID";

    $runsearch = mysqli_query($connect, $searchquery);
    $count = mysqli_num_rows($runsearch);
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

    <title>HOLIDAY HOMES | AUTUNNO - Book Holiday Homes With Fair Prices</title>
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
        <div class="searchseccontainer">
            <form class="searchform" action="holidayhomes.php" method="GET">
                <div class="searchcontent">
                    <div class="searchbarnbtn">
                        <input class="searchbar" type="text" name="txtSearch" placeholder="Search Holiday Homes" value ="<?php echo htmlspecialchars($search); ?>" required>
                        <input class="btnSearch" type="submit" name="btnSearch" value="Search">
                    </div>

                    <i class="fa-solid fa-sliders"></i><b> Filters For Searching</b>
                    <div class="SearchFilters">
                        <div>
                            <b>Holiday Home Type</b>
                            <select name="slHHtype">
                                <option value="">Any</option>
                                <?php
                                    $select="SELECT * FROM holidayhometypetb";
                                    $query=mysqli_query($connect, $select);
                                    $count=mysqli_num_rows($query);
                                    for ($i=0; $i < $count ; $i++) 
                                    { 
                                        $row=mysqli_fetch_array($query);
                                        $HTid=$row['HolidayHomeTypeID'];
                                        $HTname=$row['HolidayHomeTypeName'];
                                        echo "<option value='$HTid' " . ($HTid == $HHtype ? "selected" : "") . ">$HTname</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div>
                            <b>Price Range</b>
                            Min<input type="number" step="0.01" min="50.00" name="txtMinPrice" id="textbox" placeholder="Any" value="<?php echo htmlspecialchars($minprice); ?>">
                            Max<input type="number" step="0.01" min="100.00" name="txtMaxPrice" id="textbox" placeholder="Any" value="<?php echo htmlspecialchars($maxprice); ?>">
                        </div>
                        
                        <div>
                            <b>Number of Guest</b>
                            <input type="number" step="1" min="1" name="txtGuest" placeholder="Any" value="<?php echo htmlspecialchars($guest); ?>">
                        </div>
                        
                        <a onclick="clearFilters()"><i class="fa-solid fa-xmark"></i> Clear Filters</a>
                        <script>
                            function clearFilters() {
                                document.querySelector('select[name="slHHtype"]').selectedIndex = 0;
                                document.querySelector('input[name="txtMinPrice"]').value = '';
                                document.querySelector('input[name="txtMaxPrice"]').value = '';
                                document.querySelector('input[name="txtGuest"]').value = '';
                            }
                        </script>
                    </div>                
                </div>
            </form>
            <div class="searchresults">
                <?php
                    if (isset($runsearch)) {
                        if (mysqli_num_rows($runsearch) > 0) {
                            echo "<h2>We Found:</h2>";
                            echo "<div class='HHcontainer'>";
                            while ($row = mysqli_fetch_array($runsearch)) {
                                $HHid = $row['HolidayHomeID'];
                                $HHname = $row['HolidayHomeName'];
                                $HHtype = $row['HolidayHomeTypeName'];
                                $HHimg1 = $row['HolidayHomeImage1'];
                                $HHlocation = $row['HolidayHomeLocation'];
                                $HHprice = $row['PricePerNight'];
                                $guest = $row['NumberOfGuest'];
                                $bath = $row['NumberOfBathroom'];
                                
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
                                                <form action="holidayhomes.php" method="POST">
                                                    <input type="hidden" name="favHHid" value="<?php echo $HHid; ?>">
                                                    <input type="submit" name="btnFav" class="btnFav" value="" title="Add To Favourites">
                                                </form>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <img class="favicon" onclick="alert('You Must Be Signed In To Add Holiday Homes To Favourite!')" src="images/favouriteicon2.png" alt="Add to Favourites">
                                        <?php endif; ?>

                                        <img class="HHimg" src="<?php echo $HHimg1 ?>" alt="Holiday Home Image">
                                    </div>
                                    <div class="HHinfo">
                                        <?php echo $HHtype; ?>
                                        <br><br>

                                        <h3><?php echo $HHname; ?></h3>
                                        <?php echo $HHlocation; ?>

                                        <div class="HHbreifinfo">
                                            <div>
                                                <i class="fa-solid fa-user"></i>
                                                <?php echo $guest; ?>
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
                        } else {
                            echo "<p><b>No Match Found :( Try Searching Again!</b></p>";
                        }
                    }
                ?>
            </div>
        </div>
        <div class="HHlist">
            <h2>All Holiday Homes</h2>
            <?php
                $selectquery="SELECT * FROM holidayhometb";
                $runselect=mysqli_query($connect, $selectquery);
                $count1=mysqli_num_rows($runselect);

                if ($count1==0) 
                {
                    echo "<p>No Holiday Home Available</p>";
                }
                else
                {
                    for ($i=0; $i < $count1 ; $i+=3)
                    { 
                        $query="
                        SELECT hh.*, ht.HolidayHomeTypeName 
                        FROM holidayhometb hh
                        JOIN holidayhometypetb ht ON hh.HolidayHomeTypeID = ht.HolidayHomeTypeID
                        ORDER BY hh.HolidayHomeID 
                        LIMIT $i, 3
                        ";
                        $result=mysqli_query($connect, $query);
                        $count2=mysqli_num_rows($result);
                        echo "<div class='HHcontainer'>";
                        for ($j=0; $j < $count2 ; $j++) 
                        { 
                            $array=mysqli_fetch_array($result);
                            $HHid=$array['HolidayHomeID'];
                            $HHname=$array['HolidayHomeName'];
                            $HHtype=$array['HolidayHomeTypeName'];
                            $HHimg1=$array['HolidayHomeImage1'];
                            $HHlocation=$array['HolidayHomeLocation'];
                            $HHprice=$array['PricePerNight'];
                            $guest=$array['NumberOfGuest'];
                            $bath=$array['NumberOfBathroom'];
                            
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
                                            <form action="holidayhomes.php" method="POST">
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
                                            <i class="fa-solid fa-user"></i>
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
                            <!-- <hr> -->
                            <?php 
                        }
                        echo "</div>";
                    }
                }
            ?>
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