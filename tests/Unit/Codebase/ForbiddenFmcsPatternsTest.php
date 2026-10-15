<?php

namespace Tests\Unit\Codebase;

use PHPUnit\Framework\TestCase;

/**
 * Codebase-shape guardrail against the class of bug that landed the
 * FMCS cross-company user leak (support ticket 56305).
 *
 * `whereDoesntHave('companies' | 'company' | 'users')` inside FMCS-scoped
 * code is dangerous: the relation subquery walks a companyable model,
 * which triggers CompanyableScope recursively on the JOIN, narrowing it
 * to the caller's own companies. Rows whose companyable relation points
 * only at OUT-OF-SCOPE companies then look "no relation at all" from the
 * scope's perspective and slip through negated-relation filters. That's
 * how the users leak got past every green test in production.
 *
 * The safe substitute is a direct pivot query
 * (`whereNotIn('users.id', function ($sub) { $sub->select('user_id')->from('company_user'); })`)
 * that bypasses the recursive scope. This test fails if any file under
 * app/ reintroduces the forbidden pattern outside a small, deliberate
 * whitelist.
 */
class ForbiddenFmcsPatternsTest extends TestCase
{
    /**
     * Files that are ALLOWED to use these patterns because they are
     * user-facing search / filter code, not FMCS scoping. Any addition
     * to this list must be reviewed. Keep the list short.
     */
    private const WHITELIST = [
        // Advanced search on "not X" relation filters (e.g. "location=!dam"
        // means show users without a matching location). Not an FMCS scope,
        // and the intended semantics of doesntHave here are correct.
        'app/Models/Traits/Searchable.php',
    ];

    public function test_no_forbidden_doesnt_have_on_companyable_relations(): void
    {
        $projectRoot = dirname(__DIR__, 3);
        $hits = [];

        foreach ($this->scanPhpFiles($projectRoot.'/app') as $absolutePath) {
            $relative = ltrim(substr($absolutePath, strlen($projectRoot) + 1), '/');
            if (in_array($relative, self::WHITELIST, true)) {
                continue;
            }

            $contents = file_get_contents($absolutePath);
            if ($contents === false) {
                continue;
            }

            // Match: (or)?(where)?DoesntHave('companies'|'company'|'users'|'user')
            // with either quote style. Case-insensitive to catch typo-style
            // stylings that would still work at runtime.
            if (preg_match('/(?:or)?(?:where)?DoesntHave\s*\(\s*[\'"](companies|company|users|user)[\'"]/i', $contents, $matches, PREG_OFFSET_CAPTURE)) {
                $offset = $matches[0][1];
                $line = substr_count(substr($contents, 0, $offset), "\n") + 1;
                $hits[] = $relative.':'.$line.'  '.trim(explode("\n", substr($contents, $offset, 200))[0]);
            }
        }

        $this->assertEmpty(
            $hits,
            "Found forbidden FMCS pattern. `whereDoesntHave` on a companyable relation triggers recursive CompanyableScope on the subquery, which leaks cross-company data. Use a direct pivot query (whereNotIn(..., function(\$sub){\$sub->select('user_id')->from('company_user');})) instead, or add the file to the WHITELIST if you're certain it's not FMCS scoping.\n\nHits:\n".implode("\n", $hits)
        );
    }

    /**
     * @return \Generator<string>
     */
    private function scanPhpFiles(string $dir): \Generator
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            /** @var \SplFileInfo $file */
            if ($file->isFile() && $file->getExtension() === 'php') {
                yield $file->getPathname();
            }
        }
    }
}
