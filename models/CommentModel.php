<?php

class CommentModel{
    private $commentID;
    private $commentText;
    private $userID;
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
}

?>