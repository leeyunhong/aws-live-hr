<?php
    include ('../php-class/uploadFile.php');
    include ('../php-class/employee.php');
   
    if(isset($_POST['submit'])){
        $employeeID = $_POST['employeeid'];
        $department = $_POST['department'];
        $fullName = $_POST['name'];
        $icNo = $_POST['ic'];
        $contactNo = $_POST['contact'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $position = $_POST['position'];
        $joinDate = $_POST['dateJoined'];
        $salary = $_POST['salary'];
        $bankAcc = $_POST['bankAcc'];
        $manager = $_POST['manager'];
        $profilePic = $_FILES['profilePhoto'];

        $employee = new Employee();
        $file = new File();

        $file
        ->setEmpID($employeeID)
        ->setFileName($profilePic['name'])  
        ->setFileType($profilePic["type"])
        ->setFileSize($profilePic["size"])
        ->setFileTmpName($profilePic["tmp_name"])
        ->setFileError($profilePic["error"]);

        $validatedFile = $file->fileNewLocation();

        if(!$validatedFile){
            header('Location: ../dashboard/userProfile.php?file=error');
            exit();
        }

        $employee
        ->setEmployeeID($employeeID)
        ->setDepartmentID($department)
        ->setFullName($fullName)->setIcNo($icNo)
        ->setContactNo($contactNo)->setEmail($email)
        ->setAddress($address)->setPosition($position)
        ->setJoinDate($joinDate)->setBankAccount($bankAcc)
        ->setSalary($salary)->setManager($manager)
        ->setProfilePic($validatedFile);  

        if($employee->updateEmployee()){
            header('location: ../dashboard/userProfile.php?updateEmployee=true');
            exit();
        }else{
            header('location: ../dashboard/userProfile.php?addNewEmployee=false');
            exit();
        }
    }


?>