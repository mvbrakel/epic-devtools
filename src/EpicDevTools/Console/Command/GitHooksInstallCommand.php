<?php
namespace EpicDevTools\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class GitHooksInstallCommand
 * Installs the git hooks onto the base git repo
 *
 * @package EpicDevTools\Console\Command
 */
class GitHooksInstallCommand extends Command
{
    /**
     * Configurating the command
     */
    protected function configure()
    {
        $this->setName('githooks:install');
        $this->addOption(
            'force',
            'f',
            InputOption::VALUE_OPTIONAL,
            'Force writing of hooks, overrides existing hooks when present'
        );
    }

    /**
     * Execute the command, install the hooks
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $formatter = $this->getHelperSet()->get('formatter');

        //Force override?
        $force = false;
        if ($input->getOption('force')) {
            $force = true;
        }

        // Get the root path for the repo
        try {
            $rootPath = $this->getApplication()->getRootPath();
            if (!$rootPath) {
                throw new \Exception('404');
            }
            $output->writeln('Repo root path: ' . $rootPath);

        } catch (\Exception $e) {
            $errorMessages = array('Error!', 'No rootpath found or the application does not provide one');
            $formattedBlock = $formatter->formatBlock($errorMessages, 'error');
            $output->writeln($formattedBlock);
            return 1;
        }

        try {
            //Mirror it
            $sourceDir = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR .
                'tools' . DIRECTORY_SEPARATOR . 'git' . DIRECTORY_SEPARATOR . 'hooks';
            $targetDir = $rootPath . DIRECTORY_SEPARATOR . '.git' . DIRECTORY_SEPARATOR . 'hooks';
            $fileSystem = new Filesystem();
            $fileSystem->mirror(
                $sourceDir,
                $targetDir,
                null,
                array(
                   'override' => $force,
                   'copy_on_windows' => true
                )
            );
            if ($fileSystem->exists($targetDir . '/pre-commit')) {
                $output->writeln('Git hooks installed in: ' . $targetDir);
            } else {
                throw new \Exception('Hooks not installed');
            }
            return 0;
        } catch (\Exception $e) {
            $errorMessages = array('Error!', $e->getMessage());
            $formattedBlock = $formatter->formatBlock($errorMessages, 'error');
            $output->writeln($formattedBlock);
            return 1;
        }
    }
}
