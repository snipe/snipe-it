<?php

return [

    'undeployable' => 'Nasledujúce majetky nie je možné odovzdať, preto boli odstránené z odovzdávania: :asset_tags',
    'does_not_exist' => 'Majetok neexistuje.',
    'does_not_exist_var' => 'Majetok s označením :asset_tag nebol nájdený.',
    'no_tag' => 'Nebolo zadané žiadne označenie majetku.',
    'does_not_exist_or_not_requestable' => 'Tento majetok neexistuje alebo sa nedá vyžiadať.',
    'assoc_users' => 'Tento majetok je práve priradený používateľovi, preto nemôže byť odstránený. Prosim najprv odoberte majetok používateľovi, následne skúste znovu. ',
    'warning_audit_date_mismatch' => 'Nastavený dátum nasledujúceho auditu (:next_audit_date) je skorší ako dátum posledného auditu (:last_audit_date). Prosím upravte dátum nasledujúceho auditu.',
    'labels_generated' => 'Štítky boli úspešne vygenerované.',
    'error_generating_labels' => 'Pri generovaní štítkov nastala chyba.',
    'no_assets_selected' => 'Neboli zvolené žiadne položky majetku.',

    'create' => [
        'error' => 'Majetok nebol vytvorený, prosím skúste znovu. :(',
        'success' => 'Majetok bol úspešne vytvorený. :)',
        'success_no_checkout' => 'Asset created successfully, but was not checked out because you do not have permission to check assets out.',
        'checkout_skipped_no_permission' => 'The asset was created, but was not checked out to the requested target because you do not have permission to check assets out.',
        'success_linked' => 'Majetok s označením :tag bol úspešne pridaný. <strong><a href=":link" style="color: white;">Kliknite sem pre zobrazenie</a></strong>.',
        'multi_success_linked' => 'Majetok s označením :links bol úspešne pridaný.|:count majetkov bolo úspešne pridaných :links.',
        'partial_failure' => 'Majetok sa nepodarilo pridať. Dôvod: :failuers|:count majetkov nebolo možné pridať. Dôvody: :failures',
        'target_not_found' => [
            'user' => 'Priradeného používateľa sa nepodarilo nájsť.',
            'asset' => 'Priradený majetok sa nepodarilo nájsť.',
            'location' => 'Priradenú lokalitu sa nepodarilo nájsť.',
        ],
    ],

    'update' => [
        'error' => 'Majetok sa nepodarilo upraviť, skúste prosím znovu',
        'success' => 'Majetok bol úspešne upravený.',
        'encrypted_warning' => 'Majetok bol úspešne upravený, avšak šifrované vlastné polia neboli upravené z dôvodu oprávnení',
        'nothing_updated' => 'Neboli vybrané žiadne položky, preto nebolo nič upravené.',
        'no_assets_selected' => 'Neboli vybrané žiadne majetky, preto nebolo nič upravené.',
        'assets_do_not_exist_or_are_invalid' => 'Zvolené položky majetku nemôžu byť upravené.',
    ],

    'bulk_update' => [
        'success' => 'Asset updated successfully.|:count assets were updated successfully.',
        'partial' => ':success asset(s) updated successfully, :failed failed. See the results array for details.',
        'error' => 'No assets were updated. See the results array for details.',
    ],

    'restore' => [
        'error' => 'Majetok nebol obnovený, prosím skúste znovu',
        'success' => 'Majetok bol úspešne obnovený.',
        'bulk_success' => 'Majetok bol úspešne obnovený.',
        'nothing_updated' => 'Neboli zvolené žiadne položky majetku, preto nebolo nič obnovené.',
    ],

    'audit' => [
        'error' => 'Audit majetku nebol úspešný :error ',
        'success' => 'Audit majetko bol úspešne zaznamenaný.',
    ],

    'deletefile' => [
        'error' => 'Súbor nebol odstránený. Prosím skúste znovu.',
        'success' => 'Súbor bol úspešne odstránený.',
    ],

    'upload' => [
        'error' => 'Súbor(y) sa nepodarilo nahrať. Skúste prosím znovu.',
        'success' => 'Súbor(y) boli úspešne uložené.',
        'nofiles' => 'Nevybrali ste žiadne súbory na nahranie alebo je súbor, ktorý sa pokúšate nahrať, príliš veľký',
        'invalidfiles' => 'Jeden alebo viac súborov je príliš veľký alebo ide o typ súboru, ktorý nie je povolený. Povolené typy súborov sú png, gif, jpg, doc, docx, pdf a txt.',
    ],

    'import' => [
        'import_button' => 'Spracovať import',
        'error' => 'Niektoré položky neboli správne naimportované.',
        'errorDetail' => 'Nasledujúce položky neboli kvôli chybám importované.',
        'success' => 'Súbor bol naimportovaný',
        'file_delete_success' => 'Súbor bol úspešné odstránený',
        'file_delete_error' => 'Súbor sa nepodarilo odstrániť',
        'file_missing' => 'Vybraný súbor nebol nájdený',
        'file_already_deleted' => 'Vybraný súbor už bol odstránený',
        'file_missing_on_disk' => 'The file for this import is no longer on disk. It may have been deleted outside of Snipe-IT. Delete this entry and re-upload the file to try again.',
        'file_empty' => 'This file has no data rows. Nothing can be imported from it.',
        'already_processing' => 'This import is currently being processed by another user. Please wait for it to finish before trying again.',
        'header_row_missing' => 'This file does not have a recognized header row. Delete this entry and re-upload the file to try again.',
        'header_row_has_malformed_characters' => 'Jeden alebo viacero stĺpcov obsahujú poškodené UTF-8 znaky',
        'content_row_has_malformed_characters' => 'Jeden alebo viacero atribútov v prvom riadku obsahu obsahuje poškodené UTF-8 znaky',
        'transliterate_failure' => 'Prepis z kódovania :encoding do UTF-8 zlyhal kvôli neplatným znakom vo vstupe',
        'bulk_delete' => [
            'button' => 'Delete Selected (:count)',
            'confirm_title' => 'Delete selected import files?',
            'confirm_body' => 'You are about to permanently delete :count import file(s). This cannot be undone.',
            'confirm_button' => 'Vymazať',
            'success' => 'Import file deleted successfully.|:count import files were deleted successfully.',
            'skipped' => ':count file(s) were skipped because you do not have permission to delete them.',
            'select_all' => 'Select all files on this page',
            'select_row' => 'Select :file for bulk delete',
        ],
        'row_count' => '{0} No data rows in this file|{1} :count data row to import|[2,*] :count data rows to import',
        'summary' => [
            'created' => 'Vytvorený',
            'updated' => 'Updated',
            'skipped' => 'Skipped as duplicates',
            'errored' => 'Errored',
            'no_changes' => 'The import finished but nothing was created or updated. Every row was skipped, usually because the underlying records already existed. Check the counts below and adjust the CSV or import type if that is not what you expected.',
        ],
        'type_required' => 'Please select an import type before continuing.',
        'processing' => 'Processing your import. Please wait until this finishes before closing the page.',
        'backup_running' => 'Running backup before importing. This can take a while on larger files. Please wait.',
        'backup_label' => 'Pre-import backup',
        'backup_complete' => 'Backup complete',
        'import_label' => 'Import',
        'required_fields_missing' => 'The following required fields are not mapped: :fields',
        'history' => [
            'missing_asset_tag_identity' => '(missing asset tag)',
            'missing_asset_tag_message' => 'Row skipped: no asset tag provided.',
            'asset_not_found_message' => 'Asset with this tag does not exist. Import assets first, then re-run the history import.',
            'target_not_matched_message' => 'No :target_type matched ":name". For users, toggle the match-by options in step 1 or create the user first. For locations, make sure the CSV location name matches an existing location exactly.',
            'invalid_target_type_message' => 'Target Type ":value" is not recognized. Use "user" or "location", or leave the column blank to default to user.',
        ],
        'wizard' => [
            'step_type' => 'Choose type',
            'step_map' => 'Map fields',
            'step_preview' => 'Náhľad',
            'back' => 'Späť',
            'next' => 'Ďalší',
            'preview_button' => 'Náhľad',
            'process' => 'Process import',
            'preview_intro' => 'Previewing the first :count row(s) after applying your mapping. Use the Back button if you need to edit the mapped attributes before importing.',
        ],
    ],

    'delete' => [
        'confirm' => 'Ste si istý, že chcete odstrániť tento majetok?',
        'error' => 'Pri odstraňovaní majetku sa vyskytla chyba. Skúste prosím znovu.',
        'assigned_to_error' => '{1}Majetok: :asset_tag je odovzdaný. Prevezmite majetok pred zmazaním.|[2,*]Majetky : :asset_tag sú odovzdané. Prevezmite tieto majetky pred odmazaním.',
        'nothing_updated' => 'Neboli zvolený žiadne položky majetku, preto nebolo nič odstránené.',
        'success' => 'Majetok bol úspešne odstránený.',
    ],

    'checkout' => [
        'error' => 'Majetok sa nepodarilo odovzdať, skúste prosím znovu',
        'success' => 'Majetok bol úspešne odovzdaný.',
        'user_does_not_exist' => 'Tento užívateľ nie je platný. Prosím skúste znovu.',
        'not_available' => 'Tento majetok nie je k dospozícii pre odovzdanie!',
        'no_assets_selected' => 'Musíte vybrať najmenej jednu položku majetku zo zoznamu',
    ],

    'multi-checkout' => [
        'error' => 'Majetok nebol odovzdaný, prosím skúste znovu|Majetky neboli odovzdané, prosím skúste znovu',
        'success' => 'Majetok bol úspešne odovzdaný.|Majetky boli úspešne odovzdané.',
    ],

    'multi-checkin' => [
        'error' => 'Asset was not checked in, please try again|Assets were not checked in, please try again',
        'success' => 'Asset checked in successfully.|Assets checked in successfully.',
        'no_assets_selected' => 'Musíte vybrať najmenej jednu položku majetku zo zoznamu',
    ],

    'multi-audit' => [
        'success' => ':count asset audited successfully.|:count assets audited successfully.',
        'partial_error' => ':success asset audited, :failed failed. Check the errors below and try again.|:success assets audited, :failed failed. Check the errors below and try again.',
        'no_assets_selected' => 'Musíte vybrať najmenej jednu položku majetku zo zoznamu',
    ],

    'checkin' => [
        'error' => 'Majetok sa nepodarilo prevziať, skúste prosím znovu',
        'success' => 'Majetok bol úspešne prevzatý.',
        'user_does_not_exist' => 'Tento užívateľ nie je platný. Prosím skúste znovu.',
        'already_checked_in' => 'Tento majetok je už prevzatý.',
        'force_checkin_orphaned_success' => 'Invalid assignment cleared successfully.',
        'force_checkin_not_orphaned' => 'Item is not in an invalid assignment state.',
        'force_checkin_error' => 'Could not clear invalid assignment.',

    ],

    'requests' => [
        'error' => 'Požiadavka nebola úspešná, skúste to znova.',
        'success' => 'Žiadosť bola úspešne odoslaná.',
        'canceled' => 'Žiadosť bola úspešne zrušená.',
        'cancel' => 'Zrušiť túto žiadosť o položku',
        'duplicate' => 'You already have an active request for this item.',
        'no_active' => 'You have no active request to cancel for this item.',
        'insufficient_stock' => 'Not enough on hand to fulfill this request. Replenish first.',
        'confirm_cancel_by_admin' => "Cancel :user's request for :item?",
        'no_selection' => 'No rows were selected to fulfill.',
        'row_stale' => 'Request #:id is no longer pending and was skipped.',
        'row_qty_invalid' => 'Request #:id has an invalid quantity and was skipped.',
        'row_user_missing' => 'Request #:id has no valid target user and was skipped.',
        'row_asset_missing' => 'Request #:id has no valid target asset and was skipped.',
        'row_asset_not_requesters' => 'Request #:id skipped: selected asset does not belong to the requester.',
        'row_asset_not_available' => 'Request #:id skipped: selected asset is not an available unit of this model.',
        'row_asset_taken' => 'Request #:id skipped: selected asset was assigned to someone else before submit.',
        'row_company_mismatch' => 'Request #:id skipped: :user cannot receive items from this company.',
        'row_over_allocated' => 'Request #:id skipped: not enough on hand at the moment of submit.',
        'no_target_assets_for_user' => ':user has no assets to install into.',
        'no_available_units' => 'No available units of this model to hand out.',
        'bulk_summary' => 'Fulfilled :fulfilled of :total requests.',
        'bulk_fulfill_notification_intro' => 'The following will apply to each ticked request when fulfilled:',
    ],

];
