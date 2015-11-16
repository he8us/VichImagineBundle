<?php
namespace VichImagineBundle\Upload\Naming;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

/**
 * Class RandomNamer
 * @package VichImagineBundle\Upload\Naming
 *
 * @author Dennis Senn <info@interface-f.com>
 */
class RandomNamer implements NamerInterface
{
	public function name($entity, PropertyMapping $mapping)
	{
		/* @var UploadedFile $file */
		$file = $mapping->getFile($entity);
		$file_name = $file->getClientOriginalName();
		$extension = substr($file_name, strrpos($file_name, '.') + 1);

		// create random_string
		$random_string = time() . '_';
		$random_string .= substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVW0123456789"), 0, 20);

		// check if file exists on upload_path
		if (is_file($mapping->getUploadDestination() . '/' . $random_string)) {
			return $this->name($entity, $mapping);
		}

		return $random_string . '.' . $extension;
	}
}