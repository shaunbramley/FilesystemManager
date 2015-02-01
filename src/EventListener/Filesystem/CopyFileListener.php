<?php

namespace Bramley\Filesystem\EventListener\Filesystem;

use Bramley\Filesystem\Event\FileEvent,
	Bramley\Filesystem\EventListener\FilesystemListener,
	Bramley\Filesystem\Events\FileEvents,
	Bramley\Filesystem\File\ImageFile,
	Bramley\Filesystem\File\XMPImageDecorator,
	Bramley\Filesystem\File\EXIFImageDecorator,
	Bramley\Filesystem\Schema\DateSchema;

class CopyFileListener extends FilesystemListener {
	public function onImageFound(FileEvent $e) {
		$e->getDispatcher()->dispatch(FileEvents::FILE_COPY_PRE, $e);
		
		$i = new ImageFile($e->getSplFile());
		
		$di = new XMPImageDecorator(new EXIFImageDecorator($i));
		$di->find();
		
		$schema = new DateSchema(
				$i,
				'Y' . DIRECTORY_SEPARATOR . 'm' . DIRECTORY_SEPARATOR . 'd' . DIRECTORY_SEPARATOR . 'Ymd His',
				$e->getOutputDirectory()
		);
		$pathname = $schema->getNewPathname();

		$pathCounter = 0;

		while ($this->filesystem->exists($pathname)) {
			// If the file already exists on the system...
			if($pathCounter) {
				$pathname = str_replace(' ' . $pathCounter . '.' . $e->getSplFile()->getExtension() , '', $pathname) . ' ' . ++$pathCounter . '.' . $e->getSplFile()->getExtension();
			} else {
				$pathname = str_replace('.' . $e->getSplFile()->getExtension() , '', $pathname) . ' ' . ++$pathCounter . '.' . $e->getSplFile()->getExtension();
			}
		} 
		$e->getLogger()->info($pathname);
		$e->getLogger()->info('<<<[moving]>>>');
		$this->filesystem->copy($e->getSplFile()->getPathname(), $pathname);
	
		$e->getDispatcher()->dispatch(FileEvents::FILE_COPY_POST, $e);
	}
}
?>