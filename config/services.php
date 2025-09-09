<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'linkedin' => [
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'scopes' => 'r_emailaddress,r_liteprofile,w_member_social',
        'redirect' => env('LINKEDIN_URL'),
        'redirect_code' => env('LINKEDIN_CODE_URL'),
        'id' => 'V7fZKXYarm',
        //        'id' => 'VicKyiOTqa',
        'token' => 'AQUCza2zqDuoJbstt3la7s6IYgoT2yDefUA08xdDO-dtsqZH687hiT6IYyjpUQxIw4y2v4gNIeQuYk_FSTqIVZ_H8CsUX5gXM7P4tSynoXPu48I7gvVUgNTQzRw5FTRTnkLPOwjmRLiFBeIL4msosK7Ysi5s5OsWb8Qk7Srgrxkg3F7JjJDgOACDDMeWZW95EUHO3G5tScHliFAM2ON8k-6MgWxwCFNaIFb4wpxaRRv9y0wUiVpI2QFB3le5qBHGK0OLlV9MiE9jy2-xPMJsTWlNBstqa-b09IqPRKMEh3a6W65qM7LD3fLvq4LRMrsdC86MG5O4qHTUjBjmvm8NeGrpnDX98g',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET')
    ],
    'recaptcha' => [
        'site_key' => env('RECAPTCHA_SITE_KEY'),
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    ],


];
