<tr>
    <td class="header">
        @if (($snipeSettings->show_images_in_email=='1' ) && ($snipeSettings::setupCompleted()))

            @if ($snipeSettings->brand == '3')
                @if ($snipeSettings->logo!='')
                    <img class="navbar-brand-img logo" src="{{ url('/') }}/uploads/{{ $snipeSettings->logo }}">
                @endif
                {{ $snipeSettings->site_name }}

            @elseif ($snipeSettings->brand == '2')
                @if ($snipeSettings->logo!='')
                    <img class="navbar-brand-img logo" src="{{ url('/') }}/uploads/{{ $snipeSettings->logo }}">
                @endif
            @else
                {{ $snipeSettings->site_name }}
            @endif
        @else
            Snipe-IT
        @endif
    </td>
</tr>
