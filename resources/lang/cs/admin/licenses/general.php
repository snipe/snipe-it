<?php

return array(
    'about_licenses_title'      => 'O licencích',
    'about_licenses'            => 'Licence jsou používány ke sledování softwaru. Mají stanovený počet uživatelských licencí, které mohou být přiděleny jednotlivcům',
    'checkin'  					=> 'Převzít jednu licenci',
    'checkout_history'  		=> 'Historie',
    'checkout'  				=> 'Předat jednu licenci',
    'edit'  					=> 'Uprav licenci',
    'filetype_info'				=> 'Povolené druhy souborů jsou png, gif, jpg, jpeg, doc, docx, pdf, txt, zip a rar.',
    'clone'  					=> 'Duplikovat licenci',
    'history_for'  				=> 'Historie uživatele ',
    'in_out'  					=> 'Stav',
    'info'  					=> 'Informace o licenci',
    'license_seats'  			=> 'Počet licencí',
    'seat'  					=> 'Licence',
    'seats'  					=> 'Počet licencí',
    'software_licenses'  		=> 'Softwarové licence',
    'user'  					=> 'Uživatel',
    'view'  					=> 'Ukaž licenci',
    'delete_disabled'           => 'Tuto položku zatím nelze odstranit, neboť jsou vydány některé license.',
    'bulk'                      =>
        [
            'checkin_all'           => [
                'button'            => 'Hromadně převzít všechny licence',
                'modal'             => 'Tímto převezmete jednu licenci. | Tímto převezmete všech :checkedout_seats_count licencí.',
                'enabled_tooltip'   => 'Převzít všechny licence vydané jak uživatelům, tak i zařízením',
                'disabled_tooltip'  => 'To nelze provést, neboť není vydaná žádná licence',
                'success'           => 'Lincece úspěšně převzata! | Licence úspěšně převzaty!',
                'log_msg'           => 'Převzato pomocí hromadného zpracování licencí',
            ],

            'checkout_all'              => [
                'button'                => 'Vydat všchny licence',
                'modal'                 => 'Tímto vydáte jednu licenci prvnímu dostupnému uživateli. | Tímto vydáte všech :available_seats_count licencí dostupným uživatelům, přičemž dostupný uživatel je takový, který ještě nepřevzal tuto licenci a přitom má zapnutou volbu automatického přiřazování licencí.',
                'enabled_tooltip'   => 'Vydat všechny (dostupné) licence všem uživatelům',
                'disabled_tooltip'  => 'Nelze provést, neboť nejsou volné žádné licence',
                'success'           => 'Licence byla úspěšně vydána! | :count licenses licencí bylo úspěšně vydáno!',
                'error_no_seats'    => 'Nejsou žádné volné (nevydané) licence.',
                'warn_not_enough_seats'    => 'Licence byly přiřazeny :count uživatelům, ale již nezbyly žádné volné.',
                'warn_no_avail_users'    => 'Nelze provést, neboť již nezbývají žádní uživatelé, kteří tuto licenci nemají přiřazenu.',
                'log_msg'           => 'Vydáno pomocí hromadného zpracování licencí',


            ],
    ],
);
