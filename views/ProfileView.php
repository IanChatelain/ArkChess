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
        <main class="form-container" id="profile">
            <div class="title-container">
                <h2 class="formTitle">{$userName}'s Profile</h2>
            </div>
            <div class="user-details">
                <!-- User details here -->
                <p>UserName: {$userName}</p>
                <p>Rating: {$rating}</p>
                <input type="submit" id="submit" name="submit" value="Logout">
            </div>
            <div class="recent-games-container">
                <!-- Recent games here -->
                <h2 class="recent-games-title">Recent Games</h2>
                <div class="recent-game-item">
                    <p>Game 1</p>
                </div>
                <div class="recent-game-item">
                    <p>Game 2</p>
                </div>
                <!-- Add more game items as needed -->
            </div>
        </main>
END;

        return $profile;
    }
}