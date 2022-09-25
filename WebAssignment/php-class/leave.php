<?php
    include_once ('dbcontroller.php');
 //   include_once ('attendance.php');

    class Leave{
        private $leaveAppID, $employeeID, $applyDate, $startDate, $endDate, $leaveReason, $supportDocument, $applicationStatus;

        public function __construct(){
            $this->leaveAppID = '';
            $this->employeeID = '';
            $this->applyDate = '';
            $this->startDate = '';
            $this->endDate = '';
            $this->leaveReason = '';
            $this->supportDocument = '';
            $this->applicationStatus = '';
        }

        public function setLeaveAppID($leaveAppID){
            $this->leaveAppID = $leaveAppID;
            return $this;
        }

        public function setEmployeeID($employeeID){
            $this->employeeID = $employeeID;
            return $this;
        }

        public function setApplyDate($applyDate){
            $this->applyDate = $applyDate;
            return $this;
        }

        public function setStartDate($startDate){
            $this->startDate = $startDate;
            return $this;
        }

        public function setEndDate($endDate){
            $this->endDate = $endDate;
            return $this;
        }

        public function setLeaveReason($leaveReason){
            $this->leaveReason = $leaveReason;
            return $this;
        }

        public function setSupportDocument($supportDocument){
            $this->supportDocument = $supportDocument;
            return $this;
        }

        public function setApplicationStatus($applicationStatus){
            $this->applicationStatus = $applicationStatus;
            return $this;
        }

        //generate Leave ID
        public function generateID(){
            $db = new DBController();
            //Will be descending order
            $sql = "SELECT * FROM leaveapplication ORDER BY leaveAppID DESC";
            $result = $db->runQuery($sql);
            $prefix = 'LEV';

            if(empty($result)){
                $prefix .= '001';
                return $prefix;
            }

            //Get the first ID 
            $lastID = $result[0]['leaveAppID'];
            //SubString to last part of ID
            $numberPart = substr($lastID, 3, 6);
            
            if((int)$numberPart < 9 ){
                $prefix .= '00' . ((int)$numberPart + 1);
            }else if ((int)$numberPart >= 9){
                $prefix .= '0' . ((int)$numberPart + 1);
            }

            return $prefix;
        }

        public function selectQuery(){
            $db = new DBController();
            $sql = "SELECT * FROM leaveapplication WHERE employeeID = '$this->employeeID'";
            $result = $db->runQuery($sql);
            return $result;
        }

        public function applyNewLeave(){
            $db_handle = new DBController();

            $query = "INSERT INTO leaveapplication 
            (leaveAppID, employeeID, applyDate, startDate, endDate, leaveReason, supportDocument, applicationStatus) 
            VALUES 
            ('$this->leaveAppID','$this->employeeID', '$this->applyDate', '$this->startDate', '$this->endDate', '$this->leaveReason', '$this->supportDocument', '$this->applicationStatus')";

            $result = $db_handle->executeQuery($query);
            return $result;
        }

        public function updateLeave(){
            $db_handle = new DBController();
            $checkStatus = $this->selectQuery();

            foreach($checkStatus as $status){
                if($status['leaveAppID'] == $this->leaveAppID && $status['applicationStatus'] != 'Pending'){
                    return false;
                }
            }

            $query = "UPDATE leaveapplication SET 
            startDate = '$this->startDate', 
            endDate = '$this->endDate', 
            leaveReason = '$this->leaveReason', 
            supportDocument = '$this->supportDocument' 
            WHERE leaveAppID = '$this->leaveAppID'";

            $result = $db_handle->executeQuery($query);
            return $result;
        }

        public function deleteLeave(){
            $db_handle = new DBController();

            $query = "DELETE FROM leaveapplication WHERE leaveAppID = '$this->leaveAppID'";

            $result = $db_handle->executeQuery($query);
            return $result;
        }

        public function updateLeaveStatus($action, $employeeID){
            $db_handle = new DBController();

            $query = "UPDATE leaveapplication SET 
            applicationStatus = '$action' 
            WHERE leaveAppID = '$this->leaveAppID'";
            $result = $db_handle->executeQuery($query);

            if($result){                         
                return $this->sendLeaveStatusEmail($action, $employeeID);
            }else{
                return false;
            }
        }

        public function sendLeaveStatusEmail($action, $employeeID){
                $db_handle = new DBController();
                $employee = $db_handle->runQuery("SELECT * FROM employee WHERE employeeID = '$employeeID'");

                $toUpperAction = strtoupper($action);
                $email = $employee[0]['email'];
                $fullName = $employee[0]['fullName'];
    
                //Edit Leave Link
                $url = "http://localhost:1080/WebAssignment/dashboard/editLeave.php";
    
                //Send email
                $to = $email;
                $subject = "Leave Application Status";
                $txt = "Hi, $fullName.\n\nYour leave application with ID $this->leaveAppID is already $toUpperAction.\n\nKindly check via this link: $url\n\nThank You.";
                $headers = "From: noreply@human.com";
    
                $sendEmail = mail($to,$subject,$txt,$headers);
    
                if($sendEmail){
                    return true;               
                }else{
                    return false;
                }         
        }
        
    }
?>