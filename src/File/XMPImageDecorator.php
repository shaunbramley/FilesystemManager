<?php

namespace Bramley\Filesystem\File;

class XMPImageDecorator extends BasicImageDecorator {
	public function findImageCreationDate() {
		if($this->file instanceof BasicImageDecorator) {
			$this->file->findImageCreationDate();
		}
		if (!$this->file->getImageCreationDate()) {
			if ($this->file->getExtension() != 'png') {
				ob_start();
				readfile($this->getPathname());
				$source = ob_get_contents();
				ob_end_clean();
				
				$xmpdata_start = strpos($source,"<x:xmpmeta");
				$xmpdata_end = strpos($source,"</x:xmpmeta>");
				$xmplenght = $xmpdata_end-$xmpdata_start;
				$xmpdata = substr($source,$xmpdata_start,$xmplenght+12);
				
				if ($xmpdata) {
					preg_match('/<MicrosoftPhoto:DateAcquired>.+<\/MicrosoftPhoto:DateAcquired>/', $xmpdata, $r);
					if(array_key_exists(0, $r)) {
						$data = str_replace('MicrosoftPhoto:DateAcquired', '', $r[0]);
						$data = str_replace('</>', '', $data);
						$data = str_replace('<>', '', $data);
						$this->setImageCreationDate(new \DateTime(str_replace('T', ' ', $data)));
					}
				
				}
			}
		}
		
	}
}

?>