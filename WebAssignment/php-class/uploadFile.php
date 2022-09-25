<?php

class File{
    private $fileName, $fileType, $fileSize, $fileTmpName, $fileError, $fileLocation, $empID;

    public function __construct(){
        $this->fileName = '';
        $this->fileType = '';
        $this->fileSize = '';
        $this->fileTmpName = '';
        $this->fileError = '';
        $this->fileLocation = '';
    }

    public function setEmpID($empID){
        $this->empID = $empID;
        return $this;
    }

    public function setFileName($fileName){
        $this->fileName = $fileName;
        return $this;
    }

    public function setFileType($fileType){
        $this->fileType = $fileType;
        return $this;
    }

    public function setFileTmpName($fileTmpName){
        $this->fileTmpName = $fileTmpName;
        return $this;
    }

    public function setFileError($fileError){
        $this->fileError = $fileError;
        return $this;
    }

    public function setFileSize($fileSize){
        $this->fileSize = $fileSize;
        return $this;
    }

    public function checkFileSize(){
        if($this->fileSize > 1000000){
            return false;
        }
        return true;
    }

    public function checkFileType(){
        if($this->fileType == 'application/pdf'){
            return true;
        }else if($this->fileType == 'image/jpeg' || $this->fileType == 'image/png' || $this->fileType == 'image/jpg'){
            return true;
        }
        
        return false;
    }

     //New file name with extension
     public function newFilePath(){
        $fileinfo=PATHINFO($this->fileName);
        $newFilename= $this->empID .'_'. time() .'.'. $fileinfo['extension'];
        return $newFilename;
    }

    public function fileNewLocation(){
        if(!$this->checkFileSize()){
            return false;
        }
        if(!$this->checkFileType()){
            return false;
        }

        $newFileName = $this->newFilePath();
        $this->fileLocation = '../uploads/'.$newFileName;
        if(!move_uploaded_file($this->fileTmpName, $this->fileLocation)){
            return false;
        }
        return $this->fileLocation;
    }

}
?>