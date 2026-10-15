{{-- Theme-mode FOUT preflight.

     Runs synchronously in <head> BEFORE the stylesheet loads so users
     whose stored preference (or OS setting) is dark do not see a
     flash of light content on first paint.

     Included from both layouts/default.blade.php and layouts/basic.blade.php
     so login and error pages get the same immediate theme application. --}}
<script nonce="{{ csrf_token() }}">
    (function () {
        try {
            var stored = localStorage.getItem('theme');
            var theme = stored || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        } catch (e) {
            // localStorage / matchMedia unavailable (private-mode edge
            // cases). Fall back to the data-theme attribute already on
            // the <html> tag.
        }
    })();
</script>
