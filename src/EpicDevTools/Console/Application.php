<?php
/**
 * This file represents a Symfony console application used for installing some of the EPIC Dev Tools
 */

namespace EpicDevTools\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;

class Application extends BaseApplication
{
    /**
     * Informative constants
     */
    const NAME = 'EPIC Development Tools Console Application';
    const VERSION = '0.1';

    /**
     * Root path for the application (repository root)
     * @var string
     */
    private $rootPath;

    /**
     * Construct the application
     *
     * @param string $rootPath The root for the repo in which the application is run
     */
    public function __construct($rootPath)
    {
        if (is_dir($rootPath)) {
            $this->rootPath = $rootPath;
        }

        parent::__construct(static::NAME, static::VERSION);

        // Add commands to application.
        $this->addCommands(
            array(
                new Command\GitHooksInstallCommand()
            )
        );
    }

    /**
     * Get the application root path
     *
     * @return string
     */
    public function getRootPath()
    {
        return $this->rootPath;
    }
}
