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
            error_log("Database error: " . $e->getMessage());
            die();
        }
    }

    public static function insertNewUser($userName, $password, $email, $token){
        $db = self::connect();

        $insertQuery = "INSERT INTO chessuser (user_name, user_password, email, validation_token) values (:user_name, :user_password, :email, :validation_token)";

        try{
            $statement = $db->prepare($insertQuery);
            $statement->bindValue(':user_name', $userName);
            $statement->bindValue(':user_password', $password);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':validation_token', $token);
            $statement->execute();
            return $db->lastInsertId();
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
    
    public static function editUser($userId, $userName, $email, $rating, $role){
        $db = self::connect();

        $query = "UPDATE chessuser SET user_name = :user_name, email = :email, rating = :rating, role_id = :role_id  WHERE user_id = :user_id";
        try{
            $statement = $db->prepare($query);
            $statement->bindValue(':user_name', $userName);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':rating', $rating);
            $statement->bindValue(':role_id', $role);
            $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $statement->execute();
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
        }
    }

    public static function deleteUser($userId){
        $db = self::connect();

        $query = "DELETE FROM chessuser WHERE user_id = :user_id LIMIT 1";
        try{
            $statement = $db->prepare($query);
            $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $statement->execute();
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
        }
    }

    public static function getAuthUser($userId){
        $db = self::connect();

        $userQuery = "SELECT * FROM chessuser WHERE user_id = :userID";
    
        try{
            $statement = $db->prepare($userQuery);
            $statement->bindParam(':userID', $userID, PDO::PARAM_INT);
            $statement->execute();
            $row = $statement->fetch();
            if($row){
                $user = new UserModel($row['user_id'], $row['user_name']);
                $user->setRating($row['rating']);
                $user->setRole($row['role_id']);

                $authed = true;
                $user->setAuth($authed);
            }
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
        }
    }

    public static function doesUserExist($userName) {
        $db = self::connect();
        $query = "SELECT COUNT(*) FROM chessuser WHERE user_name = :user_name";
        
        try {
            $statement = $db->prepare($query);
            $statement->bindParam(':user_name', $userName, PDO::PARAM_STR);
            $statement->execute();

            // If the count is more than 0, the user exists
            return $statement->fetchColumn() > 0;
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public static function getAllUsers(){
        $indexQuery = "SELECT * FROM chessuser";
        $columns = [];
        $users = [];

        $db = self::connect();

        try{
            $statement = $db->prepare($indexQuery);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row){
                $user = new UserModel(
                    $row['user_id'] ?? null,
                    $row['user_name'] ?? null,
                    $row['first_name'] ?? null,
                    $row['last_name'] ?? null,
                    $row['email'] ?? null,
                    $row['rating'] ?? null,
                    $row['role_id'] ?? null,
                );

                $columns[] = $user;
            }
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
        }

        return $columns;
    }

    public static function getAllUsersJSON($userName = null){
        $db = self::connect();
    
        if($userName){
            $query = "SELECT * FROM chessuser WHERE user_name LIKE :user_name";
            $userName = "%$userName%"; // Add wildcard characters for partial matching
        } else {
            $query = "SELECT * FROM chessusers";
        }
    
        $users = [];
    
        try{
            $statement = $db->prepare($query);
            if($userName){
                $statement->bindParam(':user_name', $userName, PDO::PARAM_STR);
            }
            $statement->execute();
            $users = $statement->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
            // You could return a JSON-encoded error message here if desired
            return json_encode(['error' => 'Database error']);
        }
    
        return json_encode($users);
    }
    

    public static function getUserData($userId, UserField $field){
        $db = self::connect();

        if($field == UserField::All){
            $query = "SELECT user_id, user_name, first_name, last_name, email, rating, role_id FROM chessuser WHERE user_id = :user_id";
        }
        else{
            $query = "SELECT $field->value FROM chessuser WHERE user_id = :user_id";
        }

        try{
            $statement = $db->prepare($query);
            $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                if($field == UserField::All){
                    return new UserModel(
                        $row['user_id'] ?? null,
                        $row['user_name'] ?? null,
                        $row['first_name'] ?? null,
                        $row['last_name'] ?? null,
                        $row['email'] ?? null,
                        $row['rating'] ?? null,
                        $row['role_id'] ?? null,
                    );
                }
                else{
                    return $row[$field->value];
                }
            }
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public static function verifyUserLogin($userName, $password){
        $db = self::connect();

        $userQuery = "SELECT user_id, user_name, user_password FROM chessuser WHERE user_name = :user_name";
    
        try{
            $statement = $db->prepare($userQuery);
            $statement->bindParam(':user_name', $userName, PDO::PARAM_STR);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            if ($row && password_verify($password, $row['user_password'])) {
                return $row['user_id'];
            }
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
            return false;
        }
        return false;
    }

    /**
     * Connects and queries the database for multiple blog posts.
     * 
     * @param int $limit A limit to set the number of blogs returned by the database. Default '5'.
     * 
     * @return BlogModel[] $blogs An array of blogs.
     */
    public static function getMultiBlog(){
        $indexQuery = "SELECT * FROM blogs ORDER BY date DESC";
        $result = [];
        $blogs = [];

        $db = self::connect();

        try{
            $statement = $db->prepare($indexQuery);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row){
                $blog = new BlogModel($row['blogID'],  $row['title'], nl2br($row['content']));
                $blog->setDate($row['date']);
                $blogs[] = $blog;
            }
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
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
            error_log("Database error: " . $e->getMessage());
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
            error_log("Database error: " . $e->getMessage());
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
            error_log("Database error: " . $e->getMessage());
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
            error_log("Database error: " . $e->getMessage());
        }
    }
}

?>