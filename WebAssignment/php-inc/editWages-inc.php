<?php

    include_once ('../php-class/employee.php');

    if(isset($_POST['edit'])){
        $employeeID = $_POST['employeeid'];
        $name = $_POST['name'];
        $ic = $_POST['ic'];
        $dateJoined = $_POST['dateJoined'];
        $position = $_POST['position'];
        $bankAcc = $_POST['bankAcc'];

        $employee = new Employee();
        $employee
        ->setEmployeeID($employeeID)
        ->setFullName($name)
        ->setIcNo($ic)
        ->setJoinDate($dateJoined)
        ->setPosition($position)
        ->setBankAccount($bankAcc);

        $salary = $_POST['salary'];
        $allowance  = $_POST['allowance'];
        $annualBonus = $_POST['annualBonus'];

        $wages2 = new Wages();
        $wages2
        ->setEmployee($employee)
        ->setTotalWages($salary)
        ->setAllowance($allowance)
        ->setAnnualBonus($annualBonus);

        if($wages2->updateWages()){
            header("Location: ../dashboard/viewWages.php?edit=success");
            exit();
        }else{
            header("Location: ../dashboard/viewWages.php?edit=failed");
            exit();
        }
    
    }
?>