<?php

namespace Bramley\Filesystem\File;

class EXIFImageDecorator extends BasicImageDecorator {

	public function findImageCreationDate() {
		if($this->file instanceof BasicImageDecorator) {
			$this->file->findImageCreationDate();
		}
		if (!$this->file->getImageCreationDate()) {
			if ($this->file->getExtension() != 'png') {
				$exif = exif_read_data($this->file->getPathname());
				if (is_array($exif)) {
					if (array_key_exists('DateAcquired', $exif)) {
						$this->setImageCreationDate( new \DateTime($exif['DateAcquired']));
					} elseif (array_key_exists('DateTimeOriginal', $exif)) {
						$this->setImageCreationDate( new \DateTime($exif['DateTimeOriginal']));
					} elseif (array_key_exists('DateTime', $exif)) {
						$this->setImageCreationDate(new \DateTime($exif['DateTime']));
					}
				}
			}
		}
	}
}
?>