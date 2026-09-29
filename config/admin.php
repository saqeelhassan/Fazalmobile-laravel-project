<?php

return [
    'seed' => [
        'name' => env('ADMIN_NAME', 'Admin'),
        'email' => env('ADMIN_EMAIL', 'admin@fazalmobiles.com'),

        // If ADMIN_PASSWORD isn't set on the server, the seeder falls back
        // to this known default so the admin account still gets created.
        // AdminUserSeeder forces a password change on first login whenever
        // this fallback is the one actually used.
        'password' => env('ADMIN_PASSWORD'),
        'default_password' => 'ChangeMe@123',
    ],
];
