<?php

return [

    'command' => [
        
        /*
        |--------------------------------------------------------------------------
        | Default Command Bin
        |--------------------------------------------------------------------------
        |
        | Here you can specify which of the following command bin you want to use
        | to use as your default bin for command work. Of course
        | you can use many bin that LibreOffice --headless support.
        |
        */
        'default' => 'linux',

        'bin' => [
            'linux' => 'libreoffice',
            'windows' => 'c:\Program Files\LibreOffice\program\soffice',
        ]
    ],

    'temporary_files' => [

        /*
        |--------------------------------------------------------------------------
        | Local Temporary Path
        |--------------------------------------------------------------------------
        |
        | When converting files to pdf, we use a temporary file, before
        | file rendering. Here you can customize that path.
        |
        */
        'local_path'  => sys_get_temp_dir(),

        /*
        |--------------------------------------------------------------------------
        | Prefix Folder
        |--------------------------------------------------------------------------
        |
        | Folder where the converted files will be saved.
        | Here you can customize that folder name.
        |
        */
        'prefix_folder' => '/template-convert',

        /*
        |--------------------------------------------------------------------------
        | Delete Files After Rendering
        |--------------------------------------------------------------------------
        |
        | If this option is true, the files are removed once rendered
        |
        */
        'delete_after_rendering' => true,
    ],

    'to_words' => [

        /*
        |--------------------------------------------------------------------------
        | Currency
        |--------------------------------------------------------------------------
        |
        | This is the default currency that will be used when convert a number to words
        | from your application.
        |
        | For more information about the support: https://github.com/kwn/number-to-words
        |
        */

        'currency' => 'DOP',

         /*
        |--------------------------------------------------------------------------
        | Currency Locale
        |--------------------------------------------------------------------------
        |
        | This is the default locale in which your money values are formatted in
        | for display.
        |
        | For more information about the support: https://github.com/kwn/number-to-words
        |
        */

        'currency_locale' => 'es',

         /*
        |--------------------------------------------------------------------------
        | Currency Locale
        |--------------------------------------------------------------------------
        |
        | This is the currency symbol used in your application.
        |
        |
        */
        'currency_symbol' => 'RD$'

    ],
];
