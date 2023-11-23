<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * AdminView displays the HTML markup.
 */
class AdminView{

    // <div class="search-container">
    // <input type="text" size="30" onkeyup="showResult(this.value)">
    // <input type="submit" id="search" name="search" value="Search">
    // </div>  
    /**
     * Displays the admin page HTML.
     * 
     * @param 
     * 
     * @return string $content A string containing the admin page HTML.
     */
    public static function drawAdmin($users){
        $userRows = '';
    
        foreach ($users as $user) {
            $userName = $user->getUserName();
            $userRole = $user->getRole();
            $userEmail = $user->getEmail();
            $userID = $user->getUserID();
            $userRating = $user->getRating();

            // <select name="action">
            //     <option value="edit">Edit</option>
            //     <option value="delete">Delete</option>
            // </select>
    
            $userRows .= <<<END
                <tr>
                    <td>{$userName}</td>
                    <td>{$userRating}</td>
                    <td>{$userRole}</td>
                    <td>{$userEmail}</td>
                    <td class="userAction">
                        <input type="button" class="editUser" 
                            data-user-id="{$userID}" 
                            data-user-name="{$userName}" 
                            data-user-email="{$userEmail}" 
                            data-user-rating="{$userRating}" 
                            data-user-role="{$userRole}" value="Edit">
                        <input type="submit" class="deleteUser" name="deleteUser" data-user-id="{$userID}" value="Delete">
                    </td>
                </tr>
END;
        }
    
        $admin = <<<END
        <main class="form-container profile">
            <div class="addUserModal modal">
                <div class="modal-content">
                    <h2 class="formTitle">Admin Settings</h2>
                    <span class="addClose">&times;</span>
                    <div class="userDetails">
                        <h2 class="recent-games-title">Add User</h2>
                        <form method="POST" id="signInForm">
                            <input type="text" id="username" name="username" placeholder="Username">
                            <div class="error" id="usernameError">Username is required</div>
            
                            <input type="password" id="password" name="password" placeholder="Password">
                            <div class="error" id="passwordError">Password is required</div>
            
                            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                            <div class="error" id="confirmPasswordError">Password confirmation is required</div>
            
                            <input type="text" id="email" name="email" placeholder="Email">
                            <div class="error" id="emailError">Email is required</div>
            
                            <input type="submit" class="addUser" name="addUser" value="Add User">
                        </form>
                    </div>
                </div>
            </div>

            <div class="editUserModal modal">
                <div class="modal-content">
                    <h2 class="formTitle">Admin Settings</h2>
                    <span class="editClose">&times;</span>
                    <div class="userDetails">
                        <h2 class="recent-games-title">Edit User</h2>
                        <form method="POST" id="editUserForm">
                            <input type="hidden" id="editUserId" name="editUserId" value="">
                            <input type="text" id="editUserName" name="editUserName" placeholder="Username" value="test">
                            <div class="error" id="editUsernameError">Username is required</div>
                            
                            <input type="text" id="editEmail" name="editEmail" placeholder="Email" value="">
                            <div class="error" id="editEmailError">Email is required</div>

                            <input type="number" id="editRating" name="editRating" placeholder="Rating" value="">
                            
                            <input type="number" id="editRole" name="editRole" placeholder="Role" value="">
                            
                            <input type="submit" class="editUserSubmit" name="editUserSubmit" value="Submit">
                        </form>
                    </div>
                </div>
            </div>

            <div class="titleContainer">
                <h2 class="formTitle">Admin Panel</h2>
            </div>
            <div class="adminUserDetails">
                <h2 class="recent-games-title">User Details</h2>  
                <form action="admin.php" method="POST" name="userActionForm" class="userActionForm">
                    <table class="tablediv">
                        <thead>
                            <tr>
                                <th>UserName</th>
                                <th>Rating</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {$userRows}
                        </tbody>
                    </table>
                    <input type="hidden" name="userId" value="">
                </form>
                <input type="button" class="addUserBtn" name="addUser" value="Add User">
            </div>
        </main>
        <script src="public/js/register.js"></script>
        <script src="public/js/adminAction.js"></script>
END;
    
        return $admin;
    }
}

?>