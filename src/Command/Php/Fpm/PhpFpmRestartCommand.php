<?php

declare(strict_types=1);

namespace App\Command\Php\Fpm;

use App\{
    Command\AbstractCommand,
    Command\Behavior\PhpVersionArgumentTrait
};
use Symfony\Component\Console\Output\OutputInterface;

final class PhpFpmRestartCommand extends AbstractCommand
{
    use PhpVersionArgumentTrait;

    /** @var string */
    protected static $defaultName = 'php:fpm:restart';

    protected function configure(): void
    {
        parent::configure();

        $this
            ->setDescription('Restart PHP-FPM')
            ->addPhpVersionArgument($this);
    }

    protected function doExecute(): int
    {
        $phpVersion = $this->getPhpVersionFromArgument($this->getInput());

        $this
            ->outputTitle('Restart PHP-FPM ' . $phpVersion->toString())
            ->assertPhpVersionArgument($this->getInput())
            ->runProcess(
                ['sudo', '/usr/sbin/service', 'php' . $phpVersion->toString() . '-fpm', 'restart'],
                OutputInterface::VERBOSITY_VERBOSE,
                null,
                60,
                'Error while restarting PHP-FPM ' . $phpVersion->toString() . '.',
                '...fail!'
            )
            ->runProcessFromShellCommmandLine(
                'ps -ax | grep -v grep | grep /etc/php/' . $phpVersion->toString() . '/fpm/php-fpm.conf',
                OutputInterface::VERBOSITY_VERBOSE,
                null,
                60,
                'php' . $phpVersion->toString() . '-fpm is not started. Check your PHP configuration.'
            )
            ->outputSuccess('PHP-FPM ' . $phpVersion->toString() . ' restarted.');

        return 0;
    }
}
