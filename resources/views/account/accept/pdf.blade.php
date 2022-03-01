
@section('title')

@section('content')
    <div>

    </div>
    <div>
        <body>
        @foreach( $data as $pdf )
            {{$pdf->eula}}
            <br>
            {{$pdf->Signature}}
        @endforeach
        </body>
    </div>
@endsection
