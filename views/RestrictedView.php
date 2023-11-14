<?php

require_once('models/BlogModel.php');
require_once('controllers/PageController.php');

/**
 * PageView displays the HTML markup.
 */
class RestrictedView{
    /**
     * Displays the profile HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the profile HTML.
     */
    public static function drawRestricted(){
        $unauthorized = "Access Restricted: Admin authentication required.";

        $content = <<<END
        <main class="content">
            <article>
                {$unauthorized}
            </article>
        </main>
END;

        return $content;
    }
}