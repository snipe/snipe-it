<script nonce="{{ csrf_token() }}">

    // create the assigned assets listing box for the right side of the screen
    $(function() {
      updateQuantities();
      $('#stock_location_id_location_select').on("change", function(e) { 
        // what you would like to happen
        updateQuantities();
      });
      $('#assigned_accessory_select').on("change", function(e) { 
        // what you would like to happen
        updateQuantities();
      });
      $('input:radio[name="inventory_item_type"]').change(function() {
        updateQuantities();
      });

      function updateQuantities() {
        var item_type = $('[name=inventory_item_type]:checked').val();
        var stock_location_id = $('#stock_location_id_location_select :selected').val();
        var item_id = null;
        var endpoint = null;
        if (item_type == 'accessory') {
          item_id = $('#assigned_accessory_select :selected').val();
        }
        if (item_type == 'consumable') {
          item_id = $('#assigned_consumable_select :selected').val();
        }
        if (item_type == 'component') {
          item_id = $('#assigned_component_select :selected').val();
        }

        if (item_id && stock_location_id) {
          // get quantities here
          $.ajax({
                    type: 'GET',
                    url: '{{ url('/') }}/api/v1/locations/' + stock_location_id + '/item/' + item_type + '/' + item_id,
                    headers: {
                        "X-Requested-With": 'XMLHttpRequest',
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    },

                    dataType: 'json',
                    success: function (data) {
                        var list_html = '<ul class="list-unstyled" style="line-height: 25px; padding-bottom: 20px;">';
                        list_html += '<li><span><strong>{{ trans('admin/inventory/general.in_stock') }}</strong> ' + data.in_stock + '</span>';
                        list_html += '<li><span><strong>{{ trans('admin/inventory/general.checked_out') }}</strong> ' + data.checked_out + '</span>';
                        list_html += '<li><span><strong>{{ trans('admin/inventory/general.pending') }}</strong> ' + data.pending + '</span>';
                        list_html += '<li><span><strong>{{ trans('admin/inventory/general.archived') }}</strong> ' + data.archived + '</span>';
                        list_html += '<li><span><strong>{{ trans('admin/inventory/general.reserved_request') }}</strong> ' + data.reserved_request + '</span>';
                        list_html += '</ul>'

                        $('#current_item_location_qty_content').append('');

                        $('#current_item_location_qty_content').html(list_html);

                    },
                    error: function (data) {
                      alert('error')
                        //$('#current_assets_box').fadeOut();
                    }
                });
        } else {
          $('#current_item_location_qty_content').html("<p>Select an item and location</p>");
        }
      }

        $('#assigned_user').on("change",function () {
            var userid = $('#assigned_user option:selected').val();

            if(userid=='') {
                $('#current_item_location_qty_content').html("");
            } else {

                $.ajax({
                    type: 'GET',
                    url: '{{ url('/') }}/api/v1/users/' + userid + '/assets',
                    headers: {
                        "X-Requested-With": 'XMLHttpRequest',
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    },

                    dataType: 'json',
                    success: function (data) {
                        $('#current_assets_box').fadeIn();

                        var table_html = '<div class="row">';
                        table_html += '<div class="col-md-12">';
                        table_html += '<table class="table table-striped">';
                        table_html += '<thead><tr>';
                        table_html += '<th></th>';
                        table_html += '<th>{{ trans('admin/hardware/form.name') }}</th>';
                        table_html += '<th>{{ trans('admin/hardware/form.tag') }}</th>';
                        table_html += '<th>{{ trans('admin/hardware/form.serial') }}</th>';
                        table_html += '</tr></thead><tbody>';

                        $('#current_assets_content').append('');

                        if (data.rows.length > 0) {

                            for (var i in data.rows) {
                                var asset = data.rows[i];
                                table_html += '<tr>';
                                if (asset.image != null) {
                                    table_html += '<td class="col-md-1"><a href="' + asset.image + '" data-toggle="lightbox" data-type="image"><img src="' + asset.image + '" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;"></a></td>';
                                } else {
                                    table_html += "<td></td> ";
                                }
                                table_html += '<td><a href="{{ url('/') }}/hardware/' + asset.id + '">';

                                if ((asset.name == '') && (asset.name != null)) {
                                    table_html += " " + asset.model.name;
                                } else {
                                    table_html += asset.name;
                                    table_html += " (" + asset.model.name + ")";
                                }

                                table_html += '</a></td>';
                                table_html += '<td class="col-md-4">' + asset.asset_tag + '</td>';
                                table_html += '<td class="col-md-4">' + asset.serial + '</td>';
                                table_html += "</tr>";
                            }
                        } else {
                            table_html += '<tr><td colspan="4">No assets checked out to '+ $('.js-data-user-ajax').find('option:selected').text() + ' yet!</td></tr>';
                        }
                        $('#current_assets_content').html(table_html + '</tbody></table></div></div>');

                    },
                    error: function (data) {
                        $('#current_assets_box').fadeOut();
                    }
                });
            }
        });
    });
</script>
