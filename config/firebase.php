<?php

return [

    'credentials' => [
        'file' => env('FIREBASE_CREDENTIALS', storage_path('app/firebase-credentials.json')),
        // Or use JSON string: env('FIREBASE_CREDENTIALS_JSON')
    ],

];
