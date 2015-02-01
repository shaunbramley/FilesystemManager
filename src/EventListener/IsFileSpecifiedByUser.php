<?php

namespace Bramley\Filesystem\EventListener;

use Bramley\Filesystem\Event\FileEvent;

use Symfony\Component\Console\Input\InputInterface;

class IsFileSpecifiedByUser {
	protected $regex;

	public function __construct(InputInterface $input) {
		echo $input->getOption('specifics') . PHP_EOL;
		$option = trim(str_replace('=', '', $input->getOption('specifics')));
		if ($option) {
			$this->regex = '/' . str_replace(' ', '|', $option) . '/i';
		}
	}

	public function onFileFound(FileEvent $event) {
		$event->getLogger()->debug('Regex Value = [' . $this->regex . ']');
		if ($this->regex && !preg_match($this->regex, $event->getSplFile()->getpathname())) {
			//if the filename does not match the regex then we will not worry about it.
			$event->getLogger()->debug('File failed the specification search [' . $event->getSplFile()->getPathname() . ']');
			$event->stopPropagation();
		} else {
			$event->getLogger()->debug('File passed through the specification search [' . $event->getSplFile()->getPathname() . ']');
		}
	}
}
?>