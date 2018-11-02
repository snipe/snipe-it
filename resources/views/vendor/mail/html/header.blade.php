<tr>
    <td class="header"{!!  ($snipeSettings->header_color!='') ? ' style="background-color: '.e($snipeSettings->header_color).'"' : '' !!}>
        @if (($snipeSettings->show_images_in_email=='1' ) && ($snipeSettings::setupCompleted()))

            @if ($snipeSettings->brand == '3')
                @if ($snipeSettings->logo!='')
                    <img class="navbar-brand-img logo" src="{{ Storage::disk('public')->url('').e($snipeSettings->logo) }}"alt="{{ $snipeSettings->site_name }}">
                @endif
                {{ $snipeSettings->site_name }}

            @elseif ($snipeSettings->brand == '2')
                @if ($snipeSettings->logo!='')
                    <img class="navbar-brand-img logo" src="{{ Storage::disk('public')->url('').e($snipeSettings->logo) }}" alt="{{ $snipeSettings->site_name }}">
                @endif
            @else
                {{ $snipeSettings->site_name }}
            @endif
        @else
            Snipe-IT
        @endif
    </td>
</tr>
