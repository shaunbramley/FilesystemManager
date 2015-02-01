<?php

namespace Bramley\Filesystem\EventListener;

use Bramley\Filesystem\Event\FileEvent;

class FindImagebyImageSize {
	public function onFileFound(FileEvent $event) {
		list($width, $height) = getimagesize($event->getFile()->getPathname());
		if (!$width || !$height) {
			// There is no width or height information within the file
			$event->stopPropagation();
		}
		else {
			echo "height: " . $height . ' width: ' . $width . PHP_EOL;
		}
	}
}

?>