<?php

require_once('views/BlogView.php');
require_once('models/BlogModel.php');
require_once('views/NotFoundView.php');
require_once('views/BlogView.php');

/**
 * BlogController controls blog data flow.
 */
class BlogActionController{
    /**
     * Draws single post views using data from the database.
     * 
     * @param int $blogID A blogs unique identifier.
     */
    public static function handleBlogRequest(){
        $blogID = filter_input(INPUT_GET, 'blog', FILTER_SANITIZE_NUMBER_INT);

        $singleBlog = new BlogModel();
        $singleBlog->setBlogData($blogID);

        if($singleBlog->getBlogID() == -1){
            header('Location: CommunityView.php');
            exit;
        }
        else{
            self::displaySingleBlog($singleBlog);
        }
    }

    /**
     * Draws main blog page views using data from the database.
     */
    public static function handleBlogSearchRequest(){
        $isAuthed = Authentication::isAuthorized();
        $blogModel = new BlogModel();
        $blogModelArray = $blogModel->getAllBlogs();

        echo CommonView::drawHeader('Blogs') . "\n";
        echo BlogView::drawBlogSearch($blogModelArray, $isAuthed) . "\n";
        echo CommonView::drawFooter() . "\n";
    }
 
    public static function handleEditBlogRequest(){
        $blogID = filter_input(INPUT_GET, 'edit', FILTER_SANITIZE_NUMBER_INT);

        self::handleEdit($blogID);
        if(isset($_POST['update'])){
            $blogID = filter_input(INPUT_GET, 'update', FILTER_SANITIZE_NUMBER_INT);
            $title  = filter_input(INPUT_POST, 'postTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = filter_input(INPUT_POST, 'postContent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $userID = $_SESSION['USER_ID'];

            $blogModel = new BlogModel($blogID, $title, $content, $userID);

            // if fields are not empty update db and display edited blog
        }
        elseif(isset($_POST['delete'])){
            $blogID = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_NUMBER_INT);

            // delete blog
        }
    }

    public static function handleNewBlogRequest(){
        if(isset($_POST['insert'])){
            $title  = filter_input(INPUT_POST, 'postTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = filter_input(INPUT_POST, 'postContent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // if fields are not empty insert to db and display inserted blog
            if(!empty($title) || !empty($content)){
                $blogModel = new BlogModel(NULL, $title, $content, $_SESSION['USER_ID']);
                DBManager::updateBlog($blogModel);
            }
        }
        else{
            self::displayNewBlog();
        }
    }

    public static function displaySingleBlog($singleBlog){
        echo CommonView::drawHeader($singleBlog->getTitle()) . "\n";
        echo BlogView::drawSingleBlog($singleBlog, Authentication::isAuthorized()) . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    private static function displayEditBlog($blogID){
        // Handle auth here.
        $singleBlog = new BlogModel();
        $singleBlog->setBlogData($blogID);

        echo CommonView::drawHeader($singleBlog->getTitle()) . "\n";
        echo BlogView::drawEdit($singleBlog, NULL) . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    private static function displayNewBlog(){
        echo CommonView::drawHeader('Blogs') . "\n";
        echo BlogView::drawNewBlog() . "\n";
        echo CommonView::drawFooter() . "\n";
    }
}

?>