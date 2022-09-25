<?php
    include ('../php-class/dbcontroller.php');
     session_start();
     if(!isset($_SESSION['employeeID'])){
         header ('Location: ../home.php?login=invalid');
     }
     if($_SESSION['departmentID'] != 'DEPT003'){
        header ('Location: ../dashboard/userProfile.php?authorize=0');
     }

     $trainingResult = "";

     if((isset($_GET['trainingID']) && (isset($_GET['departmentID'])))){
         $trainingID = $_GET['trainingID'];
         $departmentID = $_GET['departmentID'];

        $db = new DBController();
        $sql = "SELECT * FROM trainingclass WHERE trainingID = '$trainingID'";
        $trainingResult = $db->runQuery($sql);
     }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Training</title>
    <link rel="stylesheet" href="../css/addTraining.css">
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
                    <h1>Edit <span>Training</span></h1>
                    <form action="../php-inc/editTraining-inc.php" method="post">
                        <div class="left-form">
                            <label for="trainingID">Training ID</label>
                            <input readonly type="text" name="trainingID" id="trainingID" required
                            value="<?php echo $trainingResult[0]['trainingID'];?>">
                            <input type="hidden" name="departmentID" value="<?php echo $trainingResult[0]['departmentID'];?>">

                            <label for="trainingTitle">Training Title</label>
                            <input type="text" name="trainingTitle" id="trainingTitle" required
                            value="<?php echo $trainingResult[0]['title'];?>">

                            <label for="desription">Description</label>
                            <textarea name="description" id="description" cols="30" rows="5" required><?php echo $trainingResult[0]['description'];?></textarea>
                            
                            <label for="department">Department</label>
                            <select name="department" id="department" disabled>
                            <?php
                                $db_handle = new DBController();
                                $query = "SELECT * FROM department";
                                $results = $db_handle->runQuery($query);

                                for($i = 0; $i < count($results); $i++) {
                                    if($results[$i]['departmentID'] == $trainingResult[0]['departmentID']){
                                        echo "<option value='".$results[$i]['departmentID']."' selected>".$results[$i]['departmentName']."</option>";
                                    }else{
                                        echo "<option value='".$results[$i]['departmentID']."'>".$results[$i]['departmentName']."</option>";
                                    }
                                }
                             ?>
                            </select>
                            <p class='error'>Department is not allowed to change</p>
                            <label for="venue">Venue</label>
                            <input type="text" name="venue" id="venue" required
                            value="<?php echo $trainingResult[0]['venue'];?>">
                        </div>
                        <div class="right-form">
                            <label for="trainer">Trainer</label>
                            <input type="text" name="trainer" id="trainer" required
                            value="<?php echo $trainingResult[0]['trainer'];?>">
                            <label for="startDate">Start Date</label>
                            <input type="date" name="startDate" id="startDate" required
                            value="<?php echo $trainingResult[0]['startDate'];?>" onchange="checkDateValid()">
                            <label for="endDate">End Date</label>
                            <input type="date" name="endDate" id="endDate" required
                            value="<?php echo $trainingResult[0]['endDate'];?>" onchange="checkDateValid()">
                            <label for="startTime">Start Time</label>
                            <input type="time" name="startTime" id="startTime" required
                            value="<?php echo $trainingResult[0]['startTime'];?>" onchange="checkTimeValid()">
                            <label for="endTime">End Time</label>
                            <input type="time" name="endTime" id="endTime" required
                            value="<?php echo $trainingResult[0]['endTime'];?>" onchange="checkTimeValid()">
                        </div>
                        <div class="btnBar">
                            <div class="btn">
                                <input type="submit" value="Edit" name="addEmp" class="submit-btn" id="submit">                               
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <footer>

    </footer>
    <script>
         setMinimumDate();

function setMinimumDate() {
    let date = new Date().toISOString().slice(0, 10);

    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');

    startDateInput.setAttribute('min', date);
    endDateInput.setAttribute('min', date);
}

function checkDateValid() {
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');

    if (!startDateInput.value || !endDateInput.value) {
        return;
    }

    if (startDateInput.value > endDateInput.value) {
        alert("The second date must be larger than the first date");
        endDateInput.value = "";
        return;
    }
    return;
}

function checkTimeValid() {
    const startTimeInput = document.getElementById('startTime');
    const endTimeInput = document.getElementById('endTime');

    if (!startTimeInput.value || !endTimeInput.value) {
        return;
    }

    if (startTimeInput.value > endTimeInput.value) {
        alert("The second time must be larger than the first time");
        endTimeInput.value = "";
        return;
    }
    return;
}

document.querySelector('#description').addEventListener("input", function (e) {
    countWords(e.target);
});

function countWords(textArea) {
    //console.log(textArea)
    let text = textArea.value;

    let numWords = 0;
    let countChar = 0;
    let currentCharacter = "";

    for (let i = 0; i < text.length; i++) {
        currentCharacter = text[i];
        countChar++;

        if (currentCharacter == " ") {
            numWords += 1;
        }
    }

    // Add 1 to make the count equal to the number of words
    numWords += 1;

    const errorMsg = document.querySelector(".error");
    const submitBtn = document.querySelector(".submit-btn");

    if (numWords >= 20 && !errorMsg) { //If error message not found
        //Set the attribute to become disabled to type
        textArea.setAttribute("maxlength", countChar);

        //Create a new error message
        const createP = document.createElement("p");
        createP.classList.add("error");
        createP.innerHTML = "You have exceeded the maximum number of words";
        document.getElementById("description").after(createP);

        //Set the button to become disabled
        submitBtn.setAttribute("disabled", "disabled");
        submitBtn.style.backgroundColor = "#ccc";

    } else if (numWords <= 50 && errorMsg) {
        //remove the error message                           
        errorMsg.remove();
        textArea.removeAttribute("maxlength");
        submitBtn.removeAttribute("disabled");
        submitBtn.removeAttribute("style");
    }
}

document.getElementById("endDate").addEventListener('change', function () {
    fetchDateAndTime();
});

async function fetchDateAndTime(){
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const departmentID = document.getElementById('department').value;
    const trainingID = document.getElementById('trainingID').value;

   let dateResult = fetch(`../php-inc/ajaxTrainingDateAndTime.php?departmentID=${departmentID}&trainingID=${trainingID}`);

    let date = await dateResult.then(response => response.json());

    let newStartDate = new Date(startDate);
    let newEndDate = new Date(endDate);

    if (Object.keys(date).length != 0){
        for (let i = 0; i < Object.keys(date).length; i++) {           
            let dbStartDate = new Date(date[i].startDate);
            let dbEndDate = new Date(date[i].endDate);

            if((newStartDate >= dbStartDate && newStartDate <= dbEndDate) || (newEndDate >= dbStartDate && newEndDate <= dbEndDate)){
                alert("The time slot has already been taken");
                document.getElementById('startDate').value = "";
                document.getElementById('endDate').value = "";
                return;
            }             
        }
    }else{
        return;
    }
}

        

        
    </script>
</body>

</html>