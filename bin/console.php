<?php

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
       require_once __DIR__ . '/../vendor/autoload.php';
} else {
       require_once __DIR__ . 'vendor/autoload.php';
}

$stream = new Monolog\Handler\StreamHandler('php://stdout', Monolog\Logger::DEBUG);
$logger = new Monolog\Logger('application');
$logger->pushHandler($stream);

$dispatcher = new Symfony\Component\EventDispatcher\EventDispatcher();
// $dispatcher->addListener(ConsoleEvents::COMMAND, function (ConsoleCommandEvent $event) use ($logger) {
// 	$logger->debug('Console command has begun.');
// });
// $dispatcher->addListener(ConsoleEvents::TERMINATE, function (ConsoleTerminateEvent $event) use ($logger) {
// 	$logger->debug('Console command has terminated.');
// });

$app = new Symfony\Component\Console\Application('My first Cli App', '0.1.0');
$app->setDispatcher($dispatcher);
$app->addCommands(
		[
			new Bramley\Filesystem\Console\Command\SortFileCommand($dispatcher, $logger),
			new Bramley\Filesystem\Console\Command\SortImageCommand($dispatcher, $logger),
		]
);

$app->run();	
