<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputArgument;

use Illuminate\Console\Command;

class Versioning extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'versioning:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and update app\'s version via git.';

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
     * @return void
     */
    public function fire()
    {

        $versionFile = 'config/version.php';
        $hash_version = str_replace("\n", '', shell_exec('git describe --tags'));

        $version = explode('-', $hash_version);

        $array = var_export(
            array(
            'app_version' => $version[0],
            'build_version' => $version[1],
            'hash_version' => $version[2],
            'full_hash' => $hash_version),
            true
        );


        // Construct our file content
            $content = <<<CON
<?php
return $array;
CON;

        // And finally write the file and output the current version
            \File::put($versionFile, $content);
            $this->line('Setting version: '. config('version.app_version').' build '.config('version.build_version').' ('.config('version.hash_version').')');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
        );
    }
}
