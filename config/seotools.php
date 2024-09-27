<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "My-Spread Forum", // set false to total remove
            'titleBefore'  => "My-Spread Forum", // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => 'Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions', // set false to total remove
            'separator'    => ' | ',
            'keywords'     => ['myspread', 'my spread', 'my-spread', 'forum', 'my-spread forum'],
            'canonical'    => false, // Set null for using Url::current(), set false to total remove
            'robots'       => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'My-Spread Forum', // set false to total remove
            'description' => 'Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions', // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => false,
            'images'      => ['https://my-spread.com/img/map5.jpg'],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'My-Spread Forum', // set false to total remove
            'description' => 'Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions', // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
            'type'        => 'WebPage',
            'images'      => [],
        ],
    ],
];
