<?php
    include ('../php-class/userClass.php');

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['currPass'];
        $icNo = $_POST['icNo'];
        $newPass = $_POST['newPass'];
        $confNewPass = $_POST['confNewPass'];

        $user = new User();

        $user
        ->setEmail($email)->setCurrPass($password)
        ->setIcNo($icNo)->setNewPass($newPass)
        ->setConfNewPass($confNewPass);

        if($user->changePassword()){
            session_start();
            if(isset($_SESSION['email'])){
                session_unset();
                session_destroy();
            }
            header("Location: ../home.php?changePass=success");
        }else{
            header("Location: ../home.php?changePass=failed");
        }
    }


?>