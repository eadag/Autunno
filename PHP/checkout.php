<?php  
session_start();
include('dbconnection.php');
include('bookingcartfunction.php');

if (isset($_SESSION['Mid'])) 
{
	$MemID=$_SESSION['Mid'];
	$Username=$_SESSION['Username'];
	$Mimage=$_SESSION['Mpfp'];

    $query = "SELECT FirstName, LastName, Email, ContactNumber FROM membertb WHERE MemberID = '$MemID'";
    $result = mysqli_query($connect, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $member = mysqli_fetch_assoc($result);
        $firstname = $member['FirstName'];
        $lastname = $member['LastName'];
        $email = $member['Email'];
        $phnum = $member['ContactNumber'];
    } 
    else {
        echo "<script>alert('Member not found!');</script>";
    }
}
else 
{
    echo "<script>window.alert('You Must Be Signed In To View This Page!')</script>";
    echo "<script>window.location='membersignin.php'</script>";
}

if (!isset($_SESSION['BookingCartFunction']) || count($_SESSION['BookingCartFunction']) == 0) {
    echo "<script>window.alert('Cannot Check Out When Booking Cart is Empty!')</script>";
    echo "<script>window.location='bookingcart.php'</script>";
    exit();
}

$subtotal = 0;
$cart = $_SESSION['BookingCartFunction'] ?? [];
foreach ($cart as $HH) {
    $subtotal += $HH['TotalPrice'];
}

$vat = 0.10;
$vatamount = $subtotal * $vat;
$grandtotal = $subtotal + $vatamount;

