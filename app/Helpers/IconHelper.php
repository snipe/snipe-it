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
            case 'users':
                return 'fas fa-users fa-fw';
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
                return 'fas fa-download';
            case 'checkmark':
                return 'fas fa-check icon-white';
            case 'x':
                return 'fas fa-times fa-fw';
            case 'logout':
                return 'fa fa-sign-out fa-fw';
            case 'admin-settings':
                return 'fa fa-cogs fa-fw';
            case 'settings':
                return 'fa fa-sign-out fa-fw';
            case 'angle-left':
                return 'fa fa-angle-left';
            case 'warning':
                return 'fas fa-exclamation-triangle';
            case 'kits':
                return 'fa fa-object-group fa-fw';
            case 'assets':
                return 'fas fa-barcode fa-fw';
            case 'accessories':
                return 'far fa-keyboard fa-fw';
            case 'components':
                return 'far fa-hdd fa-fw';
            case 'consumables':
                return 'fas fa-tint fa-fw';
            case 'licenses':
                return 'far fa-save fa-fw';
            case 'requestable':
                return 'fa fa-laptop fa-fw';
            case 'reports':
                return 'fas fa-chart-bar fa-fw';
            case 'heart':
                return 'fas fa-heart';
            case 'circle':
                return 'far fa-circle';
            case 'due':
                return 'fas fa-history fa-fw';
            case 'import':
                return 'fas fa-cloud-upload-alt fa-fw';
            case 'search':
                return 'fas fa-search';
            case 'alerts':
                return 'far fa-flag';
            case 'password':
                return 'fa-solid fa-asterisk fa-fw';
            case 'api-key':
                return 'fa-solid fa-user-secret fa-fw';
            case 'nav-toggle':
                return 'fas fa-bars';
            case 'dashboard':
                return 'fas fa-tachometer-alt fa-fw';
            case 'info-circle':
                    return 'fas fa-info-circle';
            case 'carat-right':
                return 'fa fa-caret-right';
            case 'carat-up':
                return 'fa fa-caret-up';
        }
    }
}
