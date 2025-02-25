<?php
function AddBookingCart($Hid, $NoG, $checkindate, $checkoutdate, $totalnights, $totalprice)
{
	include('dbconnection.php');
	$query="SELECT * FROM HolidayHometb WHERE HolidayHomeID='$Hid'";
	$result=mysqli_query($connect, $query);
	$count=mysqli_num_rows($result);

	if ($count < 1) {
		echo "<p>Holiday Home ID Not Found.</p>";
		exit();
	}
	$row=mysqli_fetch_array($result);
	$Hname = $row['HolidayHomeName'];
	$Himg = $row['HolidayHomeImage1'];

	if (isset($_SESSION['BookingCartFunction'])) {
		$Index = IndexOf($Hid);

		if ($Index == -1) {
			$size = count($_SESSION['BookingCartFunction']);

			$_SESSION['BookingCartFunction'][$size]['HolidayHomeID'] = $Hid;
			$_SESSION['BookingCartFunction'][$size]['HolidayHomeName'] = $Hname;
			$_SESSION['BookingCartFunction'][$size]['HolidayHomeImage1'] = $Himg;
			$_SESSION['BookingCartFunction'][$size]['NumberOfGuests'] = $NoG;
			$_SESSION['BookingCartFunction'][$size]['CheckInDate'] = $checkindate;
			$_SESSION['BookingCartFunction'][$size]['CheckOutDate'] = $checkoutdate;
			$_SESSION['BookingCartFunction'][$size]['TotalNights'] = $totalnights;
			$_SESSION['BookingCartFunction'][$size]['TotalPrice'] = $totalprice;
		}
	}
	else {
		$_SESSION['BookingCartFunction'] = array();

		$_SESSION['BookingCartFunction'][0]['HolidayHomeID'] = $Hid;
		$_SESSION['BookingCartFunction'][0]['HolidayHomeName'] = $Hname;
		$_SESSION['BookingCartFunction'][0]['HolidayHomeImage1'] = $Himg;
		$_SESSION['BookingCartFunction'][0]['NumberOfGuests'] = $NoG;
		$_SESSION['BookingCartFunction'][0]['CheckInDate'] = $checkindate;
		$_SESSION['BookingCartFunction'][0]['CheckOutDate'] = $checkoutdate;
		$_SESSION['BookingCartFunction'][0]['TotalNights'] = $totalnights;
		$_SESSION['BookingCartFunction'][0]['TotalPrice'] = $totalprice;
	}
	echo "<script>window.location='bookingcart.php'</script>";
}

function IndexOf($Hid)
{
	if (!isset($_SESSION['BookingCartFunction'])) {
		return -1;
	}

	$size = count($_SESSION['BookingCartFunction']);

	for ($i=0; $i < $size; $i++) {
		if ($_SESSION['BookingCartFunction'][$i]['HolidayHomeID'] == $Hid) {
			return $i;
		}
	}
	return -1;
}

function RemoveBookingCart($Hid)
{
	$Index = IndexOf($Hid);
	unset($_SESSION['BookingCartFunction'][$Index]);
	$_SESSION['BookingCartFunction'] = array_values($_SESSION['BookingCartFunction']);

	echo "<script>window.location='bookingcart.php'</script>";
}

function ClearBookingCart()
{
	unset($_SESSION['BookingCartFunction']);
	echo "<script>window.location='bookingcart.php'</script>";
}
?>
