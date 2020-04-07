<html>
    
    <!-- row 1 | small top bar -->
    <div class="navbar <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-light"; ?> p-0 border-bottom">
        
        <div class="container d-flex flex-row justify-content-start">
            
            <div class="d-inline">
                <a class="btn btn-sm smallNavbarBtn text-danger" href="index.php"><i class="fas fa-home"></i> Home </a>
            </div>
            
            <div class="d-inline">
                <a class="btn btn-sm smallNavbarBtn text-danger" href="html/about.php"><i class="fas fa-info"></i> About </a>
            </div>
            
            <div class="d-inline">
                <a class="btn btn-sm smallNavbarBtn text-danger" href="html/contact.php"><i class="fas fa-phone"></i> Contact </a>
            </div>
            
            <!-- currency type -->
            <div class="d-inline dropdown show">
                <a class="btn btn-sm dropdown-toggle smallNavbarBtn text-danger" href="#" role="button" id="currencyDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php 
                        if(isset($_COOKIE['currency_type']) && ($_COOKIE['currency_type']=='usd')){
                            echo "<img src='image/us_flag.png' width='25px'> USD ";
                        } else{
                            echo "<img src='image/sl_flag.png' width='25px'> LKR ";
                        }
                    ?>
                </a>

                <div class="dropdown-menu <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-light"; ?>" aria-labelledby="currencyDropdown">
                    <h6 class="pl-4"><b>Currency</b></h6>
                    <a class="dropdown-item text-danger" href="index.php?currency=lkr"><img src="image/sl_flag.png" width="25px" alt="SL Flag"> LKR (Sri Lanka Rupee)</a>
                    <!--a class="dropdown-item text-danger" href="index.php?currency=usd"><img src="image/us_flag.png" width="25px" alt="US Flag"> USD (US Dollar)</a-->
                </div>
            </div>

            <!-- Account drop down -->
            <div class="d-inline dropdown show">
                <a class="btn btn-sm dropdown-toggle smallNavbarBtn text-danger" href="#" role="button" id="smallNavbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-user"></i> Account </a>

                <div class="dropdown-menu <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-light"; ?>" aria-labelledby="smallNavbarDropdown">
                    <p class="dropdown-item text-danger"><?php if(isset($_SESSION['digimart_current_user_email'])) echo "Welcome back, ".$_SESSION['digimart_current_user_first_name']; else echo "Welcome to DigiMart"; ?></p>
                    <div class="dropdown-divider text-danger"></div>
                    <p class="dropdown-item">
                        
                        <?php
                            if(!isset($_SESSION['digimart_current_user_email'])) {
                        ?>
                        <a class="btn btn-danger" href="html/join.php">Join</a>
                        <a class="btn btn-outline-danger" href="html/sign_in.php">Sign in</a>
                        <?php
                            }
                            else {
                        ?>
                        <a class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to logout?.');"  href="html/logout.php">Logout</a>
                        <?php
                            }
                        ?>
                        
                    </p>
                    
                    <?php
                        if(isset($_SESSION['digimart_current_user_email'])) {
                    ?>
                    <a class="dropdown-item text-danger" href="html/customer_account.php">My Account</a>
                    <a class="dropdown-item text-danger" href="html/customer_order.php">My Order</a>
                    <a class="dropdown-item text-danger" href="html/customer_message_center.php">Message Center</a>
                    <?php
                        }
                    ?>
                    
                </div>
            </div>
            
            <!-- Theme -->
            <div class="d-inline dropdown show">
                <a class="btn btn-sm dropdown-toggle smallNavbarBtn text-danger" href="#" role="button" id="themeDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-palette"></i> </a>

                <div class="dropdown-menu <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-light"; ?>" aria-labelledby="themeDropdown">
                    <a class="dropdown-item text-danger" href="index.php?theme=light">Light</a>
                    <a class="dropdown-item text-danger" href="index.php?theme=dark">Dark</a>
                </div>
            </div>
            
        </div>
        
    </div>
    
    <!-- row 2 | big bar -->
    <div class="shadow-sm <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; ?> p-3 mb-5 rounded p-0">
        <nav class="navbar p-0">
            <div class="col-md-3 col-sm-6 col-6 d-flex justify-content-center">
                <a class="navbar-brand" href="index.php"><img src="image/<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "logo_w.png"; else echo "logo_b.png"; ?>" width="120px" alt="Logo"></a>
            </div>
            
            <div class="navbar col-sm-6 col-6 d-flex justify-content-center d-none d-sm-block d-md-none">
                <a class="mr-3 bigNavbarBtn" href="html/customize.php" target="_blank"><img src="image/customize.png" width="40px" data-toggle="tooltip" data-placement="bottom" title="Customize PC"></a>
                
                <a class="mr-3 bigNavbarBtn" href="html/cart.php"><img src="image/cart.png" width="40px" data-toggle="tooltip" data-placement="bottom" title="Shopping Cart"></a>

                <a class="mr-3 bigNavbarBtn" href="html/quote.php"><img src="image/quote.png" width="40px" data-toggle="tooltip" data-placement="bottom" title="Quotation"></a>
            </div>

            <div class="col-md-6 col-sm-12 d-flex justify-content-center">
                <input type="search" placeholder="What're you searching for?" class="form-control search shadow-sm">
            </div>

            <div class="navbar col-md-3 d-none d-sm-none d-md-block d-lg-block">
                <div class=" d-flex justify-content-center">
                    <a class="mr-3 bigNavbarBtn" href="html/customize.php" target="_blank"><img src="image/customize.png" width="40px" data-toggle="tooltip" data-placement="bottom" title="Customize PC"></a>
                    
                    <a class="mr-3" href="html/cart.php"><img src="image/cart.png" class="bigNavIcon" width="40px" data-toggle="tooltip" data-placement="bottom" title="Shopping Cart"></a>

                    <a href="html/quotation.php"><img src="image/quote.png" class="bigNavIcon" width="40px" data-toggle="tooltip" data-placement="bottom" title="Quotation"></a>
                </div>
            </div>
        </nav>
    </div>
</html>