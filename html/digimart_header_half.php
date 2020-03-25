<html>
    <div class="navbar <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-light"; ?> p-0 border-bottom">
        
        <div class="container d-flex flex-row justify-content-between">
            <div>

                <div class="d-inline dropdown show">
                    <a class="btn btn-sm dropdown-toggle smallNavbarBtn text-danger" href="#" role="button" id="themeDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-palette"></i> </a>

                    <div class="dropdown-menu <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-light"; ?>" aria-labelledby="themeDropdown">
                        <a class="dropdown-item text-danger" href="digimart_account.php?theme=light">Light</a>
                        <a class="dropdown-item text-danger" href="digimart_account.php?theme=dark">Dark</a>
                    </div>
                </div>
            </div>
            <div>
                <div class="d-inline">
                    <a class="btn btn-sm smallNavbarBtn text-danger" onclick="return confirm('Are you sure you want to logout?.');"  href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
</html>