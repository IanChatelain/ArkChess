<?php

class CommentModel{
    private $commentID;
    private $commentText;
    private $userID;
    private $userName;
    private $blogID;
    private $date;

    public function __construct($commentText = '', $userID = NULL, $blogID = NULL){
        $this->commentText = $commentText;
        $this->userID = $userID;
        $this->blogID = $blogID;
    }

    public function getText(){
        return $this->commentText;
    }

    public function getUserID(){
        return $this->userID;
    }

    public function getBlogID(){
        return $this->blogID;
    }

    public function getDate(){
        return $this->date;
    }

    public function getUserName(){
        return $this->userName;
    }

    private function setData($data){
        if($data){
            $this->commentID = $data['comment_id'];
            $this->date = $data['date_time'];
            $this->commentText = $data['comment_text'];
            $this->userID = $data['user_id'];
            $this->blogID = $data['blog_id'];
            $this->userName = $data['user_name'];
        }
    }

    public static function getAllComments($blogID){
        $dataArray = DBManager::getBlogComment($blogID);
        $commentModelArray = [];

        foreach($dataArray as $data){
            $commentModel = new CommentModel();
            $commentModel->setData($data);
            $commentModelArray[] = $commentModel;
        }

        return $commentModelArray;
    }
}

?>