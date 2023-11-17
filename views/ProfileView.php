<?php

/**
 * PageView displays the HTML markup.
 */
class ProfileView{
    /**
     * Displays the profile HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the profile HTML.
     */
    public static function drawProfile($user){
        $userName = $user->getUserName();
        $rating = $user->getRating();

        $profile = <<<END
        <main class="content">
            <article>
                <h2>Profile Page</h2>
                <p>UserName: {$userName}</p>
                <p>Rating: {$rating}</p>
                <form method="POST">
                    <button id="logout" name="logout" type="submit">Log Out</button>
                </form>
            </article>
        </main>
END;

        return $profile;
    }
}