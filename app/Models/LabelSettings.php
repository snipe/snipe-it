<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Watson\Validating\ValidatingTrait;

class LabelSettings extends Model
{
    use ValidatingTrait;

    /**
     * The app settings cache key name.
     *
     * @var string
     */
    const APP_LABEL_SETTINGS_KEY = 'snipeit_app_settings';

    /**
     * Model rules.
     *
     * @var array
     */

    protected $rules = [
        'name'                                => 'max:255',
        'labels_per_page'                     => 'numeric',
        'labels_width'                        => 'numeric',
        'labels_height'                       => 'numeric',
        'labels_pmargin_left'                 => 'numeric|nullable',
        'labels_pmargin_right'                => 'numeric|nullable',
        'labels_pmargin_top'                  => 'numeric|nullable',
        'labels_pmargin_bottom'               => 'numeric|nullable',
        'labels_display_bgutter'              => 'numeric|nullable',
        'labels_display_sgutter'              => 'numeric|nullable',
        'labels_fontsize'                     => 'numeric|min:5',
        'labels_pagewidth'                    => 'numeric|nullable',
        'labels_pageheight'                   => 'numeric|nullable',
    ];
    protected $table= 'label_settings';
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'labels_per_page',
        'labels_width',
        'labels_height',
        'labels_pmargin_left',
        'labels_pmargin_right',
        'labels_pmargin_top',
        'labels_pmargin_bottom',
        'labels_displayt_bgutter',
        'labels_display_sgutter',
        'labels_fontsize',
        'labels_pagewidth',
        'labels_pageheight',
        ];

    public static function getLabelSettings(): ?self
    {
        return Cache::rememberForever(self::APP_LABEL_SETTINGS_KEY, function () {
            // Need for setup as no tables exist
            try {
                return self::first();
            } catch (\Throwable $th) {
                return null;
            }
        });
    }
}
