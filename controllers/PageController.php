<?php

require_once('services/DBManager.php');
require_once('controllers/AuthController.php');
require_once('views/BlogView.php');
require_once('views/CommonView.php');
require_once('views/ContactView.php');
require_once('views/LearnView.php');
require_once('views/LoginView.php');
require_once('views/PlayView.php');
require_once('views/ProfileView.php');
require_once('views/RestrictedView.php');

/**
 * PageController controls data flow.
 */
class PageController{
    /**
     * Draws index page views using data from the database.
     */
    public static function drawBlogIndex(){
        $blogModels = DBManager::getMultiBlog();

        echo CommonView::drawHeader('Blogs') . "\n";
        echo BlogView::drawBlogIndex($blogModels) . "\n";
        echo CommonView::drawFooter() . "\n";
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
        echo CommonView::drawHeader($blogModel->getTitle()) . "\n";
        echo BlogView::drawEdit($errorFlag, $blogModel) . "\n";
        echo CommonView::drawFooter() . "\n";
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
            echo CommonView::drawHeader($blogModel->getTitle()) . "\n";
            echo BlogView::drawPost($blogModel, NULL) . "\n";
            echo CommonView::drawFooter() . "\n";
        }
    }

    /**
     * Draws new post page views using data from the database.
     * 
     * @param bool $errorFlag Whether an error was passed. Default 'false'.
     * @param BlogModel $blogModel A blog. Default 'new BlogModel()'.
     */
    public static function drawNewPost($errorFlag = false, $blogModel = new BlogModel()){
        echo CommonView::drawHeader('New Post') . "\n";
        echo BlogView::drawNewPost($errorFlag, $blogModel) . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws opening database search page views using data from lichess API.
     */
    public static function drawLearn(){
        echo CommonView::drawHeader('Learn') . "\n";
        echo LearnView::drawLearn() . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws play page views.
     */
    public static function drawPlay(){
        echo CommonView::drawHeader('Play') . "\n";
        echo PlayView::drawPlay() . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws login page views.
     */
    public static function drawLogin(){
        echo CommonView::drawHeader('Login') . "\n";
        echo LoginView::drawLogin() . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws login page views.
     */
    public static function drawContact(){
        echo CommonView::drawHeader('Contact Us') . "\n";
        echo ContactView::drawContact() . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws profile page views.
     */
    public static function drawProfile(){
        echo CommonView::drawHeader('Profile') . "\n";
        echo ProfileView::drawProfile(AuthController::getUser()) . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws restricted page views.
     */
    public static function drawRestricted(){
        echo CommonView::drawHeader('Profile',) . "\n";
        echo RestrictedView::drawRestricted(AuthController::getUser()) . "\n";
        echo CommonView::drawFooter() . "\n";
    }
    
    public static function changeBannerLink(){
        $auth = AuthController::ensureAuthenticated();
        $linkText = 'Login';
        $link = 'login';

        if ($auth) {
            $userName = AuthController::getUser()->getUserName();
            $linkText = $userName;
            $link = 'profile';
        }

        return ['linkText' => $linkText, 'link' => $link];
    }
}

?>