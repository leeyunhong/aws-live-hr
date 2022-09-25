<?php

    if(isset($_GET['leaveAppID'])){
        session_start();
        $_SESSION['leaveAppID'] = $_GET['leaveAppID'];
        
        $array[] = array(
            'status' => $_SESSION['leaveAppID']
        );

        echo json_encode($array);
    }
?>