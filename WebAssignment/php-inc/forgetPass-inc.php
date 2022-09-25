<?php

    include ('../php-class/userClass.php');

    if(isset($_POST['submit'])){

        $email = $_POST['email'];
        $icNo = $_POST['icNo'];
        
        $user = new User();

        $user
        ->setEmail($email)
        ->setIcNo($icNo);

        if($user->sendRecoveryEmail()){
            if(isset($_SESSION['email'])){
                session_start();
                session_unset();
                session_destroy();
            }
            header("Location: ../home.php?recoveryEmail=sent");
        }else{
            header("Location: ../home.php?recoveryEmail=failed");
        }
    }

?>
