<?php
    include_once ('dbcontroller.php');
    include_once ('employee.php');

    class Wages{
        private $wagesID, $employeeID, $basicWagesPerHour, $totalWages, $annualBonus, $allowance, $epfAmount , $employee;

        public function __construct(){
            $this->wagesID = '';
            $this->employeeID = '';
            $this->basicWagesPerHour = '';
            $this->annualBonus = '';
            $this->allowance = '';
            $this->epfAmount = '';
            $this->employee = new Employee();
        }

        public function setEmployee($employee){
            $this->employee = $employee;
            return $this;
        }

        public function setTotalWages($totalWages){
            $this->totalWages = $totalWages;
            return $this;
        }

        public function setWagesID($wagesID){
            $this->wagesID = $wagesID;
            return $this;
        }

        public function setEmployeeID($employeeID){
            $this->employeeID = $employeeID;
            return $this;
        }

        public function setBasicWagesPerHour($basicWagesPerHour){
            $this->basicWagesPerHour = $basicWagesPerHour;
            return $this;
        }   

        public function setAnnualBonus($annualBonus){
            $this->annualBonus = $annualBonus;
            return $this;
        }

        public function setAllowance($allowance){
            $this->allowance = $allowance;
            return $this;
        }   

        public function setEpfAmount($epfAmount){
            $this->epfAmount = $epfAmount;
            return $this;
        }

        public function selectQuery(){
            $db = new DBController();
            $sql = "SELECT * FROM wages WHERE employeeID = '$this->employeeID'";
            $result = $db->runQuery($sql);
            return $result;
        }

         //generate wages ID
        public function generateID(){
            $db = new DBController();
            //Will be descending order
            $sql = "SELECT * FROM wages ORDER BY wagesID DESC";
            $result = $db->runQuery($sql);
            $prefix = 'WAG';

            if(empty($result)){
                $prefix .= '001';
                return $prefix;
            }

            //Get the first ID 
            $lastID = $result[0]['wagesID'];
            //SubString to last part of ID
            $numberPart = substr($lastID, 3, 6);

            if((int)$numberPart < 9 ){
                $prefix .= '00' . ((int)$numberPart + 1);
            }else if ((int)$numberPart >= 9){
                $prefix .= '0' . ((int)$numberPart + 1);
            }

            return $prefix;
        }

        //Add new wages to database (for new employee)
        public function addNewWages(){
            $wagesPerHour = $this->calculateWagesPerHour();
            $calEpfAmount = $this->calEpfAmount();

            $db = new DBController();
            $sql = "INSERT INTO wages 
            (wagesID, employeeID, basicWagesPerHour, 
            annualBonus, allowance, epfAmount) 
            VALUES 
            ('$this->wagesID','$this->employeeID', '$wagesPerHour', '0', '400', '$calEpfAmount')";

            $result = $db->executeQuery($sql);

            if($result){
                return true;
            }else{
                return false;
            }
        }

         //IC, Salary, Bank Account, ContactNo
        private function checkIsNum($input){
            if(!is_numeric($input)){
                return false;
            }else{
                return true;
            }
        }

        public function updateWages(){
            $employeeID = $this->employee->getEmployeeID();
            $name = $this->employee->getFullName();
            $ic = $this->employee->getIcNo();
            $dateJoined = $this->employee->getJoinDate();
            $position = $this->employee->getPosition();
            $bankAcc = $this->employee->getBankAccount();

            if(!$this->checkIsNum($this->totalWages)){
                header('location: ../dashboard/viewWages.php?id='.$employeeID.'&name='.$name.'&icNo='.$ic.'&position='.$position.'&joinDate='.$dateJoined.'&bankAccount='.$bankAcc.'&salary=notNumber&allowance='.$this->allowance.'&annualBonus='.$this->annualBonus);
                exit();  
            }else if(!$this->checkIsNum($this->allowance)){
                header('location: ../dashboard/viewWages.php?id='.$employeeID.'&name='.$name.'&icNo='.$ic.'&position='.$position.'&joinDate='.$dateJoined.'&bankAccount='.$bankAcc.'&salary='.$this->totalWages.'&allowance=notNumber&annualBonus='.$this->annualBonus);
                exit();
            }else if(!$this->checkIsNum($this->annualBonus)){
                header('location: ../dashboard/viewWages.php?id='.$employeeID.'&name='.$name.'&icNo='.$ic.'&position='.$position.'&joinDate='.$dateJoined.'&bankAccount='.$bankAcc.'&salary='.$this->totalWages.'&allowance='.$this->allowance.'&annualBonus=notNumber');
                exit();
            }else{
                $wagesPerHour = $this->calculateWagesPerHour();
                $calEpfAmount = $this->calEpfAmount();

                $db = new DBController();
                $sql = "UPDATE wages SET 
                basicWagesPerHour = '$wagesPerHour', 
                annualBonus = '$this->annualBonus', 
                allowance = '$this->allowance', 
                epfAmount = '$calEpfAmount' 
                WHERE employeeID = '$employeeID'";

                $result = $db->executeQuery($sql);

                if($result){
                    return true;
                }else{
                    return false;
                }
            }        
        }

        public function calculateWagesPerHour(){
            $wagesPerHour = $this->totalWages / 24 / 8;
            return $wagesPerHour; 
        }

        public function calEpfAmount(){
            $epfAmount = $this->totalWages * 0.12;
            return $epfAmount;
        }
    }
?>
