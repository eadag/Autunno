<?php
session_start();
include('dbconnection.php');

if(isset($_POST['btnSignIn']))
{
	$email=$_POST['txtemail'];
	$psw=$_POST['txtpsw'];

	$selectemailnpsw="SELECT * FROM membertb WHERE Email='$email'AND MemberPassword='$psw'";

	$query=mysqli_query($connect, $selectemailnpsw);

	$rowcount=mysqli_num_rows($query);

	if ($rowcount>0)
	{
		$array=mysqli_fetch_array($query);
		$MID=$array['MemberID'];
		$username=$array['Username'];
		$Mimg=$array['ProfileImage'];

		$_SESSION['Mid']=$MID;
		$_SESSION['Username']=$username;
		$_SESSION['Mpfp']=$Mimg;

		echo "<script>window.alert('Successfully Signed In!')</script>";
		echo "<script>window.location='landingpage.php'</script>";
	}
    else
    {
        if (isset($_SESSION['signinCount'])) 
        {
            $counterror=$_SESSION['signinCount'];
            if ($counterror==1) 
            {
                echo "<script>window.alert('Failed Sign In Attempt Two! You will be moved to waiting room when you still failed to sign in after the third time.')</script>";
                $_SESSION['signinCount']=2;
            }
            elseif ($counterror==2) {
                echo "<script>window.alert('Failed Sign In Attempt Three! Please click OK and go to the waiting room.')</script>";
                echo "<script>window.location='waitingroom.php'</script>";
            }
        }
        else
        {
            echo "<script>window.alert('Failed Sign In Attempt One! You will be moved to waiting room when you still failed to sign in after the third time.')</script>";
            $_SESSION['signinCount']=1;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cus.css">
    <title>MEMBER SIGN IN | AUTUNNO</title>
</head>
<body>
    <section class="formcontainer">
    <a class="backlink"  href="landingpage.php">&lt; Back</a>
        <form class="memberSIform" action="membersignin.php" method="POST" enctype="multipart/form-data">
            <div class="columndiv">
                <img class="formimg" src="images/formhomeimage.jpg" alt="Pink door apartment">
                <div class="memberformcontent">
                    <div class="memberformheading">
                        <img src="images/AutunnoLogo1.png" alt="Autunno Logo">
                        <h2>Member</h2>
                    </div>
                    <div class="menu">
                        <a href="membersignup.php" class="SUlink"><h3>Sign Up</h3></a>
                        <a href="membersignin.php" class="SIlink"><h3>Sign In</h3></a>
                    </div>
                    <div class="field">
                        <input type="text" name="txtemail" Required>
                        <label>Enter Your Email *</label>
                    </div>
                    <div class="field">
                        <input type="password" name="txtpsw" Required>
                        <label>Enter Your Password *</label>
                    </div>   
                    <input class="btnSubmit" type="submit" name="btnSignIn" value="Sign In">
                </div>
            </div>
        </form>
    </section>
</body>
</html>
