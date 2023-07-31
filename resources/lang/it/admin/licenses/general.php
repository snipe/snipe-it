<?php

return array(
    'about_licenses_title'      => 'Informazioni sulle licenze',
    'about_licenses'            => 'Le licenze vengono utilizzate per monitorare il software. Hanno un numero specifico di posti che possono essere verificati agli individui',
    'checkin'  					=> 'Registrare Licenza Sede',
    'checkout_history'  		=> 'Storico Estrazioni',
    'checkout'  				=> 'Estrazione Licenza Sede',
    'edit'  					=> 'Modifica Licenza',
    'filetype_info'				=> 'I formati di file permessi sono png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, e rar.',
    'clone'  					=> 'Clona Licenza',
    'history_for'  				=> 'Storico per ',
    'in_out'  					=> 'Dentro/Fuori',
    'info'  					=> 'Informazioni Licenza',
    'license_seats'  			=> 'Licenza Sede',
    'seat'  					=> 'Sede',
    'seats'  					=> 'Sedi',
    'software_licenses'  		=> 'Licenze Software',
    'user'  					=> 'Utente',
    'view'  					=> 'Mostra Licenza',
    'delete_disabled'           => 'Questa licenza non può essere cancellata perché ci sono delle postazioni assegnate.',
    'bulk'                      =>
        [
            'checkin_all'           => [
                'button'            => 'Check-in di tutte le postazioni',
                'modal'             => 'Ciò effettuerà il check-in di una postazione. | Ciò effettuerà il check-in di :checkedout_seats_count postazioni per questa licenza.',
                'enabled_tooltip'   => 'Check-in di TUTTE le postazioni di questa licenza, sia di utenti che di beni',
                'disabled_tooltip'  => 'Disattivato perché non ci sono postazioni assegnate',
                'success'           => 'Check-in della licenza effettuato! | Check-in di tutte le licenze effettuato!',
                'log_msg'           => 'Check-in effettuato tramite GUI di assegnazione massiva di licenze',
            ],

            'checkout_all'              => [
                'button'                => 'Check-out di tutte le postazioni',
                'modal'                 => 'Ciò effettuerà il check-out di una postazione al primo utente disponibile. | Questa azione effettuerà il checkout di :available_seats_count postazioni ai primi utenti disponibili. Un utente viene considerato disponibile se non hanno già questa licenza e la proprietà Auto-Assegna Licenza è attivata nel loro account utente.',
                'enabled_tooltip'   => 'Assegna TUTTE le postazioni (o tutte quelle disponibili) a TUTTI gli utenti',
                'disabled_tooltip'  => 'Disattivato perché non ci sono postazioni disponibili',
                'success'           => 'Check-out della licenza effettuato ! | Check-out di :count licenze effettuato!',
                'error_no_seats'    => 'Nessuna postazione rimasta per questa licenza.',
                'warn_not_enough_seats'    => ':count utenti assegnati a questa licenza, ma le postazioni sono finite.',
                'warn_no_avail_users'    => 'Non ho fatto nulla: Non ci sono utenti che non abbiano già questa licenza.',
                'log_msg'           => 'Check-out effettuato tramite GUI di assegnazione massiva di licenze',


            ],
    ],
);
