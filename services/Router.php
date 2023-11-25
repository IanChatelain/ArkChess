<?php

require_once('controllers/PageController.php');
require_once('controllers/AuthController.php');
require_once('controllers/BlogController.php');
require_once('models/UserModel.php');
require_once('services/DBManager.php');
require_once('services/Utility.php');
require_once('services/UserField.php');
require_once('models/CommentModel.php');

/**
 * Router sanitizes input and decides which page to display.
 */
class Router{
    /**
     * Determines which page to display depending on sanitized server variables.
     */
    public static function blogRoute(){
        if(isset($_GET['post'])){
            BlogController::handleSingleBlog($_GET['post']);
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
                            $blogModel = new BlogModel($blogID, $title, $content, $_SESSION['USER_ID']);
    
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
                    else{
                        PageController::drawRestricted();
                    }
                }
                else{
                    PageController::drawRestricted();
                }
            }
            else{
                BlogController::displayAllBlogs();
            }
        }
        // If GET is newpost, display the new post page otherwise display index.
        elseif(isset($_GET['newpost'])){
            if(!empty($_SESSION['USER_ROLE'])){
                if($_SESSION['USER_ROLE'] <= 3){
                // If POST is insert and if POST is not empty string then display new post page,
                // otherwise display error.
                    if(isset($_POST['insert'])){
                        $title  = filter_input(INPUT_POST, 'postTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $content = filter_input(INPUT_POST, 'postContent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $blogModel = new BlogModel(NULL, $title, $content, $_SESSION['USER_ID']);
                        
                        if(strlen(trim($title)) > 0 && strlen(trim(trim($content)) > 0)){
                            DBManager::insertNewBlog($blogModel);
                            header("Location: blog.php");
                            exit;
                        }
                        else
                        {
                            $errorFlag = true;
                            PageController::drawNewPost($errorFlag);
                        }
                    }
                    else{
                        PageController::drawNewPost();
                    }
                }
                else{
                    PageController::drawRestricted();
                }
            }
            else{
                PageController::drawRestricted();
            }
        }
        else{
            BlogController::displayAllBlogs();
        }
    }

    public static function playRoute(){
        PageController::drawPlay();
    }

    public static function learnRoute(){
        PageController::drawLearn();
    }

    public static function loginRoute(){
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
        PageController::drawLogin();
    }

    public static function contactRoute(){
        PageController::drawContact();
    }

    public static function profileRoute(){
        // Check for logout first.
        if(isset($_POST['logout']) || isset($_POST['logout.php'])){
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
        if(isset($_POST['submit'])){
            AuthController::registerUser();
            header('Location: profile.php');
            exit();
        }
        PageController::drawRegister();
    }

    public static function logoutRoute(){
        AuthController::logoutUser();
        header('Location: login.php');
        exit();
    }

    public static function adminRoute(){
        if(isset($_SESSION['USER_ROLE']))
        {
            if($_SESSION['USER_ROLE'] == 1){
                if (isset($_POST['deleteUser']) && isset($_POST['userId'])) {
                    $userId = $_POST['userId'];
                    DBManager::deleteUser($userId);
                }
                if(isset($_POST['addUser'])){
                    AuthController::addUser();
                    header('Location: admin.php');
                    exit();
                }
                if(isset($_POST['editUserSubmit'])){
                    $userId = $_POST['editUserId'];
                    $userName = $_POST['editUserName'];
                    $email = $_POST['editEmail'];
                    $rating = $_POST['editRating'];
                    $role = $_POST['editRole'];
                    DBManager::editUser($userId, $userName, $email, $rating, $role);
                    header('Location: admin.php');
                    exit();
                }
                PageController::drawAdmin();
            }
            else{
                PageController::drawRestricted();
            }
        }
        else{
            PageController::drawRestricted();
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