<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SettingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          "brand"     => 'required|min:1|numeric',
          "qr_text"         => 'min:1|max:31',
          "logo_img"        => 'mimes:jpeg,bmp,png,gif',
          "custom_css"   => 'string',
          "alert_email"   => 'email_array',
          "slack_endpoint"   => 'url',
          "default_currency"   => 'required',
          "locale"   => 'required',
          "slack_channel"   => 'regex:/(?<!\w)#\w+/',
          "slack_botname"   => 'string',
          'labels_per_page' => 'numeric',
          'labels_width' => 'numeric',
          'labels_height' => 'numeric',
          'labels_pmargin_left' => 'numeric',
          'labels_pmargin_right' => 'numeric',
          'labels_pmargin_top' => 'numeric',
          'labels_pmargin_bottom' => 'numeric',
          'labels_display_bgutter' => 'numeric',
          'labels_display_sgutter' => 'numeric',
          'labels_fontsize' => 'numeric|min:5',
          'labels_pagewidth' => 'numeric',
          'labels_pageheight' => 'numeric',
          "ldap_server"   => 'sometimes|required_if:ldap_enabled,1|url',
          "ldap_uname"     => 'sometimes|required_if:ldap_enabled,1',
          "ldap_basedn"     => 'sometimes|required_if:ldap_enabled,1',
          "ldap_filter"     => 'sometimes|required_if:ldap_enabled,1',
          "ldap_username_field"     => 'sometimes|required_if:ldap_enabled,1',
          "ldap_lname_field"     => 'sometimes|required_if:ldap_enabled,1',
          "ldap_auth_filter_query"     => 'sometimes|required_if:ldap_enabled,1',
          "ldap_version"     => 'sometimes|required_if:ldap_enabled,1',
        ];
    }

    public function response(array $errors)
    {
        return $this->redirector->back()->withInput()->withErrors($errors, $this->errorBag);
    }
}
