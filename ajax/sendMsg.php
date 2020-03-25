<?php

    require_once('../connection/connection.php');

    session_start();

    date_default_timezone_set("Asia/Colombo");

?>
                        
    <?php

        $query2 = "SELECT * FROM `customer_message` WHERE `is_deleted` = 0 AND (`from` = '{$_SESSION['digimart_current_user_id']}' OR `to` = '{$_SESSION['digimart_current_user_id']}') ORDER BY `date_time` ASC";

        $result = $conn->query($query2);

        $prev = null;
        $next = null;

        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {


                $date_time = date_create($row['date_time']);
                $time = date_format($date_time,"H:m a");

                $next = date_format($date_time,"M d, Y");

                if($prev == null) {
                    if(date("M d, Y") == $next) {
                        //today print
    ?>

    <div class="row my-3 date">
        <div class="col-12 d-flex justify-content-center">
            <div class="rounded-pill border border-danger text-danger px-5">
                <p class="mt-3"><b>
                    <?php echo "Today"; ?>
                </b></p>

            </div>
        </div>
    </div>

    <?php
                    } else {
                        //not today
    ?>

    <div class="row my-3 date">
        <div class="col-12 d-flex justify-content-center">
            <div class="rounded-pill border border-danger text-danger px-5">
                <p class="mt-3"><b>
                    <?php echo $next; ?>
                </b></p>

            </div>
        </div>
    </div>

    <?php
                    }
                } else {
                    if($prev != $next) {
                        if(date("M d, Y") == $next) {
                        //today print
    ?>

    <div class="row my-3 date">
        <div class="col-12 d-flex justify-content-center">
            <div class="rounded-pill border border-danger text-danger px-5">
                <p class="mt-3"><b>
                    <?php echo "Today"; ?>
                </b></p>

            </div>
        </div>
    </div>

    <?php
                        } else {
                            //not today
    ?>

    <div class="row my-3 date">
        <div class="col-12 d-flex justify-content-center">
            <div class="rounded-pill border border-danger text-danger px-5">
                <p class="mt-3"><b>
                    <?php echo $next; ?>
                </b></p>

            </div>
        </div>
    </div>

    <?php
                        }
                    }
                }

                    $prev = $next;


                if($row['to'] == 'digimart'){

    ?>


    <div class="row my-2 send">
        <div class="col-12 d-flex pl-5 justify-content-end">
            <div class="pl-5 ml-5 float-right">
                <p class="mr-2 p-3 ml-5 rounded-lg border bg-danger text-light lead">
                    <?php echo $row['message']; ?>
                    <br>
                    <a class="d-flex flex-row-reverse"><small class="text-white"><?php echo $time; ?> <i class="fas fa-check <?php if($row['is_unread']==0) echo "text-primary"; ?>"></i></small></a>

                </p>

            </div>
        </div>
    </div>                        

    <?php

                } else {

    ?>

    <div class="row my-2 received">
        <div class="d-flex justify-content-start">
            <div class="incoming_msg_img">
                <img src="../image/msg_icon.jpg" alt="msg_icon">
            </div>
            <div class="pr-5 mr-5">
                <p class="ml-3 p-3 mr-5 rounded-lg border border-danger lead">
                    <?php echo $row['message']; ?>
                    <br>
                    <small class="text-muted d-flex flex-row-reverse"><?php echo $time; ?></small>
                </p>
            </div>
        </div>
    </div>

    <?php

                }
            }
        }
    ?>

    <div class="row">
        <div class="col-12 d-flex pl-5 justify-content-end">
            <div class="spinner-grow text-danger" id="chatSpinner" role="status">
                <span class="sr-only"></span>
            </div>
        </div>
    </div>