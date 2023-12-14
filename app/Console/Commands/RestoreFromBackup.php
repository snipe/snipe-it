<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;

class RestoreFromBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:restore 
                                            {--force : Skip the danger prompt; assuming you enter "y"} 
                                            {filename? : The zip file to be migrated}
                                            {--no-progress : Don\'t show a progress bar}
                                            {--sanitize-only : Sanitize and return SQL from STDIN}
                                            {--prefix= : Don\'t guess DB table prefix; use the passed-in one (or none if just \'--prefix=\' is passed) }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore from a previously created Snipe-IT backup file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public static $buffer_size = 1024 * 1024;  // use a 1MB buffer, ought to work fine for most cases?
    public static $prefix = null;
    public static $tablenames = [];


    public static function parse_sql(string $line,bool $should_guess = false): string
    {
        static $is_permitted = false;
        // 'continuation' lines for a permitted statement are PERMITTED.
        if($is_permitted && $line[0] === ' ') {
            return $line;
        }

        $table_regex = '`?([a-zA-Z0-9_]+)`?';
        $allowed_statements = [
            "/^(DROP TABLE (?:IF EXISTS )?)`$table_regex(.*)$/" => false,
            "/^(CREATE TABLE )$table_regex(.*)$/" => true, //sets up 'continuation'
            "/^(LOCK TABLES )$table_regex(.*)$/" => false,
            "/^(INSERT INTO )$table_regex(.*)$/" => false,
            "/^UNLOCK TABLES/" => false,
            "/^\\) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;/" => false, // FIXME not sure what to do here?
            // ^^^^^^ that bit should *exit* the 'perimitted' black
        ];

        foreach($allowed_statements as $statement => $statechange) {
//            $this->info("Checking regex: $statement...\n");
            $matches = [];
            if (preg_match($statement,$line,$matches)) {
                $is_permitted = $statechange;
                // matches are: 1 => first part of the statement, 2 => tablename, 3 => rest of statement
                // (with of course 0 being "the whole match")
                if (@$matches[2]) {
                    print "Found a tablename! It's: ".$matches[2]."\n";
                    if ($should_guess) {
                        @self::$tablenames[$matches[2]] += 1;
                        continue; //oh? FIXME
                    } else {
                        $cleaned_tablename = \DB::getTablePrefix().preg_replace('/^'.self::$prefix,'',$matches[2]);
                        $line = preg_replace($statement,'$1`'.$cleaned_tablename.'`$3' , $line);
                    }
                } else {
                    // no explicit tablename in this one, leave the line alone
                }
                //how do we *replace* the tablename?
                print "RETURNING LINE: $line";
                return $line;
            }
        }
        // all that is not allowed is denied.
        return "";
    }

    public function guess_prefix($stream) //FIXME - oustream? I dunno
    {
        // try to determine prefix, I guess?
        // should probably turn this into an instance method? Not sure.
        // something where we can run this, pipe output to /dev/null? Dunno.
        $bytes_read = 0;
        $reading_beginning_of_line = true;

        while (($buffer = fgets($stream, self::$buffer_size)) !== false) { // FIXME this is copied, can we re-use?
            $bytes_read += strlen($buffer);
            if ($reading_beginning_of_line) {
                $cleaned_buffer = self::parse_sql($buffer,true); //this isn't quite right?
                fputs(STDOUT,$cleaned_buffer);
            }
            // if we got a newline at the end of this, then the _next_ read is the beginning of a line
            if($buffer[strlen($buffer)-1] === "\n") {
                $reading_beginning_of_line = true;
            } else {
                $reading_beginning_of_line = false;
            }

        }
        print_r(self::$tablenames);

        $check_tables = ['settings' => null, 'migrations' => null /* 'assets' => null */];
        //can't use 'users' because the 'accessories_users' table?
        // can't use 'assets' because 'ver1_components_assets'
        foreach($check_tables as $check_table => $_ignore) {
            foreach (self::$tablenames as $tablename => $_count) {
//                print "Comparing $tablename to $check_table\n";
                if (str_ends_with($tablename,$check_table)) {
//                    print "Found one!\n";
                    $check_tables[$check_table] = substr($tablename,0,-strlen($check_table));
                }
            }
        }
        $guessed_prefix = null;
        foreach ($check_tables as $clean_table => $prefix_guess) {
            if(is_null($prefix_guess)) {
                print("Couldn't find table $clean_table\n");
                die();
            }
            if(is_null($guessed_prefix)) {
                $guessed_prefix = $prefix_guess;
            } else {
                if ($guessed_prefix != $prefix_guess) {
                    print("Prefix mismatch! Had guessed $guessed_prefix but got $prefix_guess\n");
                    die();
                }
            }
        }
        print "CALCULATED PREFIX: $guessed_prefix\n";
        self::$prefix = $guessed_prefix;
        print_r($check_tables);

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ( $this->option('prefix') ) {
            self::$prefix = $this->option('prefix');
        }

        if ($this->option('sanitize-only')) {
            if ( !self::$prefix) {
                $this->guess_prefix(STDIN);
            }
            // for 'sanitize-only' - do we have to do something weird here, piping stuff around to stdin and stdout?
            print "FINAL PREFIX IS: ".self::$prefix."\n";
            return true;
        }
        $dir = getcwd();
        if( $dir != base_path() ) { // usually only the case when running via webserver, not via command-line
            \Log::debug("Current working directory is: $dir, changing directory to: ".base_path());
            chdir(base_path()); // TODO - is this *safe* to change on a running script?!
        }
        //
        $filename = $this->argument('filename');

        if (! $filename) {
            return $this->error('Missing required filename');
        }

        if (! $this->option('force') && ! $this->confirm('Are you sure you wish to restore from the given backup file? This can lead to MASSIVE DATA LOSS!')) {
            return $this->error('Data loss not confirmed');
        }

        if (config('database.default') != 'mysql') {
            return $this->error('DB_CONNECTION must be MySQL in order to perform a restore. Detected: '.config('database.default'));
        }

        $za = new ZipArchive();

        $errcode = $za->open($filename/* , ZipArchive::RDONLY */); // that constant only exists in PHP 7.4 and higher
        if ($errcode !== true) {
            $errors = [
                ZipArchive::ER_EXISTS => 'File already exists.',
                ZipArchive::ER_INCONS => 'Zip archive inconsistent.',
                ZipArchive::ER_INVAL => 'Invalid argument.',
                ZipArchive::ER_MEMORY => 'Malloc failure.',
                ZipArchive::ER_NOENT => 'No such file ('.$filename.') in directory '.$dir.'.',
                ZipArchive::ER_NOZIP => 'Not a zip archive.',
                ZipArchive::ER_OPEN => "Can't open file.",
                ZipArchive::ER_READ => 'Read error.',
                ZipArchive::ER_SEEK => 'Seek error.',
            ];

            return $this->error('Could not access file: '.$filename.' - '.array_key_exists($errcode, $errors) ? $errors[$errcode] : " Unknown reason: $errcode");
        }


        $private_dirs = [
            'storage/private_uploads/accessories',
            'storage/private_uploads/assetmodels',
            'storage/private_uploads/assets', // these are asset _files_, not the pictures.
            'storage/private_uploads/audits',
            'storage/private_uploads/components',
            'storage/private_uploads/consumables',
            'storage/private_uploads/eula-pdfs',
            'storage/private_uploads/imports',
            'storage/private_uploads/licenses',
            'storage/private_uploads/signatures',
            'storage/private_uploads/users',
        ];
        $private_files = [
            'storage/oauth-private.key',
            'storage/oauth-public.key',
        ];
        $public_dirs = [
            'public/uploads/accessories',
            'public/uploads/assets', // these are asset _pictures_, not asset files
            'public/uploads/avatars',
            //'public/uploads/barcodes', // we don't want this, let the barcodes be regenerated
            'public/uploads/categories',
            'public/uploads/companies',
            'public/uploads/components',
            'public/uploads/consumables',
            'public/uploads/departments',
            'public/uploads/locations',
            'public/uploads/manufacturers',
            'public/uploads/models',
            'public/uploads/suppliers',
        ];

        $public_files = [
            'public/uploads/logo.*',
            'public/uploads/setting-email_logo*',
            'public/uploads/setting-label_logo*',
            'public/uploads/setting-logo*',
            'public/uploads/favicon.*',
            'public/uploads/favicon-uploaded.*',
        ];

        $all_files = $private_dirs + $public_dirs;

        $sqlfiles = [];
        $sqlfile_indices = [];

        $interesting_files = [];
        $boring_files = [];

        for ($i = 0; $i < $za->numFiles; $i++) {
            $stat_results = $za->statIndex($i);
            // echo "index: $i\n";
            // print_r($stat_results);

            $raw_path = $stat_results['name'];
            if (strpos($raw_path, '\\') !== false) { //found a backslash, swap it to forward-slash
                $raw_path = strtr($raw_path, '\\', '/');
                //print "Translating file: ".$stat_results['name']." to: ".$raw_path."\n";
            }

            // skip macOS resource fork files (?!?!?!)
            if (strpos($raw_path, '__MACOSX') !== false && strpos($raw_path, '._') !== false) {
                //print "SKIPPING macOS Resource fork file: $raw_path\n";
                $boring_files[] = $raw_path;
                continue;
            }
            if (@pathinfo($raw_path, PATHINFO_EXTENSION) == 'sql') {
                \Log::debug("Found a sql file!");
                $sqlfiles[] = $raw_path;
                $sqlfile_indices[] = $i;
                continue;
            }

            foreach (array_merge($private_dirs, $public_dirs) as $dir) {
                $last_pos = strrpos($raw_path, $dir.'/');
                if ($last_pos !== false) {
                    //print("INTERESTING - last_pos is $last_pos when searching $raw_path for $dir - last_pos+strlen(\$dir) is: ".($last_pos+strlen($dir))." and strlen(\$rawpath) is: ".strlen($raw_path)."\n");
                    //print("We would copy $raw_path to $dir.\n"); //FIXME append to a path?
                    $interesting_files[$raw_path] = ['dest' =>$dir, 'index' => $i];
                    continue 2;
                    if ($last_pos + strlen($dir) + 1 == strlen($raw_path)) {
                        // we don't care about that; we just want files with the appropriate prefix
                        //print("FOUND THE EXACT DIRECTORY: $dir AT: $raw_path!!!\n");
                    }
                }
            }
            $good_extensions = ['png', 'gif', 'jpg', 'svg', 'jpeg', 'doc', 'docx', 'pdf', 'txt',
                                'zip', 'rar', 'xls', 'xlsx', 'lic', 'xml', 'rtf', 'webp', 'key', 'ico', ];
            foreach (array_merge($private_files, $public_files) as $file) {
                $has_wildcard = (strpos($file, '*') !== false);
                if ($has_wildcard) {
                    $file = substr($file, 0, -1); //trim last character (which should be the wildcard)
                }
                $last_pos = strrpos($raw_path, $file); // no trailing slash!
                if ($last_pos !== false) {
                    $extension = strtolower(pathinfo($raw_path, PATHINFO_EXTENSION));
                    if (! in_array($extension, $good_extensions)) {
                        $this->warn('Potentially unsafe file '.$raw_path.' is being skipped');
                        $boring_files[] = $raw_path;
                        continue 2;
                    }
                    //print("INTERESTING - last_pos is $last_pos when searching $raw_path for $file - last_pos+strlen(\$file) is: ".($last_pos+strlen($file))." and strlen(\$rawpath) is: ".strlen($raw_path)."\n");
                    //no wildcards found in $file, process 'normally'
                    if ($last_pos + strlen($file) == strlen($raw_path) || $has_wildcard) { //again, no trailing slash. or this is a wildcard and we just take it.
                        // print("FOUND THE EXACT FILE: $file AT: $raw_path!!!\n"); //we *do* care about this, though.
                        $interesting_files[$raw_path] = ['dest' => dirname($file), 'index' => $i];
                        continue 2;
                    }
                }
            }
            $boring_files[] = $raw_path; //if we've gotten to here and haven't continue'ed our way into the next iteration, we don't want this file
        } // end of pre-processing the ZIP file for-loop

        // print_r($interesting_files);exit(-1);

        if (count($sqlfiles) != 1) {
            return $this->error('There should be exactly *one* sql backup file found, found: '.(count($sqlfiles) == 0 ? 'None' : implode(', ', $sqlfiles)));
        }

        if (strpos($sqlfiles[0], 'db-dumps') === false) {
            //return $this->error("SQL backup file is missing 'db-dumps' component of full pathname: ".$sqlfiles[0]);
            //older Snipe-IT installs don't have the db-dumps subdirectory component
        }

        //how to invoke the restore?
        $pipes = [];

        $env_vars = getenv();
        $env_vars['MYSQL_PWD'] = config('database.connections.mysql.password');
        // TODO notes: we are stealing the dump_binary_path (which *probably* also has your copy of the mysql binary in it. But it might not, so we might need to extend this)
        //             we unilaterally prepend a slash to the `mysql` command. This might mean your path could look like /blah/blah/blah//mysql - which should be fine. But maybe in some environments it isn't?
        $mysql_binary = config('database.connections.mysql.dump.dump_binary_path').\DIRECTORY_SEPARATOR.'mysql'.(\DIRECTORY_SEPARATOR == '\\' ? ".exe" : "");
        if( ! file_exists($mysql_binary) ) {
            return $this->error("mysql tool at: '$mysql_binary' does not exist, cannot restore. Please edit DB_DUMP_PATH in your .env to point to a directory that contains the mysqldump and mysql binary");
        }
        $proc_results = proc_open("$mysql_binary -h ".escapeshellarg(config('database.connections.mysql.host')).' -u '.escapeshellarg(config('database.connections.mysql.username')).' '.escapeshellarg(config('database.connections.mysql.database')), // yanked -p since we pass via ENV
                                  [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
                                  $pipes,
                                  null,
                                  $env_vars); // this is not super-duper awesome-secure, but definitely more secure than showing it on the CLI, or dropping temporary files with passwords in them.
        if ($proc_results === false) {
            return $this->error('Unable to invoke mysql via CLI');
        }

        stream_set_blocking($pipes[1], false); // use non-blocking reads for stdout
        stream_set_blocking($pipes[2], false); // use non-blocking reads for stderr

        // $this->info("Stdout says? ".fgets($pipes[1])); //FIXME: I think we might need to set non-blocking mode to use this properly?
        // $this->info("Stderr says? ".fgets($pipes[2])); //FIXME: ditto, same.
        // should we read stdout?
        // fwrite($pipes[0],config("database.connections.mysql.password")."\n"); //this doesn't work :(

        //$sql_contents = fopen($sqlfiles[0], "r"); //NOPE! This isn't a real file yet, silly-billy!

        $sql_stat = $za->statIndex($sqlfile_indices[0]);
        //$this->info("SQL Stat is: ".print_r($sql_stat,true));
        $sql_contents = $za->getStream($sql_stat['name']); /// duplicate this?
        if ($sql_contents === false) {
            $stdout = fgets($pipes[1]);
            $this->info($stdout);
            $stderr = fgets($pipes[2]);
            $this->info($stderr);

            return false;
        }
        $sql_prefix_sniff = $za->getStream($sql_stat['name']); /// duplicate this?
        self::guess_prefix($sql_prefix_sniff);

        $bytes_read = 0;
        $reading_beginning_of_line = true;

        try {
            while (($buffer = fgets($sql_contents, self::$buffer_size)) !== false) {
                $bytes_read += strlen($buffer);
                if ($reading_beginning_of_line) {
                    //check allowlist?
                    // \Log::debug("Buffer is: '$buffer'");
                    $bytes_written = fwrite($pipes[0], $buffer);

                    if ($bytes_written === false) {
                        throw new Exception("Unable to write to pipe");
                    }
                }
                // if we got a newline at the end of this, then the _next_ read is the beginning of a line
                if($buffer[strlen($buffer)-1] === "\n") {
                    $reading_beginning_of_line = true;
                } else {
                    $reading_beginning_of_line = false;
                }

            }
        } catch (\Exception $e) {
            \Log::error("Error during restore!!!! ".$e->getMessage());
            $err_out = fgets($pipes[1]);
            $err_err = fgets($pipes[2]);
            \Log::error("Error OUTPUT: ".$err_out);
            $this->info($err_out);
            \Log::error("Error ERROR : ".$err_err);
            $this->error($err_err);
            throw $e;
        }
        
        if (!feof($sql_contents) || $bytes_read == 0) {
            return $this->error("Not at end of file for sql file, or zero bytes read. aborting!");
        }
    
        fclose($pipes[0]);
        fclose($sql_contents);
        
        $this->line(stream_get_contents($pipes[1]));
        fclose($pipes[1]);

        $this->error(stream_get_contents($pipes[2]));
        fclose($pipes[2]);

        //wait, have to do fclose() on all pipes first?
        $close_results = proc_close($proc_results);
        if ($close_results != 0) {
            return $this->error('There may have been a problem with the database import: Error number '.$close_results);
        }

        //and now copy the files over too (right?)
        //FIXME - we don't prune the filesystem space yet!!!!
        if ($this->option('no-progress')) {
            $bar = null;
        } else {
            $bar = $this->output->createProgressBar(count($interesting_files));
        }
        foreach ($interesting_files as $pretty_file_name => $file_details) {
            $ugly_file_name = $za->statIndex($file_details['index'])['name'];
            $fp = $za->getStream($ugly_file_name);
            //$this->info("Weird problem, here are file details? ".print_r($file_details,true));
            $migrated_file = fopen($file_details['dest'].'/'.basename($pretty_file_name), 'w');
            while (($buffer = fgets($fp, self::$buffer_size)) !== false) {
                fwrite($migrated_file, $buffer);
            }
            fclose($migrated_file);
            fclose($fp);
            //$this->info("Wrote $ugly_file_name to $pretty_file_name");
            if ($bar) {
                $bar->advance();
            }
        }
        if ($bar) {
            $bar->finish();
            $this->line('');
        } else {
            $this->info(count($interesting_files).' files were succesfully transferred');
        }
        foreach ($boring_files as $boring_file) {
            $this->warn($boring_file.' was skipped.');
        }
    }
}
