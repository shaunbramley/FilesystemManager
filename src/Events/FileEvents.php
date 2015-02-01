<?php

namespace Bramley\Filesystem\Events;

class FileEvents {
	/**
	 * The file.found event is thrown whenever an SplFile is found.
	 * 
	 * The event listener receives an PicturePlayground\Event\FileEvent instance.
	 * 
	 * @var string
	 */
	const FILE_FOUND			= 'file.found';
	const IMAGE_FOUND			= 'image.found';
	const FILE_ALREADY_EXISTS	= 'file.already.exists';

	const FILE_MOVE				= 'file.move';
	const FILE_MOVE_PRE			= 'file.move.pre';
	const FILE_MOVE_POST		= 'file.move.post';

	const FILE_COPY				= 'file.copy';
	const FILE_COPY_PRE			= 'file.copy.pre';
	const FILE_COPY_POST		= 'file.copy.post';

	const FILE_DEL				= 'file.delete';
	const FILE_DEL_PRE			= 'file.delete.pre';
	const FILE_DEL_POST			= 'file.delete.post';

	const EMPTY_DIRECTORY_FOUND = 'dir.found.empty';
}