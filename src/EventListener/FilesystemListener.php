<?php

namespace Bramley\Filesystem\EventListener;

use Symfony\Component\Filesystem\Filesystem;
abstract class FilesystemListener {

	protected $filesystem;

	public function __construct(Filesystem $fs) {
		$this->filesystem = $fs;
	}
}

?>