<?php
namespace Bramley\Filesystem\Console\Command;

use Bramley\Filesystem\Console\Command\SortFileCommand,
	Bramley\Filesystem\Events\FileEvents,
	Bramley\Filesystem\EventListener\FindImageByExtensionListener,
	Bramley\Filesystem\EventListener\Filesystem\CopyFileListener;

use Symfony\Component\Filesystem\Filesystem;

class SortImageCommand extends SortFileCommand {
	protected function configure() {
		parent::configure();
		$this
			->setName('sort:images')
			->setDescription('Given an input directory this application will then sort the image files within it.')
		;
	}

	private function loadEventListeners() {

		parent::loadEventListeners();

		$this->dispatcher->addListener( FileEvents::FILE_FOUND, [ new FindImageByExtensionListener($this->logger), 'onFileFound'], -1);
		$this->dispatcher->addListener( FileEvents::IMAGE_FOUND, [ new CopyFileListener(new Filesystem()), 'onImageFound']);
	}
}
