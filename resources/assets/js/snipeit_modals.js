/* 
 * 
 * Snipe-IT Universal Modal support
 * 
 * Enables modal dialogs to create sub-resources throughout Snipe-IT
 * 
 */

 /* 
 HOW TO USE

 Create a Button looking like this:

 <a href='{{ route('modal.user') }}' data-toggle="modal"  data-target="#createModal" data-select='assigned_to' class="btn btn-sm btn-default">New</a>

 If you don't have access to Blade commands (like {{ and }}, etc), you can hard-code a URL as the 'href'

 data-toggle="modal" - required for Bootstrap Modals
 data-target="#createModal" - fixed ID for the modal, do not change
 data-select="assigned_to" - What is the *ID* of the select-dropdown that you're going to be adding to, if the modal-create was a success? Be on the lookout for duplicate ID's, it will confuse this library!
 class="btn btn-sm btn-default" - makes it look button-ey, feel free to change :)
 
 If you want to pass additional variables to the modal (In the Category Create one, for example, you can pass category_id), you can encode them as URL variables in the href
 
 */

$(function () {


  //handle modal-add-interstitial calls
  var model, select;

  if($('#createModal').length == 0) {
    $('body').append('<div class="modal fade" id="createModal"></div><!-- /.modal -->');
  }

  $('#createModal').on("show.bs.modal", function (event) {
      var link = $(event.relatedTarget);
      model = link.data("dependency");
      select = link.data("select");
      $('#createModal').load(link.attr('href'),function () {
        //do we need to re-select2 this, after load? Probably.
        $('#createModal').find('select.select2').select2();
        // Initialize the ajaxy select2 with images.
        // This is a copy/paste of the code from snipeit.js, would be great to only have this in one place.
        $('.js-data-ajax').each( function (i,item) {
            var link = $(item);
            var endpoint = link.data("endpoint");
            var select = link.data("select");

            link.select2({
                ajax: {

                    // the baseUrl includes a trailing slash
                    url: baseUrl + 'api/v1/' + endpoint + '/selectlist',
                    dataType: 'json',
                    delay: 250,
                    headers: {
                        "X-Requested-With": 'XMLHttpRequest',
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (params) {
                        var data = {
                            search: params.term,
                            page: params.page || 1,
                            assetStatusType: link.data("asset-status-type"),
                        };
                        return data;
                    },
                    processResults: function (data, params) {

                        params.page = params.page || 1;

                        var answer =  {
                            results: data.items,
                            pagination: {
                                more: "true" //(params.page  < data.page_count)
                            }
                        };

                        return answer;
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                templateResult: formatDatalist,
                templateSelection: formatDataSelection
            });
        });
      });

  });

 

  $('#createModal').on('click','#modal-save', function () {
    $.ajax({
        type: 'POST',
        url: $('.modal-body form').attr('action'),
        headers: {
            "X-Requested-With": 'XMLHttpRequest',
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },

        data: $('.modal-body form').serialize(),
        success: function (result) {

            if(result.status == "error") {
                var error_message="";
                for(var field in result.messages) {
                    error_message += "<li>Problem(s) with field <i><strong>" + field + "</strong></i>: " + result.messages[field];

                }
                $('#modal_error_msg').html(error_message).show();
                return false;
            }
            var id = result.payload.id;
            var name = result.payload.name || (result.payload.first_name + " " + result.payload.last_name);
            if(!id || !name) {
                console.error("Could not find resulting name or ID from modal-create. Name: "+name+", id: "+id);
                return false;
            }
            $('#createModal').modal('hide');
            $('#createModal').html("");

            // "select" is the original drop-down menu that someone
            // clicked 'add' on to add a new 'thing'
            // this code adds the newly created object to that select
            var selector = document.getElementById(select);

            if(!selector) {
                return false;
            }

            selector.options[selector.length] = new Option(name, id);
            selector.selectedIndex = selector.length - 1;
            $(selector).trigger("change");
            if(window.fetchCustomFields) {
                fetchCustomFields();
            }

        },
        error: function (result) {
            msg = result.responseJSON.messages || result.responseJSON.error;
            $('#modal_error_msg').html("Server Error: "+msg).show();
        }



    });
  });
});

function formatDatalist (datalist) {
    var loading_markup = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...';
    if (datalist.loading) {
        return loading_markup;
    }

    var markup = "<div class='clearfix'>" ;
    markup +="<div class='pull-left' style='padding-right: 10px;'>";
    if (datalist.image) {
        markup += "<div style='width: 30px;'><img src='" + datalist.image + "' style='max-height: 20px; max-width: 30px;'></div>";
    } else {
        markup += "<div style='height: 20px; width: 30px;'></div>";
    }

    markup += "</div><div>" + datalist.text + "</div>";
    markup += "</div>";
    return markup;
}

function formatDataSelection (datalist) {
    return datalist.text;
}
