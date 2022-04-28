<?php

return [
    'about_assets_title'           => 'Informazioni sugli asset',
    'about_assets_text'            => 'Gli asset sono elementi tracciati con il numero di serie o il tag di asset. Tendono ad essere oggetti di valore più elevato dove identificare un elemento specifico.',
    'archived'  				=> 'Archiviato',
    'asset'  					=> 'Asset',
    'bulk_checkout'             => 'Ritiro Asset',
    'bulk_checkin'              => 'Check-in Bene',
    'checkin'  					=> 'Ingresso Asset',
    'checkout'  				=> 'Asset Checkout',
    'clone'  					=> 'Copia Asset',
    'deployable'  				=> 'Distribuibile',
    'deleted'  					=> 'Questo bene è stato eliminato.',
    'edit'  					=> 'Modifica Asset',
    'model_deleted'  			=> 'Questo modello di asset è stato eliminato. Devi ripristinare il modello prima di poter ripristinare il bene.',
    'requestable'               => 'Disponibile',
    'requested'				    => 'richiesto',
    'not_requestable'           => 'Non Richiedibili',
    'requestable_status_warning' => 'Non cambiare richiedibilità',
    'restore'  					=> 'Ripristina Asset',
    'pending'  					=> 'In attesa',
    'undeployable'  			=> 'Non Distribuilbile',
    'view'  					=> 'Vedi Asset',
    'csv_error' => 'C\'è un errore nel file CSV:',
    'import_text' => '
    <p>
    Carica un CSV che contiene la storia dei beni. I beni e gli utenti DEVONO essere già esistenti nel sistema, o verranno saltati. Il match dei beni per l\'importazione della storia si basa sul tag del bene. Proveremo a trovare un utente che combacia basandoci sul nome inserito e il criterio scelto qui sotto. Se non scegli alcun criterio, il match avverrà col formato del nome utente configurato in Admin &gt; Impostazioni Generali.
    </p>

    <p>I campi inclusi del CSV devono combaciare con gli headers: <strong>Asset Tag, Name, Checkout Date, Checkin Date</strong>. Eventuali altri campi verranno ignorati. </p>

    <p>Checkin Date: Date di check-in vuote o del futuro causeranno un check-out degli oggetti all\'utente associato. Escludere completamente la data di Check-in creerà una data di check-in con la data di oggi.</p>
    ',
    'csv_import_match_f-l' => 'Abbina gli utenti col formato nome.cognome (jane.smith)',
    'csv_import_match_initial_last' => 'Abbina gli utenti col formato iniziale cognome (jsmith)',
    'csv_import_match_first' => 'Abbina gli utenti col formato nome (jane)',
    'csv_import_match_email' => 'Abbina gli utenti usando l\'email come username',
    'csv_import_match_username' => 'Abbina gli utenti con l\'username',
    'error_messages' => 'Messaggi di errore:',
    'success_messages' => 'Messaggi di successo:',
    'alert_details' => 'Leggere sotto per maggiori dettagli.',
    'custom_export' => 'Esportazione Personalizzata'
];
