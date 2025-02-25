<?php
include('dbconnection.php');
session_start();

if (isset($_SESSION['Mid'])) 
{
	$MemID=$_SESSION['Mid'];
	$Username=$_SESSION['Username'];
	$Mimage=$_SESSION['Mpfp'];
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/cus.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap"
      rel="stylesheet"
    />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap"
      rel="stylesheet"
    />

    <title>
      PRIVACY POLICY | AUTUNNO - Book Holiday Homes With Fair Prices
    </title>
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
    <section class="PPsection">
      <h1>Privacy Policy</h1>
      <p>Last updated: September 30, 2024</p>
      <p>
        This Privacy Policy describes Our policies and procedures on the
        collection, use and disclosure of Your information when You use the
        Service and tells You about Your privacy rights and how the law protects
        You.
      </p>
      <p>
        We use Your Personal data to provide and improve the Service. By using
        the Service, You agree to the collection and use of information in
        accordance with this Privacy Policy.
      </p>
      <h2>Interpretation and Definitions</h2>
      <h3>Interpretation</h3>
      <p>
        The words of which the initial letter is capitalized have meanings
        defined under the following conditions. The following definitions shall
        have the same meaning regardless of whether they appear in singular or
        in plural.
      </p>
      <h3>Definitions</h3>
      <p>For the purposes of this Privacy Policy:</p>
      <ul>
        <li>
          <p>
            <strong>Account</strong> means a unique account created for You to
            access our Service or parts of our Service.
          </p>
        </li>
        <li>
          <p>
            <strong>Affiliate</strong> means an entity that controls, is
            controlled by or is under common control with a party, where
            &quot;control&quot; means ownership of 50% or more of the shares,
            equity interest or other securities entitled to vote for election of
            directors or other managing authority.
          </p>
        </li>
        <li>
          <p>
            <strong>Company</strong> (referred to as either &quot;the
            Company&quot;, &quot;We&quot;, &quot;Us&quot; or &quot;Our&quot; in
            this Agreement) refers to Autunno.
          </p>
        </li>
        <li>
          <p><strong>Country</strong> refers to: Italy</p>
        </li>
        <li>
          <p>
            <strong>Device</strong> means any device that can access the Service
            such as a computer, a cellphone or a digital tablet.
          </p>
        </li>
        <li>
          <p>
            <strong>Personal Data</strong> is any information that relates to an
            identified or identifiable individual.
          </p>
        </li>
        <li>
          <p><strong>Service</strong> refers to the Website.</p>
        </li>
        <li>
          <p>
            <strong>Service Provider</strong> means any natural or legal person
            who processes the data on behalf of the Company. It refers to
            third-party companies or individuals employed by the Company to
            facilitate the Service, to provide the Service on behalf of the
            Company, to perform services related to the Service or to assist the
            Company in analyzing how the Service is used.
          </p>
        </li>
        <li>
          <p><strong>Website</strong> refers to Autunno.</p>
        </li>
        <li>
          <p>
            <strong>You</strong> means the individual accessing or using the
            Service, or the company, or other legal entity on behalf of which
            such individual is accessing or using the Service, as applicable.
          </p>
        </li>
      </ul>
      <h2>Collecting and Using Your Personal Data</h2>
      <h3>Types of Data Collected</h3>
      <h4>Personal Data</h4>
      <p>
        While using Our Service, We may ask You to provide Us with certain
        personally identifiable information that can be used to contact or
        identify You. Personally identifiable information may include, but is
        not limited to:
      </p>
      <ul>
        <li>
          <p>Email address</p>
        </li>
        <li>
          <p>First name and last name</p>
        </li>
        <li>
          <p>Phone number</p>
        </li>
      </ul>
      <h3>Use of Your Personal Data</h3>
      <p>The Company may use Personal Data for the following purposes:</p>
      <ul>
        <li>
          <p>
            <strong>To provide and maintain our Service</strong>, including to
            monitor the usage of our Service.
          </p>
        </li>
        <li>
          <p>
            <strong>To manage Your Account:</strong> to manage Your registration
            as a user of the Service. The Personal Data You provide can give You
            access to different functionalities of the Service that are
            available to You as a registered user.
          </p>
        </li>
        <li>
          <p>
            <strong>For the performance of a contract:</strong> the development,
            compliance and undertaking of the purchase contract for the
            products, items or services You have purchased or of any other
            contract with Us through the Service.
          </p>
        </li>
        <li>
          <p>
            <strong>To contact You:</strong> To contact You by email, telephone
            calls, SMS, or other equivalent forms of electronic communication,
            such as a mobile application's push notifications regarding updates
            or informative communications related to the functionalities,
            products or contracted services, including the security updates,
            when necessary or reasonable for their implementation.
          </p>
        </li>
        <li>
          <p>
            <strong>To provide You</strong> with news, special offers and
            general information about other goods, services and events which we
            offer that are similar to those that you have already purchased or
            enquired about unless You have opted not to receive such
            information.
          </p>
        </li>
        <li>
          <p>
            <strong>To manage Your requests:</strong> To attend and manage Your
            requests to Us.
          </p>
        </li>
        <li>
          <p>
            <strong>For business transfers:</strong> We may use Your information
            to evaluate or conduct a merger, divestiture, restructuring,
            reorganization, dissolution, or other sale or transfer of some or
            all of Our assets, whether as a going concern or as part of
            bankruptcy, liquidation, or similar proceeding, in which Personal
            Data held by Us about our Service users is among the assets
            transferred.
          </p>
        </li>
        <li>
          <p>
            <strong>For other purposes</strong>: We may use Your information for
            other purposes, such as data analysis, identifying usage trends,
            determining the effectiveness of our promotional campaigns and to
            evaluate and improve our Service, products, services, marketing and
            your experience.
          </p>
        </li>
      </ul>
      <p>We may share Your personal information in the following situations:</p>
      <ul>
        <li>
          <strong>With Service Providers:</strong> We may share Your personal
          information with Service Providers to monitor and analyze the use of
          our Service, to contact You.
        </li>
        <li>
          <strong>For business transfers:</strong> We may share or transfer Your
          personal information in connection with, or during negotiations of,
          any merger, sale of Company assets, financing, or acquisition of all
          or a portion of Our business to another company.
        </li>
        <li>
          <strong>With Affiliates:</strong> We may share Your information with
          Our affiliates, in which case we will require those affiliates to
          honor this Privacy Policy. Affiliates include Our parent company and
          any other subsidiaries, joint venture partners or other companies that
          We control or that are under common control with Us.
        </li>
        <li>
          <strong>With business partners:</strong> We may share Your information
          with Our business partners to offer You certain products, services or
          promotions.
        </li>
        <li>
          <strong>With other users:</strong> when You share personal information
          or otherwise interact in the public areas with other users, such
          information may be viewed by all users and may be publicly distributed
          outside.
        </li>
        <li>
          <strong>With Your consent</strong>: We may disclose Your personal
          information for any other purpose with Your consent.
        </li>
      </ul>
      <h3>Retention of Your Personal Data</h3>
      <p>
        The Company will retain Your Personal Data only for as long as is
        necessary for the purposes set out in this Privacy Policy. We will
        retain and use Your Personal Data to the extent necessary to comply with
        our legal obligations (for example, if we are required to retain your
        data to comply with applicable laws), resolve disputes, and enforce our
        legal agreements and policies.
      </p>
      <p>
        The Company will also retain Usage Data for internal analysis purposes.
        Usage Data is generally retained for a shorter period of time, except
        when this data is used to strengthen the security or to improve the
        functionality of Our Service, or We are legally obligated to retain this
        data for longer time periods.
      </p>
      <h3>Transfer of Your Personal Data</h3>
      <p>
        Your information, including Personal Data, is processed at the Company's
        operating offices and in any other places where the parties involved in
        the processing are located. It means that this information may be
        transferred to — and maintained on — computers located outside of Your
        state, province, country or other governmental jurisdiction where the
        data protection laws may differ than those from Your jurisdiction.
      </p>
      <p>
        Your consent to this Privacy Policy followed by Your submission of such
        information represents Your agreement to that transfer.
      </p>
      <p>
        The Company will take all steps reasonably necessary to ensure that Your
        data is treated securely and in accordance with this Privacy Policy and
        no transfer of Your Personal Data will take place to an organization or
        a country unless there are adequate controls in place including the
        security of Your data and other personal information.
      </p>
      <h3>Delete Your Personal Data</h3>
      <p>
        You have the right to delete or request that We assist in deleting the
        Personal Data that We have collected about You.
      </p>
      <p>
        Our Service may give You the ability to delete certain information about
        You from within the Service.
      </p>
      <p>
        You may update, amend, or delete Your information at any time by signing
        in to Your Account, if you have one, and visiting the account settings
        section that allows you to manage Your personal information. You may
        also contact Us to request access to, correct, or delete any personal
        information that You have provided to Us.
      </p>
      <p>
        Please note, however, that We may need to retain certain information
        when we have a legal obligation or lawful basis to do so.
      </p>
      <h3>Disclosure of Your Personal Data</h3>
      <h4>Business Transactions</h4>
      <p>
        If the Company is involved in a merger, acquisition or asset sale, Your
        Personal Data may be transferred. We will provide notice before Your
        Personal Data is transferred and becomes subject to a different Privacy
        Policy.
      </p>
      <h4>Law enforcement</h4>
      <p>
        Under certain circumstances, the Company may be required to disclose
        Your Personal Data if required to do so by law or in response to valid
        requests by public authorities (e.g. a court or a government agency).
      </p>
      <h4>Other legal requirements</h4>
      <p>
        The Company may disclose Your Personal Data in the good faith belief
        that such action is necessary to:
      </p>
      <ul>
        <li>Comply with a legal obligation</li>
        <li>Protect and defend the rights or property of the Company</li>
        <li>
          Prevent or investigate possible wrongdoing in connection with the
          Service
        </li>
        <li>
          Protect the personal safety of Users of the Service or the public
        </li>
        <li>Protect against legal liability</li>
      </ul>
      <h3>Security of Your Personal Data</h3>
      <p>
        The security of Your Personal Data is important to Us, but remember that
        no method of transmission over the Internet, or method of electronic
        storage is 100% secure. While We strive to use commercially acceptable
        means to protect Your Personal Data, We cannot guarantee its absolute
        security.
      </p>
      <h2>Children's Privacy</h2>
      <p>
        Our Service does not address anyone under the age of 18. We do not
        knowingly collect personally identifiable information from anyone under
        the age of 18. If You are a parent or guardian and You are aware that
        Your child has provided Us with Personal Data, please contact Us. If We
        become aware that We have collected Personal Data from anyone under the
        age of 18 without verification of parental consent, We take steps to
        remove that information from Our servers.
      </p>
      <p>
        If We need to rely on consent as a legal basis for processing Your
        information and Your country requires consent from a parent, We may
        require Your parent's consent before We collect and use that
        information.
      </p>
      <h2>Links to Other Websites</h2>
      <p>
        Our Service may contain links to other websites that are not operated by
        Us. If You click on a third party link, You will be directed to that
        third party's site. We strongly advise You to review the Privacy Policy
        of every site You visit.
      </p>
      <p>
        We have no control over and assume no responsibility for the content,
        privacy policies or practices of any third party sites or services.
      </p>
      <h2>Changes to this Privacy Policy</h2>
      <p>
        We may update Our Privacy Policy from time to time. We will notify You
        of any changes by posting the new Privacy Policy on this page.
      </p>
      <p>
        We will let You know via email and/or a prominent notice on Our Service,
        prior to the change becoming effective and update the &quot;Last
        updated&quot; date at the top of this Privacy Policy.
      </p>
      <p>
        You are advised to review this Privacy Policy periodically for any
        changes. Changes to this Privacy Policy are effective when they are
        posted on this page.
      </p>
      <h2>Contact Us</h2>
      <p>
        If you have any questions about this Privacy Policy, You can contact us:
      </p>
      <ul>
        <li>
          <p>By email: stayatautunno@gmail.com</p>
        </li>
        <li>
          <p>By phone number: +123 456789</p>
        </li>
      </ul>
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
