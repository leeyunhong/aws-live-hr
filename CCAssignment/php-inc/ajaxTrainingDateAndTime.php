<?php
    include ('../php-class/dbcontroller.php');

    if(isset($_GET['departmentID'])){
        $db = new DBController();
        $departmentID = $_GET['departmentID'];
        $trainingID = $_GET['trainingID'];
        $query = "SELECT * FROM trainingclass WHERE departmentID = '$departmentID' EXCEPT SELECT * FROM trainingclass WHERE trainingID = '$trainingID'";

        $result = $db->runQuery($query);

        foreach($result as $trainingClass){
            $array[] = array(
                'startDate' => $trainingClass['startDate'],
                'endDate' => $trainingClass['endDate'],
                'startTime' => $trainingClass['startTime'],
                'endTime' => $trainingClass['endTime']
            );
        }

        echo json_encode($array);
    }

?>