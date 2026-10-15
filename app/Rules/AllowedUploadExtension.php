<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class AllowedUploadExtension implements ValidationRule
{
    /** @param  array<int, string>  $extensions  */
    public function __construct(private readonly array $extensions) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile || ! $value->isValid()) {
            $fail(trans('validation.uploaded', ['attribute' => $attribute]));

            return;
        }

        // Never let a PHP-executable extension through, even if a caller's
        // allowlist accidentally names one. Mirrors the guard baked into
        // Laravel's own `mimes:` rule via shouldBlockPhpUpload, so this rule
        // stays a safe drop-in replacement.
        $phpExecutableExtensions = [
            'php', 'php3', 'php4', 'php5', 'php7', 'php8', 'phtml', 'phar',
        ];

        $clientExtension = strtolower(trim($value->getClientOriginalExtension()));
        $allowed = array_map('strtolower', $this->extensions);

        $rejected = trans('validation.mimes', [
            'attribute' => $attribute,
            'values' => implode(', ', $allowed),
        ]);

        if (in_array($clientExtension, $phpExecutableExtensions, true)) {
            $fail($rejected);

            return;
        }

        if (! in_array($clientExtension, $allowed, true)) {
            $fail($rejected);

            return;
        }

        // Belt against content that finfo confidently identifies as
        // server-runnable, even when it wouldn't reverse-map to an
        // extension on the allowlist. Catches the classic webshell
        // upload (PHP bytes named `shell.jpg`) which otherwise slips
        // through because Symfony's guesser returns null for text/x-php
        // and the uninformative-sniff branch below would let it pass.
        // Native executable formats (PE, ELF, Mach-O) live here as
        // defense-in-depth. Shebang scripts (shell, python, perl) are
        // deliberately absent because Snipe-IT does not execute uploads
        // and script snippets in .txt attachments are legitimate.
        $executableContentMimes = [
            'text/x-php',
            'application/x-httpd-php',
            'application/x-httpd-php-source',
            'application/x-executable',
            'application/x-mach-binary',
            'application/x-elf',
            'application/x-sharedlib',
        ];

        $sniffedMime = strtolower((string) $value->getMimeType());

        if (in_array($sniffedMime, $executableContentMimes, true)) {
            $fail($rejected);

            return;
        }

        // Symfony's guessExtension() sniffs the content with finfo and
        // reverse-maps the detected MIME to an extension. It returns null
        // when libmagic matches nothing that reverse-maps cleanly (e.g.
        // INI-shaped plain text). Empty files and unknown binary blobs
        // sniff to application/x-empty and application/octet-stream,
        // which reverse-map to 'bin' but carry no real signal. Windows
        // and other thin magic databases also default to octet-stream
        // for many everyday files (see issue #10387). Treat all three
        // as "no evidence against the client extension" and defer to
        // what the client sent. When the sniff does yield a meaningful
        // extension it must also be on the allowlist, which still
        // catches obvious mislabels like an .exe renamed to .txt.
        $uninformativeMimes = ['application/octet-stream', 'application/x-empty', ''];

        if (in_array($sniffedMime, $uninformativeMimes, true)) {
            return;
        }

        $guessed = strtolower(trim((string) $value->guessExtension()));

        if ($guessed !== '' && ! in_array($guessed, $allowed, true)) {
            $fail($rejected);
        }
    }
}
