<?php

return [

    /*
    |-------------------------------------------------------------------------
    | Navigation Defaults
    |--------------------------------------------------------------------------
    |
    | These options control the default navigation settings.  The array key in 
    | 'navigations' is the view you would like the navigation publishing to.
    | The value is used to group the navigaton items, this can be an array for
    | multiple navigations on the same view.
    |
    */

    'navigations' => [
        '_layouts.partials.navigation' => 'main',
        'admin._layouts.partials.navigation' => [
            'admin',
            'admin_shortcuts'
        ],
    ],
];
