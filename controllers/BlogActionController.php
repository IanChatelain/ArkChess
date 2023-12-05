<?php

require_once('views/BlogView.php');
require_once('models/BlogModel.php');
require_once('views/NotFoundView.php');
require_once('views/BlogView.php');
require_once('services/Sanitize.php');
require_once('models/FileModel.php');
require_once('services/FileUpload.php');


/**
 * BlogController controls blog data flow.
 */
class BlogActionController{
    /**
     * Draws main blog page views using data from the database.
     */
    public static function handleBlogSearchRequest(){
        $blogModel = new BlogModel();

        if(isset($_POST['sortByDropDown'])){
            $sortBy = $_POST['sortByDropDown'];
            $blogModelArray = $blogModel->getAllBlogs($sortBy);
        }
        else{
            $blogModelArray = $blogModel->getAllBlogs();
        }

        echo CommonView::drawHeader('Blogs') . "\n";
        echo BlogView::drawBlogSearch($blogModelArray, Authentication::isAuthorized()) . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    /**
     * Draws single blog views using data from the database.
     * 
     * @param int $blogID A blogs unique identifier.
     */
    public static function handleSingleBlogRequest(){
        $imageDirectory = "../public/img/uploads";
        $blogID = filter_input(INPUT_GET, 'blog', FILTER_SANITIZE_NUMBER_INT);
        $singleBlog = new BlogModel();
        $singleBlog->setBlogData($blogID);
        // $singleBlog->getFilePath(Size::ORIGINAL) - Once all image services are functional.


        if($singleBlog->getBlogID() == -1){
            header('Location: blog.php');
            exit;
        }
        else{
            self::displaySingleBlog($singleBlog);
        }
    }

     /**
     * Draws edit blog views using data from the database.
     * 
     * @param int $blogID A blogs unique identifier.
     */
    public static function handleEditBlogRequest(){
        $blogID = filter_input(INPUT_GET, 'edit', FILTER_SANITIZE_NUMBER_INT);

        if(!Authentication::isAuthorized()){
            header('Location: restricted.php');
            exit;
        }

        $singleBlog = new BlogModel();
        $singleBlog->setBlogData($blogID);

        if($singleBlog->getBlogID() == -1){
            header('Location: blog.php');
            exit;
        }

        if(isset($_POST['update'])){
            $title  = filter_input(INPUT_POST, 'postTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = Sanitize::sanitizeHTML($_POST['postContent']);

            if(!empty($title) || !empty($content)){
                $blogModel = new BlogModel($blogID, $title, $content);

                DBManager::updateBlog($blogModel);
                // Redirect to prevent form resubmission
                header("Location: blog.php?blog={$blogID}");
                exit;
            }
        }
        elseif(isset($_POST['delete'])){
            // Delete the blog and redirect
            DBManager::deleteBlog($blogID);
            header('Location: blog.php');
            exit;
        }
        else{
            self::displayEditBlog($singleBlog);
        }
    }

    public static function handleNewBlogRequest(){
        if(isset($_POST['insert'])){
            $title  = filter_input(INPUT_POST, 'postTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = Sanitize::sanitizeHTML($_POST['postContent']);

            if(!empty($title) || !empty($content)){
                $blogModel = new BlogModel(NULL, $title, $content, $_SESSION['USER_ID']);
                DBManager::insertNewBlog($blogModel);
                $blogID = DBManager::getLastInsertId("blog");
                if($blogID){
                    if(UploadImage::executeResize($blogID)){
                        $fileModel = new FileModel(NULL, $_SESSION['uploadedFileName'], $blogID);
                        $fileModel->saveFiles();
                    }
                }
                header("Location: blog.php?blog={$blogID}");
                exit;
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

    private static function displayEditBlog($singleBlog){
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