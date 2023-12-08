<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * PageView displays the HTML markup.
 */
class LoginView{
    /**
     * Displays the login HTML.
     */
    public static function drawLogin(){
        
        $errorMessage = Utility::getFlashMessage('login_error');

        $content = <<<END
        <main class="form-container">
            <h2 class="formTitle">Sign In</h2>
            <form method="POST" id="signInForm">
                <input type="text" id="username" name="username" placeholder="Username">
                <div class="error" id="usernameError">Username is required</div>

END;
        // TODO: Rework this like new blog.
        if ($errorMessage !== '' && $errorMessage !== null) {
            $content .= '<div class="error" id="loginError">' . htmlspecialchars($errorMessage) . '</div>';
        }

        $content .= <<<END
                <input type="password" id="password" name="password" placeholder="Password">
                <div class="error" id="passwordError">Password is required</div>
                
                <input type="submit" class="submit" name="login" value="Sign In">
                <span class="form-links">
                    <a href="forgot.php" id="passwordReset">Forgot Password?</a>
                    <a href="register.php" id="registerLink">Register</a>
                </span>
            </form>
            <script src="public/js/login.js"></script>
        </main>
END;
        return $content;
    }
}

