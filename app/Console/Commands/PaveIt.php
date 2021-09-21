<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\CustomField;
use Schema;
use DB;
use Illuminate\Console\Command;

class PaveIt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:pave';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the database tables, leaving all migrations, table structure, and the first user in place. (It is primarily a quick tool for developers.) If you want to destroy all tables as well, use php artisan db:wipe.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm("\n****************************************************\nTHIS WILL DELETE ALL OF THE DATA IN YOUR DATABASE. \nThere is NO undo. This WILL destroy ALL of your data. \n****************************************************\n\nDo you wish to continue? No backsies! [y|N]")) {

            // List all the tables in the database so we don't have to worry about missing some as the app grows
            $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

            $except_tables = [
                'oauth_access_tokens',
                'oauth_clients',
                'oauth_personal_access_clients',
                'migrations',
                'settings',
                'users',
            ];

            // We only need to find out what these are so we can nuke these columns on the assets table.
            $custom_fields = CustomField::get();
            foreach ($custom_fields as $custom_field) {
                $this->info('Drop the '.$custom_field->db_column.' column from assets as well.');

                if (\Schema::hasColumn('assets', $custom_field->db_column)) {
                    \Schema::table('assets', function ($table) use ($custom_field) {
                        $table->dropColumn($custom_field->db_column);
                    });
                }
            }

            foreach ($tables as $table) {
                if (in_array($table, $except_tables)) {
                    $this->info('Table '. $table. ' is skipped');
                } else {
                    \DB::statement('truncate '.$table);
                    $this->info('Table '. $table. ' is truncated');
                }
            }

            // Leave in the demo oauth keys so we don't have to reset them every day in the demos
            //\DB::statement('delete from users WHERE id > 2');
            \DB::statement('delete from oauth_clients WHERE id > 2');
            \DB::statement('delete from oauth_access_tokens WHERE id > 2');
        }
    }
}