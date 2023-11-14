<?php

require_once('models/BlogModel.php');
require_once('controllers/PageController.php');

/**
 * PageView displays the HTML markup.
 */
class LearnView{
    /**
     * Displays the opening database search HTML.
     * 
     * @param string 
     * 
     * @return string 
     */
    public static function drawLearn(){
        $header = <<<END
        <main class="content">
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
            <script src="public/js/learn.js"></script>
        </main>
END;
        return $header;
    }
}