<?php

class CommentModel{
    private $commentID;
    private $commentText;
    private $userID;
    private $blogID;

    public function __construct($commentID = NULL, $commentText = '', $userID, $blogID){
        $this->commentID = $commentID;
        $this->commentText = $commentText;
        $this->userID = $userID;
        $this->blogID = $blogID;
    }
}

?>