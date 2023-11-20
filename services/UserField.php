<?php

enum UserField: string{
    case UserId = 'user_id';
    case UserName = 'user_name';
    case FirstName = 'first_name';
    case LastName = 'last_name';
    case Email = 'email';
    case Rating = 'rating';
    case Role = 'role_id';
    case All = '*';
}

?>