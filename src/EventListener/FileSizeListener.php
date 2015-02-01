<?php

namespace Bramley\Filesystem\EventListener;

use Bramley\Filesystem\Event\FileEvent;

class FileSizeListener {
	public function onFileFound(FileEvent $event) {
		if (!($event->getSplFile()->getSize() >0)) {
			$event->stopPropagation();
		}
	}
}
?>