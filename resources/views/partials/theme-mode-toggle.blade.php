{{-- Theme-mode toggle-button wiring.

     Runs at the bottom of the page. Wires up the click handler on
     [data-theme-toggle] (the sun/moon button in the app header),
     updates its label/icon based on the current theme, and persists
     the user's choice to localStorage.

     The initial data-theme application happens in
     partials/theme-mode-preflight.blade.php (loaded in <head>) so this
     script does NOT need to worry about FOUT on first paint. It just
     hydrates the button state and attaches the toggle behavior.

     Only included from layouts/default.blade.php. layouts/basic.blade.php
     has no toggle button (login and error pages honor system/stored
     preference silently). --}}
<script nonce="{{ csrf_token() }}">
    (function () {
        var button = document.querySelector('[data-theme-toggle]');
        if (! button) {
            return;
        }

        var stored = null;
        try { stored = localStorage.getItem('theme'); } catch (e) {}
        var systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        var currentTheme = stored || (systemDark ? 'dark' : 'light');

        function updateButton(isDark) {
            var label = isDark ? '{{ trans('general.light_mode') }}' : '{{ trans('general.dark_mode') }}';
            var icon = isDark ? '<i class="fa-regular fa-sun fa-fw"></i>' : '<i class="fa-solid fa-moon fa-fw"></i>';
            // Wrap the text in a dedicated .theme-toggle-label span so
            // callers (like layouts/basic.blade.php's compact top-right
            // toggle) can hide the text via CSS while keeping the icon
            // visible. The aria-label always carries the full text
            // regardless of visual presentation for screen readers.
            button.setAttribute('aria-label', label);
            button.innerHTML = icon + ' <span class="theme-toggle-label">' + label + '</span>';
        }

        updateButton(currentTheme === 'dark');

        button.addEventListener('click', function () {
            currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
            try { localStorage.setItem('theme', currentTheme); } catch (e) {}
            document.documentElement.setAttribute('data-theme', currentTheme);
            updateButton(currentTheme === 'dark');
        });
    })();
</script>
