<?php

namespace Bramley\Filesystem\EventListener;

use Bramley\Filesystem\Event\FileEvent;

class HiddenFileListener {
	public function onFileFound(FileEvent $event) {
		if (preg_match('/(^_VU)|(^\._)/', $event->getSplFile()->getFilename())) {
			$event->stopPropagation();
		}
	}
}
?>