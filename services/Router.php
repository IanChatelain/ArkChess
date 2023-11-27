<?php

session_start();

require_once('controllers/PageController.php');
require_once('services/Authentication.php');
require_once('controllers/BlogActionController.php');
require_once('models/UserModel.php');
require_once('services/DBManager.php');
require_once('services/Utility.php');
require_once('services/UserField.php');
require_once('models/CommentModel.php');

/**
 * Router sanitizes input and decides which page to display.
 */
class Router{
    // private fields like:
    // $page; (blog, login, play, learn)
    // $parameter; (sub page get request values like edit, new post)
    // $action; (get, post)
    // 
    // child parse classes will handle which controller to send the requests to 
    // or methods 
    /**
     * Determines which page to display depending on sanitized server variables.
     */
    public static function blogRoute(){
        if(isset($_GET['blog'])){
            BlogActionController::handleBlogRequest();
        }
        elseif(isset($_GET['edit'])){
            BlogActionController::handleEditBlogRequest();
        }
        elseif(isset($_GET['newpost'])){
            BlogActionController::handleNewBlogRequest();
        }
        else{
            BlogActionController::handleBlogSearchRequest();
        }
    }

    public static function playRoute(){
        PageController::drawPlay();
    }

    public static function learnRoute(){
        PageController::drawLearn();
    }

    // Workingon this before quitting
    public static function loginRoute(){
        if (isset($_POST['login'])) {
            if (Authentication::loginUser($_POST['username'], $_POST['password'])) {
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
            Authentication::logoutUser();
            header('Location: login.php');
            exit();
        }

        // Then check if user is logged in.
        if(Authentication::isLoggedIn()){
            PageController::drawProfile();
        }
        else{
            header('Location: login.php');
            exit();
        }
    }
    
    public static function registerRoute(){
        if(isset($_POST['submit'])){
            Authentication::registerUser();
            header('Location: profile.php');
            exit();
        }
        PageController::drawRegister();
    }

    public static function logoutRoute(){
        Authentication::logoutUser();
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
                    Authentication::addUser();
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

class ParseGet extends Router{

}

class ParsePost extends Router{

}

?>