if (isset($_POST['btnConfirm'])) {
    $paymentdate = date('Y-m-d H:i:s');
    $pmID = $_POST['slPmethod'];

    $insertbooking = "INSERT INTO bookingtb (MemberID, PaymentDate, GrandTotalPrice, PaymentMethodID)
                      VALUES ('$MemID', '$paymentdate', '$grandtotal', '$pmID')";

    if (mysqli_query($connect, $insertbooking)) {
        $bookingID = mysqli_insert_id($connect);

        foreach ($cart as $HH) {
            $HHid = $HH['HolidayHomeID'];
            $checkin = $HH['CheckInDate'];
            $checkout = $HH['CheckOutDate'];
            $totalguests = $HH['NumberOfGuests'];
            $totalprice = $HH['TotalPrice'];

            $checkDetailQuery = "SELECT * FROM bookingdetailstb WHERE BookingID = '$bookingID' AND HolidayHomeID = '$HHid'";
            $checkResult = mysqli_query($connect, $checkDetailQuery);

            if (mysqli_num_rows($checkResult) == 0) {
                $insertbookingdetails = "INSERT INTO bookingdetailstb (BookingID, HolidayHomeID, CheckInDate, CheckOutDate, TotalPrice, TotalGuests)
                                         VALUES ('$bookingID', '$HHid', '$checkin', '$checkout', '$totalprice', '$totalguests')";
                if (!mysqli_query($connect, $insertbookingdetails)) {
                    echo "<script>alert('Failed to insert booking details for Holiday Home ID: $HHid. Please try again.')</script>";
                }

                $scheduleQuery = "SELECT * FROM scheduledetailstb WHERE HolidayHomeID = '$HHid'";
                $scheduleResult = mysqli_query($connect, $scheduleQuery);

                if (mysqli_num_rows($scheduleResult) > 0) {
                    while ($row = mysqli_fetch_assoc($scheduleResult)) {
                        $sid = $row['ScheduleID'];
                        $scheduleStart = $row['ScheduleStartDate'];
                        $scheduleEnd = $row['ScheduleEndDate'];
                        $createddate = date('y-m-d');
                        
                        if ($checkin > $scheduleStart) {
                            $insertScheduleBefore = "INSERT INTO scheduletb (AdministratorID, ScheduleCreatedDate) VALUES (NULL, '$createddate')";
                            mysqli_query($connect, $insertScheduleBefore);
                            $scheduleIDbefore = mysqli_insert_id($connect);

                            $insertBefore = "INSERT INTO scheduledetailstb (ScheduleID, HolidayHomeID, ScheduleStartDate, ScheduleEndDate)
                                            VALUES ('$scheduleIDbefore', '$HHid', '$scheduleStart', DATE_SUB('$checkin', INTERVAL 1 DAY))";
                            mysqli_query($connect, $insertBefore);
                        }

                        if ($checkout < $scheduleEnd) {
                            $insertScheduleAfter = "INSERT INTO scheduletb (AdministratorID, ScheduleCreatedDate) VALUES (NULL, '$createddate')";
                            mysqli_query($connect, $insertScheduleAfter);
                            $scheduleIDafter = mysqli_insert_id($connect);

                            $insertAfter = "INSERT INTO scheduledetailstb (ScheduleID, HolidayHomeID, ScheduleStartDate, ScheduleEndDate)
                                            VALUES ('$scheduleIDafter', '$HHid', DATE_ADD('$checkout', INTERVAL 1 DAY), '$scheduleEnd')";
                            mysqli_query($connect, $insertAfter);
                        }

                        $deleteSchedule = "DELETE FROM scheduledetailstb WHERE HolidayHomeID = '$HHid' AND ScheduleStartDate = '$scheduleStart' AND ScheduleEndDate = '$scheduleEnd'";
                        mysqli_query($connect, $deleteSchedule);
                    }
                }
            }
            else {
                echo "<script>alert('Booking Details Already Exist For Holiday Home.')</script>";
            }
        }

        unset($_SESSION['BookingCartFunction']);
        echo "<script>alert('Booking Successful! Enjoy your Holiday!!!')</script>";
        echo "<script>window.location='landingpage.php';</script>";
    }
    else {
        echo "<script>alert('Booking Failed. Please Try Again!')</script>";
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

    <title>CHECK OUT | AUTUNNO - Book Holiday Homes With Fair Prices</title>
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
    <section class="checkoutpage">
        <a class="backlink"  href="bookingcart.php?">&lt; Back</a>
        <h2><i class="fa-regular fa-credit-card"></i> Check Out</h2>
        <form class="checkoutform" action="checkout.php" method="POST">
            <fieldset>
                <legend><h3>(1) Member Information</h3></legend>
                <div class="coformrows">
                    <div class="rowgroup">
                        <label>First Name</label>
                        <input value="<?php echo $firstname; ?>" readonly>
                    </div>
                    <div class="rowgroup">
                        <label>Last Name</label>
                        <input value="<?php echo $lastname; ?>" readonly>
                    </div>
                </div>
                <div class="coformrows">
                    <div class="rowgroup">
                        <label>Email</label>
                        <input value="<?php echo $email; ?>" readonly>
                    </div>
                    <div class="rowgroup">
                        <label>Phone Number</label>
                        <input value="<?php echo $phnum; ?>" readonly>
                    </div>
                </div>
                <p>* The information above is pre-filled from your account.</p>
            </fieldset>

            <div>
                <fieldset>
                    <legend><h3>(2) Booking Information</h3></legend>
                    <table>
                        <tr>
                            <th>Holiday Home</th>
                            <th>Check-In Date</th>
                            <th>Check-Out Date</th>
                            <th>Total Guests</th>
                            <th>Total Price</th>
                        </tr>
                        <?php
                        foreach ($cart as $HH) {
                            echo "<tr>";
                            echo "<td><img src='{$HH['HolidayHomeImage1']}' alt='Holiday Home Image'><p>{$HH['HolidayHomeName']}</p></td>";
                            echo "<td>{$HH['CheckInDate']}</td>";
                            echo "<td>{$HH['CheckOutDate']}</td>";
                            echo "<td>{$HH['NumberOfGuests']}</td>";
                            echo "<td>&euro; " . number_format($HH['TotalPrice'], 2) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                        <tr>
                            <td colspan="5"><hr></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="bookingpricelabel">Subtotal</td>
                            <td class="bookingprice">&euro; <?= number_format($subtotal, 2) ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="bookingpricelabel">VAT (10%)</td>
                            <td class="bookingprice">&euro; <?= number_format($vatamount, 2) ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="bookingpricelabel"><b>Grand Total</b></td>
                            <td class="bookingprice"><b>&euro; <?= number_format($grandtotal, 2) ?></b></td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            
            <fieldset>
                <legend><h3>Payment Information</h3></legend>
                <p>Grand Total: <b>&euro; <?= number_format($grandtotal, 2) ?></b></p>
                <label>Select Payment Method:</label>
                <select id="paymentmethod" name="slPmethod" required>
                    <option value="">No Payment Method Selected</option>
                    <?php
                    $select = "SELECT * FROM paymentmethodtb";
                    $query = mysqli_query($connect, $select);
                    while ($row = mysqli_fetch_array($query)) { 
                        $Pid = $row['PaymentMethodID'];
                        $Pname = $row['PaymentMethodName'];
                        echo "<option value='$Pid'>$Pname</option>";
                    }
                    ?>
                </select>

                <div id="paypalform" class="hidden">
                    <h3>Pay with PayPal</h3>
                    <label>PayPal Email: </label><input type="email" name="paypalemail" placeholder="ex. jdoe@paypal.com">
                </div>

                <div id="mastercardform" class="hidden">
                    <h3>MasterCard Information</h3>
                    <label>Card Number: </label><input type="text" maxlength="16" placeholder="NNNN-NNNN-NNNN-NNNN">
                    <br>
                    <label>Expiration Date: </label><input type="text" placeholder="MM/YY">
                    <br>
                    <label>CVV: </label><input type="text" maxlength="3" placeholder="NNN">
                </div>

                <div id="visaform" class="hidden">
                    <h3>Visa Card Information</h3>
                    <label>Card Number: </label><input type="text" maxlength="16" placeholder="NNNN-NNNN-NNNN-NNNN">
                    <br>
                    <label>Expiration Date: </label><input type="text" placeholder="MM/YY">
                    <br>
                    <label>CVV: </label><input type="text" maxlength="3" placeholder="NNN">
                </div>

                <div id="amexform" class="hidden">
                    <h3>American Express Information</h3>
                    <label>Card Number: </label><input type="text" maxlength="15" placeholder="NNNN-NNNN-NNNNN">
                    <br>
                    <label>Expiration Date: </label><input type="text" placeholder="MM/YY">
                    <br>
                    <label>CVV: </label><input type="text" maxlength="4" placeholder="NNNN">
                </div>
            </fieldset>

            <div class="btnConfirm">
                <input type="submit" name="btnConfirm" value="Confirm Booking">
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
    <script>
        document.getElementById('paymentmethod').addEventListener('change', function () {
            document.getElementById('paypalform').style.display = 'none';
            document.getElementById('mastercardform').style.display = 'none';
            document.getElementById('visaform').style.display = 'none';
            document.getElementById('amexform').style.display = 'none';

            switch (this.value) {
                case '1':
                    document.getElementById('paypalform').style.display = 'block';
                    break;
                case '2':
                    document.getElementById('mastercardform').style.display = 'block';
                    break;
                case '3':
                    document.getElementById('visaform').style.display = 'block';
                    break;
                case '4':
                    document.getElementById('amexform').style.display = 'block';
                    break;
                default:
                    break;
            }
        });
        document.querySelector('.checkoutform').addEventListener('submit', function (event) {
            let paymentMethod = document.getElementById('paymentmethod').value;
            let valid = true;
            let errorMessage = '';

            if (paymentMethod === '1') {
                let paypalEmail = document.querySelector('[name="paypalemail"]').value;
                if (paypalEmail === '') {
                    errorMessage = 'Please enter your PayPal email.';
                    valid = false;
                }
            }
            else if (paymentMethod === '2') {
                let cardNumber = document.querySelector('#mastercardform [placeholder="NNNN-NNNN-NNNN-NNNN"]').value;
                let expirationDate = document.querySelector('#mastercardform [placeholder="MM/YY"]').value;
                let cvv = document.querySelector('#mastercardform [placeholder="NNN"]').value;
                if (cardNumber === '' || expirationDate === '' || cvv === '') {
                    errorMessage = 'Please fill in all MasterCard fields.';
                    valid = false;
                }
            }
            else if (paymentMethod === '3') {
                let cardNumber = document.querySelector('#visaform [placeholder="NNNN-NNNN-NNNN-NNNN"]').value;
                let expirationDate = document.querySelector('#visaform [placeholder="MM/YY"]').value;
                let cvv = document.querySelector('#visaform [placeholder="NNN"]').value;
                if (cardNumber === '' || expirationDate === '' || cvv === '') {
                    errorMessage = 'Please fill in all Visa fields.';
                    valid = false;
                }
            }
            else if (paymentMethod === '4') {
                let cardNumber = document.querySelector('#amexform [placeholder="NNNN-NNNN-NNNNN"]').value;
                let expirationDate = document.querySelector('#amexform [placeholder="MM/YY"]').value;
                let cvv = document.querySelector('#amexform [placeholder="NNNN"]').value;
                if (cardNumber === '' || expirationDate === '' || cvv === '') {
                    errorMessage = 'Please fill in all American Express fields.';
                    valid = false;
                }
            }

            if (!valid) {
                event.preventDefault();
                alert(errorMessage);
            }
        });
    </script>
</body>
</html>