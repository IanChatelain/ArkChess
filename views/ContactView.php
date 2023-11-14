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
        <main class="content">
            <article>
                <form id="contactForm" onsubmit="return validate(e)" method="post">
                    <fieldset>
                        <label for="name">Name</label>
                        <input class="forms" type="text" id="name" name="name" placeholder="Full Name">
                        <p class="error" id="nameRequired_error">* Required field</p>
                        <p class="error" id="nameInvalid_error">* Please enter a valid name</p>

                        <label for="phoneNumber">Phone Number</label>
                        <input class="forms" type="text" id="phoneNumber" name="phoneNumber" placeholder="(204)555-1234">
                        <p class="error" id="phoneNumberRequired_error">* Required field</p>
                        <p class="error" id="phoneNumberInvalid_error">* Please enter a valid phone number</p>


                        <label for="email">Email</label>
                        <input class="forms" type="text" id="email" name="email" placeholder="email@example.com">
                        <p class="error" id="emailRequired_error">* Required field</p>
                        <p class="error" id="emailInvalid_error">* Please enter a valid email</p>


                        <label for="comment">Comment</label>
                        <textarea class="forms" name="comment" id="comment" cols="30" rows="10"></textarea>
                        <p class="error" id="commentRequired_error">* Required field</p>
                        <p class="error" id="commentInvalid_error">* Please enter a valid name</p>

                        <button type="submit" id="submit" class="defaultButton">Submit</button>
                        <button type="reset" id="clear" class="defaultButton">Clear</button>
                    </fieldset>
                </form>
            </article>
        </main>
END;

        return $content;
    }
}