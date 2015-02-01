<?php

namespace Bramley\FileManagement\EventListener;


use Symfony\Component\Filesystem\Exception\IOException;
use Bramley\Filesystem\Event\FileEvent;
use Bramley\Filesystem\EventListener\FilesystemListener;

class DeleteFileListener extends FilesystemListener {

	public function onDeleteFile(FileEvent $event) {
		try {
			$this->filesystem->remove($event->getSplFile()->getPathname());
			$this->logger->debug('Deleted file: ' . $event->getSplFile()->getPathname());
		} catch (IOException $e) {
			$this->logger->error('An error occurred while attempting to delete ' . $event->getSplFile()->getPathname());
		}
	}
}
?>