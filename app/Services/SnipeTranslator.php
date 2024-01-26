<?php

namespace App\Services;

use Illuminate\Translation\Translator;
class SnipeTranslator extends Translator {

    //This is copied-and-pasted verbatim from Illuminate\Translation\Translator
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

        return $this->makeReplacements( // BELOW - that str_replace() is the *ONLY* modified part
            $this->getSelector()->choose($line, $number, str_replace("-","_",$locale)), $replace
        );
    }

}