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
            define('DB_DSN','mysql:host=localhost;dbname=serverside;charset=utf8'); // 1433 mssql engine port
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

        $query = "INSERT INTO chessuser (user_name, user_password, email, validation_token) values (:user_name, :user_password, :email, :validation_token)";

        try{
            $statement = $db->prepare($query);
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

        $query = "SELECT * FROM chessuser WHERE user_id = :userID";
    
        try{
            $statement = $db->prepare($query);
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
        $query = "SELECT * FROM chessuser";
        $columns = [];
        $users = [];

        $db = self::connect();

        try{
            $statement = $db->prepare($query);
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

        $query = "SELECT user_id, user_name, user_password FROM chessuser WHERE user_name = :user_name";
    
        try{
            $statement = $db->prepare($query);
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
        $column = self::getSortPreference()['column_name'];
        $query = "SELECT * FROM blog ORDER BY $column DESC";
        $result = [];

        $db = self::connect();

        try{
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
        }

        return $result;
    }

    public static function getSortPreference(){
        $query = "SELECT * FROM last_sort_preference";

        $db = self::connect();

        try{
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
        }

        return $result[0];
    }

    /**
     * Connects and queries the database for a single blog post.
     * 
     * @param int $blogID The unique identifier of a blog.
     * 
     * @return BlogModel $blog An instance of a blog.
     */
    public static function getSingleBlog($blogID){
        $query = "SELECT * FROM blog WHERE blog_id = :blog_id";
        $result;

        $db = self::connect();

        try{
            $statement = $db->prepare($query);
            $statement->bindValue('blog_id', $blogID, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
        }
        return $result;
    }

    public static function getComments($blogID){
        $query = "SELECT * FROM comment WHERE blog_id = :blog_id";
        $blogModel = self::getSingleBlog($blogID);
        $result = [];

        $db = self::connect();

        try{
            $statement = $db->prepare($query);
            $statement->bindValue('blog_id', $blogID, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if($result === false){
                return new BlogModel(NULL, '','','',NULL);
            }
            foreach($result as $row){
                $commentID = $row['comment_id'];
                $commentDate = $row['date'];
            }
            $commentModel = new CommentModel();

            return new BlogModel($blogID, $blogModel->getTitle(), $blogModel->getContent(), $blogModel->getUserID(), $commentModel);
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
        }
    }

    /**
     * Connects and queries the database to update a blog record.
     * 
     * @param BlogModel $blogModel An instance of a blog.
     */
    public static function updateBlog($blogModel){
        $db = self::connect();

        // TODO: add database level security, check for user id in query to match blog.
        $query = "UPDATE blog SET title = :title, text_content = :text_content WHERE blog_id = :blog_id";
        try{
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $blogModel->getTitle());
            $statement->bindValue(':text_content', $blogModel->getContent());
            $statement->bindValue(':blog_id', $blogModel->getBlogID(), PDO::PARAM_INT);
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

        $query = "INSERT INTO blog (title, text_content, user_id) values (:title, :text_content, :user_id)";
        try{
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $blogModel->getTitle());
            $statement->bindValue(':text_content', $blogModel->getContent());
            $statement->bindValue(':user_id', $blogModel->getUserID());
            $statement->execute();
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
        }
    }

    public static function getLastInsertId($table){
        $db = self::connect();

        $tableID = $table . "_id";
        $query = "SELECT $tableID FROM $table ORDER BY $tableID DESC LIMIT 1";

        try{
            $statement = $db->prepare($query);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_COLUMN, 0);
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
        }
    }
    
    public static function insertBlogComment($commentModel){
        $commentText = $commentModel->getText();
        $commentUserID = $commentModel->getUserID();
        $commentBlogID = $commentModel->getBlogID();

        $db = self::connect();

        $query = "INSERT INTO comment (comment_text, user_id, blog_id) values (:comment_text, :user_id, :blog_id)";
        try{
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $blogModel->getTitle());
            $statement->bindValue(':text_content', $blogModel->getContent());
            $statement->bindValue(':user_id', $blogModel->getUserID());
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

        // TODO: Add db level security matching user_id to blog.
        $query = "DELETE FROM blog WHERE blog_id = :blog_id LIMIT 1";
        try{
            $statement = $db->prepare($query);
            $statement->bindValue(':blog_id', $blogID, PDO::PARAM_INT);
            $statement->execute();
        }
        catch(PDOException $e){
            error_log("Database error: " . $e->getMessage());
        }
    }
}

?>