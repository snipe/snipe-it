<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use function Laravel\Prompts\info;
use function Laravel\Prompts\select;

class Version extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'version:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $use_branch = select(
            label: 'Which branch?',
            options: ['master', 'develop'],
            default: 'develop',
        );

        $use_type = select(
            label: 'Which release type?',
            options: [
                'hash' => 'Hash bump',
                'patch' => 'Patch release',
                'minor' => 'Minor release',
                'major' => 'Major release',
                'pre-patch' => 'Pre-patch release',
                'pre-minor' => 'Pre-minor release',
                'pre-major' => 'Pre-major release',
            ],
            default: 'hash',
            scroll: 7,
        );

        $git_branch = trim(shell_exec('git rev-parse --abbrev-ref HEAD'));
        $versionFile = 'config/version.php';

        // Describe off the selected branch so build_version and the
        // count/hash suffix of full_hash refer to the same commit lineage.
        // Prior shape mixed use_branch's rev-count with master's describe
        // output, which produced a mismatch between build_version and the
        // number embedded in full_hash.
        $build_version = trim(shell_exec('git rev-list --count '.escapeshellarg($use_branch)));
        $full_hash_version = str_replace("\n", '', shell_exec('git describe '.escapeshellarg($use_branch).' --tags'));

        $version = explode('-', $full_hash_version);
        $hash_version = (array_key_exists('2', $version)) ? $version[2] : '';
        $prerelease_version = '';

        if (array_key_exists('3', $version)) {
            $prerelease_version = $version[1];
            $hash_version = $version[3];
        }

        // Base semver bumps off the latest tag reachable from master.
        // develop can be branched from an older release lineage, so
        // deriving the starting version from `git describe <use_branch>`
        // would start the count from a stale tag.
        $latest_master_tag = trim(shell_exec('git describe master --tags --abbrev=0'));
        $app_version_raw = explode('.', $latest_master_tag);

        $maj = str_replace('v', '', $app_version_raw[0]);
        $min = $app_version_raw[1];
        $patch = '';

        // This is a major release that might not have a third .0
        if (array_key_exists(2, $app_version_raw)) {
            $patch = $app_version_raw[2];
        }

        if ($use_type === 'major') {
            $app_version = 'v'.($maj + 1).".$min.$patch";
        } elseif ($use_type === 'minor') {
            $app_version = 'v'."$maj.".($min + 1).".$patch";
        } elseif ($use_type === 'pre-patch') {
            $app_version = 'v'."$maj.$min.".($patch + 1).'-pre';
        } elseif ($use_type === 'pre-minor') {
            $app_version = 'v'."$maj.".($min + 1).'.0-pre';
        } elseif ($use_type === 'pre-major') {
            $app_version = 'v'.($maj + 1).'.0.0-pre';
        } elseif ($use_type === 'patch') {
            $app_version = 'v'."$maj.$min.".($patch + 1);
        } elseif ($use_type === 'hash') {
            // Hash-only bump preserves whatever version is currently in
            // the config so the semver doesn't reset back to the last
            // released tag. Only build_version, hash_version, and the
            // derived display strings get refreshed below.
            $app_version = config('version.app_version');
            $prerelease_version = config('version.prerelease_version');
        }

        $full_hash_version = str_replace($version[0], $app_version, $full_hash_version);
        $full_app_version = $app_version.' - build '.$build_version.'-'.$hash_version;

        $content = <<<PHP
        <?php

        return [
            'app_version' => '$app_version',
            'full_app_version' => '$full_app_version',
            'build_version' => '$build_version',
            'prerelease_version' => '$prerelease_version',
            'hash_version' => '$hash_version',
            'full_hash' => '$full_hash_version',
            'branch' => '$git_branch',
        ];

        PHP;

        \File::put($versionFile, $content);
        info('New version: '.$full_app_version.' ('.$git_branch.')');

        // Master ships production-minified assets; develop / topic
        // branches ship the dev-build artifacts so partial merges
        // don't drop into master with mismatched compiled JS/CSS.
        $npmScript = $use_branch === 'master' ? 'npm run prod' : 'npm run dev';

        info('Building JS/CSS assets ('.$npmScript.')...');
        passthru($npmScript, $exitCode);

        if ($exitCode !== 0) {
            $this->error('Asset build failed with exit code '.$exitCode);
        } else {
            info('Assets built successfully.');
        }
    }
}
