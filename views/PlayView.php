<?php

/**
 * PageView displays the HTML markup.
 */
class PlayView{
    /**
     * Displays the play page HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the play page HTML.
     */
    public static function drawPlay(){
        return self::drawBoard();
    }

    /**
     * Displays the board HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the board HTML.
     */
    public static function drawBoard(){
        $content = <<<END
        <main class="content">
            <article>
                <div id="playBoard">
                    <script src="public/js/playBoard.js"></script>
                </div>
            </article>
        </main>
END;

        return $content;
    }
}