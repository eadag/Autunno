<?php 
function AddSchedule($HHomeID, $SstartDate, $SendDate)
{
	$host="localhost";
	$user="root";
	$pass="";
	$database="autunnodb";
	$connection=mysqli_connect($host,$user,$pass,$database);
	$HHquery="SELECT * FROM holidayhometb WHERE HolidayHomeID='$HHomeID'";
	$result=mysqli_query($connection, $HHquery);
	$count=mysqli_num_rows($result);
	if ($count<1)
	{
		echo "<p>No Holiday Home Found.</p>";
		exit();
	}
	$array=mysqli_fetch_array($result);
	$HHname=$array['HolidayHomeName'];
	$HHimg=$array['HolidayHomeImage1'];
 
	if(isset($_SESSION['schedulefunction'])) 
	{
		$index=IndexOf($HHomeID);
		if($index==-1) {
			$size=count($_SESSION['schedulefunction']);
			$_SESSION['schedulefunction'][$size]['HolidayHomeID']=$HHomeID;
			$_SESSION['schedulefunction'][$size]['HolidayHomeName']=$HHname;
			$_SESSION['schedulefunction'][$size]['ScheduleStartDate']=$SstartDate;
			$_SESSION['schedulefunction'][$size]['ScheduleEndDate']=$SendDate;
			$_SESSION['schedulefunction'][$size]['HolidayHomeImage1']=$HHimg;
		}
	}
	else
	{
		$_SESSION['schedulefunction']=array();
		$_SESSION['schedulefunction'][0]['HolidayHomeID']=$HHomeID;
	  	$_SESSION['schedulefunction'][0]['HolidayHomeName']=$HHname;
	  	$_SESSION['schedulefunction'][0]['ScheduleStartDate']=$SstartDate;
	  	$_SESSION['schedulefunction'][0]['ScheduleEndDate']=$SendDate;
	  	$_SESSION['schedulefunction'][0]['HolidayHomeImage1']=$HHimg;
 
	}
	echo "<script>window.location='addschedule.php'</Script>";
}

function IndexOf($HHomeID)
{
if(!isset($_SESSION['schedulefunction']))
{
	return -1;
}
$size=count($_SESSION['schedulefunction']);
if($size==0)
{
	return -1;
}
for($i=0; $i<$size; $i++)
{
	if($HHomeID==$_SESSION['schedulefunction'][$i]['HolidayHomeID'])
	{
	return $i;
	}
}
	return -1;
}

function RemoveSchedule($HHomeID)
{
	$index = IndexOf($HHomeID);
	if ($index != -1) {
        unset($_SESSION['schedulefunction'][$index]);
        $_SESSION['schedulefunction'] = array_values($_SESSION['schedulefunction']);
        echo "<script>window.location='addschedule.php'</script>";
    }
}
?>