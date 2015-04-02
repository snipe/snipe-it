<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Table specific configuration options.
    |--------------------------------------------------------------------------
    |
    */

    'table' => array(

        /*
        |--------------------------------------------------------------------------
        | Table class
        |--------------------------------------------------------------------------
        |
        | Class(es) added to the table
        | Supported: string
        |
        */

        'class' => 'table table-bordered',

        /*
        |--------------------------------------------------------------------------
        | Table ID
        |--------------------------------------------------------------------------
        |
        | ID given to the table. Used for connecting the table and the Datatables
        | jQuery plugin. If left empty a random ID will be generated.
        | Supported: string
        |
        */

        'id' => '',

        /*
        |--------------------------------------------------------------------------
        | DataTable options
        |--------------------------------------------------------------------------
        |
        | jQuery dataTable plugin options. The array will be json_encoded and
        | passed through to the plugin. See https://datatables.net/usage/options
        | for more information.
        | Supported: array
        |
        */

        'options' => array(

            "pagingType" => "full_numbers",
            'processing'=>true,
            'language'=>array(
                   'processing'=>'<i class="fa fa-spinner fa-spin"></i> Loading...'
            ),
            'deferRender'=> true,
            'stateSave'=> true,
            'paging'=>true,
            'pageLength'=> Setting::getSettings()->per_page,
            'lengthMenu'=>array(array(10,25,50,75,100,125,150,-1), array(10,25,50,75,100,125,150,'All')),
            'tableTools' => array(
                'sSwfPath'=> Config::get('app.url').'/assets/swf/copy_csv_xls_pdf.swf',
                'aButtons'=>array(
                    array(
                        'sExtends'=>'copy',
                        'sButtonText'=>'Copy',
                        'mColumns'=>'visible',
                        'bFooter'=>false,
                        ),
                    array(
                        'sExtends'=>'print',
                        'sButtonText'=>'Print',
                        'mColumns'=>'visible',
                        'bShowAll'=>true,
                        ),
                    array(
                        'sExtends'=>'collection',
                        'sButtonText'=>'Export',
                        'aButtons'=>array(
                            array(
                                'sExtends'=>'csv',
                                'sButtonText'=>'csv',
                                'mColumns'=>'visible',
                                'bFooter'=>false,
                                ),
                            array(
                                'sExtends'=>'xls',
                                'sButtonText'=>'XLS',
                                'mColumns'=>'visible',
                                'bFooter'=>false,
                                ),
                            array(
                                'sExtends'=>'pdf',
                                'sButtonText'=>'PDF',
                                'mColumns'=>'visible',
                                'bFooter'=>false,
                                )
                            )
                        )
                    ) 
                ),

        ),

        /*
        |--------------------------------------------------------------------------
        | DataTable callbacks
        |--------------------------------------------------------------------------
        |
        | jQuery dataTable plugin callbacks. The array will be json_encoded and
        | passed through to the plugin. See https://datatables.net/usage/callbacks
        | for more information.
        | Supported: array
        |
        */

        'callbacks' => array(
            "stateSaveCallback"=>"function (oSettings, oData) {
                    localStorage.setItem('DataTables_'+window.location.pathname, JSON.stringify(oData));
                }",
            "stateLoadCallback"=>"function (oSettings) {
                    return JSON.parse(localStorage.getItem('DataTables_'+window.location.pathname));
                }",
        ),

        /*
        |--------------------------------------------------------------------------
        | Skip javascript in table template
        |--------------------------------------------------------------------------
        |
        | Determines if the template should echo the javascript
        | Supported: boolean
        |
        */

        'noScript' => false,


        /*
        |--------------------------------------------------------------------------
        | Table view
        |--------------------------------------------------------------------------
        |
        | Template used to render the table
        | Supported: string
        |
        */

        'table_view' => 'datatable::template',


        /*
        |--------------------------------------------------------------------------
        | Script view
        |--------------------------------------------------------------------------
        |
        | Template used to render the javascript
        | Supported: string
        |
        */

        'script_view' => 'datatable::javascript',


    ),


    /*
    |--------------------------------------------------------------------------
    | Engine specific configuration options.
    |--------------------------------------------------------------------------
    |
    */

    'engine' => array(

        /*
        |--------------------------------------------------------------------------
        | Search for exact words
        |--------------------------------------------------------------------------
        |
        | If the search should be done with exact matching
        | Supported: boolean
        |
        */

        'exactWordSearch' => false,
        
        /*
        |--------------------------------------------------------------------------
        | Enable to display all records.  
        |--------------------------------------------------------------------------
        |
        | Be careful! It may be overloaded with large record.
        | Supported: boolean
        |
        */
        'enableDisplayAll' => false,
        /*
        |--------------------------------------------------------------------------
        | Limit display when iDisplayLength invaild
        |--------------------------------------------------------------------------
        */
        'defaultDisplayLength' => 10,
    )


);
