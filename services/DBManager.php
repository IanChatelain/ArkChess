<?php

require_once('models/BlogModel.php');
require_once('models/UserModel.php');

/**
 * DBManager handles database connection and queries, as well as server authentication.
 */
class DBManager{

    /**
     * Connects to the database using predefined keys.
     */
    public static function connect(){
        if(!defined('DB_DSN')){
            define('DB_DSN','mysql:host=localhost;dbname=serverside;charset=utf8');
        }
        if(!defined('DB_USER')){
            define('DB_USER','serveruser');
        }
        if(!defined('DB_PASS')){
            define('DB_PASS','gorgonzola7!');
        }

        try {
            $db = new PDO(DB_DSN, DB_USER, DB_PASS);
            return $db;
        } catch (PDOException $e) {
            print "Error: " . $e->getMessage();
            die();
        }
    }

    public static function insertNewUser($userRegistered){
        // New user insert successful.
        $errorCode = 0;
        $db = self::connect();
        $username = $userRegistered->getUserName();

        if(self::doesUserExist($username, 'user_name')){
            // User already exists.
            $errorCode = -100;
        }
        else{
            $insertQuery = "INSERT INTO chessuser (user_name, user_password, email) values (:user_name, :user_password, :email)";

            try{
                $statement = $db->prepare($insertQuery);
                $statement->bindValue(':user_name', $userRegistered->getUserName());
                $statement->bindValue(':user_password', $userRegistered->getPassword());
                $statement->bindValue(':email', $userRegistered->getEmail());
                $statement->execute();
            }
            catch(PDOException $e){
                // Failed to insert new user.
                $erroCode = -200;

                echo "Error: " . $e->getMessage();
            }
        }

        return $errorCode;
    }

    public static function authUser($user){
        $authed = false;
        $userName = $user->getUserName();
        $password = $user->getPassword();
        $db = self::connect();
    
        $userQuery = "SELECT user_id, user_name, user_password, role_id FROM chessuser WHERE user_name = :userName AND user_password = :password";
    
        try{
            $statement = $db->prepare($userQuery);
            $statement->bindParam(':userName', $userName, PDO::PARAM_STR);
            $statement->bindParam(':password', $password, PDO::PARAM_STR);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            if($row){
                $user = new UserModel($row['user_id'], $row['user_name'], null, $row['role_id']);
                $authed = true;
                $user->setAuth($authed);
            }
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    
        return $user;
    }

    public static function getAuthUser(){
        $user = null;

        if(isset($_SESSION['USER_ID'])){
            $userID = $_SESSION['USER_ID'];
            $db = self::connect();

            $userQuery = "SELECT * FROM chessuser WHERE user_id = :userID";
        
            try{
                $statement = $db->prepare($userQuery);
                $statement->bindParam(':userID', $userID, PDO::PARAM_INT);
                $statement->execute();
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                if($row){
                    $user = new UserModel($row['user_id'], $row['user_name']);
                    $user->setRating($row['rating']);
                    $user->setRole($row['role_id']);
    
                    $authed = true;
                    $user->setAuth($authed);
                }
            }
            catch(PDOException $e){
                echo "Error: " . $e->getMessage();
            }

        }
        
        return $user;
    }

    public static function doesUserExist($userField, $searchColumn){
        $userAlreadyExists = false;

        $db = self::connect();

        $userQuery = "SELECT * FROM chessuser WHERE $searchColumn = :userField";
    
        try{
            $statement = $db->prepare($userQuery);
            $statement->bindParam(':userField', $userField, PDO::PARAM_STR);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            if($row){
                $userAlreadyExists = true;
            }
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }

        return $userAlreadyExists;
    }

    /**
     * Connects and queries the database for multiple blog posts.
     * 
     * @param int $limit A limit to set the number of blogs returned by the database. Default '5'.
     * 
     * @return BlogModel[] $blogs An array of blogs.
     */
    public static function getMultiBlog(int $limit = 5){
        $indexQuery = "SELECT * FROM blogs ORDER BY date DESC LIMIT :limit";
        $result = [];
        $blogs = [];

        $db = self::connect();

        try{
            $statement = $db->prepare($indexQuery);
            $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row){
                $blog = new BlogModel($row['blogID'],  $row['title'], nl2br($row['content']));
                $blog->setDate($row['date']);
                $blogs[] = $blog;
            }
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }

        return $blogs;
    }

    /**
     * Connects and queries the database for a single blog post.
     * 
     * @param int $blogID The unique identifier of a blog.
     * 
     * @return BlogModel $blog An instance of a blog.
     */
    public static function getSingleBlog($blogID){
        $blogQuery = "SELECT * FROM blogs WHERE blogID = :id";
        $result = [];

        $db = self::connect();

        try{
            $statement = $db->prepare($blogQuery);
            $statement->bindValue('id', $blogID, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch();
            if($result === false){
                return new BlogModel(-1,'','','','');
            }
            $blog = new BlogModel($result['blogID'],  $result['title'], $result['content']);
            $blog->setDate($result['date']);
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
        return $blog;
    }

    /**
     * Connects and queries the database to update a blog record.
     * 
     * @param BlogModel $blogModel An instance of a blog.
     */
    public static function updateEdit($blogModel){
        $db = self::connect();

        $updateQuery = "UPDATE blogs SET title = :title, content = :content WHERE blogID = :blogID";
        try{
            $statement = $db->prepare($updateQuery);
            $statement->bindValue(':title', $blogModel->getTitle());
            $statement->bindValue(':content', $blogModel->getContent());
            $statement->bindValue(':blogID', $blogModel->getBlogID(), PDO::PARAM_INT);
            $statement->execute();
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Connects and queries the database to insert a new blog record.
     * 
     * @param BlogModel $blogModel An instance of a blog.
     */
    public static function insertNewBlog($blogModel){
        $db = self::connect();

        $insertQuery = "INSERT INTO blogs (title, content) values (:title, :content)";
        try{
            $statement = $db->prepare($insertQuery);
            $statement->bindValue(':title', $blogModel->getTitle());
            $statement->bindValue(':content', $blogModel->getContent());
            $statement->execute();
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Connects and queries the database to delete a blog record.
     * 
     * @param int $blogID A unique identifier of a blog.
     */
    public static function deleteBlog($blogID){
        $db = self::connect();

        $deleteQuery = "DELETE FROM blogs WHERE blogID = :blogID LIMIT 1";
        try{
            $statement = $db->prepare($deleteQuery);
            $statement->bindValue(':blogID', $blogID, PDO::PARAM_INT);
            $statement->execute();
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }
}

?>