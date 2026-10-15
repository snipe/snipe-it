{{-- Tenant color overrides for the theme-mode CSS variables.

     The static portion of what used to live in default.blade.php's
     inline <style> block moved to resources/assets/less/overrides.less
     (compiled into all.css). Only the variables that admins can
     customize via Settings > Branding stay inline so their chosen
     values interpolate at request time.

     Cascade order: overrides.less loads first (via all.css <link>),
     this inline block loads second in <head>, so these values win
     for tenants who have picked their own.

     Included from both layouts/default.blade.php and
     layouts/basic.blade.php so login and error pages carry the
     tenant's brand colors too. --}}
<style>
    :root {
        --main-theme-color: {{ $snipeSettings->header_color ?? '#3c8dbc' }};
        --btn-theme-text-color: {{ $nav_link_color ?? 'light-dark(hsl(from var(--main-theme-color) h s calc(l + 10)),hsl(from var(--main-theme-color) h s calc(l - 10)))' }};
        --nav-hover-text-color: {{ $nav_link_color ?? 'hsl(from var(--main-theme-color) h s calc(l - 10))' }};
        --nav-primary-text-color: {{ $nav_link_color ?? '#ffffff' }};
        --default-label-link-text: light-dark({{ $link_light_color ?? '#296282' }}, {{ $link_dark_color ?? '#5fa4cc' }});
    }
    [data-theme="light"] {
        --link-color: {{ $link_light_color ?? '#296282' }};
    }
    [data-theme="dark"] {
        --link-color: {{ $link_dark_color ?? '#5fa4cc' }};
    }
</style>
