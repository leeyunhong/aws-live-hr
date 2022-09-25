<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/contactUs.css">
    <title>Contact Us</title>
</head>

<body>
<header>
            <nav id="top-nav">
                <div class="img-cont">
                    <a href="home.php">
                        <img id="logo" src="./img/Logo - Purple.png" alt="HR_Logo">
                    </a>
                </div>

                <div class="menu">
                    <ul>
                        <li><a href="home.php" id="homeURL">Home</a></li>
                        <li><a href="aboutUs.php" id="aboutUsURL">About Us</a></li>
                        <li><a href="contactUs.php" id="contactURL">Contact Us</a></li>
                    </ul>

                </div>

                <?php
                    if(isset($_SESSION['email'])){                        
                ?>
                    <div class="logout">
                        <button href="window.location.href='dashboard/userProfile.php'" id="dashboard-btn">Dashboard</button>                  
                        <input type="button" value="Logout" id="logout-btn"
                        onClick="window.location.href='php-inc/logout-inc.php'">
                    </div>
                <?php     
                  }else{
                ?>
                    <div class="login-reg">                  
                        <input type="button" value="Login" id="login-btn">
                    </div>
                <?php        
                    }
                ?>
            </nav>

            <div class="login-Container" id="login-Cont">
                <div class="outer-box">
                    <div class="login-img">                      
                    </div>
                    <div class="login-content">      
                        <img src="img/close-button.png" alt="Close Button" class="close-btn" id="login-close-btn"> 
                        <img src="img/white-login.png" alt="Login Icon" class="user-img">
                        <form action="php-inc/login-inc.php" method="POST">       
                            <input type="email" name="email" id="loginID" placeholder="Email" required>
                            <input type="password" name="password" id="loginPassword" placeholder="Password" required>
                            <div class="btn-box">
                                <input type="submit"  name="submit"  value="Login" id="login">
                                <input type="button" onClick="window.location.href='forgetPass.php'" value="Forget Password" target="_blank">
                            </div>   
                        </form>
                        
                    </div>
                </div>          
            </div>
        </header>

    <div class="top-cont-mar90">
        <h1>Contact Us</h1>
        <hr>
        <div class="contact-cont">
            <div class="contact">
                <div class="tel">
                    <h2>Telephone</h2>
                    <li>

                        <a href="tel:+(6)03-41450123">
                            Tel: +(6)03-41450123
                        </a>
                    </li>
                </div>
                <div class="email">
                    <h2>Email</h2>
                    <li>
                        <a href="mailto:info@tarc.edu.my">
                            Email: info@tarc.edu.my
                        </a>
                    </li>
                </div>
                <div class="address">
                    <h2>Locate Us</h2>
                    <li>

                        <a
                            href="https://www.google.com.my/maps/place/Tunku+Abdul+Rahman+University+College/@3.2161697,101.7268275,17z/data=!3m1!4b1!4m5!3m4!1s0x31cc3843bfb6a031:0x2dc5e067aae3ab84!8m2!3d3.2161643!4d101.7290216">
                            Jalan Genting Kelang, Setapak,
                            53300 Kuala Lumpur,
                            P.O. Box 10979, 50932 Kuala Lumpur, Malaysia.
                        </a>
                    </li>
                </div>
            </div>

            <div class="contact-form">
                <h1>Drop Your Message</h1>
                <form action="#">
                    <input type="email" name="email" id="feedbackEmail" placeholder="Email">
                    <input type="text" name="subject" id="feedbackSubject" placeholder="Subject">
                    <textarea name="content" id="feedbackContent" cols="30" rows="10"
                        placeholder="Your Concerns"></textarea>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-nav">
            <h1>Navigate Yourself</h1>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>

        </div>
        <div class="social-media">
            <h1>Follow Us</h1>
            <ul>
                <li><a href="https://www.facebook.com" class="fa fa-facebook"></a></li>
                <span>
                    - Human, HR Management System
                </span>
                <li><a href="https://www.twitter.com" class="fa fa-twitter"></a></li>
                <span>
                    - @humanHRManagement
                </span>
                <li><a href="https://www.instagram.com" class="fa fa-instagram"></a></li>
                <span>
                    - #humanHRManagement
                </span>
            </ul>
        </div>
        <div class="contact-form">
            <h1>Feedback Us</h1>
            <form action="#">
                <input type="email" name="email" id="feedbackEmail" placeholder="Email">
                <input type="text" name="subject" id="feedbackSubject" placeholder="Subject">
                <textarea name="content" id="feedbackContent" cols="30" rows="10"
                    placeholder="Your Concerns"></textarea>
                <input type="submit" value="Submit">
            </form>
        </div>

    </footer>


    <script src="./js/work.js"></script>
</body>

</html>