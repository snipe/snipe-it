<script>
    var _barcode_variables = {
        'word' : '',
        'state' : 0,
        'prefix' : {{ config( 'barcode.prefix' ) }},
        'suffix' : {{ config( 'barcode.suffix' ) }},
        'limit' : {{ config( 'barcode.limit' ) }}
    };

    $(document).keypress(function(e) {

        if ( e.keyCode == _barcode_variables.prefix ) // Waiting for barcode Preffix
        {
            $("#tagSearch").blur();
            _barcode_variables.state=1;
        }
        else if ( e.keyCode == _barcode_variables.suffix ) // Wait for barcode Suffix
        {
            if (_barcode_variables.state == 1)
            {
                _barcode_variables.state = 2;
            }
            else
            {
                _barcode_variables.word='';
                _barcode_variables.state = 0;
            }
        }
        else if ( _barcode_variables.word.length > _barcode_variables.limit ) // insurance in case of not read by barcode reader
        {
            _barcode_variables.word='';
            _barcode_variables.state=0;
        }

        if (_barcode_variables.state==1 )
        {
            // if not Barcode Preffix
            if ( e.keyCode != _barcode_variables.prefix )
            {
                // put char at the end of string
                _barcode_variables.word = _barcode_variables.word + String.fromCharCode(e.keyCode);
            }
        }
        else if (_barcode_variables.state==2)
        {
            // insert scanned data into search field
            $("#tagSearch").val( _barcode_variables.word );
            $("form[role=search]").submit();

            _barcode_variables.word='';
            _barcode_variables.state=0;
        }

    });
</script>