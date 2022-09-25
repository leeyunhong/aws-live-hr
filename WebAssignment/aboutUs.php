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

    <link rel="stylesheet" href="css/aboutUs.css">
    <title>About Us</title>
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
                                <input type="submit" name="submit" value="Login" id="login">
                                <input type="button" onClick="window.location.href='forgetPass.php'" value="Forget Password" target="_blank">
                            </div>   
                        </form>
                        
                    </div>
                </div>          
            </div>
        </header>

    <div class="top-cont-mar90">
        <h1>About Us</h1>
        <hr>
        <div class="desc-cont">
            <div class="desc">
                
                <h2>Human - HR Management System</h2>
                <span> > </span>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis est omnis voluptatem eos earum reiciendis, tempora accusantium recusandae consequuntur, ullam odit? Temporibus numquam reprehenderit dignissimos. Et corrupti voluptas necessitatibus sint.
                    Commodi, cupiditate qui. Natus officiis sequi error maiores illo, ipsam nostrum iure. Rerum adipisci molestias reiciendis. Suscipit commodi consequatur repudiandae nemo fuga, natus accusamus quam iusto corrupti, culpa ipsam et!
                </p>
            </div>
            <div class="img">
                <!-- <img src="/img/undraw_People_re_8spw-removebg-preview.png" alt="People Illustration"> -->
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
                <textarea name="content" id="feedbackContent" cols="30" rows="10" placeholder="Your Concerns"></textarea>
                <input type="submit" value="Submit">
            </form>
        </div>

    </footer>


    <script src="./js/work.js"></script>
</body>

</html>