<?php

/**
 * PageView displays the HTML markup.
 */
class RegisterView{
    /**
     * Displays the register HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the register HTML.
     */
    public static function drawRegister(){
        $content = <<<END
        <main class="form-container">
            <h2 id="formTitle">Register</h2>
            <form method="POST" id="signInForm">
                <input type="text" id="username" name="username" placeholder="Username">
                <div class="error" id="usernameError">Username is required</div>

                <input type="password" id="password" name="password" placeholder="Password">
                <div class="error" id="passwordError">Password is required</div>

                <input type="text" id="email" name="email" placeholder="Email">
                <div class="error" id="emailError">Email is required</div>

                <input type="submit" id="submit" name="register" value="Submit">
                <span class="form-links">
                    <a href="forgot.php" id="passwordReset">Forgot Password?</a> |
                    <a href="register.php" id="registerLink">Register</a>
                </span>
            </form>
            <script src="public/js/register.js"></script>
        </main>
END;

        return $content;
    }
}