<?php
  include ('../php-class/training.php');

  if(isset($_GET['departmentID'])){
    $db_control = new DBController();

    $trainingResult = "";
    $departmentResult = "";

    //For reset
    if($_GET['departmentID'] == 'all'){
        $trainingResult = $db_control->runQuery("SELECT * FROM trainingclass");
        $departmentResult = $db_control->runQuery("SELECT * FROM department");
    }else{
        //For specific department
        $departmentResult = $db_control->runQuery("SELECT * FROM department WHERE departmentID = '$_GET[departmentID]'");
        $trainingResult = $db_control->runQuery("SELECT * FROM trainingclass WHERE departmentID = '$_GET[departmentID]'");
    }

    

    if(!empty($trainingResult) && !empty($departmentResult)){
        //Store in an array with assign key
        $array = array();

        foreach($trainingResult as $row){
            $trainingID = $row['trainingID'];
            $departmentID = $row['departmentID'];

            foreach($departmentResult as $row2){
                if($row['departmentID'] == $row2['departmentID']){
                    $departmentName = $row2['departmentName'];
                }
            }

            $title = $row['title'];
            $description = $row['description'];
            $trainer = $row['trainer'];
            $startDate = $row['startDate'];
            $endDate = $row['endDate'];
            $startTime = $row['startTime'];
            $endTime = $row['endTime'];
            $venue = $row['venue'];

            $array[] = array(
                "trainingID" => $trainingID,
                "departmentID" => $departmentID,
                "departmentName" => $departmentName,
                "title" => $title,
                "description" => $description,
                "trainer" => $trainer,
                "startDate" => $startDate,
                "endDate" => $endDate,
                "startTime" => $startTime,
                "endTime" => $endTime,
                "venue" => $venue
            );           
        }

        echo json_encode($array);

    }else{
        $array[] = array(
            "trainingID" => "",       
        ); 

        echo json_encode($array);
    }

  }
?>