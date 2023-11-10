<?php

require_once('services/DBManager.php');
require_once('views/PageView.php');
require_once('controllers/AuthController.php');

/**
 * PageController controls data flow.
 */
class PageController{
    /**
     * Draws index page views using data from the database.
     */
    public static function drawBlogIndex(){
        $blogModels = DBManager::getMultiBlog();
        echo PageView::drawHeader('Blogs', AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawBanner(AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawBlogIndex($blogModels, AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawFooter(AuthController::ensureAuthenticated()) . "\n";
    }

    /**
     * Draws edit page views using data from the database.
     * 
     * @param int $blogID A blogs unique identifier.
     * @param bool $errorFlag Whether an error was passed. Default 'false'.
     * @param BlogModel $blogModel A blog. Default 'new BlogModel()'.
     */
    public static function drawEdit($blogID, $errorFlag = false, $blogModel = new BlogModel()){
        $blogModelDB = DBManager::getSingleBlog($blogID);
        if(!$errorFlag){
            $blogModel = $blogModelDB;
        }
        echo PageView::drawHeader($blogModel->getTitle(), AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawBanner(AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawEdit($errorFlag, $blogModel, AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawFooter(AuthController::ensureAuthenticated()) . "\n";
    }

    /**
     * Draws single post views using data from the database.
     * 
     * @param int $blogID A blogs unique identifier.
     */
    public static function drawSinglePost($blogID){
        $blogModel = DBManager::getSingleBlog($blogID);
        if($blogModel->getBlogID() == -1){
            self::drawNotFound();
        }
        else{
            echo PageView::drawHeader($blogModel->getTitle(), AuthController::ensureAuthenticated()) . "\n";
            echo PageView::drawBanner(AuthController::ensureAuthenticated()) . "\n";
            echo PageView::drawPost($blogModel, NULL, AuthController::ensureAuthenticated()) . "\n";
            echo PageView::drawFooter(AuthController::ensureAuthenticated()) . "\n";
        }
    }

    /**
     * Draws new post page views using data from the database.
     * 
     * @param bool $errorFlag Whether an error was passed. Default 'false'.
     * @param BlogModel $blogModel A blog. Default 'new BlogModel()'.
     */
    public static function drawNewPost($errorFlag = false, $blogModel = new BlogModel()){
        echo PageView::drawHeader('New Post', AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawBanner(AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawNewPost($errorFlag, $blogModel, AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawFooter(AuthController::ensureAuthenticated()) . "\n";
    }

    /**
     * Draws opening database search page views using data from lichess API.
     */
    public static function drawLearn(){
        echo PageView::drawHeader('Learn', AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawBanner(AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawLearn(AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawFooter(AuthController::ensureAuthenticated()) . "\n";
    }

    /**
     * Draws play page views.
     */
    public static function drawPlay(){
        echo PageView::drawHeader('Play', AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawBanner(AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawPlay(AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawFooter(AuthController::ensureAuthenticated()) . "\n";
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
        echo PageView::drawHeader('Contact Us', AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawBanner(AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawContact(AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawFooter(AuthController::ensureAuthenticated()) . "\n";
    }

    /**
     * Draws profile page views.
     */
    public static function drawProfile(){
        echo PageView::drawHeader('Profile', AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawBanner(AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawProfile(AuthController::getUser(), AuthController::ensureAuthenticated()) . "\n";
        echo PageView::drawFooter(AuthController::ensureAuthenticated()) . "\n";
    }

}

?>