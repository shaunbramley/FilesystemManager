<?php

namespace Bramley\Filesystem\File;

abstract class BasicImageDecorator extends ImageFile {
	public function __construct(ImageFile $file) {
		parent::__construct($file);
	}

	protected function findImageCreationDate() {}

	public function find() {
		$this->findImageDimensions();
		$this->findImageCreationDate();
	}

	protected function setImageCreationDate(\DateTime $d) {
		$this->file->setImageCreationDate($d);
	}

	protected function findImageDimensions() {
		list($w, $h) = getimagesize($this->getPathname());
		$this->file->setHeight($h);
		$this->file->setWidth($w);
	}
}
?>