<?php

require_once('controllers/PageController.php');
require_once('controllers/AuthController.php');
require_once('models/UserModel.php');
require_once('services/DBManager.php');
require_once('services/Utility.php');
require_once('services/UserField.php');

/**
 * Router sanitizes input and decides which page to display.
 */
class Router{

    /**
     * Determines which page to display depending on sanitized server variables.
     */
    public static function blogRoute(){
        // If GET is post, display the post page otherwise display index.
        if(isset($_GET['post'])){
            $blogID = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);

            if($blogID){
                PageController::drawSinglePost($blogID, 0);
            }
            else{
                PageController::drawBlogIndex();
            }
        }
        // If GET is edit, display the edit page otherwise display index.
        elseif(isset($_GET['edit'])){
            $blogID = filter_input(INPUT_GET, 'edit', FILTER_SANITIZE_NUMBER_INT);

            if($blogID){
                if(!empty($_SESSION['USER_ROLE'])){
                    if($_SESSION['USER_ROLE'] == 1){
                        // If POST is update and if POST is not empty string then display edit page,
                        // otherwise display error.
                        if(isset($_POST['update'])){
                            $errorFlag = false;
                            $title  = filter_input(INPUT_POST, 'postTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                            $content = filter_input(INPUT_POST, 'postContent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                            $blogID = filter_input(INPUT_POST, 'blogID', FILTER_SANITIZE_NUMBER_INT);
                            $blogModel = new BlogModel($blogID, $title, $content);
    
                            if(strlen(trim($title)) > 0 && strlen(trim($content) > 0)){
                                DBManager::updateEdit($blogModel);
                                header("Location: blog.php?post={$blogID}");
                                exit;
                            }
                            else{
                                $errorFlag = true;
                                PageController::drawEdit($blogID, $errorFlag, $blogModel);
                            }
                        }
                        // If POST is delete, delete the post and display index.
                        elseif(isset($_POST['delete'])){
                            DBManager::deleteBlog($blogID);
                            header("Location: blog.php");
                            exit;
                        }
                        else{
                            PageController::drawEdit($blogID);
                        }
                    }
                }
                else{
                    PageController::drawRestricted();
                }
            }
            else{
                PageController::drawBlogIndex();
            }
        }
        // If GET is newpost, display the new post page otherwise display index.
        elseif(isset($_GET['newpost'])){
            if(!empty($_SESSION['USER_ROLE'])){
                if($_SESSION['USER_ROLE'] == 1){
                // If POST is insert and if POST is not empty string then display new post page,
                // otherwise display error.
                    if(isset($_POST['insert'])){
                        $title  = filter_input(INPUT_POST, 'postTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $content = filter_input(INPUT_POST, 'postContent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $blogModel = new BlogModel(NULL, $title, $content);
                        
                        if(strlen(trim($title)) > 0 && strlen(trim(trim($content)) > 0)){
                            DBManager::insertNewBlog($blogModel);
                            header("Location: blog.php");
                            exit;
                        }
                        else
                        {
                            $errorFlag = true;
                            PageController::drawNewPost($errorFlag, $blogModel);
                        }
                    }
                    else{
                        PageController::drawNewPost();
                    }
                }
            }
            else{
                PageController::drawRestricted();
            }
        }
        else{
            PageController::drawBlogIndex();
        }
    }

    public static function playRoute(){
        PageController::drawPlay();
    }

    public static function learnRoute(){
        PageController::drawLearn();
    }

    public static function loginRoute(){
        PageController::drawLogin();
        if (isset($_POST['login'])) {
            if (AuthController::loginUser()) {
                header('Location: profile.php');
                exit();
            } else {
                Utility::setFlashMessage('login_error', 'No account found with that username or password. Try again.');
                header('Location: login.php');
                exit();
            }
        }
    }

    public static function contactRoute(){
        PageController::drawContact();
    }

    public static function profileRoute(){
        // Check for logout first.
        if(isset($_POST['logout'])){
            AuthController::logoutUser();
            header('Location: login.php');
            exit();
        }

        // Then check if user is logged in.
        if(AuthController::isLoggedIn()){
            PageController::drawProfile();
        }
        else{
            header('Location: login.php');
            exit();
        }
    }
    
    public static function registerRoute(){
        PageController::drawRegister();
        if(isset($_POST['submit'])){
            AuthController::registerUser();
            header('Location: profile.php');
            exit();
        }
    }

    public static function validatedEmailRoute(){
        if(isset($_SESSION['USER_NAME'])){
            $userName = $_SESSION['USER_NAME'];
            $cookieName = $userName . "_email_token";
            $token = $_COOKIE[$cookieName];
            if(isset($_GET['token'])){
                if($_GET['token'] === $token){
                    PageController::drawValidatedEmail();
                }
                else{
                    echo "Incorrect token or token expired";
                }
            }
        }
    }
}

?>