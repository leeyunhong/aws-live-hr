<?php
    include ('../php-class/userClass.php');

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new User();

        $user->setEmail($email)->setCurrPass($password);

        if($user->loginValidation()){
            header("Location: ../home.php?login=success");
        }else{
            header("Location: ../home.php?login=failed");
        }
    }


?>