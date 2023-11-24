<?php

// Might not need this.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
require_once('views/RegisterView.php');
require_once('views/ValidatedEmailView.php');
require_once('views/AdminView.php');

/**
 * PageController controls data flow.
 */
class PageController{
    // TODO: Rename all draws to different names than page controller draw functions.
    /**
     * Draws index page views using data from the database.
     */
    public static function drawBlogSearch(){
        $blogModels = DBManager::getMultiBlog();

        echo CommonView::drawHeader('Blogs') . "\n";
        echo BlogView::drawBlogSearch($blogModels) . "\n";
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
        echo BlogView::drawEdit($blogID, $errorFlag, $blogModel) . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws single post views using data from the database.
     * 
     * @param int $blogID A blogs unique identifier.
     */
    public static function drawSingleBlog($blogID){
        $blogModel = DBManager::getSingleBlog($blogID);
        if($blogModel->getBlogID() == -1){
            self::drawNotFound();
        }
        else{
            echo CommonView::drawHeader($blogModel->getTitle()) . "\n";
            echo BlogView::drawSingleBlog($blogModel, NULL) . "\n";
            echo CommonView::drawFooter() . "\n";
        }
    }

    /**
     * Draws new post page views using data from the database.
     * 
     * @param bool $errorFlag Whether an error was passed. Default 'false'.
     * @param BlogModel $blogModel A blog. Default 'new BlogModel()'.
     */
    public static function drawNewPost($errorFlag = false){
        echo CommonView::drawHeader('New Post') . "\n";
        echo BlogView::drawNewPost($errorFlag) . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws opening database search page views using data from lichess API.
     */
    public static function drawLearn(){
        self::isReadOnlyUser();
        echo CommonView::drawHeader('Learn') . "\n";
        echo LearnView::drawLearn() . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws play page views.
     */
    public static function drawPlay(){
        self::isReadOnlyUser();
        echo CommonView::drawHeader('Play') . "\n";
        echo PlayView::drawPlay() . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws login page views.
     */
    public static function drawLogin(){
        self::isReadOnlyUser();
        echo CommonView::drawHeader('Login') . "\n";
        echo LoginView::drawLogin() . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws login page views.
     */
    public static function drawContact(){
        self::isReadOnlyUser();
        echo CommonView::drawHeader('Contact Us') . "\n";
        echo ContactView::drawContact() . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws profile page views.
     */
    public static function drawProfile(){
        if(isset($_SESSION['USER_ID'])){
            $userData = DBManager::getUserData($_SESSION['USER_ID'], UserField::All);
        }
        if($userData->getRole() == 1){
            
        }
        echo CommonView::drawHeader('Profile') . "\n";
        echo ProfileView::drawProfile($userData) . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws restricted page views.
     */
    public static function drawRestricted(){
        self::isReadOnlyUser();
        echo CommonView::drawHeader('Profile') . "\n";
        echo RestrictedView::drawRestricted() . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws register page views.
     */
    public static function drawRegister(){
        self::isReadOnlyUser();
        echo CommonView::drawHeader('Profile') . "\n";
        echo RegisterView::drawRegister() . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws validated email page views.
     */
    public static function drawValidatedEmail(){
        self::isReadOnlyUser();
        echo CommonView::drawHeader('Profile') . "\n";
        echo ValidatedEmailView::drawValidatedEmail() . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws admin page views.
     */
    public static function drawAdmin(){
        $users = DBManager::getAllUsers();

        echo CommonView::drawHeader('Admin') . "\n";
        echo AdminView::drawAdmin($users) . "\n";
        echo CommonView::drawFooter() . "\n";
    }
    
    public static function changeBannerLink(){
        $userId = AuthController::isLoggedIn();
        $linkText = 'Sign In';
        $link = 'login';

        if ($userId) {
            $userName = DBManager::getUserData($_SESSION['USER_ID'], UserField::UserName);
            $linkText = $userName;
            $link = 'profile';
        }

        return ['linkText' => $linkText, 'link' => $link];
    }

    public static function isReadOnlyUser(){
        if(!isset($_SESSION['USER_ID'])){
            $_SESSION['USER_ROLE'] = 4;
        }
    }

    public static function userOwnsBlog($blogId){
        if(isset($_SESSION['USER_ID'])){

        }
    }
}

?>