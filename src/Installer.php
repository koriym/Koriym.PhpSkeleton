<?php

namespace PHP\Skeleton;

use Composer\Factory;
use Composer\IO\IOInterface;
use Composer\Json\JsonFile;
use Composer\Script\Event;

class Installer
{
    /**
     * @var array
     */
    private static $packageName;

    /**
     * @var string
     */
    private static $name;

    public static function preInstall(Event $event)
    {
        $io = $event->getIO();
        $vendorClass = self::ask($io, 'What is the vendor name ?', 'MyVendor');
        $packageClass = self::ask($io, 'What is the package name ?', 'MyPackage');
        self::$name = self::ask($io, 'What is your name ?', self::getUserName());
        $packageName = sprintf('%s/%s', self::camel2dashed($vendorClass), self::camel2dashed($packageClass));
        $json = new JsonFile(Factory::getComposerFile());
        $composerDefinition = self::getDefinition($vendorClass, $packageClass, $packageName, $json);
        self::$packageName = [$vendorClass, $packageClass];
        // Update composer definition
        $json->write($composerDefinition);
        $io->write("<info>composer.json for {$composerDefinition['name']} is created.\n</info>");
    }

    public static function postInstall(Event $event = null)
    {
        list($vendorName, $packageName) = self::$packageName;
        $skeletonRoot = dirname(__DIR__);
        self::recursiveJob("{$skeletonRoot}", self::rename($vendorName, $packageName));
        //mv
        $skeletonPhp = __DIR__ . '/Skeleton.php';
        copy($skeletonPhp, "{$skeletonRoot}/src/{$packageName}.php");
        $skeletoTest = "{$skeletonRoot}/tests/SkeletonTest.php";
        copy($skeletoTest, "{$skeletonRoot}/tests/{$packageName}Test.php");
        // remove installer files
        unlink($skeletonRoot . '/README.md');
        unlink($skeletonPhp);
        unlink($skeletoTest);
        unlink(__FILE__);
    }

    /**
     * @param IOInterface $io
     * @param string      $question
     * @param string      $default
     *
     * @return string
     */
    private static function ask(IOInterface $io, $question, $default)
    {
        $ask = [
            sprintf("\n<question>%s</question>\n", $question),
            sprintf("\n(<comment>%s</comment>):", $default)
        ];
        $answer = $io->ask($ask, $default);

        return $answer;
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
        foreach ($iterator as $file) {
            $job($file);
        }
    }

    /**
     * @param string   $name
     * @param string   $vendor
     * @param string   $package
     * @param string   $packageName
     * @param JsonFile $json
     *
     * @return array
     */
    private static function getDefinition($vendor, $package, $packageName, JsonFile $json)
    {
        $composerDefinition = $json->read();
        unset($composerDefinition['autoload']['files']);
        unset($composerDefinition['scripts']['pre-install-cmd']);
        unset($composerDefinition['scripts']['post-install-cmd']);
        unset($composerDefinition['require-dev']['composer/composer']);
        $composerDefinition['name'] = $packageName;
        $composerDefinition['authors']['name'] = self::$name;
        $composerDefinition['description'] = '';
        $composerDefinition['autoload']['psr-4'] = ["{$vendor}\\{$package}\\" => "src/"];

        return $composerDefinition;
    }

    /**
     * @param string $vendor
     * @param string $package
     *
     * @return \Closure
     */
    private static function rename($vendor, $package)
    {
        $jobRename = function (\SplFileInfo $file) use ($vendor, $package) {
            $fineName = $file->getFilename();
            if ($file->isDir() || strpos($fineName, '.') === 0 || !is_writable($file)) {
                return;
            }
            $contents = file_get_contents($file);
            $contents = str_replace('__Vendor__', "{$vendor}", $contents);
            $contents = str_replace('__Package__', "{$package}", $contents);
            $contents = str_replace('__year__', date('Y'), $contents);
            $contents = str_replace('__name__', self::$name, $contents);
            file_put_contents($file, $contents);
        };

        return $jobRename;
    }

    /**
     * @return \Closure
     */
    private static function chmod()
    {
        $jobChmod = function (\SplFileInfo $file) {
            chmod($file, 0777);
        };

        return $jobChmod;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private static function camel2dashed($name)
    {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $name));
    }


    private static function getUserName()
    {
        $author = `git config --global user.name`;

        return $author ? trim($author) : '';
    }
}
