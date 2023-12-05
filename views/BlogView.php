<?php

require_once('models/BlogModel.php');

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
    public static function drawNewBlog(){
        $html = <<<END
        <main class="form-container profile">
            <h2 class="formTitle">Community Blogs</h2>
            <div class="blogPageContainer">
                <form method="post" enctype="multipart/form-data">
                    <fieldset id="blogs">
                        <label for="postTitle">Title</label>
                        <input class="forms" type="text" id="postTitle" name="postTitle" placeholder="Title">

                        <label for="postContent">Content</label>
                        <textarea class="forms" name="postContent" id="postContent"></textarea>

                        <div class="newBlogButtons">
                            <label for="file" class="file-label">Upload Image</label>
                            <input type="file" name="file" id="file">
                        </div>
                        <button type="submit" name="insert" class="updateButton">Submit Blog</button>
                    </fieldset>
                </form>
            </div>
        </main>
        END;
        
        return $html;
    }


    /**
     * Displays the blog edit HTML.
     * 
     * @param BlogModel $blogModel A blog.
     * @param bool $errorFlag
     * 
     * @return string $editMain A string containing the edit page HTML.
     */
    public static function drawEdit($blogModel, $errorFlag){
        $errorTag = '';
        $blogID = $blogModel->getBlogID();
        $title = htmlspecialchars($blogModel->getTitle());
        $content = htmlspecialchars($blogModel->getContent());
        if($errorFlag){
            $errorTag = '<p>Each field must contain at least 1 letter.</p>';
        }
        $html = <<<END
            <div>
                <h1>Edit Blog</h1>
                <form method="post">
                    <fieldset id="blogs">
                        <label for="postTitle">Title</label>
                        <input type="hidden" name="blogID" value="{$blogID}">
                        <input class="forms" type="text" id="postTitle" name="postTitle" value="{$title}">
    
                        <label for="postContent">Content</label>
                        <textarea class="forms" name="postContent" id="postContent">{$content}</textarea>
                        $errorTag
                        <button type="submit" name="update" class="updateButton">Update</button>
                        <button type="submit" name="delete" class="deleteButton">Delete</button>
                    </fieldset>
                </form>
            </div>
            END;
        
        return $html;
    }

    /**
     * Displays the blog page HTML.
     * 
     * @param BlogModel[] $blogModels An array of blogs.
     * 
     * @return string $content A string containing the blog page HTML.
     */
    public static function drawBlogSearch($blogModels, $isAuthed){
        $blogItem = "";
        $standardUserControls = "";
        $imgTag = "";
        $imageDirectory = "../public/img/uploads/medium/";

        if($isAuthed){
            $standardUserControls = <<<END
                <form type="hidden" method="POST" action="blog.php?newpost">
                    <input type="submit" name="newPostButton" class="newPostButton" value="New Post">
                </form>
                <form type="hidden" method="POST">
                    <select name="sortByDropDown" id="sortByDropDown">
                        <option value="default">Sort By</option>
                        <option value="title">Title</option>
                        <option value="date_time">Date</option>
                        <option value="user_name">User</option>
                    </select>

                    <input type="submit" class="submit" name="submit" value="Sort">
                </form>
                END;
        }

        if($blogModels){
            foreach($blogModels as $blogModel){
                $blogID = $blogModel->getBlogID();
                $title = $blogModel->getTitle();
                $date = $blogModel->getDate();
                $userID = $blogModel->getUserID(); // Needs to be joined to get the user name and display it on each item.
                $userName = $blogModel->getUserName();
                if($userName == null){
                    $userName = DBManager::getUserData($userID, UserField::UserName);
                }
                $fileName = $blogModel->getFileName();
                if($fileName){
                    $imagePath = $imageDirectory . $fileName;
                    $imgTag = <<<END
                        <img src="{$imagePath}"></img>
                        END;
                }

                $blogItem .= <<<END
                <div class="blog-item">
                    <h2>
                        <a href="blog.php?blog={$blogID}">{$imgTag}{$title}</a>
                    </h2>
                    <p class="date">{$date}</p>
                    <p>$userName</p>
                </div>
                END;
                $blogItem .= "\n";
            }
        }
        else{
            $blogItem = "No blogs found.";
        }


        $html = <<<END
        <main class="form-container profile">
            <h2 class="formTitle">Community Blogs</h2>
            <div class="blogPageContainer">
                <div class="blogSearchContainer">
                    $standardUserControls
                    <input type="text" name="blogSearch" class="blogSearch" placeholder="Search Blogs">
                    <input type="submit" name="blogSearchButton" class="blogSearchButton" value="Search">
                </div>
                <div class="blog-item-container">
                $blogItem
                </div>
            </div>
        </main>
        <script src="public/js/sortBlog.js"></script>
        END;

        return $html;
    }

    /**
     * Displays the blog post HTML
     * 
     * @param BlogModel $blogModel A blog.
     * @param int $limit Character limit to display. Default 'NULL'.
     * 
     * @return string $postMain A string containing the blog post page HTML.
     */
    public static function drawSingleBlog($blogModel, $isAuthed){
        $blogID = $blogModel->getBlogID();
        $title = $blogModel->getTitle();
        $date = $blogModel->getDate();
        $content = $blogModel->getContent();
        $standardUserControls = "";

        if($isAuthed){
            $standardUserControls = <<<END
            <div>
                <form method="POST" action="blog.php?edit={$blogID}">
                    <input type="submit" class="editButton" name="editButton" value="Edit">
                </form>
                <input type="submit" class="commentButton" name="commentButton" onClick="comment.js" value="Comment">
            </div>
            END;
        }

        $commentBlock = <<<END
        <div class="blog-item">
            <p class="date">{$date}</p>
            <p class="blogContent">{$content}</p>
        </div>
        END;

        $html = <<<END
        <main class="form-container profile">
            <h2 class="formTitle">Community Blogs</h2>
            <div class="blogPageContainer">
                <h2 class="recent-games-title">
                    <a href="blog.php?blog={$blogID}">{$title}</a>
                </h2>
                <div>
                    <div class="blog-item">
                        <p class="date">{$date}</p>
                        <p class="blogContent">{$content}</p>
                    </div>
                </div>
                $standardUserControls
            </div>
        </main>
        <script src="public/js/comment.js"></script>
        END;

        return $html;
    }
}