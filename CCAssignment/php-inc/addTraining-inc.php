<?php
    include ('../php-class/training.php');

    if(isset($_POST['addTraining'])){
        $trainingTitle = $_POST['trainingTitle'];
        $description = $_POST['description'];
        $department = $_POST['department'];
        $trainer = $_POST['trainer'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $venue = $_POST['venue'];

        $training = new Training();

        $training
        ->setTrainingID($training->generateID())
        ->setDepartmentID($department)
        ->setTitle($trainingTitle)
        ->setDescription($description)
        ->setTrainer($trainer)
        ->setStartDate($startDate)
        ->setEndDate($endDate)
        ->setStartTime($startTime)
        ->setEndTime($endTime)
        ->setVenue($venue);
        
        if($training->addTraining()){
            header("Location: ../dashboard/addTraining.php?training=addedSuccess");
            exit();
        }else{
            header("Location: ../dashboard/addTraining.php?training=addedFailed");
            exit();
        }
    }

?>