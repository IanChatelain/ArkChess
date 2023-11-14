<?php

require_once('models/BlogModel.php');
require_once('controllers/PageController.php');

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
            <div id="signInForm">
                <input type="text" id="username" placeholder="Username">
                <div class="error" id="usernameError">Username is required</div>
                <input type="password" id="password" placeholder="Password">
                <div class="error" id="passwordError">Password is required</div>
                <input type="submit" id="submit" value="Submit">
                <span class="form-links">
                    <a href="/password-reset" id="passwordReset">Forgot Password?</a> |
                    <a href="/register" id="registerLink">Register</a>
                </span>
            </div>
            <script src="public/js/login.js"></script>
        </main>
END;
        return $content;
    }
}

