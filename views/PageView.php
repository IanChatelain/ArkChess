<?php

require_once('models/BlogModel.php');

/**
 * PageView displays the HTML markup.
 */
class PageView{

    /**
     * Displays the header HTML.
     * 
     * @param string $title A string containging the blog title.
     * 
     * @return string $header A string containing the header HTML 
     */
    public static function drawHeader($title, $auth = false){
        $authedHeader = <<<END
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="css/main.css">
            <link rel="stylesheet" type="text/css" href="css/board.css">
            <link rel="stylesheet" type="text/css" href="css/learn.css">
            <link rel="stylesheet" type="text/css" href="css/login.css">
            <link rel="stylesheet" type="text/css" href="css/contact.css">
            <link rel="stylesheet"
                href="https://unpkg.com/@chrisoakman/chessboardjs@1.0.0/dist/chessboard-1.0.0.min.css"
                integrity="sha384-q94+BZtLrkL1/ohfjR8c6L+A6qzNH9R2hBLwyoAfu3i/WCvQjzL2RQJ3uNHDISdU"
                crossorigin="anonymous">
            <script src="js/footerLogoSeparator.js"></script>
            <script src="js/login.js"></script>
            <script src="js/contact.js"></script>
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"
                integrity="sha384-ZvpUoO/+PpLXR1lu4jmpXWu80pZlYUAfxl5NsBMWOEPSjUn/6Z/hRTt8+pR6L4N2"
                crossorigin="anonymous">
            </script>
            <script src="https://unpkg.com/@chrisoakman/chessboardjs@1.0.0/dist/chessboard-1.0.0.min.js"
                integrity="sha384-8Vi8VHwn3vjQ9eUHUxex3JSN/NFqUg3QbPyX8kWyb93+8AC/pPWTzj+nHtbC5bxD"
                crossorigin="anonymous">
            </script>

            <title>ArkChess - {$title}</title>

            
        </head>
END;

        $notAuthedHeader = <<<END
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" type="text/css" href="css/main.css">
                <link rel="stylesheet" type="text/css" href="css/board.css">
                <link rel="stylesheet" type="text/css" href="css/learn.css">
                <link rel="stylesheet" type="text/css" href="css/login.css">
                <link rel="stylesheet" type="text/css" href="css/contact.css">
                <link rel="stylesheet"
                    href="https://unpkg.com/@chrisoakman/chessboardjs@1.0.0/dist/chessboard-1.0.0.min.css"
                    integrity="sha384-q94+BZtLrkL1/ohfjR8c6L+A6qzNH9R2hBLwyoAfu3i/WCvQjzL2RQJ3uNHDISdU"
                    crossorigin="anonymous">
                <script src="js/footerLogoSeparator.js"></script>
                <script src="js/login.js"></script>
                <script src="js/contact.js"></script>
                <script src="https://code.jquery.com/jquery-3.5.1.min.js"
                    integrity="sha384-ZvpUoO/+PpLXR1lu4jmpXWu80pZlYUAfxl5NsBMWOEPSjUn/6Z/hRTt8+pR6L4N2"
                    crossorigin="anonymous">
                </script>
                <script src="https://unpkg.com/@chrisoakman/chessboardjs@1.0.0/dist/chessboard-1.0.0.min.js"
                    integrity="sha384-8Vi8VHwn3vjQ9eUHUxex3JSN/NFqUg3QbPyX8kWyb93+8AC/pPWTzj+nHtbC5bxD"
                    crossorigin="anonymous">
                </script>

                <title>ArkChess - {$title}</title>

                
            </head>
END;

        if($auth){
            return $authedHeader;
        }
        else{
            return $notAuthedHeader;
        }
    }

