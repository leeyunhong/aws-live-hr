<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link rel="stylesheet" href="css/forgetPass.css">
</head>

<body>
    <div class="forgetPass-Container" id="forgetPass-Cont">
        <a href="home.php">Home Page</a>
        <div class="outer-box">
            <div class="forgetPass-img">
                <div class="img-cont">
                    <h1>Password</h1>
                </div>
            </div>
            <div class="forgetPass-content">
                <h1>Recovery</h1>
                <form action="./php-inc/forgetPass-inc.php" method="POST">
                    <input type="email" name="email" id="forgetPassID" placeholder="Email" required value="<?php if((isset($_GET['email']) && $_GET['email'] != 'invalid'))
                        echo $_GET['email'];
                    ?>">

                    <?php
                    if(isset($_GET['email'])){
                        if($_GET['email'] == 'invalid'){
                            echo '<p class="error">Email Not Found</p>';
                        }
                    }
                    ?>

                    <!--Tooltip, Help Icon-->
                    <div class="tooltip right1">
                        <img src="img/information.png" alt="Info">
                        <div class="right">                           
                            <p>Key In The Email You Have Registered to HR</p>
                            <i></i>
                        </div>
                    </div>

                    
                    <input type="text" name="icNo" id="icNum" placeholder="Ic Number" required value="<?php if((isset($_GET['icNo']) && $_GET['icNo'] != 'invalid'))
                        echo $_GET['icNo'];
                    ?>">
                    <?php
                    
                    if(isset($_GET['icNo'])){
                        if($_GET['icNo'] == 'invalid'){
                            echo '<p class="error">Wrong Ic Number</p>';
                        }
                    }
                    ?>

                    <!--Tooltip, Help Icon-->
                    <div class="tooltip right2">
                        <img src="img/information.png" alt="Info">
                        <div class="right">                         
                            <p>Key In Your IC Number</p>
                            <i></i>
                        </div>
                    </div>

                    <input type="submit" name="submit" value="Get New Password" id="passRecov-btn">
                </form>
            </div>
        </div>
    </div>
</body>
</html>