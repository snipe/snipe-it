/**
 * @author vincent loh <vincent.ml@gmail.com>
 * @version: v1.1.0
 * https://github.com/vinzloh/bootstrap-table/
 * Sticky header for bootstrap-table
 * @update J Manuel Corona <jmcg92@gmail.com>
 */

(function ($) {
    'use strict';

    var sprintf = $.fn.bootstrapTable.utils.sprintf;
    $.extend($.fn.bootstrapTable.defaults, {
        stickyHeader: false
    });
    
    var bootstrapVersion = 3;
    try {
        bootstrapVersion = parseInt($.fn.dropdown.Constructor.VERSION, 10);
    } catch (e) { }
    var hidden_class = bootstrapVersion > 3 ? 'd-none' : 'hidden';

    var BootstrapTable = $.fn.bootstrapTable.Constructor,
        _initHeader = BootstrapTable.prototype.initHeader;

    BootstrapTable.prototype.initHeader = function () {
        var that = this;
        _initHeader.apply(this, Array.prototype.slice.apply(arguments));

        if (!this.options.stickyHeader) {
            return;
        }

        var table = this.$tableBody.find('table'),
            table_id = table.attr('id'),
            header_id = table.attr('id') + '-sticky-header',
            sticky_header_container_id = header_id +'-sticky-header-container',
            anchor_begin_id = header_id +'_sticky_anchor_begin',
            anchor_end_id = header_id +'_sticky_anchor_end';
        // add begin and end anchors to track table position

        table.before(sprintf('<div id="%s" class="%s"></div>', sticky_header_container_id, hidden_class));
        table.before(sprintf('<div id="%s"></div>', anchor_begin_id));
        table.after(sprintf('<div id="%s"></div>', anchor_end_id));

        table.find('thead').attr('id', header_id);

        // clone header just once, to be used as sticky header
        // deep clone header. using source header affects tbody>td width
        this.$stickyHeader = $($('#'+header_id).clone(true, true));
        // avoid id conflict
        this.$stickyHeader.removeAttr('id');

        // render sticky on window scroll or resize
        $(window).on('resize.'+table_id, table, render_sticky_header);
        $(window).on('scroll.'+table_id, table, render_sticky_header);
        // render sticky when table scroll left-right
        table.closest('.fixed-table-container').find('.fixed-table-body').on('scroll.'+table_id, table, match_position_x);

        this.$el.on('all.bs.table', function (e) {
            that.$stickyHeader = $($('#'+header_id).clone(true, true));
            that.$stickyHeader.removeAttr('id');
        });

        function render_sticky_header(event) {
            var table = event.data;
            var table_header_id = table.find('thead').attr('id');
            // console.log('render_sticky_header for > '+table_header_id);
            if (table.length < 1 || $('#'+table_id).length < 1){
                // turn off window listeners
                $(window).off('resize.'+table_id);
                $(window).off('scroll.'+table_id);
                table.closest('.fixed-table-container').find('.fixed-table-body').off('scroll.'+table_id);
                return;
            }
            // get header height
            var header_height = '0';
            if (that.options.stickyHeaderOffsetY) header_height = that.options.stickyHeaderOffsetY.replace('px','');
            // window scroll top
            var t = $(window).scrollTop();
            // top anchor scroll position, minus header height
            var e = $("#"+anchor_begin_id).offset().top - header_height;
            // bottom anchor scroll position, minus header height, minus sticky height
            var e_end = $("#"+anchor_end_id).offset().top - header_height - $('#'+table_header_id).css('height').replace('px','');
            // show sticky when top anchor touches header, and when bottom anchor not exceeded
            if (t > e && t <= e_end) {
                // ensure clone and source column widths are the same
                $.each( that.$stickyHeader.find('tr').eq(0).find('th'), function (index, item) {
                    $(item).css('min-width', $('#'+table_header_id+' tr').eq(0).find('th').eq(index).css('width'));
                });
                // match bootstrap table style
                $("#"+sticky_header_container_id).removeClass(hidden_class).addClass("fix-sticky fixed-table-container") ;
                // stick it in position
                $("#"+sticky_header_container_id).css('top', header_height + 'px');
                // create scrollable container for header
                var scrollable_div = $('<div style="position:absolute;width:100%;overflow-x:hidden;" />');
                // append cloned header to dom
                $("#"+sticky_header_container_id).html(scrollable_div.append(that.$stickyHeader));
                // match clone and source header positions when left-right scroll
                match_position_x(event);
            } else {
                // hide sticky
                $("#"+sticky_header_container_id).removeClass("fix-sticky").addClass(hidden_class);
            }

        }
        function match_position_x(event){
            var table = event.data;
            var table_header_id = table.find('thead').attr('id');
            // match clone and source header positions when left-right scroll
            $("#"+sticky_header_container_id).css(
                'width', +table.closest('.fixed-table-body').css('width').replace('px', '') + 1
            );
            $("#"+sticky_header_container_id+" thead").parent().scrollLeft(Math.abs($('#'+table_header_id).position().left));
        }
    };

})(jQuery);

