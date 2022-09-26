<?php
    session_start();

    if(isset($_SESSION)){
        

        $array[] = array(
            'employeeID' => $_SESSION['employeeID'],
            'departmentID' => $_SESSION['departmentID'],
            'fullName' => $_SESSION['fullName'],
            'email' => $_SESSION['email']
        );

        echo json_encode($array);
    }
?>