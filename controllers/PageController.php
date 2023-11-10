<?php

require_once('services/DBManager.php');
require_once('views/PageView.php');
require_once('models/UserModel.php');
require_once('controllers/AuthController.php');

/**
 * PageController controls data flow.
 */
class PageController{
    /**
     * Draws index page views using data from the database.
     */
    public static function drawBlogIndex(){
        AuthController::ensureAuthenticated();
        $blogModels = DBManager::getMultiBlog();
        echo PageView::drawHeader('Blogs') . "\n";
        echo PageView::drawBanner() . "\n";
        echo PageView::drawBlogIndex($blogModels) . "\n";
        echo PageView::drawFooter() . "\n";
    }

    /**
     * Draws edit page views using data from the database.
     * 
     * @param int $blogID A blogs unique identifier.
     * @param bool $errorFlag Whether an error was passed. Default 'false'.
     * @param BlogModel $blogModel A blog. Default 'new BlogModel()'.
     */
    public static function drawEdit($blogID, $errorFlag = false, $blogModel = new BlogModel()){
        AuthController::ensureAuthenticated();
        $blogModelDB = DBManager::getSingleBlog($blogID);
        if(!$errorFlag){
            $blogModel = $blogModelDB;
        }
        echo PageView::drawHeader($blogModel->getTitle()) . "\n";
        echo PageView::drawBanner() . "\n";
        echo PageView::drawEdit($errorFlag, $blogModel) . "\n";
        echo PageView::drawFooter() . "\n";
    }

    /**
     * Draws single post views using data from the database.
     * 
     * @param int $blogID A blogs unique identifier.
     */
    public static function drawSinglePost($blogID){
        AuthController::ensureAuthenticated();
        $blogModel = DBManager::getSingleBlog($blogID);
        if($blogModel->getBlogID() == -1){
            self::drawNotFound();
        }
        else{
            echo PageView::drawHeader($blogModel->getTitle()) . "\n";
            echo PageView::drawBanner() . "\n";
            echo PageView::drawPost($blogModel) . "\n";
            echo PageView::drawFooter() . "\n";
        }
    }

    /**
     * Draws new post page views using data from the database.
     * 
     * @param bool $errorFlag Whether an error was passed. Default 'false'.
     * @param BlogModel $blogModel A blog. Default 'new BlogModel()'.
     */
    public static function drawNewPost($errorFlag = false, $blogModel = new BlogModel()){
        AuthController::ensureAuthenticated();
        echo PageView::drawHeader('New Post') . "\n";
        echo PageView::drawBanner() . "\n";
        echo PageView::drawNewPost($errorFlag, $blogModel) . "\n";
        echo PageView::drawFooter() . "\n";
    }

    /**
     * Draws opening database search page views using data from lichess API.
     */
    public static function drawLearn(){
        AuthController::ensureAuthenticated();
        echo PageView::drawHeader('Learn') . "\n";
        echo PageView::drawBanner() . "\n";
        echo PageView::drawLearn() . "\n";
        echo PageView::drawFooter() . "\n";
    }

    /**
     * Draws play page views.
     */
    public static function drawPlay(){
        AuthController::ensureAuthenticated();
        echo PageView::drawHeader('Play') . "\n";
        echo PageView::drawBanner() . "\n";
        echo PageView::drawPlay() . "\n";
        echo PageView::drawFooter() . "\n";
    }

    /**
     * Draws login page views.
     */
    public static function drawLogin(){
        echo PageView::drawHeader('Login') . "\n";
        echo PageView::drawBanner() . "\n";
        echo PageView::drawLogin() . "\n";
        echo PageView::drawFooter() . "\n";
    }

    /**
     * Draws login page views.
     */
    public static function drawContact(){
        AuthController::ensureAuthenticated();
        echo PageView::drawHeader('Contact Us') . "\n";
        echo PageView::drawBanner() . "\n";
        echo PageView::drawContact() . "\n";
        echo PageView::drawFooter() . "\n";
    }

}

?>