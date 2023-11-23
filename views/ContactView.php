<?php

/**
 * PageView displays the HTML markup.
 */
class ContactView{
    /**
     * Displays the contact HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the contact HTML.
     */
    public static function drawContact(){
        $content = <<<END
        <main class="form-container">
            <h2 class="formTitle">Contact Us</h2>
            <form method="POST" id="contactForm">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="email@example.com">
                <div class="error" id="emailRequired_error">* Required field</div>
    
                <label for="comment">Comment</label>
                <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
                <div class="error" id="commentRequired_error">* Required field</div>
    
                <input type="submit" class="submit" name="submit" value="Submit">
                <input type="reset" class="reset" name="reset" value="Clear">
            </form>
        </main>
        <script src="public/js/contact.js"></script>
END;

        return $content;
    }
}