<?php

require_once('models/CommentModel.php');
require_once('services/ImageSize.php');
require_once('models/FileModel.php');

/**
 * BlogModel represents the data stored of in a blog.
 */
class BlogModel{
    private $blogID;
    private $title;
    private $content;
    private $date;
    private $userID;
    private CommentModel $commentModel;
    private $commentModels; // Array of comment models.
    private FileModel $fileModel;
    private $gameID;
    private $userName;
    private $fileNameOrg;
    private $fileNameMed;
    private $fileNameThumb;

    public function __construct($blogID = NULL, $title = '', $content = '', $userID = NULL){
        $this->blogID = $blogID;
        $this->title = $title;
        $this->content = $content;
        $this->userID = $userID;
    }

    public function setBlogData($blogID){
        $data = DBManager::getSingleBlog($blogID);
        $this->setData($data);
    }

    public function getAllBlogs($sortBy = NULL, $searchInput = NULL){
        if($sortBy == NULL){
            $sortBy = 'date_time';
        }
        $dataArray = DBManager::getMultiBlog($sortBy, $searchInput);
        $blogModelArray = [];

        foreach($dataArray as $data){
            $blogModel = new BlogModel();
            $blogModel->setData($data);
            $blogModelArray[] = $blogModel;
        }

        return $blogModelArray;
    }

    private function setData($data){
        if($data){
            $this->blogID = $data['blog_id'];
            $this->title = $data['title'];
            $this->content = $data['text_content'];
            $this->date = $data['date_time'];
            $this->userID = $data['user_id'];
            if(isset($data['user_name'])){
                $this->userName = $data['user_name'];
            }
            $this->fileModel = DBManager::getUploadedFile($data['blog_id']);
            $this->commentModels = CommentModel::getAllComments($data['blog_id']);
        }
        else{
            $this->blogID = -1;
        }
    }

    public function getComments(){
        return $this->commentModels;
    }

    // TODO: Move to file model.
    public function getFileName(Size $size){
        return $this->fileModel->getFileName($size);
    }

    /**
     * Gets the blog id.
     * 
     * @return int $this->blogID A unique identifier of the blog.
     */
    public function getUserName(){
        return $this->userName;
    }

    /**
     * Gets the blog id.
     * 
     * @return int $this->blogID A unique identifier of the blog.
     */
    public function getBlogID(){
        return $this->blogID;
    }

    /**
     * Gets the blog title.
     * 
     * @return string $this->title A string containing the blog title.
     */
    public function getTitle(){
        return $this->title;
    }

    /**
     * Gets the blog date.
     * 
     * @return date $this->date A timestamp of when the blog was created.
     */
    public function getDate(){
        return $this->date;
    }
    
    /**
     * Gets the blog content.
     * 
     * @return string $this->content A string containing the blog content.
     */
    public function getContent(){
        return $this->content;
    }

    /**
     * Sets the blog date.
     */
    public function setDate($date){
        $this->date = date("F d, Y, h:i a", strtotime($date));
    }

    /**
     * Gets the blog content.
     * 
     * @return string $this->content A string containing the blog content.
     */
    public function getUserID(){
        return $this->userID;
    }
}

?>