<html>
    <div class="navbar <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-light"; ?> p-0 border-bottom">
        
        <div class="container d-flex flex-row justify-content-between">
            <div>
                <div class="d-inline">
                    <a class="btn btn-sm smallNavbarBtn text-danger" href="../index.php"><i class="fas fa-home"></i> Home </a>
                </div>

                <div class="d-inline">
                    <a class="btn btn-sm smallNavbarBtn text-danger" href="about.php"><i class="fas fa-info"></i> About </a>
                </div>

                <div class="d-inline">
                    <a class="btn btn-sm smallNavbarBtn text-danger" href="contact.php"><i class="fas fa-phone"></i> Contact </a>
                </div>

                <div class="d-inline dropdown show">
                    <a class="btn btn-sm dropdown-toggle smallNavbarBtn text-danger" href="#" role="button" id="currencyDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php 
                            if(isset($_COOKIE['currency_type']) && ($_COOKIE['currency_type']=='usd')){
                                echo "<img src='../image/us_flag.png' width='25px'> USD ";
                            } else{
                                echo "<img src='../image/sl_flag.png' width='25px'> LKR ";
                            }
                        ?>
                    </a>

                    <div class="dropdown-menu <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-light"; ?>" aria-labelledby="currencyDropdown">
                        <h6 class="pl-4"><b>Currency</b></h6>
                        <a class="dropdown-item text-danger" href="../index.php?currency=lkr"><img src="../image/sl_flag.png" width="25px" alt="SL Flag"> LKR (Sri Lanka Rupee)</a>
                        <a class="dropdown-item text-danger" href="../index.php?currency=usd"><img src="../image/us_flag.png" width="25px" alt="US Flag"> USD (US Dollar)</a>
                    </div>
                </div>

                <div class="d-inline dropdown show">
                    <a class="btn btn-sm dropdown-toggle smallNavbarBtn text-danger" href="#" role="button" id="smallNavbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-user"></i> Account </a>

                    <div class="dropdown-menu <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-light"; ?>" aria-labelledby="smallNavbarDropdown">
                        <p class="dropdown-item text-danger">Welcome to DigiMart!</p>
                        <div class="dropdown-divider text-danger"></div>
                        <p class="dropdown-item">
                            <a class="btn btn-danger" href="../html/join.php">Join</a>
                            <a class="btn btn-outline-danger" href="../html/sign_in.php">Sign in</a>
                        </p>
                    </div>
                </div>

                <div class="d-inline dropdown show">
                    <a class="btn btn-sm dropdown-toggle smallNavbarBtn text-danger" href="#" role="button" id="themeDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-palette"></i> </a>

                    <div class="dropdown-menu <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-light"; ?>" aria-labelledby="themeDropdown">
                        <a class="dropdown-item text-danger" href="../index.php?theme=light">Light</a>
                        <a class="dropdown-item text-danger" href="../index.php?theme=dark">Dark</a>
                    </div>
                </div>
            </div>
            <div>
                <div class="d-inline">
                    <a class="btn btn-sm smallNavbarBtn text-danger" href="cart.php"><img src="../image/cart.png" width="25px" alt="Cart" data-toggle="tooltip" data-placement="bottom" title="Shopping Cart"></a>
                </div>

                <div class="d-inline">
                    <a class="btn btn-sm smallNavbarBtn text-danger" href="quotation.php"><img src="../image/quote.png" width="25px" alt="Quote" data-toggle="tooltip" data-placement="bottom" title="Quotation"></a>
                </div>
            </div>
        </div>
    </div>
</html>