<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SystemBackup extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'snipeit:backup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This command creates a database dump and zips up all of the uploaded files in the upload directories.';

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
	public function fire()
	{
		//
		$files['avatars'] = glob(public_path().'/uploads/avatars/*');
		$files['models'] = glob(public_path().'/uploads/models/*');
		$files['suppliers'] = glob(public_path().'/uploads/suppliers/*');
		$files['private_uploads'] = glob(config('app.private_uploads').'/*');
		$base_filename = date('Ymdgis');
		$zip_file = config('app.private_uploads').'/backups/zips/'.$base_filename.'-backup.zip';
		$db_dump = config('app.private_uploads').'/backups/sql/'.$base_filename.'-db.sql';
		$this->call('db:backup', array('filename' => $db_dump));
        echo $zip_file."\n";
        echo $db_dump."\n";


		Zipper::make($zip_file)
			->folder('avatars')->add($files['avatars'])
			->folder('models')->add($files['models'])
			->folder('suppliers')->add($files['suppliers'])
			->folder('private_uploads')->add($files['private_uploads'])
			->folder('database')->add($db_dump)->close();

		$this->info('Backup file created at '.$zip_file);
		$this->info('Removing SQL dump at '.$db_dump);
		unlink($db_dump);

	}



}
