<?php
     session_start();
     if(!isset($_SESSION['employeeID'])){
         header ('Location: ../home.php?login=invalid');
     }

     if(isset($_GET['applyLeave'])){
        if($_GET['applyLeave'] == 'success'){
           echo '<script>alert("Leave Apply Successfully!");</script>';
        }else{
           echo '<script>alert("Leave Apply Failed!");</script>';
        }  
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Leave</title>
    <link rel="stylesheet" href="../css/applyLeave.css">
</head>

<body>
    <div class="container">
    <aside>
            <img src="../img/Logo - BnW.png" alt="Logo">
            <nav>
                <ul>
                    <li class="layer1Li">
                        <input type="checkbox" id="employee">
                        <label for="employee">Employee</label>
                        <ul class="employeeSub">
                            <li><a href="userProfile.php">View Profile</a></li>
                            <?php
                                if($_SESSION['departmentID'] == 'DEPT003'){
                                ?>
                                <li><a href="addEmployee.php">Add Employee</a></li>
                                <li><a href="employeeTable.php">Employee List</a></li>
                            <?php
                                 }
                            ?>
                            
                        </ul>
                    </li>
                    <li class="layer1Li">
                        <input type="checkbox" id="payroll">
                        <label for="payroll">Payroll</label>
                        <ul class="payrollSub">
                            <li><a href="viewWages.php">View Wages</a></li>
                        </ul>
                    </li>
                    <li class="layer1Li">
                        <input type="checkbox" id="application">
                        <label for="application">Leave Application</label>
                        <ul class="applicationSub">
                            <?php
                                if($_SESSION['departmentID'] == 'DEPT003'){
                                ?>
                                 <li><a href="viewLeave.php">View Application</a></li>
                            <?php
                                 }
                            ?>             
                            <li><a href="applyLeave.php">Apply Leave</a></li>
                            <li><a href="editLeave.php">Edit Leave</a></li>
                        </ul>
                    </li>
                    <li class="layer1Li">
                        <input type="checkbox" id="schedule">
                        <label for="schedule">Training</label>
                        <ul class="scheduleSub">
                            <?php
                                if($_SESSION['departmentID'] == 'DEPT003'){
                                ?>
                                 <li><a href="addTraining.php">Add Training</a></li>
                            <?php
                                 }
                            ?>                               
                            <li><a href="viewTraining.php">View Schedule</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>
        <div class="inner-cont">
            <div class="right-top-container">
                <div class="top">
                <?php
                        if(isset($_SESSION['fullName'])){
                            echo "<h3>Hi, <span>".$_SESSION['fullName']."</span></h3>";
                        }
                    ?>
                    <a href="../changePassword.php">Change Password</a>
                    <form action="../php-inc/logout-inc.php" method="get">
                        <input type="submit" name="logout" value="Logout">
                    </form>
                </div>
            </div>
            <div class="right-lower-cont">
                <div class="inner-cont">
                    <h1>Apply For <span>Leave</span></h1>
                    <form action="../php-inc/applyLeave-inc.php" method="post" enctype="multipart/form-data">
                        <div class="left-form">
                            <label for="employeeid">Employee ID</label>
                            <input type="text" name="employeeid" id="id" readonly
                            <?php
                                if(isset($_SESSION['employeeID'])){
                                    echo "value='".$_SESSION['employeeID']."'";
                                }
                            ?>
                            >
                            <label for="name">Employee Name</label>
                            <input type="text" name="name" id="name" readonly
                            <?php
                                if(isset($_SESSION['fullName'])){
                                    echo "value='".$_SESSION['fullName']."'";
                                }
                            ?>
                            >
                            <label for="date">Date</label>
                            <div class="input-date-range">
                                <input type="date" name="startdate" id="startdate" required onchange="checkDateValid();">
                                <span> - </span>
                                <input type="date" name="enddate" id="enddate" required onchange="checkDateValid();">
                            </div>
                            <label>New Evidence Upload</label>
                            <input type="file" name="file" accept="image/*,.pdf" required>
                            <label for="reason">Leave Reason (Less than 50 words)</label>
                            <textarea name="reason" id="reason" cols="30" rows="5" required></textarea>

                        </div>

                        <div class="btnBar">
                            <div class="btn">
                                <input type="submit" value="Submit" name="submitLeave" class="submit-btn" id="submit">
                                <input type="reset" value="Reset" name="reset" id="reset">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <footer>

    </footer>
    <script src="../js/editLeave.js">        

    </script>
</body>

</html>