<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Transformers\UsersTransformer;
use App\Models\InvoiceType;
use App\Models\LegalPerson;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Rollbar\Payload\Trace;

class BitrixSyncController extends Controller
{

    public function syncUsers(Request $request)
    {

        /** @var \GuzzleHttp\Client $client */
        $client = new \GuzzleHttp\Client();


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

        $count = count($bitrix_users_final);
//        return "Синхрониизтрованно ".count($bitrix_users_final)." пользователей Битрикс";
        $res = [
            'type'=> 'users',
            'result' => true,
            'all' => $count,
//            'new' => $new_count,
        ];
        return json_encode($res);
    }

    public function syncLocations(Request $request)
    {
        /** @var \GuzzleHttp\Client $client */
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://bitrix.legis-s.ru/rest/1/rzrrat22t46msv7v/legis_crm.object.list/?select%5B0%5D=UF_*&select%5B1%5D=*');
        $response = $response->getBody()->getContents();
        $bitrix_objects = json_decode($response, true);
        $bitrix_objects = $bitrix_objects["result"];
        $count = 0 ;
        $new_count = 0 ;
        foreach ($bitrix_objects as &$value) {
            if($value["TABEL_ID"] && $value["UF_TYPE"] == 455 && $value["DELETED"] != 1){
                $count++;

                $bitrix_user =  $value["ASSIGNED_BY_ID"];
                /** @var User $sklad_user */
                $sklad_user = User::where('bitrix_id', $bitrix_user)->first();
                $location = Location::updateOrCreate(
                    ['bitrix_id' =>  $value["ID"]],
                    [
                        'name' => $value["NAME"],
                        'city' => $value["ADDRESS_CITY"],
                        'address' => mb_substr($value["ADDRESS"], 0, 49),
                        'address2' => mb_substr($value["ADDRESS_2"], 0, 49),
                        'manager_id'=> $sklad_user->id,
                    ]
                );
                if ($location->wasChanged()){
                    $new_count++;
                }
//                $location->manager_id = $sklad_user->id;
//                $location->save();
            }
        }
        $res = [
            'type'=> 'locations',
            'result' => true,
            'all' => $count,
            'new' => $new_count,
        ];
        return json_encode($res);
    }


    public function syncSuppliers(Request $request)
    {

        /** @var \GuzzleHttp\Client $client */
        $client = new \GuzzleHttp\Client();

        $next = 0;
        $finish = false;
        $bitrix_suppliers = [];
        while ($finish == false){
            $response = $client->request('GET', 'https://bitrix.legis-s.ru/rest/1/rzrrat22t46msv7v/crm.company.list?FILTER[COMPANY_TYPE]=1&start='."$next");
            $response = $response->getBody()->getContents();
            $suppliers_response = json_decode($response, true);
            $suppliers_data = $suppliers_response["result"];
            $bitrix_suppliers = array_merge($bitrix_suppliers, $suppliers_data);
            if (array_key_exists("next", $suppliers_response)) {
                $next =  $suppliers_response["next"];
            }else{
                $finish = true;
            }
        }

        $count = 0 ;
        $new_count = 0 ;
        foreach ($bitrix_suppliers as &$value) {
            $count++;
            $supplier = Supplier::updateOrCreate(

                ['bitrix_id' =>  $value["ID"]],
                [
                    'name' => $value["TITLE"],
                    'city' => $value["ADDRESS_CITY"],
                    'notes'=> $value["COMMENTS"],
                    'address' => mb_substr($value["ADDRESS"], 0, 49),
                    'address2' => mb_substr($value["ADDRESS_2"], 0, 49),
                ]
            );

            if ($supplier->isDirty()){
                $new_count++;
            }

        }
//        return ("Синхрониизтрованно ".$count." поставщиков \n");
        $res = [
            'type'=> 'suppliers',
            'result' => true,
            'all' => $count,
            'new' => $new_count,
        ];
        return json_encode($res);

    }

    public function syncLegalPersons(Request $request)
    {
        /** @var \GuzzleHttp\Client $client */
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://bitrix.legis-s.ru/rest/1/rzrrat22t46msv7v/lists.element.get?IBLOCK_TYPE_ID=lists&IBLOCK_ID=77');
        $response = $response->getBody()->getContents();
        $bitrix_legal_persons = json_decode($response, true);
        $bitrix_legal_persons = $bitrix_legal_persons["result"];
        $count = 0 ;
        foreach ($bitrix_legal_persons as &$value) {
            $count++;
            $legal_person = LegalPerson::updateOrCreate(

                ['bitrix_id' =>  $value["ID"]],
                [
                    'name' => $value["NAME"],
                ]
            );

        }
//        return("Синхрониизтрованно ".$count." юр. лиц \n");
        $res = [
            'type'=> 'legal_persons',
            'result' => true,
            'all' => $count,
//            'new' => $new_count,
        ];
        return json_encode($res);

    }


    public function syncInvoiceTypes(Request $request)
    {
        /** @var \GuzzleHttp\Client $client */
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://bitrix.legis-s.ru/rest/1/rzrrat22t46msv7v/lists.element.get?IBLOCK_TYPE_ID=lists&IBLOCK_ID=166');
        $response = $response->getBody()->getContents();
        $bitrix_invoice_types = json_decode($response, true);
        $bitrix_invoice_types = $bitrix_invoice_types["result"];
        $count = 0 ;
        foreach ($bitrix_invoice_types as &$value) {
            $count++;
            $invoice_type = InvoiceType::updateOrCreate(

                ['bitrix_id' =>  $value["ID"]],
                [
                    'name' => $value["NAME"],
                ]
            );

        }
//        return ("Синхрониизтрованно ".$count." типов закупок \n");
        $res = [
            'type'=> 'invoice_types',
            'result' => true,
            'all' => $count,
//            'new' => $new_count,
        ];
        return json_encode($res);

    }
}