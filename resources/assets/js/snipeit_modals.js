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

 <a href='{{ route('modal.user') }}' data-toggle="modal"  data-target="#createModal" data-dependency="user" data-select='assigned_to' class="btn btn-sm btn-default">New</a>

 If you don't have access to Blade commands (like {{ and }}, etc), you can hard-code a URL as the 'href'

 data-toggle="modal" - required for Bootstrap Modals
 data-target="#createModal" - fixed ID for the modal, do not change
 data-dependency="user" - which Snipe-IT model you're going to be creating.
 data-select="assigned_to" - What is the *ID* of the select-dropdown that you're going to be adding to, if the modal-create was a success? Be on the lookout for duplicate ID's, it will confuse this library!
 class="btn btn-sm btn-default" - makes it look button-ey, feel free to change :)
 */

 $(function () {
  console.warn("Loading up Modal functionality.");

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
      });
  });


  $('#createModal').on('click','#modal-save', function () {
    var data = {};
    console.warn("We are about to SAVE!!! for model: "+model+" and select ID: "+select);
    $('.modal-body input:visible').each(function (index, elem) {
        var bits = elem.id.split("-");
        if (bits[0] === "modal") {
            data[bits[1]] = $(elem).val();
        }
    });
    //this can probably get replaced with a normal 'serialize' instead
    $('.modal-body select:visible').each(function (index, elem) {
        var bits = elem.id.split("-");
        data[bits[1]] = $(elem).val();
    });

    data._token = Laravel.csrfToken;
    //console.log(data);

    $.ajax({
        type: 'POST',
        url: "../api/v1/" + model + "s",
        headers: {
            "X-Requested-With": 'XMLHttpRequest',
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },

        data: data,
        success: function (result) {
            // {"status":"error","messages":{"name":["The name field is required."]}}
            if(result.status == "error") {
                var error_message="";
                for(var field in result.messages) {
                    error_message+="Problem(s) with field '"+field+"': "+result.messages[field].join(", ");
                }
                //window.alert("Error adding "+model+": "+error_message);
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
               // console.error("Could not find original <select> element with an id of: "+select);
                return false;
            }
            //console.log(document.getElementById(select));
            // console.dir(selector);
            selector.options[selector.length] = new Option(name, id);
            selector.selectedIndex = selector.length - 1;
            $(selector).trigger("change");
            if(window.fetchCustomFields) {
                fetchCustomFields();
            }

        },
        error: function (result) {
            // console.log('Error: ' + result.responseJSON.error.message );
            msg = result.responseJSON.messages || result.responseJSON.error;
            $('#modal_error_msg').html("Server Error: "+msg).show();
            //window.alert("Unable to add new " + model + " - error: " + msg);
        }



    });
  });
});
