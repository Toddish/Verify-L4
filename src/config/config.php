<?php

return array(

    // The db column to authenticate against
    'username' => array('email', 'username'),

    // The User mode to use
    'user_model' => 'Verify\Models\User',

    // The Super Admin role
    // (returns true for all permissions)
    'super_admin' => 'Super Admin',

    // DB prefix for tables
    'prefix' => ''

);