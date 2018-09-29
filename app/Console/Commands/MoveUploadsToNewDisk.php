<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MoveUploadsToNewDisk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:move-uploads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $public_uploads['accessories'] = glob('public/uploads/accessories'."/*.*");
        $public_uploads['assets'] = glob('public/uploads/assets'."/*.*");
        $public_uploads['avatars'] = glob('public/uploads/avatars'."/*.*");
        $public_uploads['barcodes'] = glob('public/uploads/barcodes'."/*.*");
        $public_uploads['categories'] = glob('public/uploads/categories'."/*.*");
        $public_uploads['companies'] = glob('public/uploads/companies'."/*.*");
        $public_uploads['components'] = glob('public/uploads/components'."/*.*");
        $public_uploads['consumables'] = glob('public/uploads/consumables'."/*.*");
        $public_uploads['departments'] = glob('public/uploads/departments'."/*.*");
        $public_uploads['locations'] = glob('public/uploads/locations'."/*.*");
        $public_uploads['manufacturers'] = glob('public/uploads/manufacturers'."/*.*");
        $public_uploads['suppliers'] = glob('public/uploads/suppliers'."/*.*");
        $public_uploads['assetmodels'] = glob('public/uploads/models'."/*.*");


        // iterate files
        foreach($public_uploads as $public_type => $public_upload)
        {
            $type_count = 0;
            $this->info("\nThere are ".count($public_upload).' PUBLIC '.$public_type.' files.');

            for ($i = 0; $i < count($public_upload); $i++) {
                $type_count++;
                $filename = basename($public_upload[$i]);

                try  {
                    Storage::disk('public')->put($public_type.'/'.$filename, $filename);
                    $new_url = Storage::disk('public')->url($public_type.'/'.$filename, $filename);
                    $this->info($type_count.'. PUBLIC: '.$filename.' was copied to '.$new_url);
                } catch (\Exception $e) {
                    \Log::debug($e);
                    $this->error($e);
                }

            }

        }

        $logos = glob('public/uploads'."/logo*.*");
        $this->info("\nThere are ".count($logos).' files that might be logos.');
        $type_count=0;
        $this->info(print_r($logos, true));

        for ($l = 0; $l < count($logos); $l++) {
            $type_count++;
            $filename = basename($logos[$l]);
            $new_url = Storage::disk('public')->url($public_type.'/'.$logos[$l], $filename);
            $this->info($type_count.'. LOGO: '.$filename.' was copied to '.$new_url);
        }

        $private_uploads['assets'] = glob('storage/private_uploads/assets'."/*.*");
        $private_uploads['signatures'] = glob('storage/private_uploads/signatures'."/*.*");
        $private_uploads['audits'] = glob('storage/private_uploads/audits'."/*.*");
        $private_uploads['assetmodels'] = glob('storage/private_uploads/assetmodels'."/*.*");
        $private_uploads['imports'] = glob('storage/private_uploads/imports'."/*.*");
        $private_uploads['licenses'] = glob('storage/private_uploads/licenses'."/*.*");
        $private_uploads['users'] = glob('storage/private_uploads/users'."/*.*");


        foreach($private_uploads as $private_type => $private_upload)
        {
            $this->info("\nThere are ".count($private_upload).' PRIVATE '.$private_type.' files.');
            // $this->info(print_r($private_upload, true));

            $type_count = 0;
            for ($x = 0; $x < count($private_upload); $x++) {
                $type_count++;
                $filename = basename($private_upload[$x]);

                try  {
                    Storage::put('private_uploads/'.$private_type.'/'.$filename, $filename);
                    $new_url = Storage::url($private_type.'/'.$filename, $filename);
                    $this->info($type_count.'. PRIVATE: '.$filename.' was copied to '.$new_url);

                } catch (\Exception $e) {
                    \Log::debug($e);
                    $this->error($e);
                }

            }

        }



    }
}
