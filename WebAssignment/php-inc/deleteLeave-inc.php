<?php
    include ('../php-class/leave.php');

    if(isset($_GET['leaveAppID'])){
        $leaveAppID = $_GET['leaveAppID'];
        $leave = new Leave();
        $leave->setLeaveAppID($leaveAppID);
        
        if($leave->deleteLeave()){
            header("Location: ../dashboard/editLeave.php?delete=success");
            exit();
        }else{
            header("Location: ../dashboard/editLeave.php?delete=failed");
            exit();
        }
    }


?>