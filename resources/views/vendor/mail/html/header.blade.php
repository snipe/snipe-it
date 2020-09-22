<tr>
    <td class="header"{!!  ($snipeSettings->header_color!='') ? ' style="background-color: '.e($snipeSettings->header_color).'"' : '' !!}>

        @if (($snipeSettings->show_images_in_email=='1' ) && ($snipeSettings::setupCompleted()))

            <!-- show text and logo -->
            @if ($snipeSettings->brand == '3')
                @if ($snipeSettings->email_logo!='')
                    <img class="logo-text" src="{{ Storage::disk('public')->url('').e($snipeSettings->email_logo) }}"alt="{{ $snipeSettings->site_name }}">
                @elseif ($snipeSettings->logo!='')
                    <img class="logo-text" src="{{ Storage::disk('public')->url('').e($snipeSettings->logo) }}"alt="{{ $snipeSettings->site_name }}">
                @endif

                    {{ $snipeSettings->site_name }}


            <!-- show only logo -->
            @elseif ($snipeSettings->brand == '2')
                @if ($snipeSettings->email_logo!='')
                    <img class="logo-only" style="float:left"  src="{{ Storage::disk('public')->url('').e($snipeSettings->email_logo) }}" alt="{{ $snipeSettings->site_name }}">
                @elseif ($snipeSettings->logo!='')
                    <img class="logo-only" src="{{ Storage::disk('public')->url('').e($snipeSettings->logo) }}" alt="{{ $snipeSettings->site_name }}">
                @endif

           <!-- show only text -->
            @else
                {{ $snipeSettings->site_name }}
            @endif


        @else
            {{ $snipeSettings->site_name }}
        @endif
    </td>
</tr>
