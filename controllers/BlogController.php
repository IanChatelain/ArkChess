<?php

require_once('views/BlogView.php');
require_once('views/CommonView.php');
require_once('models/BlogModel.php');

/**
 * BlogController controls blog data flow.
 */
class BlogController{
    /**
     * Draws single post views using data from the database.
     * 
     * @param int $blogID A blogs unique identifier.
     */
    public static function handleSingleBlog($blogID){
        // Can use auth functions here.
        $blogID = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);

        $singleBlog = new BlogModel();
        $singleBlog->setBlogData($blogID);

        if($singleBlog->getBlogID() == -1){
            self::drawNotFound();
        }
        else{
            echo CommonView::drawHeader($singleBlog->getTitle()) . "\n";
            echo BlogView::drawSingleBlog($singleBlog, NULL) . "\n";
            echo CommonView::drawFooter() . "\n";
        }
    }

    /**
     * Draws index page views using data from the database.
     */
    public static function displayAllBlogs(){
        $blogModel = new BlogModel();
        $blogModelArray = $blogModel->getAllBlogs();

        echo CommonView::drawHeader('Blogs') . "\n";
        echo BlogView::drawBlogSearch($blogModelArray) . "\n";
        echo CommonView::drawFooter() . "\n";
    }
}

?>