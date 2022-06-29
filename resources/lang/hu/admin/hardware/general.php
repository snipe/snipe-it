<?php

return [
    'about_assets_title'           => 'Az eszközökről',
    'about_assets_text'            => 'Az eszközök a sorszám vagy az eszközcímke által követett elemek. Ezek általában magasabb értékű termékek, amelyekben egy adott elem azonosítása fontos.',
    'archived'  				=> 'Arhivált',
    'asset'  					=> 'Eszköz',
    'bulk_checkout'             => 'Eszközök kiadása',
    'bulk_checkin'              => 'Eszköz visszavétele',
    'checkin'  					=> 'Eszköz visszavétele',
    'checkout'  				=> 'Checkout Asset',
    'clone'  					=> 'Eszköz klónozása',
    'deployable'  				=> 'Kiadható',
    'deleted'  					=> 'Az eszköz törölve lett.',
    'edit'  					=> 'Eszköz módosítása',
    'model_deleted'  			=> 'Ennek az eszköznek a modellje törölve lett. Elösszőr a modellt vissza kell állítani, utánna lehet csak az eszközt visszaállítani.',
    'requestable'               => 'lehívási',
    'requested'				    => 'Kérve',
    'not_requestable'           => 'Nem kérhető',
    'requestable_status_warning' => 'Ne változtassa meg a kérelmezhető státuszt',
    'restore'  					=> 'Visszaállítás eszköz',
    'pending'  					=> 'Függőben',
    'undeployable'  			=> 'Nem telepíthető',
    'view'  					=> 'Eszköz megtekintése',
    'csv_error' => 'Hiba van a CSV fájlban:',
    'import_text' => '
<p>
    Töltsön fel egy CSV fájlt, amely tartalmazza az eszközök előzményeit. Az eszközöknek és a felhasználóknak már létezniük kell a rendszerben, különben a rendszer kihagyja őket. Az előzmények importálásához az eszközök egyeztetése az eszközcímke alapján történik. Megpróbáljuk megtalálni a megfelelő felhasználót az Ön által megadott felhasználónév és az alább kiválasztott kritériumok alapján. Ha az alábbiakban nem választja ki egyik kritériumot sem, a rendszer egyszerűen megpróbál megfelelni az Admin  &gt;  általános beállításai között beállított felhasználónév-formátumnak.
    </p>

    <p>A CSV-ben szereplő mezőknek meg kell egyezniük a fejlécekkel: <strong>Eszközcímke, név, kiadás dátuma, visszavétel dátuma</strong>.  Minden további mezőt figyelmen kívül hagyunk.</p>

    <p>Kiadás dátuma: üres vagy jövőbeli bejelentkezési dátumok a kapcsolódó felhasználónak történő kiadást eredményezik.  A viszzavétel dátuma oszlop kizárása a mai dátummal egyező kiadás dátumot hoz létre.</p>
    ',
    'csv_import_match_f-l' => 'Próbálja meg a felhasználókat a keresztnév.vezetéknév (jane.smith) formátum alapján összevetni',
    'csv_import_match_initial_last' => 'Próbálja meg a felhasználókat a keresztnév első betűjével és a vezetéknévvel (jsmith) összevetni',
    'csv_import_match_first' => 'Próbálja meg a felhasználókat keresztnév (jane) alapján összevetni',
    'csv_import_match_email' => 'Próbálja meg a felhasználókat e-mail cím alapján mint felhasználónév összevetni',
    'csv_import_match_username' => 'Próbálja meg a felhasználókat felhasználónév alapján összevetni',
    'error_messages' => 'Hibaüzenetek:',
    'success_messages' => 'Sikeres üzenetek:',
    'alert_details' => 'A részleteket lásd alább.',
    'custom_export' => 'Egyéni export'
];
