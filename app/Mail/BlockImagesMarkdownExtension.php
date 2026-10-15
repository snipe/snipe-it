<?php

namespace App\Mail;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

/**
 * CommonMark extension that neutralizes markdown image syntax in outbound
 * mail. Registered globally on the Illuminate\Mail\Markdown singleton so
 * every parser instance picks it up. That includes the hardcoded
 * Illuminate\Mail\Markdown::parse calls inside vendor mail views (mail::table,
 * mail::panel, mail::subcopy, mail::footer, mail::layout), which a container
 * subclass would otherwise miss.
 *
 * The image renderer is replaced at priority 100, which beats the priority-0
 * default from CommonMarkCoreExtension. Rather than dropping the content
 * entirely we render the image node's alt text as plain text. A note like
 * `![My photo](/etc/passwd)` becomes literal "My photo" in the email instead
 * of vanishing silently.
 *
 * Why this matters. laravel-mail-auto-embed walks outbound emails and, for
 * every <img src> it finds, either file_get_contents()s the path or curl-
 * fetches the URL and attaches the result. Without this extension, any
 * user-controlled string that reaches a markdown mail template can be used
 * to exfiltrate arbitrary server-readable files or issue arbitrary internal
 * HTTP requests. See GHSA advisory for the full attack chain.
 */
class BlockImagesMarkdownExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment->addRenderer(Image::class, new class implements NodeRendererInterface
        {
            public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
            {
                return htmlspecialchars(
                    $childRenderer->renderNodes($node->children()),
                    ENT_QUOTES | ENT_HTML5,
                    'UTF-8'
                );
            }
        }, 100);
    }
}