    /**
     * Displays the banner HTML.
     * 
     * @return string $banner A string containing the banner HTML.
     */
    public static function drawBanner($auth = false){
        $userName = '';

        if(isset($_SESSION['USER_NAME'])){
            $userName = $_SESSION['USER_NAME'];
        }

        $authedBanner = <<<END
        <body>
            <div id="container">
                <header id="banner">
                    <span class="span-hover"><a href="play.php"><img src="img/ArkChessLogoTransparentC9.png" alt="ArkChess Logo">ArkChess</a></span>
                    <nav aria-label="Top navigation">
                        <ul>
                            <li><a href="play.php">Play</a></li>
                            <li><a href="blog.php">Blogs</a></li>
                            <li><a href="learn.php">Learn</a></li>
                            <li><a href="profile.php">{$userName}</a></li>
                            <li><a href="contact.php">Contact Us</a></li>
                        </ul>
                    </nav>
                </header>
                <main class="content" id="indexContent">
END;
        
        $notAuthedBanner = <<<END
            <body>
                <div id="container">
                    <header id="banner">
                        <span class="span-hover"><a href="play.php"><img src="img/ArkChessLogoTransparentC9.png" alt="ArkChess Logo">ArkChess</a></span>
                        <nav aria-label="Top navigation">
                            <ul>
                                <li><a href="play.php">Play</a></li>
                                <li><a href="blog.php">Blogs</a></li>
                                <li><a href="learn.php">Learn</a></li>
                                <li><a href="login.php">Sign In</a></li>
                                <li><a href="contact.php">Contact Us</a></li>
                            </ul>
                        </nav>
                    </header>
                    <main class="content" id="indexContent">
END;

        if($auth){
            return $authedBanner;
        }
        else{
            return $notAuthedBanner;
        }
    }

    /**
     * Displays the footer HTML.
     * 
     * @return string $footer A string containing the footer HTML.
     */
    public static function drawFooter($auth = false){
        $footer = <<<END
                        </main>

                        <footer>
                            <nav aria-label="Bottom navigation">
                                <ul id="footerul">
                                    <li><a href="play.php">Play</a></li>
                                    <li><a href="blog.php">Blogs</a></li>
                                    <li><a href="learn.php">Learn</a></li>
                                    <li><a href="login.php">Sign In</a></li>
                                    <li><a href="contact.php">Contact Us</a></li>
                                </ul>
                            </nav>
                        </footer>
                    </div>
                </body>
            </html>
END;

        return $footer;
    }

