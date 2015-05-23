<?php

namespace __Vendor__\__Package__;

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
        $splFile = new \SplFileInfo($skeletonRoot);
        $folderName = $splFile->getFilename();
        $appNameRegex = '/^[A-Za-z0-9]+\.[A-Za-z0-9]+$/';
        if (! preg_match($appNameRegex, $folderName)) {
          throw new \LogicException('Package name must be in the format "Vendor.Application".');
        }
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
            $contents = str_replace('__Package__', $packageName, $contents);
            $contents = str_replace('__Vendor__', $vendorName, $contents);
            $contents = str_replace('{package_name}', strtolower("{$vendorName}/{$packageName}"), $contents);
            file_put_contents($file, $contents);
        };

        // rename file contents
        self::recursiveJob("{$skeletonRoot}/src", $jobRename);
        self::recursiveJob("{$skeletonRoot}/tests", $jobRename);

        rename("{$skeletonRoot}/src/Skeleton.php", "{$skeletonRoot}/src/{$packageName}.php");
        rename("{$skeletonRoot}/tests/SkeletonTest.php", "{$skeletonRoot}/tests/{$packageName}Test.php");

        // composer.json
        unlink("{$skeletonRoot}/composer.json");
        unlink("{$skeletonRoot}/composer.lock");
        $jobRename(new \SplFileInfo("{$skeletonRoot}/composer.json.dist"));
        rename("{$skeletonRoot}/composer.json.dist", "{$skeletonRoot}/composer.json");

        // composer autoload_psr4.php
        $jobRename(new \SplFileInfo("{$skeletonRoot}/vendor/composer/autoload_psr4.php"));

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
