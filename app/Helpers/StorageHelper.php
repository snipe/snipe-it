<?php

namespace App\Helpers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use League\Csv\EscapeFormula;
use League\Csv\Reader;
use League\Csv\Writer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StorageHelper
{
    public static function downloader($filename, $disk = 'default'): BinaryFileResponse|RedirectResponse|StreamedResponse
    {
        if ($disk == 'default') {
            $disk = config('filesystems.default');
        }

        // Neutralize the response so a browser can't be tricked into treating
        // an uploaded file as active content: force a generic content type,
        // stop MIME sniffing, and keep the attachment disposition.
        $safeHeaders = [
            'Content-Type' => 'application/octet-stream',
            'X-Content-Type-Options' => 'nosniff',
        ];

        // Formula-injection guard for CSV attachments. Every CSV going
        // out gets its cells run through EscapeFormula so `=cmd|...`,
        // `+HYPERLINK(...)`, `@SUM(...)`, etc. are treated as literal
        // text by Excel / LibreOffice / Google Sheets rather than live
        // formulas. Same backtick prefix and config gate the CSV
        // exporters in ReportsController / SettingsController use.
        // Skipped when app.escape_formulas is explicitly false.
        if (str_ends_with(strtolower((string) $filename), '.csv')
            && config('app.escape_formulas') !== false) {
            return self::downloadSanitizedCsv($filename, $disk, $safeHeaders);
        }

        switch (config("filesystems.disks.$disk.driver")) {
            case 'local':
                return response()->download(Storage::disk($disk)->path($filename), null, $safeHeaders);

            case 's3':
                return redirect()->to(Storage::disk($disk)->temporaryUrl(
                    $filename,
                    now()->addMinutes(5),
                    [
                        'ResponseContentType' => 'application/octet-stream',
                        'ResponseContentDisposition' => 'attachment; filename="'.basename($filename).'"',
                    ]
                ));

            default:
                return Storage::disk($disk)->download($filename, null, $safeHeaders);
        }
    }

    /**
     * Read a stored CSV, escape every cell that could act as a formula
     * on open, and stream the sanitized bytes back with the original
     * filename. Runs against any driver (local / S3 / whatever) since
     * we pull bytes through the Storage facade rather than the on-disk
     * path — costs one round-trip through the app for S3 CSV downloads,
     * which is the price of the safety guarantee.
     */
    private static function downloadSanitizedCsv(string $filename, string $disk, array $headers): StreamedResponse
    {
        $bytes = Storage::disk($disk)->get($filename) ?? '';
        $downloadName = basename($filename);
        $sanitized = self::sanitizeCsvBytes($bytes);

        return response()->streamDownload(
            function () use ($sanitized): void {
                echo $sanitized;
            },
            $downloadName,
            $headers,
        );
    }

    /**
     * Escape every cell in a CSV string using the same backtick prefix
     * that Snipe-IT's own CSV exporters use. Preserves row / column
     * shape and does nothing to genuinely-safe content — cells that
     * don't start with `=`, `+`, `-`, `@`, tab, or carriage-return pass
     * through unchanged.
     */
    private static function sanitizeCsvBytes(string $bytes): string
    {
        if ($bytes === '') {
            return $bytes;
        }

        $reader = Reader::createFromString($bytes);
        $writer = Writer::createFromString('');
        $formatter = new EscapeFormula('`');

        foreach ($reader->getRecords() as $record) {
            $writer->insertOne($formatter->escapeRecord($record));
        }

        return $writer->toString();
    }

    public static function getMediaType($file_with_path)
    {

        // Get the file extension and determine the media type
        if (Storage::exists($file_with_path)) {
            $fileinfo = pathinfo($file_with_path);
            $extension = strtolower($fileinfo['extension']);
            switch ($extension) {
                case 'avif':
                case 'jpg':
                case 'png':
                case 'gif':
                case 'svg':
                case 'webp':
                    return 'image';
                case 'pdf':
                    return 'pdf';
                case 'mp3':
                case 'wav':
                case 'ogg':
                    return 'audio';
                case 'mp4':
                case 'webm':
                case 'mov':
                    return 'video';
                case 'doc':
                case 'docx':
                    return 'document';
                case 'txt':
                    return 'text';
                case 'xls':
                case 'xlsx':
                case 'ods':
                    return 'spreadsheet';
                default:
                    return $extension; // Default for unknown types
            }
        }

        return null;
    }

    /**
     * This determines the file types that should be allowed inline and checks their fileinfo extension
     * to determine that they are safe to display inline.
     *
     * @author <A. Gianotto> [<snipe@snipe.net]>
     *
     * @since  v7.0.14
     *
     * @return bool
     */
    public static function allowSafeInline($file_with_path)
    {
        // Extension is the coarse gate; the server-detected MIME must also
        // land in the extension's allowed set (config/filesystems.php →
        // allowed_inline_display), so a .png that is actually XML/HTML/XSLT
        // can't ride the extension check into an inline response.
        $allowed_inline = config('filesystems.allowed_inline_display', []);

        if (! Storage::exists($file_with_path)) {
            return false;
        }

        $extension = strtolower(pathinfo($file_with_path, PATHINFO_EXTENSION));

        if (! isset($allowed_inline[$extension])) {
            return false;
        }

        try {
            $detected = Storage::mimeType($file_with_path);
        } catch (\Throwable) {
            return false;
        }

        return $detected && in_array($detected, $allowed_inline[$extension], true);
    }

    public static function getFiletype($file_with_path)
    {

        // The file exists and is allowed to be displayed inline
        if (Storage::exists($file_with_path)) {
            return pathinfo($file_with_path, PATHINFO_EXTENSION);
        }

        return null;

    }

    /**
     * Return a local filesystem path the caller can hand to native PHP
     * methods like `getimagesize()`, `fopen()`, or TCPDF's image writer,
     * regardless of the underlying disk driver.
     *
     * Returns null when the file doesn't exist on the disk, matching
     * the existing `->exists()` semantics used elsewhere in this class.
     *
     * @param  string  $filename  path relative to the disk root
     * @param  string  $disk  filesystem disk name (defaults to `public`)
     * @return string|null local path, or null if the file is missing
     */
    public static function readablePath(string $filename, string $disk = 'public'): ?string
    {
        if (! Storage::disk($disk)->exists($filename)) {
            return null;
        }

        // Local disk: return the real filesystem path directly. No temp file
        if (config("filesystems.disks.$disk.driver") === 'local') {
            return Storage::disk($disk)->path($filename);
        }

        // Non-local disk: stream the object into a temp file so callers can treat it
        // like a local path.
        // Preserving the original extension matters for methods like
        // getimagesize() that sniff the file type via the extension
        // before reading bytes.
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $tmp = tempnam(sys_get_temp_dir(), 'snipeit-readable-');
        if ($tmp === false) {
            return null;
        }
        if ($extension !== '') {
            $tmpWithExt = $tmp.'.'.$extension;
            if (! @rename($tmp, $tmpWithExt)) {
                @unlink($tmp);

                return null;
            }
            $tmp = $tmpWithExt;
        }

        $stream = Storage::disk($disk)->readStream($filename);
        if ($stream === null) {
            @unlink($tmp);

            return null;
        }
        $handle = fopen($tmp, 'wb');
        if ($handle === false) {
            fclose($stream);
            @unlink($tmp);

            return null;
        }
        stream_copy_to_stream($stream, $handle);
        fclose($handle);
        fclose($stream);

        // Auto-clean at request end so the caller doesn't own the
        // lifecycle. Register once per file so many calls in the same
        // request each get their own cleanup.
        register_shutdown_function(fn () => @unlink($tmp));

        return $tmp;
    }
}
