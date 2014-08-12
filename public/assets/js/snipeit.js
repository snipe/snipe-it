/**
 * Module containing core application logic.
 * @param  {jQuery} $        Insulated jQuery object
 * @param  {JSON} settings Insulated `window.snipeit.settings` object.
 * @return {IIFE}          Immediately invoked. Returns self.
 */
(function($, settings) {
    var Components = {};
    Components.modals = {};

    Components.example = function() {
        var paginationType = 'full_numbers';
        var $el = $('#example');

        var render = function() {
            $el.dataTable({
                "sPaginationType": paginationType,
                "iDisplayLength": settings.per_page,
                "aLengthMenu": [
                    [settings.per_page, -1],
                    [settings.per_page, "All"]
                ],
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': ['actions']
                }]
            });

            $el.popover();
        };

        return {
            render: render
        };
    };


    Components.nosorting = function() {
        var paginationType = 'full_numbers';
        var $el = $('#nosorting');

        var render = function() {
            $el.dataTable({
                "sPaginationType": paginationType,
                "fnSort": [1, 'asc'],
                "aoColumns": [{
                    "bSortable": false
                }, {
                    "bSortable": false
                }, {
                    "bSortable": false
                }, {
                    "bSortable": false
                }],
                "iDisplayLength": settings.per_page,
                "aLengthMenu": [
                    [settings.per_page, -1],
                    [settings.per_page, "All"]
                ]
            });
        };

        return {
            render: render
        };
    };

    // add uniform plugin styles to html elements
    Components.pluginStyles = function() {
        var $el = $("input:checkbox, input:radio");

        var render = function() {
            $el.uniform();
        };

        return {
            render: render
        };
    };

    // datepicker plugin
    Components.datepicker = function() {
        $el = $('.datepicker');

        var events = {
            'changeDate': function(ev) {
                $(this).datepicker('hide');
            }
        };

        var render = function() {
            $el.datepicker();
            $el.on('changeDate', events['changeDate']);
        };

        return {
            render: render
        };
    };

    // select2 plugin for select elements
    Components.select2 = function() {
        var text = "Select";
        var $el = $('.select2');

        var render = function() {
            $el.select2({
                placeholder: text
            });
        };

        return {
            render: render
        };
    };

    // jQuery Knobs
    Components.knob = function() {
        $el = $('.knob');

        var render = function() {
            $el.knob();
        };

        return {
            render: render
        };
    };

    // confirm delete modal
    Components.modals.confirmDelete = function() {
        var $el = $('.delete-asset');

        var events = {
            'click': function(evnt) {
                var $context = $(this);
                var $dataConfirmModal = $('#dataConfirmModal');
                var href = $context.attr('href');
                var message = $context.attr('data-content');
                var title = $context.attr('data-title');

                $('#myModalLabel').text(title);
                $dataConfirmModal.find('.modal-body').text(message);
                $('#dataConfirmOK').attr('href', href);
                $dataConfirmModal.modal({
                    show: true
                });
            }
        };

        var render = function() {
            $el.on('click', events['click']);
        };

        return {
            render: render
        };
    };


    /**
     * Application start point
     * Component definition stays out of load event, execution only happens.
     */
    $(function() {
        new Components.example().render();
        new Components.nosorting().render();
        new Components.pluginStyles().render();
        new Components.datepicker().render();
        new Components.select2().render();
        new Components.knob().render();
        new Components.modals.confirmDelete().render();
    });
}(jQuery, window.snipeit.settings));