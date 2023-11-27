<?php

/**
 * PageView displays the HTML markup.
 */
class NotFoundView{
    /**
     * Displays the profile HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the profile HTML.
     */
    public static function drawNotFound(){
        $unauthorized = "404: Page Not Found.";

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