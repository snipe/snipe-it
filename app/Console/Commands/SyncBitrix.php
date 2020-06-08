<?php

namespace App\Console\Commands;

use App\Models\CustomField;
use Illuminate\Console\Command;
use App\Models\Asset;
use App\Models\Supplier;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class SyncBitrix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:sync-bitrix {--output= : info|warn|error|all} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This utility will sync with bitrix';

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
        $output['info'] = [];
        $output['warn'] = [];
        $output['error'] = [];


        /** @var \GuzzleHttp\Client $client */
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://bitrix.legis-s.ru/rest/1/rzrrat22t46msv7v/legis_crm.object.list/?select%5B0%5D=UF_*&select%5B1%5D=*');
        $response = $response->getBody()->getContents();
        $bitrix_objects = json_decode($response, true);
        $bitrix_objects = $bitrix_objects["result"];
        $count = 0 ;
        foreach ($bitrix_objects as &$value) {
            if($value["TABEL_ID"] && $value["UF_TYPE"] == 455 && $value["DELETED"] != 1){
                $count++;
                $location = Location::updateOrCreate(
                    ['bitrix_id' =>  $value["ID"]],
                    [
                        'name' => $value["NAME"],
                        'city' => $value["ADDRESS_CITY"],
                        'address' => $value["ADDRESS"],
                        'address2' => $value["ADDRESS_2"],
                 ]
                );
            }
        }
        print("Синхрониизтрованно ".$count." объектов Битрикс\n");

        /**
         * Начинаем с нуля или с какого то предыдущего шага
         */
        $leadID = 0;
        $finish = false;
        $bitrix_users_final = [];
        while (!$finish){
            $response = $client->request('GET', 'https://bitrix.legis-s.ru/rest/1/rzrrat22t46msv7v/user.get.json?ACTIVE=True&start='.$leadID);
            $response = $response->getBody()->getContents();
            $bitrix_users = json_decode($response, true);
            $bitrix_users = $bitrix_users["result"];
            $leadID = $leadID + count($bitrix_users);
            $bitrix_users_final = array_merge($bitrix_users_final, $bitrix_users);
            if (count($bitrix_users) > 0 && count($bitrix_users) ==50) {
            }else{
                $finish = true;
            }
        }


        foreach ($bitrix_users_final as &$value) {
            $user = User::firstOrCreate(
                ['bitrix_id' =>  $value["ID"]],
                [
                    'username' => $value["EMAIL"],
                    'last_name' => $value["LAST_NAME"],
                    'first_name' => $value["NAME"],
                    'email' => $value["EMAIL"],
                    'password'=> bcrypt($value["EMAIL"]),
                    'activated'=> true,
                ]
            );
        }
        print("Синхрониизтрованно ".count($bitrix_users_final)." пользователей Битрикс\n");


        $response = $client->request('GET', 'https://bitrix.legis-s.ru/rest/1/rzrrat22t46msv7v/crm.company.list?FILTER[COMPANY_TYPE]=1');
        $response = $response->getBody()->getContents();
        $bitrix_suppliers = json_decode($response, true);
        $bitrix_suppliers = $bitrix_suppliers["result"];
        $count = 0 ;
        foreach ($bitrix_suppliers as &$value) {
            $count++;
            $supplier = Supplier::updateOrCreate(
                    ['bitrix_id' =>  $value["ID"]],
                    [
                        'name' => $value["TITLE"],
                        'city' => $value["ADDRESS_CITY"],
                        'notes'=> $value["COMMENTS"],
                        'address' => $value["ADDRESS"],
                        'address2' => $value["ADDRESS_2"],
                    ]
                );
        }
        print("Синхрониизтрованно ".$count." поставщиков \n");




        if (($this->option('output')=='all') || ($this->option('output')=='info')) {
            foreach ($output['info'] as $key => $output_text) {
                $this->info($output_text);
            }
        }
        if (($this->option('output')=='all') || ($this->option('output')=='warn')) {
            foreach ($output['warn'] as $key => $output_text) {
                $this->warn($output_text);
            }
        }
        if (($this->option('output')=='all') || ($this->option('output')=='error')) {
            foreach ($output['error'] as $key => $output_text) {
                $this->error($output_text);
            }
        }
    }
}
