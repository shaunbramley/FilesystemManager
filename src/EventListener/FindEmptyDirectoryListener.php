<?php

namespace Bramley\Filesystem\EventListener;

use Bramley\Filesystem\EventListener\FilesystemListener,
	Bramley\Filesystem\Event\FileEvent;

class SearchForEmptyDirectoryListener extends FilesystemListener {
	public function onFindEmptyDir(FileEvent $event) {
		$rdi = new \RecursiveDirectoryIterator($event->getPathname());
		foreach ($rdi as $item) {
			if($item->isDir() and !$item->hasChildren()) {
				// We have an empty directory within the originating file structure.
				$this->logger->debug('Found an empty directory [' . $item->getPathname() . ']');
				$event->getDispatcher()->dispatch('file.delete', 
					array(
						new FileEvent($item),
						$this->logger,
					)
				);
				
			}
		}
	}
}

?>