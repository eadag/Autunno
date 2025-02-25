<?php
include('dbconnection.php');
if (isset($_POST['btnSignUp']))
{
    $firstname=$_POST['txtfirstname'];
    $lastname=$_POST['txtlastname'];
    $username=$_POST['txtusername'];
    $email=$_POST['txtemail'];
    $psw=$_POST['txtpsw'];
    $contactno=$_POST['txtcontactno'];

    $number=preg_match('@[0-9]@', $psw);
    $upperletter=preg_match('@[A-Z]@', $psw);
    $lowerletter=preg_match('@[a-z]@', $psw);
    $specialcharacter=preg_match('@[^\w]@', $psw);

    $usernameexistcheck="SELECT * FROM membertb WHERE Username='$username'";
    $ucquery=mysqli_query($connect,$usernameexistcheck);
    $ucrow=mysqli_num_rows($ucquery);

    $emailexistcheck="SELECT * FROM membertb WHERE Email='$email'";
    $ecquery=mysqli_query($connect,$emailexistcheck);
    $ecrow=mysqli_num_rows($ecquery);

    if ($ucrow>0)
    {
        echo "<script>window.alert('Username is taken. Try another one!')</script>";
        echo "<script>window.location='membersignup.php'</script>";
    }
    else if ($ecrow>0)
    {
        echo "<script>window.alert('Email is already registered! Try Signing In.')</script>";
        echo "<script>window.location='membersignin.php'</script>";
    }
    else if(strlen($psw) <8 || !$number || !$upperletter || !$lowerletter || !$specialcharacter)
    {
    	echo "<script>window.alert('Password must be at least 8 characters long that include at least a number, an upper letter, a lower letter, and a special character.')</script>";
        echo "<script>window.location='membersignup.php'</script>";
    }
    else if(strpos($email, '@gmail.com') === false)
    {
        echo "<script>window.alert('Please enter a valid Email!')</script>";
        echo "<script>window.location='membersignup.php'</script>";
    }
    else
    {
        $Mimg=$_FILES['fileMimg']['name'];
        $copyfolder="images/";
        $filename=$copyfolder.uniqid()."_".$Mimg;
        $copy=copy($_FILES['fileMimg']['tmp_name'], $filename);
        if (!$copy) 
        {
            echo "<p>Profile Image cannot be uploaded. Please try again!</p>";
            exit();
        }
        $insertMdata="INSERT INTO membertb (ProfileImage, Username, FirstName, LastName, Email, MemberPassword, ContactNumber)
        VALUES('$filename', '$username', '$firstname', '$lastname', '$email', '$psw','$contactno')";
        $inserted=mysqli_query($connect,$insertMdata);
        if ($inserted)
        {
            echo "<script>window.alert('Your account has been created successfully!')</script>";
            echo "<script>window.location='membersignin.php'</script>";
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
    <title>MEMBER SIGN UP | AUTUNNO</title>
</head>
<body>
    <section class="formcontainer">
        <a class="backlink"  href="landingpage.php">&lt; Back</a>
        <form class="memberSUform" action="membersignup.php" method="POST" enctype="multipart/form-data">
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
                        <input type="text" name="txtfirstname" Required>
                        <label>First Name *</label>
                    </div>
                    <div class="field">
                        <input type="text" name="txtlastname" Required>
                        <label>Last Name *</label>
                    </div>
                    <div class="field">
                        <input type="text" name="txtusername" Required>
                        <label>Create a Username *</label>
                    </div>
                    <div class="field">
                        <input type="text" name="txtemail" Required>
                        <label>Email *</label>
                    </div>
                    <div class="field">
                        <input type="password" name="txtpsw" Required>
                        <label>Create a Password *</label>
                    </div>
                    <div class="field">
                        <input type="text" name="txtcontactno" Required>
                        <label>Contact Number *</label>
                    </div>
                    <div class="uploadimg">
                        <label>Upload Profile Image *</label>
                        <input type="file" name="fileMimg" Required>
                    </div>  
                    <input class="btnSubmit" type="submit" name="btnSignUp" value="Sign Up">
                </div>
            </div>
        </form>
    </section>
</body>
</html>