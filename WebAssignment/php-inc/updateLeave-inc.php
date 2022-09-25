<?php
    include ('../php-class/leave.php');
    include ('../php-class/uploadFile.php');
    session_start();

    if(isset($_SESSION['leaveAppID']) && isset($_POST['employeeid'])){
        $leaveAppID = $_SESSION['leaveAppID'];
        $leaveReason = $_POST['reason'];
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $file = $_FILES['file'];

        $evidence = new File();
        $evidence
        ->setEmpID($_POST['employeeid'])
        ->setFileName($file['name'])  
        ->setFileType($file["type"])
        ->setFileSize($file["size"])
        ->setFileTmpName($file["tmp_name"])
        ->setFileError($file["error"]);

        $validatedFile = $evidence->fileNewLocation();
        
        if(!$validatedFile){
            header('Location: ../dashboard/editLeave.php?file=error&leaveReason='.$leaveReason.'&enddate='.$enddate.'&startdate='.$startdate);
            exit();
        }

        $leave = new Leave();
        $leave->setLeaveAppID($leaveAppID)
        ->setLeaveReason($leaveReason)
        ->setStartDate($startdate)
        ->setEndDate($enddate)
        ->setSupportDocument($validatedFile);
        
        if($leave->updateLeave()){
            unset($_SESSION['leaveAppID']);
            header("Location: ../dashboard/editLeave.php?status=updateSuccess");
            exit();
        }else{
            unset($_SESSION['leaveAppID']);
            header("Location: ../dashboard/editLeave.php?status=updateFailed");
            exit();
        }
    }


?>