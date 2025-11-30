# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is Koriym.PhpSkeleton - a PHP project skeleton generator that creates modern, quality-focused PHP packages through a Composer `create-project` command. It installs and configures multiple QA tools (PHPUnit, PHPStan, Psalm, PHPCS, PHPMD, PHPMetrics, ComposerRequireChecker) with a single command.

**Key Architecture**: The `Installer` class (src/Installer.php) is the heart of the skeleton. It hooks into Composer's install lifecycle via `pre-install-cmd`, `post-install-cmd`, `pre-update-cmd`, and `post-create-project-cmd` scripts to:
1. Prompt for vendor/package names, author name, and email
2. Update composer.json with user-provided information
3. Recursively rename placeholder tokens (`__Vendor__`, `__Package__`, `__year__`, etc.) across all files
4. Copy template files (Skeleton.php → PackageName.php)
5. Clean up installer artifacts
6. Run initial QA tools setup

## Development Commands

### Testing
- `composer test` - Run PHPUnit tests
- `composer coverage` - Generate coverage report using XDebug (outputs to build/coverage)
- `composer phpdbg` - Generate coverage using phpdbg
- `composer pcov` - Generate coverage using pcov (faster than XDebug)

### Code Quality
- `composer cs` - Check coding standards (PSR-12 + Doctrine Coding Standard via phpcs.xml)
- `composer cs-fix` - Auto-fix coding standard violations
- `composer sa` - Run static analysis (both PHPStan and Psalm)
- `composer phpstan` - Run PHPStan only (level: max)
- `composer psalm` - Run Psalm only
- `composer phpmd` - Run PHP Mess Detector
- `composer baseline` - Generate PHPStan and Psalm baselines
- `composer audit` - Check for security vulnerabilities in dependencies
- `composer crc` - Check composer.json dependencies are properly declared
- `composer metrics` - Generate code quality metrics report (outputs to build/metrics)
- `composer clean` - Clear PHPStan and Psalm caches

### Full Build
- `composer tests` - Run cs + sa + test (quick validation)
- `composer build` - Full build: clean + cs + sa + coverage + crc + audit + metrics

## Code Architecture

### Template Replacement System
The installer uses a token replacement strategy with these placeholders:
- `__Vendor__` → User's vendor name (e.g., "Koriym")
- `__Package__` → User's package name (e.g., "MyPackage")
- `__PackageVarName__` → Lowercase-first package name (e.g., "myPackage")
- `_package_name_` → Dashed package name (e.g., "koriym/my-package")
- `__year__` → Current year
- `__name__` → Author name
- `__email__` → Author email

The `Installer::rename()` method creates a closure that processes all writable files recursively to replace these tokens.

### Dependency Isolation with vendor-bin
Development tools are installed in `vendor-bin/tools/` and `vendor-bin/require-checker/` using bamarni/composer-bin-plugin. This isolates QA tool dependencies from the skeleton package itself. The main composer.json only requires PHP ^8.1 and a minimal dev dependency set.

### Coding Standards Configuration
- **phpcs.xml**: PSR-12 + Doctrine Coding Standard with specific exclusions for tests/Fake directory
- **phpstan.neon**: Level max, analyzes both src/ and tests/
- **psalm.xml**: Static analysis configuration
- **phpmd.xml**: Complexity thresholds (cyclomatic: 20, NPath: 200, class complexity: 100)

### Test Structure
- `tests/` - Main test files
- `tests/Fake/` - Test doubles (excluded from coding standards checks)
- PHPUnit configured to run all tests in tests/ directory with coverage on src/

## Important Development Notes

### When Modifying the Installer
- The installer is self-destructing: `Installer.php` deletes itself after `postInstall()` runs
- Template files (Skeleton.php, SkeletonTest.php) are copied then deleted during installation
- Always test changes with `composer create-project` to ensure the full lifecycle works
- The installer runs `phpcbf` and `composer dump-autoload` automatically after setup

### PHP Version
- Requires PHP ^8.1
- Targets PHP 8.0+ compatibility in phpcs.xml (php_version: 80000)

### GitHub Actions
Pre-configured workflows in .github/workflows/:
- continuous-integration.yml
- static-analysis.yml
- coding-standards.yml

These are templates that will be included in generated projects.
