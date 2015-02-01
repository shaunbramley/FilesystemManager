<?php

namespace Bramley\Filesystem\Event;

use Symfony\Component\EventDispatcher\Event;
use Psr\Log\LoggerInterface;

class FileEvent extends Event {
	protected $file;
	protected $logger;
	protected $outputDir;

	public function __construct(\SplFileInfo $file, LoggerInterface $log, $outputDir)
	{
		$this->file = $file;
		$this->logger = $log;
		$this->outputDir = $outputDir;
	}

	public function getSplFile()
	{
		return $this->file;
	}

	public function getLogger() {
		return $this->logger;
	}

	public function getOutputDirectory() {
		return $this->outputDir;
	}
}