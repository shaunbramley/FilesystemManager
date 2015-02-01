<?php

namespace Bramley\Filesystem\Console\Command;

use Symfony\Component\Console\Command\Command,
	Symfony\Component\Console\Input\InputArgument,
	Symfony\Component\Console\Input\InputInterface,
	Symfony\Component\Console\Input\InputOption,
	Symfony\Component\Console\Output\OutputInterface,
	Symfony\Component\EventDispatcher\EventDispatcher;


use Bramley\Filesystem\EventListener\AppleFileListener,
	Bramley\Filesystem\EventListener\FileSizeListener,
	Bramley\Filesystem\EventListener\HiddenFileListener,
	Bramley\Filesystem\EventListener\IsFileExcludedByUser,
	Bramley\Filesystem\EventListener\IsFileSpecifiedByUser,
	Bramley\Filesystem\EventListener\SystemFileListener,
	Bramley\Filesystem\Events\FileEvents,
	Bramley\Filesystem\Service\SortFileService;

use Psr\Log\LoggerInterface;

class SortFileCommand extends Command {
	protected $dispatcher;
	protected $logger;

	public function __construct(EventDispatcher $dispatcher, LoggerInterface $log = NULL) {
		parent::__construct();
		$this->dispatcher = $dispatcher;
		$this->logger = $log;
	}

	protected function configure() {
		$this
			->setName('sort:files')
			->setDescription('Given an input directory this application will then sort the files within it.')
			
			// Add the arguments
			->configureArguments()
			
			// Add the Options
			->configureOptions()
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$this->loadEventListeners($input);

		
		if ($input->getOption('move')) {
			;
		} else {
// 			if ($input->getOption('delete')) {
// 				;
// 			}
		}
		
		$this->logger->debug('Recursive Search [' . $input->getOption('recursive') . ']');
		
		$sortFileService = new SortFileService(
		    $input->getArgument('input'),
		    $input->getArgument('output'),
		    $this->dispatcher,
		    $input->getOption('recursive'),
		    $this->logger
		);
		$sortFileService->sort();
	}

	private function loadEventListeners(InputInterface $input) {
		if ($input->getOption('delete-zero-size')) {
            $this->dispatcher->addListener(
				FileEvents::FILE_FOUND,
				[
					new FileSizeListener(),
					'onFileFound',
				]
			);
		}

		if ($input->getOption('delete-hidden-files')) {
			$this->dispatcher->addListener(
			FileEvents::FILE_FOUND,
				[
					new HiddenFileListener(),
					'onFileFound',
				]
			);
		}

		if ($input->getOption('delete-os-artifacts')) {
			$this->dispatcher->addListener(
				FileEvents::FILE_FOUND,
				[
					new AppleFileListener(),
					'onFileFound',
				]
			);
		    $this->dispatcher->addListener(
		    	FileEvents::FILE_FOUND,
				[
					new SystemFileListener(),
					'onFileFound',
				]
			);
		}
		if ($input->getOption('skip')) {
			$this->logger->debug('Adding Listener: Exclusions');
			$this->dispatcher->addListener(
				FileEvents::FILE_FOUND,
			    [
					new IsFileExcludedByUser($input),
					'onFileFound',
				],
				10
			);
		}
		if ($input->getOption('specify')) {
			$this->logger->debug('Adding Listener: Specifics');
			$this->dispatcher->addListener(
				FileEvents::FILE_FOUND,
			    [
					new IsFileSpecifiedByUser($input),
					'onFileFound',
				],
				10
			);
		}
	}

	private function configureArguments() {
	    $this
	       ->addArgument(
	           'input',
	           InputArgument::REQUIRED,
	           'This is the root directory that the application looks within for files.'
	       )
	       ->addArgument(
	           'output',
	           InputArgument::REQUIRED,
	           'This is the root directory within which the sorted files are placed into.'
	       );
        return $this;
	}

	private function configureOptions() {
	    $this
            ->addOption(
                'duplicate',
                null,
                InputOption::VALUE_NONE,
                'If set, the application will search for and label duplicate files.'
            )
            
    	    ->addOption(
    	        'delete-duplicates',
    	        null,
    	        InputOption::VALUE_NONE,
    	        'If set, the application will delete original files after copying them.'
    	    )
    	    ->addOption(
    	        'delete-hidden-files',
    	        null,
    	        InputOption::VALUE_NONE,
    	        'If set, the application will search for and delele hidden files.'
    	    )
    	    ->addOption(
    	        'delete-os-artifacts',
    	        null,
    	        InputOption::VALUE_NONE,
    	        'If set, the application will remove OS based artifacts.'
    	    )
    	    ->addOption(
    	        'delete-zero-size',
    	        null,
    	        InputOption::VALUE_NONE,
    	        'If set, the application will remove files with a size of 0 Kb.'
    	    )
    	    ->addOption(
    	        'move',
    	        'mv',
    	        InputOption::VALUE_NONE,
    	        'If set, the application will move files instead of simply copying them.'
    	    )
    	    ->addOption(
    	        'recursive',
    	        'r',
    	        InputOption::VALUE_NONE,
				'If set, the application will recusrively search through the supplied input directory.'
    	    )
    	    ->addOption(
    	        'specify',
    	        null,
    	        InputOption::VALUE_REQUIRED,
    	        'If set, the application will only sort files with a pathname matching the supplied string.',
    	        null
    	    )
    	    ->addOption(
    	        'skip',
    	        null,
    	        InputOption::VALUE_REQUIRED,
    	        'If set, the application will skip any file with a pathname matching the supplied string.  This will take presidence over anything specified.',
    	        null
    	    );
	    return $this;
	}
}