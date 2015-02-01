<?php

namespace Bramley\Filesystem\EventListener;

use Bramley\Filesystem\Event\FileEvent,
	Bramley\Filesystem\Events\FileEvents;

class SystemFileListener {
	public function onFileFound(FileEvent $event) {
		if (preg_match('/(Thumbs\.db)/', $event->getSplFile()->getPathname())) {
			$event->stopPropagation();
			$event->getDispatcher()->dispatch(FileEvents::FILE_DEL, $event);
		}
	}
}
?>