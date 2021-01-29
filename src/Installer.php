<?php

declare(strict_types=1);

namespace Koriym\PhpSkeleton;

use Closure;
use Composer\Factory;
use Composer\IO\IOInterface;
use Composer\Json\JsonFile;
use Composer\Script\Event;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function copy;
use function date;
use function dirname;
use function file_get_contents;
use function file_put_contents;
use function is_callable;
use function is_writable;
use function lcfirst;
use function passthru;
use function preg_match;
use function preg_replace;
use function shell_exec;
use function sprintf;
use function str_replace;
use function strpos;
use function strtolower;
use function trim;
use function ucfirst;
use function unlink;
use function var_dump;

final class Installer
{
    /** @var list<string> */
    private static $appName;

    /** @var string */
    private static $packageName;

    /** @var string */
    private static $userName;

    /** @var string */
    private static $userEmail;

    public static function preInstall(Event $event): void
    {
        $pacakageNameValidator = self::getValidator();
        $io = $event->getIO();
        $vendorClass = self::ask($io, 'What is the vendor name?', 'MyVendor', $pacakageNameValidator);
        $packageClass = self::ask($io, 'What is the package name?', 'MyPackage', $pacakageNameValidator);
        self::$userName = self::ask($io, 'What is your name?', self::getUserName());
        self::$userEmail = self::ask($io, 'What is your email address ?', self::getUserEmail());
        self::$packageName = sprintf('%s/%s', self::camel2dashed($vendorClass), self::camel2dashed($packageClass));
        $json = new JsonFile(Factory::getComposerFile());
        $composerDefinition = self::getDefinition($vendorClass, $packageClass, self::$packageName, $json);
        self::$appName = [$vendorClass, $packageClass];
        // Update composer definition
        $json->write($composerDefinition);
    }

    private static function getValidator(): callable
    {
        return static function (string $input): string {
            if (! preg_match('/^[A-Za-z][A-Za-z0-9]+$/', $input)) {
                throw new Exception();
            }

            return ucfirst($input);
        };
    }

    public static function postInstall(Event $event): void
    {
        $io = $event->getIO();
        [$vendorName, $packageName] = self::$appName;
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
        // install QA tools
        passthru(dirname(__DIR__) . '/vendor/bin/composer install');
        // run tools
        shell_exec(dirname(__DIR__) . '/vendor/bin/phpcbf');
        shell_exec(dirname(__DIR__) . '/vendor/bin/composer dump-autoload --quiet');
        shell_exec(dirname(__DIR__) . '/vendor/bin/psalm --init > /dev/null');
        // README
        rename($skeletonRoot . '/README.proj.md', $skeletonRoot . '/README.md');
        rename($skeletonRoot . '/.gitattributes.txt', $skeletonRoot . '/.gitattributes');
        $io->write(sprintf('<info>%s package created.</info>', self::$packageName));
        $io->write('<info>Happy quality coding!</info>');
    }

    private static function ask(IOInterface $io, string $question, string $default, ?callable $validation = null): string
    {
        $ask = sprintf("\n<question>%s</question>\n(<comment>%s</comment>): ", $question, $default);
        $answer = is_callable($validation) ? (string) $io->askAndValidate($ask, $validation, null, $default) : (string) $io->ask($ask, $default);
        $io->write(sprintf('<info>%s</info>', $answer));

        return $answer;
    }

    private static function recursiveJob(string $path, callable $job): void
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
        foreach ($iterator as $file) {
            $job($file);
        }
    }

    /**
     * @return array<string, string|array<string, string>>
     */
    private static function getDefinition(string $vendor, string $package, string $packageName, JsonFile $json): array
    {
        $composerDefinition = $json->read();
        unset(
            $composerDefinition['autoload']['files'],
            $composerDefinition['scripts']['pre-install-cmd'],
            $composerDefinition['scripts']['post-install-cmd'],
            $composerDefinition['scripts']['pre-update-cmd'],
            $composerDefinition['scripts']['post-create-project-cmd'],
            $composerDefinition['keywords'],
            $composerDefinition['homepage'],
            $composerDefinition['require-dev']['composer/composer']
        );
        $composerDefinition['name'] = $packageName;
        $composerDefinition['authors'] = [
            [
                'name' => self::$userName,
                'email' => self::$userEmail,
            ],
        ];
        $composerDefinition['description'] = '';
        $composerDefinition['autoload']['psr-4'] = ["{$vendor}\\{$package}\\" => 'src/'];
        $composerDefinition['scripts']['post-install-cmd'] = '@composer bin all install --ansi';
        $composerDefinition['scripts']['post-update-cmd'] = '@composer bin all update --ansi';

        return $composerDefinition;
    }

    private static function rename(string $vendor, string $package): Closure
    {
        return static function (SplFileInfo $file) use ($vendor, $package): void {
            $fileName = $file->getFilename();
            $filePath = (string) $file;
            if ($file->isDir() || strpos($fileName, '.') === 0 || ! is_writable($filePath)) {
                return;
            }

            $contents = (string) file_get_contents($filePath);
            $search = ['__Vendor__', '__Package__', '__year__', '__name__', '__PackageVarName__', '_package_name_'];
            $replace = [$vendor, $package, date('Y'), self::$userName, lcfirst($package), self::$packageName];
            $contents = str_replace($search, $replace, $contents);
            file_put_contents($filePath, $contents);
        };
    }

    private static function camel2dashed(string $name): string
    {
        return strtolower((string) preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $name));
    }

    private static function getUserName(): string
    {
        $author = shell_exec('git config --global user.name || git config user.name');

        return $author ? trim($author) : '';
    }

    private static function getUserEmail(): string
    {
        $email = shell_exec('git config --global user.email || git config user.email');

        return $email ? trim($email) : '';
    }
}
