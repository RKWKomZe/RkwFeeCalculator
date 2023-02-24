<?php
namespace RKW\RkwFeecalculator\Command;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class SendCommand
 *
 * Execute on CLI with: 'vendor/bin/typo3 rkw_feecalculator:cleanup'
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CleanupCommand extends Command
{

    /**
     * @var string
     */
    protected string $defaultUploadFolder = '1:/user_upload/tx_rkwfeecalculator';

    /**
     * @var \TYPO3\CMS\Core\Log\Logger|null
     */
    protected ?Logger $logger = null;


    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure(): void
    {
        $this->setDescription('Cleanup requests folder.')
            ->addOption(
                'daysFromNow',
                'd',
                InputOption::VALUE_REQUIRED,
                'Defines which old files should be deleted',
                30
            );
    }


    /**
     * Initializes the command after the input has been bound and before the input
     * is validated.
     *
     * This is mainly useful when a lot of commands extends one main command
     * where some things need to be initialized based on the input arguments and options.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @see \Symfony\Component\Console\Input\InputInterface::bind()
     * @see \Symfony\Component\Console\Input\InputInterface::validate()
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        // nothing to do
    }


    /**
     * Executes the command for showing sys_log entries
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     * @see \Symfony\Component\Console\Input\InputInterface::bind()
     * @see \Symfony\Component\Console\Input\InputInterface::validate()
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());

        $daysFromNow = $input->getOption('daysFromNow');
        $io->note('Using daysFromNow="' . $daysFromNow . '"');
        $io->newLine();

        $result = 0;
        try {

            $cleanupTimestamp = time() - (intval($daysFromNow) * 24 * 60 * 60);
            $filePathArray = [$this->defaultUploadFolder . '/'];

            foreach ($filePathArray as $filePath) {

                // Yes: Remove ":" AND "/" (the slash comes back through $GLOBALS['TYPO3_CONF_VARS']['BE']['fileadminDir']
                $filePathSplit = GeneralUtility::trimExplode(':/', $filePath);
                $filePath = GeneralUtility::getFileAbsFileName(
                    $GLOBALS['TYPO3_CONF_VARS']['BE']['fileadminDir']
                    . $filePathSplit[1]
                );

                // ERROR Check if path does not exists
                if (!is_dir($filePath)) {
                    $message = sprintf('Given file path does not exist=%s.', $filePath);

                    $io->error($message);
                    $this->getLogger()->log(LogLevel::ERROR, $message);
                    continue;
                }

                // WARNING Disallow ALL paths without string "tx_rkwform" in it! Just for secure. Anything could be defined via
                // the ExtForm-Yaml file
                if (strpos($filePath, 'tx_rkwfeecalculator') === false) {

                    $message = sprintf(
                        'Rejected: The given path does not contains the string "tx_rkwform"=%s.',
                        $filePath
                    );
                    $io->warning($message);
                    $this->getLogger()->log(LogLevel::WARNING, $message);
                    continue;
                }

                // get all files from given path
                $counter = 0;
                $fileList = GeneralUtility::getFilesInDir($filePath);
                foreach ($fileList as $file) {

                    if (
                        $daysFromNow === 0
                        || (
                            $cleanupTimestamp > 0
                            && ($cleanupTimestamp > filemtime($filePath . $file)
                            )
                        )
                    ) {
                        $counter++;
                        // remove file from disk
                        unlink($filePath . $file);
                    }
                }

                // Message with x files were deleted
                $message = sprintf(
                    'Cleanup command runs successfully. A total of %s files were deleted from %s.',
                    $counter,
                    $filePath
                );
                $io->note($message);
                $this->getLogger()->log(LogLevel::INFO, $message);
            }

            $result = 1;

        } catch (\Exception $e) {

            $message = sprintf('An unexpected error occurred while trying to cleanup the requests: %s',
                str_replace(array("\n", "\r"), '', $e->getMessage())
            );

            $io->error($message);
            $this->getLogger()->log(LogLevel::ERROR, $message);
        }

        $io->writeln('Done');
        return $result;

    }


    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger(): Logger
    {
        if (!$this->logger instanceof \TYPO3\CMS\Core\Log\Logger) {
            $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        }

        return $this->logger;
    }
}
