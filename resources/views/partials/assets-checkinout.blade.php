<script nonce="{{ csrf_token() }}">

    $("#checkinout-form").submit(function (event) {
        $('#checkedinout-div').show();
        $('#checkinout-loader').show();

        event.preventDefault();

        var form = $("#checkinout-form").get(0);
        var formData = $('#checkinout-form').serializeArray();
        var assets = $('#bulk_assets_select').val();


        for(let i = 0; i < assets.length; i++){
            // For each asset, override previous 'asset_id' value
            formData = formData.filter(a => !(a.name === "asset_id"));
            formData.push({name: 'asset_id', value: assets[i]});
            
            if ($("#checkinout-form").hasClass("checkout-form")) {
                checkinout_url = "{{ route('api.asset.checkoutbyid') }}";
            } else if ($("#checkinout-form").hasClass("checkin-form")) {
                checkinout_url = "{{ route('api.asset.checkinbyid') }}";
            } else {
                // Should handle the error
            }

            $.ajax({
                url: checkinout_url,
                type : 'POST',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                dataType : 'json',
                data : formData,
                success : function (data) {
                    if (data.status == 'success') {
                        $('#checkedinout tbody').prepend("<tr class='success'><td>" + data.payload.asset_tag + "</td><td>" + data.payload.name + "</td><td>" + data.payload.model + "</td><td>" + data.payload.model_number + "</td><td>" + data.messages + "</td><td><i class='fas fa-check text-success'></i></td></tr>");
                        @if ($user->enable_sounds)
                        if ( ! assets.length > 1 ) {
                            var audio = new Audio('{{ config('app.url') }}/sounds/success.mp3');
                            audio.play()
                        }
                        @endif

                        incrementOnSuccess();
                    } else {
                        handlecheckinoutFail(data);
                    }
                    $('input#asset_tag').val('');
                },
                error: function (data) {
                    handlecheckinoutFail(data);
                },
                complete: function() {
                    $('#checkinout-loader').hide();
                }

            });
        }

        $('#checkinout-loader').hide();

        return false;
    });

    function handlecheckinoutFail (data) {

        @if ($user->enable_sounds)
        var audio = new Audio('{{ config('app.url') }}/sounds/error.mp3');
        audio.play()
        @endif

        if (data.payload && data.payload.asset_tag) {
            var asset_tag = data.payload.asset_tag;
            var name = data.payload.name;
            var model = data.payload.model;
            var model_number = data.payload.model_number;
        } else {
            var asset_tag = '';
            var name = '';
            var model = '';
            var model_number = '';
        }
        if (data.messages) {
            var messages = data.messages;
        } else {
            var messages = '';
        }
        $('#checkedinout tbody').prepend("<tr class='danger'><td>" + asset_tag + "</td><td>" + name + "</td><td>" + model + "</td><td>" + model_number + "</td><td>" + messages + "</td><td><i class='fas fa-times text-danger'></i></td></tr>");
    }

    function incrementOnSuccess() {
        var x = parseInt($('#checkinout-counter').html());
        y = x + 1;
        $('#checkinout-counter').html(y);
    }

    $("#checkinout_tag").focus();

</script>
