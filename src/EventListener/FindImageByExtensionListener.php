<?php

namespace Bramley\Filesystem\EventListener;

use Bramley\Filesystem\Event\FileEvent,
	Bramley\Filesystem\Events\FileEvents;

class FindImageByExtensionListener {
	protected $extensions = [
	'3fr', 'ari', 'arw', 'bay',
	'crw', 'cr2', 'cap', 'dcs',
	'dcr', 'dng', 'drf', 'eip',
	'erf', 'fff', 'iiq', 'k25',
	'kdc', 'mdc', 'mef', 'mos',
	'mrw', 'nef', 'nrw', 'obm',
	'orf', 'pef', 'ptx', 'pxn',
	'r3d', 'raf', 'raw', 'rwl',
	'rw2', 'rwz', 'sr2', 'srf',
	'srw', 'x3f', 'jpg', 'jpeg',
	'png', 'bmp'
	];

	public function onFileFound(FileEvent $event) {

		$regex = '/(' . implode('|', $this->extensions) . ')$/i';
		if (preg_match($regex, $event->getSplFile()->getPathname())) {
			$event->getLogger()->info('Image file found at ' . $event->getSplFile()->getPathname());

			$event->getDispatcher()->dispatch(FileEvents::IMAGE_FOUND, $event);
		} 
	}
}
?>