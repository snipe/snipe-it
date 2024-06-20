<?php

return [
    'exception_message' => 'Greška: :message',
    'exception_trace' => 'Praćenje greške: :trace',
    'exception_message_title' => 'Greška',
    'exception_trace_title' => 'Praćenje greške',

    'backup_failed_subject' => 'Neuspješno sigurnosno kopiranje za :application_name',
    'backup_failed_body' => 'Važno: Došlo je do greške prilikom sigurnosnog kopiranja za :application_name',

    'backup_successful_subject' => 'Uspješno sigurnosno kopiranje za :application_name',
    'backup_successful_subject_title' => 'Uspješno sigurnosno kopiranje!',
    'backup_successful_body' => 'Nova sigurnosna kopija za :application_name je uspješno spremljena na disk :disk_name.',

    'cleanup_failed_subject' => 'Neuspješno čišćenje sigurnosnih kopija za :application_name',
    'cleanup_failed_body' => 'Došlo je do greške prilikom čišćenja sigurnosnih kopija za :application_name',

    'cleanup_successful_subject' => 'Uspješno čišćenje sigurnosnih kopija za :application_name',
    'cleanup_successful_subject_title' => 'Uspješno čišćenje sigurnosnih kopija!',
    'cleanup_successful_body' => 'Sigurnosne kopije za :application_name su uspješno očišćene s diska :disk_name.',

    'healthy_backup_found_subject' => 'Sigurnosne kopije za :application_name na disku :disk_name su zdrave',
    'healthy_backup_found_subject_title' => 'Sigurnosne kopije za :application_name su zdrave',
    'healthy_backup_found_body' => 'Sigurnosne kopije za :application_name se smatraju zdravima. Svaka čast!',

    'unhealthy_backup_found_subject' => 'Važno: Sigurnosne kopije za :application_name su nezdrave',
    'unhealthy_backup_found_subject_title' => 'Važno: Sigurnosne kopije za :application_name su nezdrave. :problem',
    'unhealthy_backup_found_body' => 'Sigurnosne kopije za :application_name na disku :disk_name su nezdrave.',
    'unhealthy_backup_found_not_reachable' => 'Destinacija sigurnosne kopije nije dohvatljiva. :error',
    'unhealthy_backup_found_empty' => 'Nijedna sigurnosna kopija ove aplikacije ne postoji.',
    'unhealthy_backup_found_old' => 'Zadnja sigurnosna kopija generirana na datum :date smatra se prestarom.',
    'unhealthy_backup_found_unknown' => 'Isprike, ali nije moguće odrediti razlog.',
    'unhealthy_backup_found_full' => 'Sigurnosne kopije zauzimaju previše prostora. Trenutno zauzeće je :disk_usage što je više od dozvoljenog ograničenja od :disk_limit.',

    'no_backups_info' => 'Nema sigurnosnih kopija',
    'application_name' => 'Naziv aplikacije',
    'backup_name' => 'Naziv sigurnosne kopije',
    'disk' => 'Disk',
    'newest_backup_size' => 'Veličina najnovije sigurnosne kopije',
    'number_of_backups' => 'Broj sigurnosnih kopija',
    'total_storage_used' => 'Ukupno zauzeće',
    'newest_backup_date' => 'Najnovija kopija na datum',
    'oldest_backup_date' => 'Najstarija kopija na datum',
];
