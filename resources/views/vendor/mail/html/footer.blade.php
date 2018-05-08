<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
            <tr>
                <td class="content-cell" align="center">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}

                    @if ($snipeSettings->privacy_policy_link!='')
                        <a href="{{ $snipeSettings->privacy_policy_link }}">{{ trans('admin/settings/general.privacy_policy') }}</a>
                    @endif


                </td>
            </tr>
        </table>
    </td>
</tr>
