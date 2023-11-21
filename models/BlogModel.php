<?php

/**
 * BlogModel represents the data stored of in a blog.
 */
class BlogModel{
    private $blogID;
    private $title;
    private $date;
    private $content;


    public function __construct($blogID = NULL, $title = '', $content = ''){
        $this->blogID = $blogID;
        $this->title = $title;
        $this->content = $content;
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
}

?>