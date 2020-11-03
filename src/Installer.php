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

final class Installer
{
    /** @var list<string> */
    private static $packageName;

    /** @var string */
    private static $name;

    /** @var string */
    private static $email;
    private static $validator;

    public static function preInstall(Event $event): void
    {
        $pacakageNameValidator = self::getValidator();
        $io = $event->getIO();
        $vendorClass = self::ask($io, 'What is the vendor name?', 'MyVendor', $pacakageNameValidator);
        $io->write(sprintf('<info>%s</info>', $vendorClass));
        $packageClass = self::ask($io, 'What is the package name?', 'MyPackage', $pacakageNameValidator);
        $io->write(sprintf('<info>%s</info>', $packageClass));
        self::$name = self::ask($io, 'What is your name?', self::getUserName());
        self::$email = self::ask($io, 'What is your email address ?', self::getUserEmail());
        $packageName = sprintf('%s/%s', self::camel2dashed($vendorClass), self::camel2dashed($packageClass));
        $json = new JsonFile(Factory::getComposerFile());
        $composerDefinition = self::getDefinition($vendorClass, $packageClass, $packageName, $json);
        self::$packageName = [$vendorClass, $packageClass];
        // Update composer definition
        $json->write($composerDefinition);
    }

    private static function getValidator(): callable
    {
        return static function (string $input): string {
            if (! preg_match('/^[A-Za-z][A-Za-z0-9]+$/', $input)) {
                throw new Exception();
            }

            return ucfirst(strtolower($input));
        };
    }

    public static function postInstall(Event $event): void
    {
        $io = $event->getIO();
        [$vendorName, $packageName] = self::$packageName;
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
        // run tools
        shell_exec(dirname(__DIR__) . '/vendor/bin/phpcbf');
        shell_exec(dirname(__DIR__) . '/vendor/bin/composer dump-autoload --quiet');
        shell_exec(dirname(__DIR__) . '/vendor/bin/psalm --init > /dev/null');
        $io->write(sprintf('<info>%s/%s package created.</info>', self::camel2dashed($vendorName), self::camel2dashed($packageName)));
        $io->write('<info>Happy quality coding!</info>');
    }

    private static function ask(IOInterface $io, string $question, string $default, ?callable $validation = null): string
    {
        $ask = sprintf("\n<question>%s</question>\n(<comment>%s</comment>): ", $question, $default);

        return is_callable($validation) ? (string) $io->askAndValidate($ask, $validation, null, $default) : (string) $io->ask($ask, $default);
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
                'name' => self::$name,
                'email' => self::$email,
            ],
        ];
        $composerDefinition['description'] = '';
        $composerDefinition['autoload']['psr-4'] = ["{$vendor}\\{$package}\\" => 'src/'];

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
            $contents = str_replace('__Vendor__', "{$vendor}", $contents);
            $contents = str_replace('__Package__', "{$package}", $contents);
            $contents = str_replace('__year__', date('Y'), $contents);
            $contents = str_replace('__name__', self::$name, $contents);
            $contents = str_replace('__PackageVarName__', lcfirst($package), $contents);
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
