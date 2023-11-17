<?php

/**
 * PageView displays the HTML markup.
 */
class LoginView{
    /**
     * Displays the login HTML.
     */
    public static function drawLogin(){
        $content = <<<END
        <main class="form-container">
            <h2 id="formTitle">Sign In</h2>
            <form method="POST" id="signInForm">
                <input type="text" id="username" name="username" placeholder="Username">
                <div class="error" id="usernameError">Username is required</div>

                <input type="password" id="password" name="password" placeholder="Password">
                <div class="error" id="passwordError">Password is required</div>
                
                <input type="submit" id="submit" name="submit" value="Submit">
                <span class="form-links">
                    <a href="forgot.php" id="passwordReset">Forgot Password?</a> |
                    <a href="register.php" id="registerLink">Register</a>
                </span>
            </form>
            <script src="public/js/login.js"></script>
        </main>
END;
        return $content;
    }
}

