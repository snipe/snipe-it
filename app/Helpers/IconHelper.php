<?php

namespace App\Helpers;

class IconHelper
{

    public static function icon($type) {
        switch ($type) {
            case 'checkout':
                return 'fa-solid fa-rotate-left';
            case 'checkin':
                return 'fa-solid fa-rotate-right';
            case 'edit':
                return 'fas fa-pencil-alt';
            case 'clone':
                return 'far fa-clone';
            case 'delete':
                return 'fas fa-trash';
            case 'create':
                return 'fa-solid fa-plus';
            case 'audit':
                return 'fa-solid fa-clipboard-check';
            case '2fa reset':
                return 'fa-solid fa-mobile-screen';
            case 'new-user':
                return 'fa-solid fa-user-plus';
            case 'merged-user':
                return 'fa-solid fa-people-arrows';
            case 'delete-user':
                return 'fa-solid fa-user-minus';
            case 'update-user':
                return 'fa-solid fa-user-pen';
            case 'user':
                return 'fa-solid fa-user';
            case 'restore':
                return 'fa-solid fa-trash-arrow-up';
            case 'external-link':
                return 'fa fa-external-link';
            case 'email':
                return 'fa-regular fa-envelope';
            case 'phone':
                return 'fa-solid fa-phone';
            case 'long-arrow':
                return 'fas fa-long-arrow-alt-right';
            case 'download':
                return 'as fa-download';

        }
    }
}
