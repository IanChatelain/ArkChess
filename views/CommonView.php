<?php

require_once('controllers/PageController.php');

class CommonView{
    /**
     * Displays the header HTML.
     * 
     * @param string $title A string containging the blog title.
     * 
     * @return string $header A string containing the header HTML 
     */
    public static function drawHeader($title){
        $link = PageController::changeBannerLink()['link'];
        $linkText = PageController::changeBannerLink()['linkText'];
        $event = "openDropdown(event)";
        $onclick = "";

        if($link == "profile"){
            $link = "javascript:void(0)";
            $onclick = sprintf("onclick=%s", $event);
        }

        $header = <<<END
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" type="text/css" href="public/css/main.css">
                <link rel="stylesheet" type="text/css" href="public/css/board.css">
                <link rel="stylesheet" type="text/css" href="public/css/learn.css">
                <link rel="stylesheet" type="text/css" href="public/css/login.css">
                <link rel="stylesheet" type="text/css" href="public/css/admin.css">
                <link rel="stylesheet" type="text/css" href="public/css/blog.css">
                <link rel="stylesheet" type="text/css" href="public/css/adminModal.css">
                <link rel="stylesheet" type="text/css" href="public/css/chessboard-1.0.0.css">
                <title>ArkChess - {$title}</title>
            </head>
            <body>
                <div id="container">
                    <header id="banner">
                        <span class="span-hover"><a href="play.php"><img src="public/img/ArkChessLogoTransparentC9.png" alt="ArkChess Logo">ArkChess</a></span>
                        <nav aria-label="Top navigation">
                            <ul>
                                <li><a href="play.php">Play</a></li>
                                <li><a href="blog.php">Blogs</a></li>
                                <li><a href="learn.php">Learn</a></li>
                                <li><a href="{$link}.php" id="dynamicDropdown" {$onclick}>{$linkText}</a>
                                    <div id="dropdownContent" class="dropdown-content">
                                    </div>
                                </li>
                                <li><a href="contact.php">Contact Us</a></li>
                            </ul>
                        </nav>
                    </header>
END;

        return $header;
    }

    /**
     * Displays the footer HTML.
     * 
     * @return string $footer A string containing the footer HTML.
     */
    public static function drawFooter(){
        $link = PageController::changeBannerLink()['link'];
        $linkText = PageController::changeBannerLink()['linkText'];

        $footer = <<<END
                        <footer>
                            <nav aria-label="Bottom navigation">
                                <ul id="class="footer-links"">
                                    <li><a href="play.php">Play</a></li>
                                    <li><a href="blog.php">Blogs</a></li>
                                    <li><a href="learn.php">Learn</a></li>
                                    <li><a href="{$link}.php">{$linkText}</a></li>
                                    <li><a href="contact.php">Contact Us</a></li>
                                </ul>
                            </nav>
                        </footer>
                    </div>
                    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="crossorigin="anonymous">
                    </script>
                    <script src="public/js/chessboard-1.0.0.js"></script>
                    <script src="public/js/banner.js"></script>
                </body>
            </html>
END;

        return $footer;
    }
}

?>