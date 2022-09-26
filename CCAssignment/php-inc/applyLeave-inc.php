<?php
    include ('../php-class/uploadFile.php');
    include ('../php-class/leave.php');


    if(isset($_POST['submitLeave'])){
        $evidence = new File();
        $file = $_FILES['file'];

        $evidence
        ->setEmpID($_POST['employeeid'])
        ->setFileName( $file['name'])  
        ->setFileType( $file["type"])
        ->setFileSize( $file["size"])
        ->setFileTmpName( $file["tmp_name"])
        ->setFileError( $file["error"]);

        $validatedFile = $evidence->fileNewLocation();
        
        if(!$validatedFile){
            header('Location: ../dashboard/applyLeave.php?file=error');
            exit();
        }

        $leave = new Leave();

        $leave
        ->setLeaveAppID($leave->generateID())
        ->setEmployeeID($_POST['employeeid'])
        ->setApplyDate(date('Y-m-d'))
        ->setStartDate($_POST['startdate'])
        ->setEndDate($_POST['enddate'])
        ->setLeaveReason($_POST['reason'])
        ->setSupportDocument($validatedFile)
        ->setApplicationStatus('Pending');

        if($leave->applyNewLeave()){
            header("Location: ../dashboard/applyLeave.php?applyLeave=success");
            exit();
        }else{
            header("Location: ../dashboard/applyLeave.php?applyLeave=failed");
            exit();
        }
    }

?>