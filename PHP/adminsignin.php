<?php
session_start();
include('dbconnection.php');

if(isset($_POST['btnSignIn']))
{
	$email=$_POST['txtemail'];
	$psw=$_POST['txtpsw'];

	$selectemailnpsw="SELECT * FROM administratortb WHERE Email='$email'AND AdministratorPassword='$psw'";

	$query=mysqli_query($connect, $selectemailnpsw);

	$rowcount=mysqli_num_rows($query);

	if ($rowcount>0)
	{

		$array=mysqli_fetch_array($query);
		$AID=$array['AdministratorID'];
        $Fname=$array['FirstName'];
		$uname=$array['Username'];
		$Aimg=$array['ProfileImage'];

		$_SESSION['Aid']=$AID;
        $_SESSION['Fname']=$Fname;
		$_SESSION['Uname']=$uname;
		$_SESSION['Apfp']=$Aimg;

		echo "<script>window.alert('Successfully Signed In!')</script>";
		echo "<script>window.location='dashboard.php'</script>";
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
    <link rel="stylesheet" href="css/admin.css">
    <title>ADMINISTRATOR SIGN IN | AUTUNNO</title>
</head>
<body>
    <section class="formcontainer">
        <form class="adminSIform" action="adminsignin.php" method="POST" enctype="multipart/form-data">
            <div class="columndiv">
            <img class="formimg" src="images/formhomeimage.jpg" alt="Pink door apartment">
                <div class="adminformcontent">
                    <div class="adminformheading">
                        <img src="images/AutunnoLogo1.png" alt="Autunno Logo">
                        <h2>Administrator</h2>
                    </div>
                    <div class="menu">
                        <a href="adminsignup.php" class="SUlink"><h3>Sign Up</h3></a>
                        <a href="adminsignin.php" class="SIlink"><h3>Sign In</h3></a>
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