<?php
/**
 * This file is part of Level42TddBundle.
 *
 * (c) Level42
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\TddBundle\Exceptions;

/**
 * Specialized exception
 * 
 * @author fperinel
 */
class FileAllreadyExistException extends \Exception 
{
    public function __construct($file) {
        parent::__construct("File '$file' allready exist");
    }
}