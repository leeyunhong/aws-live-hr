<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/changePass.css">
</head>

<body>
    <?php
        $getUrl = getURLIntoArray();               
          
        function getURLIntoArray(){
            $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];         
            $intoArray = parse_url($url, PHP_URL_QUERY);
            parse_str($intoArray, $arr);
            return $arr;
        }
        
    ?>
    
    <div class="changePass-Container" id="changePass-Cont">
    
        <a href="home.php">Home Page</a>
        
        <div class="outer-box">
            <div class="changePass-img">
                <div class="img-cont">
                    <h1>Change</h1>
                </div>
            </div>
            <div class="changePass-content">
                <h1>Password</h1>
                <?php
                        
                        if(isset($getUrl['passwordRecovery']) && (strlen($getUrl['passwordRecovery']) > 12)){    
                            $recoveryString = $getUrl['passwordRecovery']; 
                 ?> 
                        <form action="./php-inc/chgPassRecover-inc.php?passwordRecovery=<?php echo $recoveryString ?>" method="POST" id="changePass-Form">
 
                 <?php  }else{ ?>
                        <form action="./php-inc/changePass-inc.php" method="POST" id="changePass-Form">
                <?php
                        }
                ?>        
                    <input type="email" name="email" id="changePassEmail" placeholder="Email" required value="<?php if((isset($_GET['email']) && $_GET['email'] != 'invalid'))
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

                    <?php
                        if(!isset($_GET['passwordRecovery'])){               
                    ?>
                    <input type="password" name="currPass" id="currPass" placeholder="Current Password" required maxlength="12">
                    <?php
                        }
                    ?>

                    <?php
                    if(isset($_GET['password'])){
                        if($_GET['password'] == 'invalid'){
                            echo '<p class="error">Wrong Password</p>';
                        }
                    }
                    ?>

                    <input type="password" name="newPass" id="newPass" placeholder="New Password" required maxlength="12">

                    <!--Tooltip, Help Icon-->
                    <div class="tooltip right3">
                        <img src="img/information.png" alt="Info">
                        <div class="right">
                            <p>Password Length more than 8 <br>
                                Include Alphabet, Number and Special Character
                            </p>
                            <i></i>
                        </div>
                    </div>

                    <input type="password" name="confNewPass" id="confPass" placeholder="Confirm New Password" onkeyup='checkMatchPassword();' required maxlength="12">

                    <input type="submit" name="submit" value="Change Password" id="changePass-btn">

                </form>             

            </div>
        </div>
    </div>
</body>

<script>
    notFoundCurrPwdInput();

    function checkMatchPassword(){
        const newPass = document.getElementById('newPass').value;
        const confPass = document.getElementById('confPass').value;
        const getErrorP = document.getElementById('errorPw');
        const getForm = document.getElementById('changePass-Form');
        const submitBtn = document.getElementById('changePass-btn');

        if(newPass != confPass){
            if(!getErrorP){
                document.getElementById('confPass').style.borderColor = 'red';

                pElement = document.createElement('p');               
                pElement.setAttribute('id', 'errorPw');
                pElement.innerHTML = 'New Password Not Match';
                document.getElementById('confPass').after(pElement);

                submitBtn.disabled = true;
                submitBtn.style.backgroundColor = "#b6b8ba";
                submitBtn.style.color = "#5e19e7";
            }
        }else if(newPass == confPass){
            if(!getErrorP){
                return;
            }
            getForm.removeChild(getErrorP);
            submitBtn.disabled = false;
            submitBtn.removeAttribute('style', '');
        }
    }

    function notFoundCurrPwdInput(){
        const email = document.getElementById('changePassEmail');
        const icNum = document.getElementById('icNum');
        const currPass = document.getElementById('currPass');

        if(!currPass){
            email.setAttribute('readonly','');
            email.style.backgroundColor = "#cacccf";
            icNum.setAttribute('readonly','');
            icNum.style.backgroundColor = "#cacccf";
        }else{
            email.disabled = false;
            icNum.disabled = false;
        }     
    }
</script>

</html>