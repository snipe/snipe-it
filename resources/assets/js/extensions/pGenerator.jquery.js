/*!
 * pGenerator jQuery Plugin v1.0.5
 * https://github.com/M1Sh0u/pGenerator
 *
 * Created by Mihai MATEI <mihai.matei@outlook.com>
 * Released under the MIT License (Feel free to copy, modify or redistribute this plugin.)
 */

(function($){

    var numbers_array       = [],
        upper_letters_array = [],
        lower_letters_array = [],
        special_chars_array = [],
        $pGeneratorElement  = null;

    /**
     * Plugin methods.
     *
     * @type {{init: init, generatePassword: generatePassword}}
     */
    var methods = {

        /**
         * Initialize the object.
         *
         * @param options
         * @param callbacks
         *
         * @returns {*}
         */
        init: function(options, callbacks)
        {
            var settings = $.extend({
                'bind': 'click',
                'passwordElement': null,
                'displayElement': null,
                'passwordLength': 16,
                'uppercase': true,
                'lowercase': true,
                'numbers':   true,
                'specialChars': true,
                'additionalSpecialChars': [],
                'onPasswordGenerated': function(generatedPassword) { }
            }, options);

            for(var i = 48; i < 58; i++) {
                numbers_array.push(i);
            }

            for(i = 65; i < 91; i++) {
                upper_letters_array.push(i);
            }

            for(i = 97; i < 123; i++) {
                lower_letters_array.push(i);
            }
            
            special_chars_array = [33, 35, 64, 36, 38, 42, 91, 93, 123, 125, 92, 47, 63, 58, 59, 95, 45].concat(settings.additionalSpecialChars);

            return this.each(function(){

                $pGeneratorElement = $(this);

                $pGeneratorElement.bind(settings.bind, function(e){
                    e.preventDefault();
                    methods.generatePassword(settings);
                });

            });
        },

        /**
         * Generate the password.
         *
         * @param {object} settings
         */
        generatePassword: function(settings)
        {
            var password = new Array(),
                selOptions = settings.uppercase + settings.lowercase + settings.numbers + settings.specialChars,
                selected = 0,
                no_lower_letters = new Array();

            var optionLength = Math.floor(settings.passwordLength / selOptions);

            if(settings.uppercase) {
                // uppercase letters
                for(var i = 0; i < optionLength; i++) {
                    password.push(String.fromCharCode(upper_letters_array[randomFromInterval(0, upper_letters_array.length - 1)]));
                }

                no_lower_letters = no_lower_letters.concat(upper_letters_array);

                selected++;
            }

            if(settings.numbers) {
                // numbers letters
                for(var i = 0; i < optionLength; i++) {
                    password.push(String.fromCharCode(numbers_array[randomFromInterval(0, numbers_array.length - 1)]));
                }

                no_lower_letters = no_lower_letters.concat(numbers_array);

                selected++;
            }

            if(settings.specialChars) {
                // numbers letters
                for(var i = 0; i < optionLength; i++) {
                    password.push(String.fromCharCode(special_chars_array[randomFromInterval(0, special_chars_array.length - 1)]));
                }

                no_lower_letters = no_lower_letters.concat(special_chars_array);

                selected++;
            }

            var remained = settings.passwordLength - (selected * optionLength);

            if(settings.lowercase) {

                for(var i = 0; i < remained; i++) {
                    password.push(String.fromCharCode(lower_letters_array[randomFromInterval(0, lower_letters_array.length - 1)]));
                }

            } else {

                for(var i = 0; i < remained; i++) {
                    password.push(String.fromCharCode(no_lower_letters[randomFromInterval(0, no_lower_letters.length - 1)]));
                }
            }

            password = shuffle(password).join('');

            if(settings.passwordElement !== null) {
                $(settings.passwordElement).val(password);
            }

            if(settings.displayElement !== null) {
                if($(settings.displayElement).is("input")) {
                    $(settings.displayElement).val(password);
                } else {
                    $(settings.displayElement).text(password);
                }
            }

            settings.onPasswordGenerated(password);
        }
    };

    /**
     * Shuffle the password.
     *
     * @param {Array} o
     *
     * @returns {Array}
     */
    function shuffle(o)
    {
        for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);

        return o;
    }

    /**
     * Get a random number in the given interval.
     *
     * @param {number} from
     * @param {number} to
     *
     * @returns {number}
     */
    function randomFromInterval(from, to)
    {
        return Math.floor(Math.random()*(to-from+1)+from);
    }

    /**
     * Define the pGenerator jQuery plugin.
     *
     * @param method
     * @returns {*}
     */
    $.fn.pGenerator = function(method)
    {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        }
        else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        }
        else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.pGenerator' );
        }
    };

})(jQuery);