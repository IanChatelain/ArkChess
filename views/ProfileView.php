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
            <div class="titleContainer">
                <h2 id="formTitle">{$userName}</h2>
            </div>
            <div class="profileContent">
                <div class="recent-games-container">
                    <h2 class="recent-games-title">Recent Games</h2>
                    <div class="recent-game-item">
                        <!-- Game details here -->
                        <p>Game 1</p>
                    </div>
                    <div class="recent-game-item">
                        <!-- Game details here -->
                        <p>Game 2</p>
                    </div>
                    <div class="recent-game-item">
                        <!-- Game details here -->
                    <p>Game 2</p>
                </div>
                </div>
                <div class="userDetails">
                    <h2 class="recent-games-title">User Details</h2>
                    <p class="userDetail rating"><span class="label">Bullet:</span> {$rating}</p>
                    <p class="userDetail rating"><span class="label">Blitz:</span> 800</p>
                    <p class="userDetail rating"><span class="label">Rapid:</span> 1200</p>
                </div>
            </div>
            <div class="logoutContainer">
                <form method="POST">
                    <input type="submit" id="submit" name="submit" value="Logout">
                </form>
            </div>
        </main>
END;

        return $profile;
    }
}

?>