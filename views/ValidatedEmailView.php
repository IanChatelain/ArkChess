<?php

require_once ('controllers/PageController.php');

/**
 * PageView displays the HTML markup.
 */
class ValidatedEmailView{
    /**
     * Displays the profile HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the profile HTML.
     */
    public static function drawValidatedEmail($isValidated){
        $message = "Thank you for validating your email address!";
        $message2 = '<p><a href="profile.php">Click Here</a> to update your profile information.</p>';

        if(!$isValidated){
            $message = "You must validate your email before proceeding.";
            $message2 = "";
        }

        $profile = <<<END
        <main class="content">
            <article>
                <p>$message</p>
                $message2
            </article>
        </main>
END;

        return $profile;
    }
}