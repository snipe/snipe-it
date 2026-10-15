<?php

namespace Tests\Feature\Blade;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\License;
use App\Models\User;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Support\Facades\Blade;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

class InfoPanelNotesTest extends TestCase
{
    #[TestWith([Asset::class], 'asset')]
    #[TestWith([Accessory::class], 'accessory')]
    #[TestWith([License::class], 'license')]
    public function test_notes_preserve_text_after_an_unclosed_html_tag(string $modelClass): void
    {
        $notes = "prefix <unfinished\nRemaining details";

        $document = $this->render_info_panel($notes, $modelClass);
        $element = $this->notes_element($document);

        $this->assertSame($notes, $element->textContent);
        $this->assertSame(1, $element->getElementsByTagName('br')->length);
        $this->assertSame(1, $document->query('//*[@data-clipboard-target=".js-copy-notes"]')->length);
    }

    public function test_notes_keep_inline_markdown_formatting(): void
    {
        $element = $this->notes_element($this->render_info_panel(
            '**Warning** *important* `a<b & c` [Manual](https://example.com)'
        ));

        $this->assertSame('Warning', $element->getElementsByTagName('strong')->item(0)?->textContent);
        $this->assertSame('important', $element->getElementsByTagName('em')->item(0)?->textContent);
        $this->assertSame('a<b & c', $element->getElementsByTagName('code')->item(0)?->textContent);
        $link = $element->getElementsByTagName('a')->item(0);
        $this->assertInstanceOf(DOMElement::class, $link);
        $this->assertSame('https://example.com', $link->getAttribute('href'));
        $this->assertSame('Warning important a<b & c Manual', $element->textContent);
        $this->assertSame(0, $element->getElementsByTagName('p')->length);
    }

    #[TestWith(['<script>alert(1)</script>'], 'script tag')]
    #[TestWith(['<img src=x onerror=alert(1)>'], 'event handler')]
    #[TestWith(['Δοκιμή <value> & "quoted" > end'], 'technical text')]
    #[TestWith(['Symbols: < > & "quoted"'], 'plain text')]
    public function test_notes_escape_html_without_removing_text(string $notes): void
    {
        $element = $this->notes_element($this->render_info_panel($notes));

        $this->assertSame($notes, $element->textContent);
        $this->assertSame(0, $element->getElementsByTagName('*')->length);
    }

    public function test_notes_do_not_render_unsafe_links(): void
    {
        $element = $this->notes_element($this->render_info_panel('[Unsafe](javascript:alert%281%29)'));

        $this->assertSame('Unsafe', $element->textContent);
        foreach ($element->getElementsByTagName('a') as $link) {
            $this->assertStringNotContainsString('javascript:', strtolower($link->getAttribute('href')));
        }
    }

    #[TestWith(["First\nSecond\nThird"], 'LF')]
    #[TestWith(["First\r\nSecond\r\nThird"], 'CRLF')]
    #[TestWith(["First\n\nThird"], 'blank line')]
    public function test_notes_preserve_line_breaks_without_doubling_them(string $notes): void
    {
        $element = $this->notes_element($this->render_info_panel($notes));

        $this->assertSame(str_replace("\r\n", "\n", $notes), $element->textContent);
        $this->assertSame(2, $element->getElementsByTagName('br')->length);
    }

    public function test_markdown_hard_breaks_are_not_doubled(): void
    {
        $element = $this->notes_element($this->render_info_panel("First  \nSecond"));

        $this->assertSame("First\nSecond", $element->textContent);
        $this->assertSame(1, $element->getElementsByTagName('br')->length);
    }

    #[TestWith([''], 'empty string')]
    #[TestWith([null], 'null')]
    public function test_empty_notes_do_not_render_a_notes_entry(?string $notes): void
    {
        $document = $this->render_info_panel($notes);

        $this->assertSame(0, $document->query('//span[@class="js-copy-notes"]')->length);
        $this->assertSame(0, $document->query('//*[@data-clipboard-target=".js-copy-notes"]')->length);
    }

    private function render_info_panel(?string $notes, string $modelClass = Asset::class): DOMXPath
    {
        $this->actingAs(User::factory()->superuser()->create());
        $item = $modelClass::factory()->create(['notes' => $notes]);
        $html = Blade::render('<x-info-panel :infoPanelObj="$item" />', ['item' => $item]);

        $document = new DOMDocument;
        $document->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_NOERROR | LIBXML_NOWARNING);

        return new DOMXPath($document);
    }

    private function notes_element(DOMXPath $document): DOMElement
    {
        $elements = $document->query('//span[@class="js-copy-notes"]');
        $this->assertSame(1, $elements->length);
        $element = $elements->item(0);
        $this->assertInstanceOf(DOMElement::class, $element);

        return $element;
    }
}
