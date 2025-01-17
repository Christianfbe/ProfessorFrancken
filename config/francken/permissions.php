<?php

declare(strict_types=1);

// policies, gate, permissions
return [
    'web' => [
        'super-admin-read',
        'super-admin-write',

        /**
         * These are permissions that should only be given to members having the
         * board role
         */
        'board',
        'board-president',
        'board-secretary',
        'board-treasurer',
        'board-external-relations',
        'board-internal-relations',

        'can-access-dashboard',

        'dashboard:news-read',
        'dashboard:news-write',

        'dashboard:francken-vrij-read',
        'dashboard:francken-vrij-write',

        'dashboard:francken-vrij-subscriptions-read',
        'dashboard:francken-vrij-subscriptions-write',

        'dashboard:registrations-read',
        'dashboard:registrations-write',

        'dashboard:members-read',
        'dashboard:members-write',

        'dashboard:activities-read',
        'dashboard:activities-write',

        'dashboard:photos-read',
        'dashboard:photos-write',

        'dashboard:board-members-read',
        'dashboard:board-members-write',

        'dashboard:committees-read',
        'dashboard:committees-write',

        'dashboard:books-read',
        'dashboard:books-write',

        'dashboard:symposia-read',
        'dashboard:symposia-write',

        'dashboard:pages-read',
        'dashboard:pages-write',

        'dashboard:companies-read',
        'dashboard:companies--write',

        'dashboard:fact-sheet-read',

        'dashboard:settings-read',
        'dashboard:settings-write',

        'dashboard:accounts-read',
        'dashboard:accounts-write',

        'dashboard:permissions-read',
        'dashboard:permissions-write',

        'dashboard:alumni-activity',

        // Given when a member activates their borrelcie account
        'borrelcie',
    ],

    'api' => [
        'plus-one-read',
        'plus-one-write',

        'register-symposium',
        'register-symposium',
    ]
];
