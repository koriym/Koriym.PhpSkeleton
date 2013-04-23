<?php

use Composer\Script\Event;

class Installer
{
    /**
     * Composer post install script
     *
     * @param Event $event
     */
    public static function postInstall(Event $event = null)
    {
        $skeletonRoot = dirname(__DIR__);
        $folderName = (new \SplFileInfo($skeletonRoot))->getFilename();
        list($vendorName, $packageName) = explode('.', $folderName);
        $jobChmod = function (\SplFileInfo $file) {
            chmod($file, 0777);
        };
        $jobRename = function (\SplFileInfo $file) use ($vendorName, $packageName) {
            $fineName = $file->getFilename();
            if ($file->isDir() || strpos($fineName, '.') === 0 || ! is_writable($file)) {
                return;
            }
            $contents = file_get_contents($file);
            $contents = str_replace('Skeleton', $packageName, $contents);
            $contents = str_replace('Php', $vendorName, $contents);
            $contents = str_replace('{package_name}', strtolower("{$vendorName}/{$packageName}"), $contents);
            file_put_contents($file, $contents);
        };

        // chmod
        self::recursiveJob("{$skeletonRoot}/data/tmp", $jobChmod);

        // rename file contents
        self::recursiveJob("{$skeletonRoot}/src", $jobRename);
        self::recursiveJob("{$skeletonRoot}/tests", $jobRename);

        rename("{$skeletonRoot}/src/Php/Skeleton", "{$skeletonRoot}/src/Php/{$packageName}");
        rename("{$skeletonRoot}/src/Php", "{$skeletonRoot}/src/{$vendorName}");
        rename("{$skeletonRoot}/src/{$vendorName}/{$packageName}/Skeleton.php", "{$skeletonRoot}/src/{$vendorName}/{$packageName}/{$packageName}.php");

        rename("{$skeletonRoot}/tests/Php/Skeleton", "{$skeletonRoot}/tests/Php/{$packageName}");
        rename("{$skeletonRoot}/tests/Php", "{$skeletonRoot}/tests/{$vendorName}");
        rename("{$skeletonRoot}/tests/{$vendorName}/{$packageName}/SkeletonTest.php", "{$skeletonRoot}/tests/{$vendorName}/{$packageName}/{$packageName}Test.php");

        // composer.json
        unlink("{$skeletonRoot}/composer.json");
        rename("{$skeletonRoot}/src/composer.json", "{$skeletonRoot}/composer.json");

        // delete self
        unlink(__FILE__);
    }

    /**
     * @param string   $path
     * @param Callable $job
     *
     * @return void
     */
    private static function recursiveJob($path, $job)
    {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);
        foreach($iterator as $file) {
            $job($file);
        }
    }
}
