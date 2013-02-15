<?php
/**
 * This file is part of Level42TddBundle.
 *
 * (c) Level42
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\TddBundle\Tests;
use \AppKernel;
use Symfony\Bundle\SwiftmailerBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\Container;
use Demo\DemoBundle\Services\DemoInterface;

/**
 * Parent class to implement test case with service container
 * support
 * 
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Service container
     * @var Container
     */
    public $container;

    /**
     * Testcase constructor with Kernel instanciation
     */
    public function __construct()
    {
        $kernel = new AppKernel('test', true);
        $kernel->loadClassCache();
        $kernel->boot();
        $this->container = $kernel->getContainer();
    }

    /**
     * Return projet service container
     * 
     * @return \Symfony\Component\DependencyInjection\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Remove a directory recursively
     * 
     * @param string $dir Directory to remove
     */
    static function rmdir_recursive($dir)
    {
        $dir_content = scandir($dir);
        if ($dir_content !== FALSE) 
        {
            foreach ($dir_content as $entry) 
            {
                if (!in_array($entry, array('.', '..'))) 
                {
                    $entry = $dir . DIRECTORY_SEPARATOR . $entry;
                    if (!is_dir($entry)) 
                    {
                        unlink($entry);
                    } else {
                        TestCase::rmdir_recursive($entry);
                    }
                }
            }
        }
        rmdir($dir);
    }
}