    /**
     * Displays the blog post HTML.
     * 
     * @param BlogModel $blogModel A blog.
     * @param bool $errorFlag
     * 
     * @return string $newPostMain A string containing the blog page HTML.
     */
    public static function drawNewPost($errorFlag, $blogModel, $auth = false){
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
    public static function drawEdit($errorFlag, $blogModel, $auth = false){
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
    public static function drawBlogIndex($blogModels, $auth = false){
        $content = '<div><h1>Recent Blogs<a id="newPost" href="blog.php?newpost">New Post</a></h1>';

        foreach($blogModels as $blogModel){
            $content = $content . self::drawPost($blogModel, 200);
        }

        if(empty($blogModels)){
            $content = $content . '<article class="blogs">No Blogs Exist.</article>';
        }

        $content = $content . '</div>';

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
    public static function drawPost($blogModel, $limit = NULL, $auth = false){
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

    /**
     * Displays the opening database search HTML.
     * 
     * @param string 
     * 
     * @return string 
     */
    public static function drawLearn($auth = false){
        $header = <<<END
            <article>
                <div id="search">
                    <div id="learnContentMenu">
                        <button class="learnMenuButton" name="openingSearch" type="button">Search</button>
                        <button class="learnMenuButton" name="openingExplore" type="button">Explore</button>
                    </div>
                    <div>
                        <h2>Opening Search</h2>
                    </div>
                    <div>
                        <form id="openingForm">
                            <input name="openingSearch" id="openingSearch">
                            <button type="submit">Search</button>
                        </form>
                    </div>
                </div>
                <div class="openingsContainer"></div>
                <p id="openingCredit">Data provided by <a id="lichessCredit" href="https://lichess.org/api">Lichess Opening Explorer database.</a></p>
            </article>  
            <script src="https://cdnjs.cloudflare.com/ajax/libs/chess.js/0.10.3/chess.min.js"></script>
            <script src="js/learn.js"></script>
END;
        return $header;
    }

    /**
     * Displays the play page HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the play page HTML.
     */
    public static function drawPlay($auth = false){
        return self::drawBoard();
    }

    /**
     * Displays the board HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the board HTML.
     */
    public static function drawBoard($auth = false){
        $content = <<<END
            <article>
                <div id="playBoard">
                    <script src="js/playBoard.js"></script>
                </div>
            </article>
END;

        return $content;
    }

    /**
     * Displays the login HTML.
     */
    public static function drawLogin($auth = false){
        $content = <<<END
            <div id="contentMenu">
                <button class="menuButton" name="signIn" type="button">Sign In</button>
                <button class="menuButton" name="register" type="button">Register</button>
            </div>
            <form id="signinForm" action="#" method="POST">
                    <fieldset>
                        <label for="username">Username</label>
                        <input class="forms" type="text" id="username" name="username" placeholder="ChessUser1">
                        <p class="error" id="usernameRequired_error">* Required field</p>
                        <p class="error" id="usernameInvalid_error">* Please enter a valid username</p>

                        <label for="password">Password</label>
                        <input class="forms" type="text" id="password" name="password" placeholder="Ilovechess1337!">
                        <p class="error" id="passwordRequired_error">* Required field</p>
                        <p id="passwordErrorMarker"></p>

                        <label id="emailLabel" for="email">Email</label>
                        <input class="forms" type="text" id="email" name="email" placeholder="email@example.com">
                        <p class="error" id="emailRequired_error">* Required field</p>
                        <p class="error" id="emailInvalid_error">* Please enter a valid email</p>

                        <button name="login" type="submit" class="defaultButton">Submit</button>
                    </fieldset>
                </form>
                <script src="js/login.js"></script>
END;
        return $content;
    }

    /**
     * Displays the contact HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the contact HTML.
     */
    public static function drawContact($auth = false){
        $content = <<<END
            <article>
                <form id="contactForm" onsubmit="return validate(e)" method="post">
                    <fieldset>
                        <label for="name">Name</label>
                        <input class="forms" type="text" id="name" name="name" placeholder="Full Name">
                        <p class="error" id="nameRequired_error">* Required field</p>
                        <p class="error" id="nameInvalid_error">* Please enter a valid name</p>

                        <label for="phoneNumber">Phone Number</label>
                        <input class="forms" type="text" id="phoneNumber" name="phoneNumber" placeholder="(204)555-1234">
                        <p class="error" id="phoneNumberRequired_error">* Required field</p>
                        <p class="error" id="phoneNumberInvalid_error">* Please enter a valid phone number</p>


                        <label for="email">Email</label>
                        <input class="forms" type="text" id="email" name="email" placeholder="email@example.com">
                        <p class="error" id="emailRequired_error">* Required field</p>
                        <p class="error" id="emailInvalid_error">* Please enter a valid email</p>


                        <label for="comment">Comment</label>
                        <textarea class="forms" name="comment" id="comment" cols="30" rows="10"></textarea>
                        <p class="error" id="commentRequired_error">* Required field</p>
                        <p class="error" id="commentInvalid_error">* Please enter a valid name</p>

                        <button type="submit" id="submit" class="defaultButton">Submit</button>
                        <button type="reset" id="clear" class="defaultButton">Clear</button>
                    </fieldset>
                </form>
            </article>
END;

        return $content;
    }

    /**
     * Displays the profile HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the profile HTML.
     */
    public static function drawProfile($user, $auth = false){
        $userName = $user->getUserName();
        $rating = $user->getRating();

        $notAuthedContent = <<<END
            <article>
                <p>Not logged in <a href="login.php">click here</a> to log in.</p>
            </article>
END;

        $authedContent = <<<END
            <article>
                <h2>Profile Page</h2>
                <p>UserName: {$userName}</p>
                <p>Rating: {$rating}</p>
                <form method="POST" action="#">
                    <button id="logout" name="logout" type="submit">Log Out</button>
                </form>
            </article>
END;

        if($auth){
            return $authedContent;
        }
        else{
            return $content;
        }
    }

    
    /**
     * Displays the profile HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the profile HTML.
     */
    public static function drawRestricted($auth = false){
        $unauthorized = "Access Denied: Admin authentication required.";

        $content = <<<END
            <article>
                {$unauthorized}
            </article>
END;

        return $content;
    }
}

?>