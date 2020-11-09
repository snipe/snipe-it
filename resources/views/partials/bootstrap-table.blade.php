@push('css')
<link rel="stylesheet" href="{{ url(mix('css/dist/bootstrap-table.css')) }}">
@endpush

@push('js')
<script src="{{ asset(mix('js/dist/bootstrap-table.js')) }}"></script>
<script nonce="{{ csrf_token() }}">

    $(function () {

        var stickyHeaderOffsetY = 0;

        if ( $('.navbar-fixed-top').css('height') ) {
            stickyHeaderOffsetY = +$('.navbar-fixed-top').css('height').replace('px','');
        }
        if ( $('.navbar-fixed-top').css('margin-bottom') ) {
            stickyHeaderOffsetY += +$('.navbar-fixed-top').css('margin-bottom').replace('px','');
        }

        var blockedFields = "searchable,sortable,switchable,title,visible,formatter,class".split(",");

        var keyBlocked = function(key) {
            for(var j in blockedFields) {
                if(key === blockedFields[j]) {
                    return true;
                }
            }
            return false;
        }

        $('.snipe-table').bootstrapTable('destroy').bootstrapTable({
            classes: 'table table-responsive table-no-bordered',
            ajaxOptions: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            stickyHeader: true,
            stickyHeaderOffsetY: stickyHeaderOffsetY + 'px',
            undefinedText: '',
            iconsPrefix: 'fa',
            cookie: true,
            cookieExpire: '2y',
            cookieIdTable: '{{ Route::currentRouteName() }}',
            mobileResponsive: true,
            maintainSelected: true,
            trimOnSearch: false,
            paginationFirstText: "{{ trans('general.first') }}",
            paginationLastText: "{{ trans('general.last') }}",
            paginationPreText: "{{ trans('general.previous') }}",
            paginationNextText: "{{ trans('general.next') }}",
            pageList: ['10','20', '30','50','100','150','200', '500'],
            pageSize: {{  (($snipeSettings->per_page!='') && ($snipeSettings->per_page > 0)) ? $snipeSettings->per_page : 20 }},
            paginationVAlign: 'both',
            queryParams: function (params) {
                var newParams = {};
                for(var i in params) {
                    if(!keyBlocked(i)) { // only send the field if it's not in blockedFields
                        newParams[i] = params[i];
                    }
                }
                return newParams;
            },
            formatLoadingMessage: function () {
                return '<h2><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading... please wait.... </h4>';
            },
            icons: {
                advancedSearchIcon: 'fa fa-search-plus',
                paginationSwitchDown: 'fa-caret-square-o-down',
                paginationSwitchUp: 'fa-caret-square-o-up',
                columns: 'fa-columns',
                refresh: 'fa-refresh',
                export: 'fa-download'
            },
            exportTypes: ['csv', 'excel', 'doc', 'txt','json', 'xml', 'pdf'],
            onLoadSuccess: function () {
                $('[data-toggle="tooltip"]').tooltip(); // Need to attach tooltips after ajax call
            }
        });
    });





    function dateRowCheckStyle(value) {
        if ((value.days_to_next_audit) && (value.days_to_next_audit < {{ $snipeSettings->audit_warning_days ?: 0 }})) {
            return { classes : "danger" }
        }
        return {};
    }


    // Handle whether or not the edit button should be disabled
    $('.snipe-table').on('check.bs.table', function () {
        $('#bulkEdit').removeAttr('disabled');
    });

    $('.snipe-table').on('check-all.bs.table', function () {
        $('#bulkEdit').removeAttr('disabled');
    });

    $('.snipe-table').on('uncheck.bs.table', function () {
        if ($('.snipe-table').bootstrapTable('getSelections').length == 0) {
            $('#bulkEdit').attr('disabled', 'disabled');
        }
    });

    $('.snipe-table').on('uncheck-all.bs.table', function (e, row) {
        $('#bulkEdit').attr('disabled', 'disabled');
    });

    // This only works for model index pages because it uses the row's model ID
    function genericRowLinkFormatter(destination) {
        return function (value,row) {
            if (value) {
                return '<a href="{{ url('/') }}/' + destination + '/' + row.id + '"> ' + value + '</a>';
            }
        };
    }

    // Use this when we're introspecting into a column object and need to link
    function genericColumnObjLinkFormatter(destination) {
        return function (value,row) {
            if ((value) && (value.status_meta)) {

                var text_color;
                var icon_style;
                var text_help;
                var status_meta = {
                  'deployed': '{{ strtolower(trans('general.deployed')) }}',
                  'deployable': '{{ strtolower(trans('admin/hardware/general.deployable')) }}',
                  'pending': '{{ strtolower(trans('general.pending')) }}'
                }

                switch (value.status_meta) {
                    case 'deployed':
                        text_color = 'blue';
                        icon_style = 'fa-circle';
                        text_help = '<label class="label label-default">{{ trans('general.deployed') }}</label>';
                    break;
                    case 'deployable':
                        text_color = 'green';
                        icon_style = 'fa-circle';
                        text_help = '';
                    break;
                    case 'pending':
                        text_color = 'orange';
                        icon_style = 'fa-circle';
                        text_help = '';
                        break;
                    default:
                        text_color = 'red';
                        icon_style = 'fa-times';
                        text_help = '';
                }

                return '<nobr><a href="{{ url('/') }}/' + destination + '/' + value.id + '" data-toggle="tooltip" title="'+ status_meta[value.status_meta] + '"> <i class="fa ' + icon_style + ' text-' + text_color + '"></i> ' + value.name + ' ' + text_help + ' </a> </nobr>';
            } else if ((value) && (value.name)) {

                // Add some overrides for any funny urls we have
                var dest = destination;
                if (destination=='fieldsets') {
                    var dpolymorphicItemFormatterest = 'fields/fieldsets';
                }

                return '<nobr><a href="{{ url('/') }}/' + dest + '/' + value.id + '"> ' + value.name + '</a></span>';
            }
        };
    }

    function hardwareAuditFormatter(value, row) {
        return '<a href="{{ url('/') }}/hardware/audit/' + row.id + '/" class="btn btn-sm bg-yellow" data-tooltip="true" title="Audit this item">{{ trans('general.audit') }}</a>';
    }


    // Make the edit/delete buttons
    function genericActionsFormatter(owner_name, element_name = '') {
        return function (value,row) {

            var actions = '<nobr>';

            // Add some overrides for any funny urls we have
            var dest = owner_name;

            if (dest =='groups') {
                var dest = 'admin/groups';
            }

            if (dest =='maintenances') {
                var dest = 'hardware/maintenances';
            }

            if(element_name != '') {
                dest = dest + '/' + row.owner_id + '/' + element_name;
            }

            if ((row.available_actions) && (row.available_actions.clone === true)) {
                actions += '<a href="{{ url('/') }}/' + dest + '/' + row.id + '/clone" class="btn btn-sm btn-info" data-tooltip="true" title="Clone Item"><i class="fa fa-copy" aria-hidden="true"></i><span class="sr-only">Clone</span></a>&nbsp;';
            }

            if ((row.available_actions) && (row.available_actions.update === true)) {
                actions += '<a href="{{ url('/') }}/' + dest + '/' + row.id + '/edit" class="btn btn-sm btn-warning" data-tooltip="true" title="Update Item"><i class="fa fa-pencil" aria-hidden="true"></i><span class="sr-only">Update</span></a>&nbsp;';
            }

            if ((row.available_actions) && (row.available_actions.delete === true)) {
                actions += '<a href="{{ url('/') }}/' + dest + '/' + row.id + '" '
                    + ' class="btn btn-danger btn-sm delete-asset"  data-toggle="tooltip"  '
                    + ' data-toggle="modal" '
                    + ' data-content="{{ trans('general.sure_to_delete') }} ' + row.name + '?" '
                    + ' data-title="{{  trans('general.delete') }}" onClick="return false;">'
                    + '<i class="fa fa-trash" aria-hidden="true"></i><span class="sr-only">Delete</span></a>&nbsp;';
            } else {
                actions += '<a class="btn btn-danger btn-sm delete-asset disabled" onClick="return false;"><i class="fa fa-trash"></i></a>&nbsp;';
            }

            if ((row.available_actions) && (row.available_actions.restore === true)) {
                actions += '<a href="{{ url('/') }}/' + dest + '/' + row.id + '/restore" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Restore"><i class="fa fa-retweet"></i></a>&nbsp;';
            }

            actions +='</nobr>';
            return actions;

        };
    }


    // This handles the icons and display of polymorphic entries
    function polymorphicItemFormatter(value) {

        var item_destination = '';
        var item_icon;

        if ((value) && (value.type)) {

            if (value.type == 'asset') {
                item_destination = 'hardware';
                item_icon = 'fa-barcode';
            } else if (value.type == 'accessory') {
                item_destination = 'accessories';
                item_icon = 'fa-keyboard-o';
            } else if (value.type == 'component') {
                item_destination = 'components';
                item_icon = 'fa-hdd-o';
            } else if (value.type == 'consumable') {
                item_destination = 'consumables';
                item_icon = 'fa-tint';
            } else if (value.type == 'license') {
                item_destination = 'licenses';
                item_icon = 'fa-floppy-o';
            } else if (value.type == 'user') {
                item_destination = 'users';
                item_icon = 'fa-user';
            } else if (value.type == 'location') {
                item_destination = 'locations'
                item_icon = 'fa-map-marker';
            }

            return '<nobr><a href="{{ url('/') }}/' + item_destination +'/' + value.id + '" data-tooltip="true" title="' + value.type + '"><i class="fa ' + item_icon + ' text-{{ $snipeSettings->skin!='' ? $snipeSettings->skin : 'blue' }} "></i> ' + value.name + '</a></nobr>';

        } else {
            return '';
        }


    }

    // This just prints out the item type in the activity report
    function itemTypeFormatter(value, row) {

        if ((row) && (row.item) && (row.item.type)) {
            return row.item.type;
        }
    }


    // Convert line breaks to <br>
    function notesFormatter(value) {
        if (value) {
            return value.replace(/(?:\r\n|\r|\n)/g, '<br />');;
        }
    }


    // We need a special formatter for license seats, since they don't work exactly the same
    // Checkouts need the license ID, checkins need the specific seat ID

    function licenseSeatInOutFormatter(value, row) {
        // The user is allowed to check the license seat out and it's available
        if ((row.available_actions.checkout == true) && (row.user_can_checkout == true) && ((!row.asset_id) && (!row.assigned_to))) {
            return '<a href="{{ url('/') }}/licenses/' + row.license_id + '/checkout/'+row.id+'" class="btn btn-sm bg-maroon" data-toggle="tooltip" title="Check this item out">{{ trans('general.checkout') }}</a>';
        } else {
            return '<a href="{{ url('/') }}/licenses/' + row.id + '/checkin" class="btn btn-sm bg-purple" data-toggle="tooltip" title="Check in this license seat.">{{ trans('general.checkin') }}</a>';
        }

    }

    function genericCheckinCheckoutFormatter(destination) {
        return function (value,row) {

            // The user is allowed to check items out, AND the item is deployable
            if ((row.available_actions.checkout == true) && (row.user_can_checkout == true) && ((!row.asset_id) && (!row.assigned_to))) {
                    return '<a href="{{ url('/') }}/' + destination + '/' + row.id + '/checkout" class="btn btn-sm bg-maroon" data-toggle="tooltip" title="Check this item out">{{ trans('general.checkout') }}</a>';

            // The user is allowed to check items out, but the item is not deployable
            } else if (((row.user_can_checkout == false)) && (row.available_actions.checkout == true) && (!row.assigned_to)) {
                return '<div  data-toggle="tooltip" title="This item has a status label that is undeployable and cannot be checked out at this time."><a class="btn btn-sm bg-maroon disabled">{{ trans('general.checkout') }}</a></div>';

            // The user is allowed to check items in
            } else if (row.available_actions.checkin == true)  {
                if (row.assigned_to) {
                    return '<a href="{{ url('/') }}/' + destination + '/' + row.id + '/checkin" class="btn btn-sm bg-purple" data-toggle="tooltip" title="Check this item in so it is available for re-imaging, re-issue, etc.">{{ trans('general.checkin') }}</a>';
                } else if (row.assigned_pivot_id) {
                    return '<a href="{{ url('/') }}/' + destination + '/' + row.assigned_pivot_id + '/checkin" class="btn btn-sm bg-purple" data-toggle="tooltip" title="Check this item in so it is available for re-imaging, re-issue, etc.">{{ trans('general.checkin') }}</a>';
                }

            }

        }


    }


    // This is only used by the requestable assets section
    function assetRequestActionsFormatter (row, value) {
        if (value.available_actions.cancel == true)  {
            return '<form action="{{ url('/') }}/account/request-asset/'+ value.id + '" method="GET"><button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Cancel this item request">{{ trans('button.cancel') }}</button></form>';
        } else if (value.available_actions.request == true)  {
            return '<form action="{{ url('/') }}/account/request-asset/'+ value.id + '" method="GET"><button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Request this item">{{ trans('button.request') }}</button></form>';
        }

    }



    var formatters = [
        'hardware',
        'accessories',
        'consumables',
        'components',
        'locations',
        'users',
        'manufacturers',
        'maintenances',
        'statuslabels',
        'models',
        'licenses',
        'categories',
        'suppliers',
        'departments',
        'companies',
        'depreciations',
        'fieldsets',
        'groups',
        'kits'
    ];

    for (var i in formatters) {
        window[formatters[i] + 'LinkFormatter'] = genericRowLinkFormatter(formatters[i]);
        window[formatters[i] + 'LinkObjFormatter'] = genericColumnObjLinkFormatter(formatters[i]);
        window[formatters[i] + 'ActionsFormatter'] = genericActionsFormatter(formatters[i]);
        window[formatters[i] + 'InOutFormatter'] = genericCheckinCheckoutFormatter(formatters[i]);
    }

    var child_formatters = [
        ['kits', 'models'],
        ['kits', 'licenses'],
        ['kits', 'consumables'],
        ['kits', 'accessories'],
    ];

    for (var i in child_formatters) {
        var owner_name = child_formatters[i][0];
        var child_name = child_formatters[i][1];
        window[owner_name + '_' + child_name + 'ActionsFormatter'] = genericActionsFormatter(owner_name, child_name);
    }



    // This is  gross, but necessary so that we can package the API response
    // for custom fields in a more useful way.
    function customFieldsFormatter(value, row) {


            if ((!this) || (!this.title)) {
                return '';
            }

            var field_column = this.title;

            // Pull out any HTMl that might be passed via the presenter
            // (for example, the locked icon for encrypted fields)
            var field_column_plain = field_column.replace(/<(?:.|\n)*?> ?/gm, '');
            if ((row.custom_fields) && (row.custom_fields[field_column_plain])) {

                // If the field type needs special formatting, do that here
                if ((row.custom_fields[field_column_plain].field_format) && (row.custom_fields[field_column_plain].value)) {
                    if (row.custom_fields[field_column_plain].field_format=='URL') {
                        return '<a href="' + row.custom_fields[field_column_plain].value + '" target="_blank" rel="noopener">' + row.custom_fields[field_column_plain].value + '</a>';
                    } else if (row.custom_fields[field_column_plain].field_format=='EMAIL') {
                        return '<a href="mailto:' + row.custom_fields[field_column_plain].value + '">' + row.custom_fields[field_column_plain].value + '</a>';
                    }
                }
                return row.custom_fields[field_column_plain].value;

            }

    }


    function createdAtFormatter(value) {
        if ((value) && (value.formatted)) {
            return value.formatted;
        }
    }

    function externalLinkFormatter(value) {
        if (value) {
            return '<a href="' + value + '" target="_blank">' + value + '</a>';
        }
    }

    function groupsFormatter(value) {

        if (value) {
            var groups = '';
            for (var index in value.rows) {
                groups += '<a href="{{ url('/') }}/admin/groups/' + value.rows[index].id + '" class="label label-default"> ' + value.rows[index].name + '</a> ';
            }
            return groups;
        }
    }



    function changeLogFormatter(value) {
        var result = '';
            for (var index in value) {
                result += index + ': <del>' + value[index].old + '</del>  <i class="fa fa-long-arrow-right" aria-hidden="true"></i> ' + value[index].new + '<br>'
            }

        return result;

    }


    // Create a linked phone number in the table list
    function phoneFormatter(value) {
        if (value) {
            return  '<a href="tel:' + value + '">' + value + '</a>';
        }
    }


    function deployedLocationFormatter(row, value) {
        if ((row) && (row!=undefined)) {
            return '<a href="{{ url('/') }}/locations/' + row.id + '"> ' + row.name + '</a>';
        } else if (value.rtd_location) {
            return '<a href="{{ url('/') }}/locations/' + value.rtd_location.id + '" data-toggle="tooltip" title="Default Location"> ' + value.rtd_location.name + '</a>';
        }

    }

    function groupsAdminLinkFormatter(value, row) {
        return '<a href="{{ url('/') }}/admin/groups/' + row.id + '"> ' + value + '</a>';
    }

    function assetTagLinkFormatter(value, row) {
        if ((row.asset) && (row.asset.id)) {
            return '<a href="{{ url('/') }}/hardware/' + row.asset.id + '"> ' + row.asset.asset_tag + '</a>';
        }
        return '';

    }

    function departmentNameLinkFormatter(value, row) {
        if ((row.assigned_user) && (row.assigned_user.department) && (row.assigned_user.department.name)) {
            return '<a href="{{ url('/') }}/department/' + row.assigned_user.department.id + '"> ' + row.assigned_user.department.name + '</a>';
        }

    }

    function assetNameLinkFormatter(value, row) {
        if ((row.asset) && (row.asset.name)) {
            return '<a href="{{ url('/') }}/hardware/' + row.asset.id + '"> ' + row.asset.name + '</a>';
        }

    }

    function trueFalseFormatter(value) {
        if ((value) && ((value == 'true') || (value == '1'))) {
            return '<i class="fa fa-check text-success"></i>';
        } else {
            return '<i class="fa fa-times text-danger"></i>';
        }
    }

    function dateDisplayFormatter(value) {
        if (value) {
            return  value.formatted;
        }
    }

    function iconFormatter(value) {
        if (value) {
            return '<i class="' + value + '  icon-med"></i>';
        }
    }

    function emailFormatter(value) {
        if (value) {
            return '<a href="mailto:' + value + '"> ' + value + '</a>';
        }
    }

    function linkFormatter(value) {
        if (value) {
            return '<a href="' + value + '"> ' + value + '</a>';
        }
    }

    function assetCompanyFilterFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/hardware/?company_id=' + row.id + '"> ' + value + '</a>';
        }
    }

    function assetCompanyObjFilterFormatter(value, row) {
        if ((row) && (row.company)) {
            return '<a href="{{ url('/') }}/hardware/?company_id=' + row.company.id + '"> ' + row.company.name + '</a>';
        }
    }

    function usersCompanyObjFilterFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/users/?company_id=' + row.id + '"> ' + value + '</a>';
        } else {
            return value;
        }
    }

    function employeeNumFormatter(value, row) {

        if ((row) && (row.assigned_to) && ((row.assigned_to.employee_number))) {
            return '<a href="{{ url('/') }}/users/' + row.assigned_to.id + '"> ' + row.assigned_to.employee_number + '</a>';
        }
    }

    function orderNumberObjFilterFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/hardware/?order_number=' + row.order_number + '"> ' + row.order_number + '</a>';
        }
    }


   function imageFormatter(value, row) {



        if (value) {

            if (row.name) {
                var altName = row.name;
            }
                else if ((row) && (row.model)) {
                var altName = row.model.name;
           }
            return '<a href="' + value + '" data-toggle="lightbox" data-type="image"><img src="' + value + '" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive" alt="' + altName + '"></a>';
        }
    }

    function fileUploadFormatter(value) {
        if ((value) && (value.url) && (value.inlineable)) {
            return '<a href="' + value.url + '" data-toggle="lightbox" data-type="image"><img src="' + value.url + '" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive"></a>';
        } else if ((value) && (value.url)) {
            return '<a href="' + value.url + '" class="btn btn-default"><i class="fa fa-download"></i></a>';
        }
    }


    function fileUploadNameFormatter(value) {
        console.dir(value);
        if ((value) && (value.filename) && (value.url)) {
            return '<a href="' + value.url + '">' + value.filename + '</a>';
        }
    }

    function sumFormatter(data) {
        if (Array.isArray(data)) {
            var field = this.field;
            var total_sum = data.reduce(function(sum, row) {
                return (sum) + (parseFloat(row[field]) || 0);
            }, 0);
            return total_sum.toFixed(2);
        }
        return 'not an array';
    }


    $(function () {
        $('#bulkEdit').click(function () {
            var selectedIds = $('.snipe-table').bootstrapTable('getSelections');
            $.each(selectedIds, function(key,value) {
                $( "#bulkForm" ).append($('<input type="hidden" name="ids[' + value.id + ']" value="' + value.id + '">' ));
            });

        });
    });


    // This is necessary to make the bootstrap tooltips work inside of the
    // wenzhixin/bootstrap-table formatters
    $(function() {
        $('#table').on('post-body.bs.table', function () {
            $('[data-toggle="tooltip"]').tooltip({
                container: 'body'
            });
        });
    });

</script>
    
@endpush
