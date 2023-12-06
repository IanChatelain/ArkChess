<?php

/**
 * FileModel represents the data stored for a file.
 */
class FileModel{
    private $fileID;
    private $fileNameOrg;
    private $fileNameMed;
    private $fileNameThumb;
    private $blogID;


    public function __construct($fileID = NULL, $fileNameOrg = NULL, $fileNameMed = NULL, $fileNameThumb = NULL, $blogID = NULL){
        $this->fileID = $fileID;
        $this->fileNameOrg = $fileNameOrg;
        $this->fileNameMed = $fileNameMed;
        $this->fileNameThumb = $fileNameThumb;
        $this->blogID = $blogID;
    }

    private function setData($data){
        if($data){
            $this->fileID = $data['image_id'];
            $this->fileName = $data['image_name'];
            $this->blogID = $data['blog_id'];
        }
    }

    public function getFileName(Size $size){
        switch($size){
            case Size::ORIGINAL:
                return $this->fileNameOrg;
                break;
            case Size::MEDIUM:
                return $this->fileNameMed;
                break;
            case Size::THUMBNAIL:
                return $this->fileNameThumb;
                break;
        }
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
        DBManager::insertUploadedFile(NULL, $this->fileNameOrg, $this->fileNameMed, $this->fileNameThumb, $this->blogID);
    }
}

?>