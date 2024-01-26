<?php

namespace App\Services;

use Illuminate\Translation\Translator;

/***************************************************************
 * This is just a very, very light modification to the default Laravel Translator.
 * The only difference it has is that it modifies the $locale
 * value when the pluralizations are done so we can switch over from en-US to en_US (for example).
 *
 * This means our translation directories can stay where they are (en-US), but the
 * pluralization code can get executed against a locale of en_US
 * (Which is required by Symfony, for some inexplicable reason)
 *
 * This method is called by the trans_choice() helper, which we *do* use a lot.
 ***************************************************************/
class SnipeTranslator extends Translator {

    //This is copied-and-pasted (almost) verbatim from Illuminate\Translation\Translator
    public function choice($key, $number, array $replace = [], $locale = null)
    {
        $line = $this->get(
            $key, $replace, $locale = $this->localeForChoice($locale)
        );

        // If the given "number" is actually an array or countable we will simply count the
        // number of elements in an instance. This allows developers to pass an array of
        // items without having to count it on their end first which gives bad syntax.
        if (is_array($number) || $number instanceof Countable) {
            $number = count($number);
        }

        $replace['count'] = $number;

        $underscored_locale = str_replace("-","_",$locale); // OUR CHANGE.
        return $this->makeReplacements( // BELOW - that $underscored_locale is the *ONLY* modified part
            $this->getSelector()->choose($line, $number, $underscored_locale), $replace
        );
    }

}