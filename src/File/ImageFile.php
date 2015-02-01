<?php

namespace Bramley\Filesystem\File;

class ImageFile extends \SplFileInfo {
	protected $file;
	protected $height;
	protected $width;
	protected $date;

	function __construct(\SplFileInfo $file) {
		$this->file = $file;
	}

	public function getHeight() {
		return $this->height;
	}

	public function getWidth() {
		return $this->width;
	}

	public function getDate() {
		return $this->date;
	}

	public function getImageCreationDate() {
		return $this->getDate();
	}
	
	protected function setImageCreationDate(\DateTime $date) {
		$this->date = $date;
	}

	protected function setHeight($h) {
		$this->height = $h;
	}

	protected function setWidth($w) {
		$this->width = $w;
	}

	public function getExtension() {
		return $this->file->getExtension();
	}

	public function getPathname() {
		return $this->file->getPathname();
	}

	public function getFilename() {
		return $this->file->getFilename();
	}
}

?>