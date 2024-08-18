<?php

namespace App\Helpers;

class IconHelper
{

    public static function icon($type) {
        switch ($type) {
            case 'checkout':
                return 'fa-solid fa-rotate-left';
                break;
            case 'checkin':
                return 'fa-solid fa-rotate-right';
                break;
            case 'edit':
                return 'fas fa-pencil-alt';
                break;
            case 'clone':
                return 'far fa-clone';
                break;
            case 'delete':
                return 'fas fa-trash';
                break;
            case 'create':
                return 'fa-solid fa-plus';
                break;
            case 'audit':
                return 'fa-solid fa-clipboard-check';
                break;
            case '2fa reset':
                return 'fa-solid fa-mobile-screen';
                break;
            case 'new-user':
                return 'fa-solid fa-user-plus';
                break;
            case 'merged-user':
                return 'fa-solid fa-people-arrows';
                break;
            case 'delete-user':
                return 'fa-solid fa-user-minus';
                break;
            case 'update-user':
                return 'fa-solid fa-user-pen';
                break;
            case 'user':
                return 'fa-solid fa-user';
                break;
            case 'restore':
                return 'fa-solid fa-trash-arrow-up';
                break;
            case 'external-link':
                return 'fa fa-external-link';
                break;
            case 'email':
                return 'fa-regular fa-envelope';
                break;
            case 'phone':
                return 'fa-solid fa-phone';
                break;
            case 'long-arrow':
                return 'fas fa-long-arrow-alt-right';
                break;
        }
    }
}
