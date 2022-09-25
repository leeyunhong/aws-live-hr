<?php
    session_start();

    if(isset($_GET['recoveryEmail'])){
        if($_GET['recoveryEmail'] == 'sent'){
           echo '<script>alert("Please Check Your Email!");</script>';
        }else{
           echo '<script>alert("Something Wrong, Please Contact HR Department!");</script>';
        }  
    }

    if(isset($_GET['changePass'])){
        if($_GET['changePass'] == 'success'){
           echo '<script>alert("Password Change Successfully!");</script>';
        }else{
           echo '<script>alert("Something Wrong, Please Contact HR Department!");</script>';
        }  
    }

    if(isset($_GET['password'])){
        if($_GET['password'] == 'invalid'){
           echo '<script>alert("Wrong Password!");</script>';
        }
    }

    if(isset($_GET['email'])){
        if($_GET['email'] == 'invalid'){
           echo '<script>alert("User Email Wrong!");</script>';
        }
    }
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

    <link rel="stylesheet" href="css/home.css">
    <title>Human - People Manage People</title>
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
                        <button onClick="window.location.href='dashboard/userProfile.php'" id="dashboard-btn">Dashboard</button>                  
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
                                <input type="submit" name="submit"  value="Login" id="login">
                                <input type="button" onClick="window.location.href='forgetPass.php'" value="Forget Password" target="_blank">
                            </div>   
                        </form>
                        
                    </div>
                </div>          
            </div>
        </header>
    <div class="top-cont-mar90">
        <div class="introduction">
            <div class="intro-text">
                <h2>Fast.Accurate.Integrated.</h2>
                <h1>Your First Choice of <br>HR Management System.</h1>
                <p>Our HR Management System Designed For The Industry Demand. <br>Managing Employee <strong>TO
                        BE</strong> Easy and Accurate.</p>
                <a href="#">Enroll Now</a>
            </div>
            <div class="intro-img">
                <img src="img/intro-image.png" alt="Intro Image">
            </div>
        </div>
    </div>

    <div class="app-desc">
        <div>
            <h1>Employee Management</h1>
            <p>Provide Add, Record, Find and View team members’ details, including name, phone number, email address,
                etc.</p>
        </div>
        <div>
            <img src="img/employee-management-removebg-preview.png" alt="Employee Management.png">
        </div>
        <div>
            <img src="img/attendance-removebg-preview.png" alt="Attendance.png">
        </div>
        <div>
            <h1>Attendance Clock In</h1>
            <p>Quickly record working hours and breaks comfortably at the office.</p>
        </div>
        <div>
            <h1>Recruit New Employee</h1>
            <p>Provide a platform for interviewee to drop their resume.</p>
        </div>
        <div>
            <img src="img/recruit-newbie-removebg-preview.png" alt="Recruitment.png">
        </div>
        <div>
            <img src="img/payroll-removebg-preview.png" alt="Payroll.png">
        </div>
        <div>
            <h1>Payroll Management</h1>
            <p>Calculate, Maintain and Summarize payroll for your employees.</p>
        </div>
    </div>

    <div class="testimonial-cont">
        <h1>Testimonial</h1>
        <p>Our Application Make Our Client Days~</p>

        <div class="testimonial">
            <div>
                <blockquote>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias placeat culpa ad corporis
                    iusto

                </blockquote>
                <img src="img/boy1-testi.jpg" alt="First Boy Testimonial">
                <h3>Co-Founder, Media Tech Co.</h3>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
            </div>
            <div>
                <blockquote>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias placeat culpa ad corporis
                    iusto

                </blockquote>
                <img src="img/girl-testi.jpg" alt="First Boy Testimonial">
                <h3>CEO, Boomerang Inc.</h3>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
            </div>
            <div>
                <blockquote>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias placeat culpa ad corporis
                    iusto

                </blockquote>
                <img src="img/boy2-testi.jpg" alt="First Boy Testimonial">
                <h3>Project Manager, SimTech Co.</h3>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
            </div>
        </div>

    </div>

    <footer>
        <div class="footer-nav">
            <h1>Navigate Yourself</h1>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="aboutUs.php">About Us</a></li>
                <li><a href="contactUs.php">Contact Us</a></li>
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