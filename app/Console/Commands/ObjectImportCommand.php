<?php
namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Importer\AccessoryImporter;
use App\Importer\AssetImporter;
use App\Importer\ConsumableImporter;
use App\Importer\Importer;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Company;
use App\Models\Consumable;
use App\Models\CustomField;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Setting;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use DB;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use League\Csv\Reader;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use ForceUTF8\Encoding;

ini_set('max_execution_time', 600); //600 seconds = 10 minutes
ini_set('memory_limit', '500M');

/**
 * Class ObjectImportCommand
 */
class ObjectImportCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'snipeit:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Items from CSV';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    private $bar;
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $filename = $this->argument('filename');
        $class = title_case($this->option('item-type'));
        $classString = "App\\Importer\\{$class}Importer";
        $importer = new $classString($filename);
        $importer->setCallbacks([$this, 'log'], [$this, 'progress'], [$this, 'errorCallback'])
                 ->setUserId($this->option('user_id'))
                 ->setUpdating($this->option('update'))
                 ->setUsernameFormat($this->option('username_format'));

        $logFile = $this->option('logfile');
        \Log::useFiles($logFile);
        $this->comment('======= Importing Items from '.$filename.' =========');
        $importer->import();

        $this->bar = null;

        if (!empty($this->errors)) {
            $this->comment("The following Errors were encountered.");
            foreach ($this->errors as $asset => $error) {
                $this->comment('Error: Item: ' . $asset . ' failed validation: ' . json_encode($error));
            }
        } else {
            $this->comment("All Items imported successfully!");
        }
        $this->comment("");

        return;
    }

    public function errorCallback($item, $field, $errorString)
    {
        $this->errors[$item->name][$field] = $errorString;
    }
    public function progress($count)
    {
        if (!$this->bar) {
            $this->bar = $this->output->createProgressBar($count);
        }
        static $index =0;
        $index++;
        if ($index < $count) {
            $this->bar->advance();
        } else {
            $this->bar->finish();
        }
    }
    // Tracks the current item for error messages
    private $updating;
    // An array of errors encountered while parsing
    private $errors;


    /**
     * Log a message to file, configurable by the --log-file parameter.
     * If a warning message is passed, we'll spit it to the console as well.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param string $string
     * @param string $level
    */
    public function log($string, $level = 'info')
    {
        if ($level === 'warning') {
            \Log::warning($string);
            $this->comment($string);
        } else {
            \Log::Info($string);
            if ($this->option('verbose')) {
                $this->comment($string);
            }
        }
    }
    /**
     * Get the console command arguments.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('filename', InputArgument::REQUIRED, 'File for the CSV import.'),
        );
    }


    /**
     * Get the console command options.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @return array
     */
    protected function getOptions()
    {
        return array(
        array('email_format', null, InputOption::VALUE_REQUIRED, 'The format of the email addresses that should be generated. Options are firstname.lastname, firstname, filastname', null),
        array('username_format', null, InputOption::VALUE_REQUIRED, 'The format of the username that should be generated. Options are firstname.lastname, firstname, filastname, email', null),
        array('logfile', null, InputOption::VALUE_REQUIRED, 'The path to log output to.  storage/logs/importer.log by default', storage_path('logs/importer.log') ),
        array('item-type', null, InputOption::VALUE_REQUIRED, 'Item Type To import.  Valid Options are Asset, Consumable, Accessory, License, or User', 'Asset'),
        array('web-importer', null, InputOption::VALUE_NONE, 'Internal: packages output for use with the web importer'),
        array('user_id', null, InputOption::VALUE_REQUIRED, 'ID of user creating items', 1),
        array('update', null, InputOption::VALUE_NONE, 'If a matching item is found, update item information'),
        );

    }
}
