<?php 
include('dbconnection.php');

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

	<title>WAITING ROOM | AUTUNNO - Book Holiday Homes With Fair Prices</title>
</head>
<body>
	<section class="countdown">
        <h1>Autunno Sign In Waiting Room</h1>
        <p>You are here because you failed to sign in thrice. Try Again In Ten (10) Minutes</p>

        <h2>
            <span id="countdown">600</span> seconds
        </h2>

        <?php
            if (isset($_SERVER['HTTP_REFERER'])) {
                $previouspage = basename($_SERVER['HTTP_REFERER']);
                if ($previouspage == 'membersignin.php') {
                    echo "<a href='landingpage.php'>Continue As Guest &rarr;</a>";
                }
            }
        ?>

        <script type="text/javascript">
            var seconds=600;
            function updatecountdown()
            {
                document.getElementById('countdown').textContent=seconds;
                seconds--;

                if (seconds<0) 
                {
                    window.location.href='membersignin.php';
                }
            }
            setInterval(updatecountdown, 1000);
        </script>		
	</section>
</body>
</html>