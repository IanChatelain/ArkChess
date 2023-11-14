<?php

require_once('models/BlogModel.php');
require_once('controllers/PageController.php');

/**
 * PageView displays the HTML markup.
 */
class BlogView{

    /**
     * Displays the blog post HTML.
     * 
     * @param BlogModel $blogModel A blog.
     * @param bool $errorFlag
     * 
     * @return string $newPostMain A string containing the blog page HTML.
     */
    public static function drawNewPost($errorFlag, $blogModel){
        $errorTag = '';
        $title = $blogModel->getTitle();
        $content = $blogModel->getContent();
        if($errorFlag){
            $errorTag = '<p>Each field must contain at least 1 letter</p>';
        }
        $newPostMain = <<<END
            <div>
                <h1>New Blog</h1>
                <form method="post">
                    <fieldset id="blogs">
                        <label for="postTitle">Title</label>
                        <input class="forms" type="text" id="postTitle" name="postTitle" value="{$title}">
    
                        <label for="postContent">Content</label>
                        <textarea class="forms" name="postContent" id="postContent" cols="30" rows="10">{$content}</textarea>
    
                        $errorTag
                        <button type="submit" name="insert" class="updateButton">Submit Blog</button>
                    </fieldset>
                </form>
            </div>
END;
        
        return $newPostMain;
    }


    /**
     * Displays the blog edit HTML.
     * 
     * @param BlogModel $blogModel A blog.
     * @param bool $errorFlag
     * 
     * @return string $editMain A string containing the edit page HTML.
     */
    public static function drawEdit($errorFlag, $blogModel){
        $errorTag = '';
        $blogID = $blogModel->getBlogID();
        $title = $blogModel->getTitle();
        $content = $blogModel->getContent();
        if($errorFlag){
            $errorTag = '<p>Each field must contain at least 1 letter.</p>';
        }
        $editMain = <<<END
            <div>
                <h1>Edit Blog</h1>
                <form method="post">
                    <fieldset id="blogs">
                        <label for="postTitle">Title</label>
                        <input type="hidden" name="blogID" value="{$blogID}">
                        <input class="forms" type="text" id="postTitle" name="postTitle" value="{$title}">
    
                        <label for="postContent">Content</label>
                        <textarea class="forms" name="postContent" id="postContent" cols="30" rows="10">{$content}</textarea>
    
                        $errorTag
                        <button type="submit" name="update" class="updateButton">Update</button>
                        <button type="submit" name="delete" class="deleteButton">Delete</button>
                    </fieldset>
                </form>
            </div>
END;
        
        return $editMain;
    }

    /**
     * Displays the blog page HTML.
     * 
     * @param BlogModel[] $blogModels An array of blogs.
     * 
     * @return string $content A string containing the blog page HTML.
     */
    public static function drawBlogIndex($blogModels){
        $content = '<main class="content"><div><h1>Recent Blogs<a id="newPost" href="blog.php?newpost">New Post</a></h1>';

        foreach($blogModels as $blogModel){
            $content = $content . self::drawPost($blogModel, 200);
        }

        if(empty($blogModels)){
            $content = $content . '<article class="blogs">No Blogs Exist.</article>';
        }

        $content = $content . '</div></main>';

        return $content;
    }

    /**
     * Displays the blog post HTML
     * 
     * @param BlogModel $blogModel A blog.
     * @param int $limit Character limit to display. Default 'NULL'.
     * 
     * @return string $postMain A string containing the blog post page HTML.
     */
    public static function drawPost($blogModel, $limit = NULL){
        $blogID = $blogModel->getBlogID();
        $title = $blogModel->getTitle();
        $date = $blogModel->getDate();
        $content = $blogModel->getContent();
        $blogLink = '';

        if($limit && strlen($content) > $limit){
            $content = substr($content, 0, $limit);
            $blogLink = 'Read Full Post...';
        }

        $postMain = <<<END
            <article class="blogs">  
                <h2>
                    <a href="blog.php?post={$blogID}">{$title}</a>
                    <a id="editLink" href="blog.php?edit={$blogID}">Edit</a>
                </h2>
                <p class="date">{$date}</p>
                <p class="blogContent">{$content}<a class="blogLink" href="blog.php?post={$blogID}">{$blogLink}</a></p>
            </article>
END;

        return $postMain;
    }
}