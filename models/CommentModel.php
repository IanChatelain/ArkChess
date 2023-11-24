<?php

class CommentModel{
    private $commentID;
    private $commentText;
    private $userID;
    private $blogID;
    private $date;

    public function __construct($commentID = NULL, $commentText = '', $userID = NULL, $date = NULL){
        $this->commentID = $commentID;
        $this->commentText = $commentText;
        $this->userID = $userID;
        $this->blogID = $blogID;
        $this->date = $date;
    }

    public static function getText(){
        return $this->commentText;
    }

    public static function getUserID(){
        return $this->userID;
    }

    public static function getBlogID(){
        return $this->blogID;
    }
}

?>