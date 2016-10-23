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
        // Path to the file containing your version
        // This will be overwritten everything you commit a message
        $versionFile = 'config/version.php';

        // The git's output
        // get the argument passed in the git command
         $hash_version = $this->argument('app_version');

         // discard the commit hash
         $version = explode('-', $hash_version);
         $realVersion = $version[0];

         // save the version array to a variable
         $array = var_export(array('app_version' => $realVersion,'hash_version' => $hash_version), true);


        // Construct our file content
        $content = <<<CON
<?php
return $array;
CON;

        // And finally write the file and output the current version
        \File::put($versionFile, $content);
        $this->line('Setting version: '. \config('version.latest'));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('app_version', InputArgument::REQUIRED, 'version number is required.'),
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
