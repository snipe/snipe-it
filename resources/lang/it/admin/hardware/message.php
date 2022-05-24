<?php

return [

    'undeployable' 		=> '<strong>Attenzione: </strong> Questo asset è stato marcato come non distribuibile.
                       Se lo stato è cambiato,aggiorna lo stato dell\'asset.',
    'does_not_exist' 	=> 'Questo Asset non esiste.',
    'does_not_exist_or_not_requestable' => 'Questo bene non esiste o non è disponibile.',
    'assoc_users'	 	=> 'Questo asset è stato assegnato ad un Utente e non può essere cancellato. Per favore Riassegnalo in magazzino,e dopo riprova a cancellarlo.',

    'create' => [
        'error'   		=> 'L\'asset non è stato creato, riprova per favore. :(',
        'success' 		=> 'L\'asset è stato creato con successo. :)',
    ],

    'update' => [
        'error'   			=> 'Il bene non è stato aggiornato, si prega di riprovare',
        'success' 			=> 'Bene aggiornato con successo.',
        'nothing_updated'	=>  'Non è stato selezionato nessun campo, nulla è stato aggiornato.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Il bene non è stato ripristinato, riprova',
        'success' 		=> 'Bene ripristinato con successo.',
    ],

    'audit' => [
        'error'   		=> 'L\'audit del patrimonio non è riuscito. Riprova.',
        'success' 		=> 'L\'audit di risorse si è registrato con successo.',
    ],


    'deletefile' => [
        'error'   => 'File non cancellato. Riprova.',
        'success' => 'File cancellato con successo.',
    ],

    'upload' => [
        'error'   => 'File non caricato/i. Riprova.',
        'success' => 'File caricato/i con successo.',
        'nofiles' => 'Non hai selezionato nessun file per il caricamento, oppure il file selezionato è troppo grande',
        'invalidfiles' => 'Uno o più file è troppo grande o è un tipo di file non consentito. Tipi di file ammessi sono png, gif, jpg, doc, docx, pdf, txt.',
    ],

    'import' => [
        'error'                 => 'Alcuni elementi non sono stati importati correttamente.',
        'errorDetail'           => 'Gli elementi seguenti non sono stati importati correttamente a causa di errori.',
        'success'               => 'Il file è stato importato con successo',
        'file_delete_success'   => 'Il file è stato cancellato con successo',
        'file_delete_error'      => 'Impossibile eliminare il file',
    ],


    'delete' => [
        'confirm'   	=> 'Sei sicuro di voler eliminare questo bene?',
        'error'   		=> 'C\'è stato un problema durante la cancellazione del bene. Riprova per favore.',
        'nothing_updated'   => 'Nessun patrimonio è stato selezionato, quindi niente è stato eliminato.',
        'success' 		=> 'Il bene è stato eliminato con successo.',
    ],

    'checkout' => [
        'error'   		=> 'Il bene non è stato estratto, per favore riprova',
        'success' 		=> 'Il bene è stato estratto con successo.',
        'user_does_not_exist' => 'Questo utente non è valido. Riprova.',
        'not_available' => 'Questo prodotto non è disponibile per il checkout!',
        'no_assets_selected' => 'È necessario selezionare almeno una risorsa dall\'elenco',
    ],

    'checkin' => [
        'error'   		=> 'Il bene non è stato registrato, per favore riprova',
        'success' 		=> 'Il bene è stato registrato con successo.',
        'user_does_not_exist' => 'Questo utente non è valido. Riprova.',
        'already_checked_in'  => 'Il prodotto è già rientrato.',

    ],

    'requests' => [
        'error'   		=> 'L\'asset non è stato richiesto, si prega di riprovare',
        'success' 		=> 'Asset richiesto con successo.',
        'canceled'      => 'Richiesta di checkout cancellata con successo',
    ],

];
