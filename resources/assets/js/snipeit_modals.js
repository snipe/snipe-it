
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
      // console.warn("Uh, href is: "+link.attr('href'));
      // console.dir(link);
      $('#createModal').load(link.attr('href'),function () {
          //do we need to re-select2 this, after load? Probably.
          $('#createModal').find('select.select2').select2();                
      });
  });


  $('#createModal').on('click','#modal-save', function () {
    console.warn("MODAL SAVE CALLED FOR MODAL!");
    var data = {};
    console.warn("We are about to SAVE!!! for model: "+model+" and select ID: "+select);
    $('.modal-body input:visible').each(function (index, elem) {
        console.warn("["+index+"]: "+elem.id+" = "+$(elem).val());
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
    console.log(data);

    $.ajax({
        type: 'POST',
        url: "/api/v1/" + model + "s",
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
            console.log(name);
            $('#createModal').modal('hide');
            $('#createModal').html("");

            // "select" is the original drop-down menu that someone
            // clicked 'add' on to add a new 'thing'
            // this code adds the newly created object to that select
            var selector = document.getElementById(select);
            //console.log(document.getElementById(select));
            selector.options[selector.length] = new Option(name, id);
            selector.selectedIndex = selector.length - 1;
            $(selector).trigger("change");
            fetchCustomFields();

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