<?php

    //connection start
    require_once('../connection/connection.php');

    //session variable start
    session_start();

    //set currency type as cookie in local machine
    if(isset($_GET['currency'])){
        setcookie("currency_type", $_GET['currency'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    //set theme as cookie in local machine
    if(isset($_GET['theme'])){
        setcookie("theme", $_GET['theme'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- title -->
        <title>Terms &amp; Conditions | DigiMart</title>

        <!-- title icon -->
        <link rel="icon" type="image/ico" href="../image/logo.png"/>

        <!-- Bootstrap CSS -->
        <link type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- CSS -->
        <link type="text/css" href="../css/navbar.css" rel="stylesheet">

        <!-- google font -->
        <link href='https://fonts.googleapis.com/css?family=Atomic Age' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>

        <!-- Fontawesome icons -->
        <script src="https://kit.fontawesome.com/faf1c6588d.js" crossorigin="anonymous"></script>

        <!-- jQuery -->
        <script src="../vendor/jquery/jquery-3.4.1.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.js"></script>

        <!-- Internal CSS -->
        <style>
            body {
                /*background-image: url('../image/back.gif');
                background-image: url('../image/back.png');*/
                <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "background-color: #404550"; ?>
            }

            .termRow2 {
                background-color: rgba(221,18,60,0.3);
                font-family: 'Abel';
                font-size: 20px;
            }

            .display-4 {
                font-family: 'Atomic Age';
            }

        </style>

        <!-- Script -->
        <script>
            //for tooltips
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>


    </head>

    <body>

        <!-- import navbar -->
        <?php
            require_once('header_half.php');
        ?>

        <!-- page content row 1 -->
        <div class="container">

            <div class="mt-4">
                <h1 class="display-4 text-danger"><img src="../image/privacy.png" width="60px"> Privacy and Confidentiality</h1>
            </div>

            <div class="pt-5 pb-4">
                <p class="text-justify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-light"; ?> lead">

                    &emsp;&emsp;&emsp;&emsp;Welcome to the digimart website (the "Site") operated by team digimart (Private) Limited. We respect your privacy and want to protect your personal information. To learn more, please read this Privacy Policy.

                    <br><br>

                    This Privacy Policy explains how we collect, use and (under certain conditions) disclose your personal information. This Privacy Policy also explains the steps we have taken to secure your personal information. Finally, this Privacy Policy explains your options regarding the collection, use and disclosure of your personal information. By visiting the Site directly or through another site, you accept the practices described in this Policy.

                    <br><br>

                    Data protection is a matter of trust and your privacy is important to us. We shall therefore only use your name and other information which relates to you in the manner set out in this Privacy Policy. We will only collect information where it is necessary for us to do so and we will only collect information if it is relevant to our dealings with you.

                    <br><br>

                    We will only keep your information for as long as we are either required to by law or as is relevant for the purposes for which it was collected.

                    <br><br>

                    You can visit the Site and browse without having to provide personal details. During your visit to the Site you remain anonymous and at no time can we identify you unless you have an account on the Site and log on with your user name and password.

                </p>
            </div>

        </div>

        <!-- page content row 1 -->
        <div class="container-fluid termRow2 mt-4">
            <div class="container pt-5 pb-4">

                <h2 class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-danger"; ?>">1. Data that we collect</h2>

                <p class="text-justify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-light"; ?>">

                    We may collect various pieces of information if you seek to place an order for a product with us on the Site.

                    <br><br>

                    We collect, store and process your data for processing your purchase on the Site and any possible later claims, and to provide you with our services. We may collect personal information including, but not limited to, your title, name, gender, date of birth, email address, postal address, delivery address (if different), telephone number, mobile number, fax number, payment details, payment card details or bank account details.

                    <br><br>

                    We will use the information you provide to enable us to process your orders and to provide you with the services and information offered through our website and which you request. Further, we will use the information you provide to administer your account with us; verify and carry out financial transactions in relation to payments you make; audit the downloading of data from our website; improve the layout and/or content of the pages of our website and customize them for users; identify visitors on our website; carry out research on our users' demographics; send you information we think you may find useful or which you have requested from us, including information about our products and services, provided you have indicated that you have not objected to being contacted for these purposes. Subject to obtaining your consent we may contact you by email with details of other products and services. If you prefer not to receive any marketing communications from us, you can opt out at any time.

                    <br><br>

                    We may pass your name and address on to a third party in order to make delivery of the product to you (for example to our courier or supplier). You must only submit to us the Site information which is accurate and not misleading and you must keep it up to date and inform us of changes.

                    <br><br>

                    Your actual order details may be stored with us but for security reasons cannot be retrieved directly by us. However, you may access this information by logging into your account on the Site. Here you can view the details of your orders that have been completed, those which are open and those which are shortly to be dispatched and administer your address details, bank details ( for refund purposes) and any newsletter to which you may have subscribed. You undertake to treat the personal access data confidentially and not make it available to unauthorized third parties. We cannot assume any liability for misuse of passwords unless this misuse is our fault.

                </p>

                <h3 class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-danger"; ?>">Other uses of your Personal Information</h3>

                <p class="text-justify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-light"; ?>">

                    We may use your personal information for opinion and market research. Your details are anonymous and will only be used for statistical purposes. You can choose to opt out of this at any time. Any answers to surveys or opinion polls we may ask you to complete will not be forwarded on to third parties. Disclosing your email address is only necessary if you would like to take part in competitions. We save the answers to our surveys separately from your email address.

                    <br><br>

                    We may also send you other information about us, the Site, our other websites, our products, sales promotions, our newsletters, anything relating to other companies in our group or our business partners. If you would prefer not to receive any of this additional information as detailed in this paragraph (or any part of it) please click the 'unsubscribe' link in any email that we send to you. Within 7 working days (days which are neither (i) a Sunday, nor (ii) a public holiday anywhere in Srilanka) of receipt of your instruction we will cease to send you information as requested. If your instruction is unclear we will contact you for clarification.

                    <br><br>

                    We may further anonymize data about users of the Site generally and use it for various purposes, including ascertaining the general location of the users and usage of certain aspects of the Site or a link contained in an email to those registered to receive them, and supplying that anonymized data to third parties such as publishers. However, that anonymized data will not be capable of identifying you personally.

                </p>

                <h3 class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-danger"; ?>">Competitions</h3>

                <p class="text-justify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-light"; ?>">

                    For any competition we use the data to notify winners and advertise our offers. You can find more details where applicable in our participation terms for the respective competition.

                </p>

                <h3 class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-danger"; ?>">Third Parties and Links</h3>

                <p class="text-justify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-light"; ?>">

                    We may pass your details to other companies in our group. We may also pass your details to our agents and subcontractors to help us with any of our uses of your data set out in our Privacy Policy. For example, we may use third parties to assist us with delivering products to you, to help us to collect payments from you, to analyze data and to provide us with marketing or customer service assistance.

                    <br><br>

                    We may exchange information with third parties for the purposes of fraud protection and credit risk reduction. We may transfer our databases containing your personal information if we sell our business or part of it. Other than as set out in this Privacy Policy, we shall NOT sell or disclose your personal data to third parties without obtaining your prior consent unless this is necessary for the purposes set out in this Privacy Policy or unless we are required to do so by law. The Site may contain advertising of third parties and links to other sites or frames of other sites. Please be aware that we are not responsible for the privacy practices or content of those third parties or other sites, nor for any third party to whom we transfer your data in accordance with our Privacy Policy.

                </p>

                <hr>

                <h2 class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-danger"; ?>">2. Cookies</h2>

                <p class="text-justify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-light"; ?>">

                    The acceptance of cookies is not a requirement for visiting the Site. However we would like to point out that the use of the 'basket' functionality on the Site and ordering is only possible with the activation of cookies. Cookies are tiny text files which identify your computer to our server as a unique user when you visit certain pages on the Site and they are stored by your Internet browser on your computer's hard drive. Cookies can be used to recognize your Internet Protocol address, saving you time while you are on, or want to enter, the Site. We only use cookies for your convenience in using the Site (for example to remember who you are when you want to amend your shopping cart without having to re-enter your email address) and not for obtaining or using any other information about you (for example targeted advertising). Your browser can be set to not accept cookies, but this would restrict your use of the Site. Please accept our assurance that our use of cookies does not contain any personal or private details and are free from viruses. If you want to find out more information about cookies, go to <a href="http://www.allaboutcookies.org" target="_blank">http://www.allaboutcookies.org</a> or to find out about removing them from your browser, go to <a href="http://www.allaboutcookies.org/manage-cookies/index.html" target="_blank">http://www.allaboutcookies.org/manage-cookies/index.html</a>.

                    <br><br>

                    This website uses Google Analytics, a web analytics service provided by Google, Inc. ("Google"). Google Analytics uses cookies, which are text files placed on your computer, to help the website analyze how users use the site. The information generated by the cookie about your use of the website (including your IP address) will be transmitted to and stored by Google on servers in the United States. Google will use this information for the purpose of evaluating your use of the website, compiling reports on website activity for website operators and providing other services relating to website activity and internet usage. Google may also transfer this information to third parties where required to do so by law, or where such third parties process the information on Google's behalf. Google will not associate your IP address with any other data held by Google. You may refuse the use of cookies by selecting the appropriate settings on your browser, however please note that if you do this you may not be able to use the full functionality of this website. By using this website, you consent to the processing of data about you by Google in the manner and for the purposes set out above.

                </p>

                <hr>

                <h2 class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-danger"; ?>">3. Security</h2>

                <p class="text-justify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-light"; ?>">

                    We have in place appropriate technical and security measures to prevent unauthorized or unlawful access to or accidental loss of or destruction or damage to your information. When we collect data through the Site, we collect your personal details on a secure server. We use firewalls on our servers. Our security procedures mean that we may occasionally request proof of identity before we disclose personal information to you. You are responsible for protecting against unauthorized access to your password and to your computer.

                </p>

                <hr>

                <h2 class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-danger"; ?>">4. Your rights</h2>

                <p class="text-justify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-light"; ?>">

                    If you are concerned about your data you have the right to request access to the personal data which we may hold or process about you. You have the right to require us to correct any inaccuracies in your data free of charge. At any stage you also have the right to ask us to stop using your personal data for direct marketing purposes.

                </p>

            </div>
        </div>

        <!-- footer -->
        <?php
            require_once('footer.php');
        ?>

    </body>
</html>