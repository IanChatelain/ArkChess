<?php

/**
 * FileModel represents the data stored for a file.
 */
class FileModel{
    private $fileID;
    private $fileName;
    private $blogID;


    public function __construct($fileID = NULL, $fileName = NULL, $blogID = NULL){
        $this->fileID = $fileID;
        $this->fileName = $fileName;
        $this->blogID = $blogID;
    }

    private function setData($data){
        if($data){
            $this->fileID = $data['image_id'];
            $this->fileName = $data['image_name'];
            $this->blogID = $data['blog_id'];
            $this->date = $data['date_time'];
        }
    }

    public function getFileName(){
        return $this->fileName;
    }
    
    /**
     * 
     * 
     * @return 
     */
    public function getAllFiles($blogID){
        $dataArray = DBManager::getUploadedFile($blogID);
        $fileModelArray = [];

        foreach($dataArray as $data){
            $fileModel = new FileModel();
            $fileModel->setData($data);
            $fileModelArray[] = $blogModel;
        }

        return $fileModelArray;
    }

    public function saveFiles(){
        DBManager::insertUploadedFile(NULL, $this->fileName, $this->blogID);
    }
}

?>