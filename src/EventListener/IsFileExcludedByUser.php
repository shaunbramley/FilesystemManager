<?php

namespace Bramley\Filesystem\EventListener;

use Bramley\Filesystem\Event\FileEvent;
use Symfony\Component\Console\Input\InputInterface;

class IsFileExcludedByUser {
	protected $regex;
	protected $logger;

	public function __construct(InputInterface $input) {
		$option = trim(str_replace('=', '', $input->getOption('exclusions')));
		if ($option) {
			$this->regex = '/' . str_replace(' ', '|', $option) . '/i';
		}
	}

	public function onFileFound(FileEvent $event) {
		if($this->regex && preg_match($this->regex, $event->getSplFile()->getpathname())) {
			$event->getLogger()->debug('File failed the specification search [' . $event->getSplFile()->getPathname() . ']');
			$event->stopPropagation();
		} else {
			$event->getLogger()->debug('File passed through the exclusion search [' . $event->getSplFile()->getPathname() . ']');
		}
	}
}
?>