/**
 * @author: aperez <aperez@datadec.es>
 * @version: v2.0.0
 *
 * @update Dennis Hernández <http://djhvscf.github.io/Blog>
 */

!function($) {
    'use strict';

    var firstLoad = false;

    var sprintf = $.fn.bootstrapTable.utils.sprintf;

    var showAvdSearch = function(pColumns, searchTitle, searchText, that) {
        if (!$("#avdSearchModal" + "_" + that.options.idTable).hasClass("modal")) {
            var vModal = sprintf("<div id=\"avdSearchModal%s\"  class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"mySmallModalLabel\" aria-hidden=\"true\">", "_" + that.options.idTable);
            vModal += "<div class=\"modal-dialog modal-xs\">";
            vModal += " <div class=\"modal-content\">";
            vModal += "  <div class=\"modal-header\">";
            vModal += "   <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\" >&times;</button>";
            vModal += sprintf("   <h4 class=\"modal-title\">%s</h4>", searchTitle);
            vModal += "  </div>";
            vModal += "  <div class=\"modal-body modal-body-custom\">";
            vModal += sprintf("   <div class=\"container-fluid\" id=\"avdSearchModalContent%s\" style=\"padding-right: 0px;padding-left: 0px;\" >", "_" + that.options.idTable);
            vModal += "   </div>";
            vModal += "  </div>";
            vModal += "  </div>";
            vModal += " </div>";
            vModal += "</div>";

            $("body").append($(vModal));

            var vFormAvd = createFormAvd(pColumns, searchText, that),
                timeoutId = 0;;

            $('#avdSearchModalContent' + "_" + that.options.idTable).append(vFormAvd.join(''));

            $('#' + that.options.idForm).off('keyup blur', 'input').on('keyup blur', 'input', function (event) {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function () {
                    that.onColumnAdvancedSearch(event);
                }, that.options.searchTimeOut);
            });

            $("#btnCloseAvd" + "_" + that.options.idTable).click(function() {
                $("#avdSearchModal" + "_" + that.options.idTable).modal('hide');
            });

            $("#avdSearchModal" + "_" + that.options.idTable).modal();
        } else {
            $("#avdSearchModal" + "_" + that.options.idTable).modal();
        }
    };

    var createFormAvd = function(pColumns, searchText, that) {
        var htmlForm = [];
        htmlForm.push(sprintf('<form class="form-horizontal" id="%s" action="%s" >', that.options.idForm, that.options.actionForm));
        for (var i in pColumns) {
            var vObjCol = pColumns[i];
            if (!vObjCol.checkbox && vObjCol.visible && vObjCol.searchable) {
                htmlForm.push('<div class="form-group">');
                htmlForm.push(sprintf('<label class="col-sm-4 control-label">%s</label>', vObjCol.title));
                htmlForm.push('<div class="col-sm-6">');
                htmlForm.push(sprintf('<input type="text" class="form-control input-md" name="%s" placeholder="%s" id="%s">', vObjCol.field, vObjCol.title, vObjCol.field));
                htmlForm.push('</div>');
                htmlForm.push('</div>');
            }
        }

        htmlForm.push('<div class="form-group">');
        htmlForm.push('<div class="col-sm-offset-9 col-sm-3">');
        htmlForm.push(sprintf('<button type="button" id="btnCloseAvd%s" class="btn btn-default" >%s</button>', "_" + that.options.idTable, searchText));
        htmlForm.push('</div>');
        htmlForm.push('</div>');
        htmlForm.push('</form>');

        return htmlForm;
    };

    $.extend($.fn.bootstrapTable.defaults, {
        advancedSearch: false,
        idForm: 'advancedSearch',
        actionForm: '',
        idTable: undefined,
        onColumnAdvancedSearch: function (field, text) {
            return false;
        }
    });

    $.extend($.fn.bootstrapTable.defaults.icons, {
        advancedSearchIcon: 'glyphicon-chevron-down'
    });

    $.extend($.fn.bootstrapTable.Constructor.EVENTS, {
        'column-advanced-search.bs.table': 'onColumnAdvancedSearch'
    });

    $.extend($.fn.bootstrapTable.locales, {
        formatAdvancedSearch: function() {
            return 'Advanced search';
        },
        formatAdvancedCloseButton: function() {
            return "Close";
        }
    });

    $.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales);

    var BootstrapTable = $.fn.bootstrapTable.Constructor,
        _initToolbar = BootstrapTable.prototype.initToolbar,
        _load = BootstrapTable.prototype.load,
        _initSearch = BootstrapTable.prototype.initSearch;

    BootstrapTable.prototype.initToolbar = function() {
        _initToolbar.apply(this, Array.prototype.slice.apply(arguments));

        if (!this.options.search) {
            return;
        }

        if (!this.options.advancedSearch) {
            return;
        }

        if (!this.options.idTable) {
            return;
        }

        var that = this,
            html = [];

        html.push(sprintf('<div class="columns columns-%s btn-group pull-%s" role="group">', this.options.buttonsAlign, this.options.buttonsAlign));
        html.push(sprintf('<button class="btn btn-default%s' + '" type="button" name="advancedSearch" aria-label="advanced search" title="%s">', that.options.iconSize === undefined ? '' : ' btn-' + that.options.iconSize, that.options.formatAdvancedSearch()));
        html.push(sprintf('<i class="%s %s"></i>', that.options.iconsPrefix, that.options.icons.advancedSearchIcon))
        html.push('</button></div>');

        that.$toolbar.prepend(html.join(''));

        that.$toolbar.find('button[name="advancedSearch"]')
            .off('click').on('click', function() {
                showAvdSearch(that.columns, that.options.formatAdvancedSearch(), that.options.formatAdvancedCloseButton(), that);
            });
    };

    BootstrapTable.prototype.load = function(data) {
        _load.apply(this, Array.prototype.slice.apply(arguments));

        if (!this.options.advancedSearch) {
            return;
        }

        if (typeof this.options.idTable === 'undefined') {
            return;
        } else {
            if (!firstLoad) {
                var height = parseInt($(".bootstrap-table").height());
                height += 10;
                $("#" + this.options.idTable).bootstrapTable("resetView", {height: height});
                firstLoad = true;
            }
        }
    };

    BootstrapTable.prototype.initSearch = function () {
        _initSearch.apply(this, Array.prototype.slice.apply(arguments));

        if (!this.options.advancedSearch) {
            return;
        }

        var that = this;
        var fp = $.isEmptyObject(this.filterColumnsPartial) ? null : this.filterColumnsPartial;

        this.data = fp ? $.grep(this.data, function (item, i) {
            for (var key in fp) {
                var fval = fp[key].toLowerCase();
                var value = item[key];
                value = $.fn.bootstrapTable.utils.calculateObjectValue(that.header,
                    that.header.formatters[$.inArray(key, that.header.fields)],
                    [value, item, i], value);

                if (!($.inArray(key, that.header.fields) !== -1 &&
                    (typeof value === 'string' || typeof value === 'number') &&
                    (value + '').toLowerCase().indexOf(fval) !== -1)) {
                    return false;
                }
            }
            return true;
        }) : this.data;
    };

    BootstrapTable.prototype.onColumnAdvancedSearch = function (event) {
        var text = $.trim($(event.currentTarget).val());
        var $field = $(event.currentTarget)[0].id;

        if ($.isEmptyObject(this.filterColumnsPartial)) {
            this.filterColumnsPartial = {};
        }
        if (text) {
            this.filterColumnsPartial[$field] = text;
        } else {
            delete this.filterColumnsPartial[$field];
        }

        this.options.pageNumber = 1;
        this.onSearch(event);
        this.updatePagination();
        this.trigger('column-advanced-search', $field, text);
    };
}(jQuery);
