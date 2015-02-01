<?php

namespace Bramley\Filesystem\EventListener\Filesystem;

use Bramley\Filesystem\EventListener\FilesystemListener;
use Bramley\Filesystem\Event\FileEvent;
use Bramley\Filesystem\Events\FileEvents;

class MoveListener extends FilesystemListener {

	public function onFileMove(FileEvent $e) {
		$e->getDispatcher()->dispatch(FileEvents::FILE_MOVE_PRE, $e);
		echo 'moving file' . PHP_EOL;
		
		$e->getDispatcher()->dispatch(FileEvents::FILE_MOVE_POST, $e);
	}
}

?>