<?php

require_once('views/BlogView.php');
require_once('models/BlogModel.php');
require_once('views/NotFoundView.php');
require_once('views/BlogView.php');
require_once('services/Sanitize.php');
require_once('models/FileModel.php');
require_once('services/UploadImage.php');


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
        $blogID = filter_input(INPUT_GET, 'blog', FILTER_SANITIZE_NUMBER_INT);
        $singleBlog = new BlogModel();
        $singleBlog->setBlogData($blogID);
        $comments = [];

        if($singleBlog->getBlogID() == -1){
            header('Location: blog.php');
            exit;
        }
        else{
            if(isset($_POST['commentSubmitButton'])){
                $commentText  = filter_input(INPUT_POST, 'commentTextArea', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                if(!empty($commentText) && isset($_SESSION['USER_ID'])){
                    DBManager::insertBlogComment(new CommentModel($commentText, $_SESSION['USER_ID'], $blogID));
                }
            }
            else{
                $commentModel = DBManager::getBlogComments($blogID);
                self::displaySingleBlog($singleBlog, $commentModel);
            }
        }
    }

     /**
     * Draws edit blog views using data from the database.
     * 
     * @param int $blogID A blogs unique identifier.
     */
    public static function handleEditBlogRequest(){
        $blogID = filter_input(INPUT_GET, 'edit', FILTER_SANITIZE_NUMBER_INT);
        $deleteOption = false;
        $uploadedImage = DBManager::getUploadedFile($blogID);
        $imageName = $uploadedImage->getFileName(Size::MEDIUM);

        if($imageName != NULL){
            $deleteOption = true;
            $filePathMedium = "public/img/uploads/medium/" . $imageName;
        }

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

            if(!empty($title) && !empty($content)){
                if (isset($_POST['deleteImage']) && $_POST['deleteImage'] == 'delete') {
                    DBManager::deleteImage($blogID);

                    unlink($filePathMedium);
                }

                $blogModel = new BlogModel($blogID, $title, $content);

                DBManager::updateBlog($blogModel);
                // Redirect to prevent form resubmission
                header("Location: blog.php?blog={$blogID}");
                exit;
            }
        }
        elseif(isset($_POST['delete'])){
            // Delete the blog and redirect
            DBManager::deleteImage($blogID);
            DBManager::deleteBlog($blogID);
            unlink($filePath);
            header('Location: blog.php');
            exit;
        }
        else{
            self::displayEditBlog($singleBlog, $deleteOption);
        }
    }

    public static function handleNewBlogRequest(){
        $errorCode = 0;
        unset($_SESSION['img_org']);
        unset($_SESSION['img_med']);
        unset($_SESSION['img_thumb']);

        if(isset($_POST['insert'])){
            $title  = filter_input(INPUT_POST, 'postTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = Sanitize::sanitizeHTML($_POST['postContent']);
            $errorCode = UploadImage::executeResize();

            if(!empty($title) && !empty($content) && $errorCode == 0){
                $blogModel = new BlogModel(NULL, $title, $content, $_SESSION['USER_ID']);
                DBManager::insertNewBlog($blogModel);
                $blogID = DBManager::getLastInsertId("blog");
                if($blogID){
                    if($errorCode == 0 && $_FILES['file']['name'] != NULL){
                        $fileModel = new FileModel(NULL, $_SESSION['img_org'], $_SESSION['img_med'], $_SESSION['img_thumb'], $blogID);
                        $fileModel->saveFiles();
                    }
                    else{
                        self::displayNewBlog($errorCode);
                    }
                }
                if($errorCode == 0){
                    header("Location: blog.php?blog={$blogID}");
                    exit;
                }
            }
            else{
                self::displayNewBlog($errorCode);
            }
        }
        else{
            self::displayNewBlog($errorCode);
        }
    }

    public static function displaySingleBlog($singleBlog, $commentModel){
        echo CommonView::drawHeader($singleBlog->getTitle()) . "\n";
        echo BlogView::drawSingleBlog($singleBlog, Authentication::isAuthorized(), $commentModel) . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    private static function displayEditBlog($singleBlog, $deleteOption){
        echo CommonView::drawHeader($singleBlog->getTitle()) . "\n";
        echo BlogView::drawEdit($singleBlog, $deleteOption) . "\n";
        echo CommonView::drawFooter() . "\n";
    }

    private static function displayNewBlog($errorCode){
        echo CommonView::drawHeader('Blogs') . "\n";
        echo BlogView::drawNewBlog($errorCode) . "\n";
        echo CommonView::drawFooter() . "\n";
    }
}

?>