<?php
/**
 * This file is part of Level42TddBundle.
 *
 * (c) Level42
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\TddBundle\Tests\Command;

use Level42\TddBundle\Tests\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Level42\TddBundle\Command\TddCommand;

/**
 * Test class for command
 * @author fperinel
 *
 */
class TddCommandTest extends TestCase
{
    /**
     * Execute command with arguments passed in parameters
     * 
     * @param array $args Array of arguments
     * 
     * @return string Ouput of the command
     */
    private function executeCommand($args = array())
    {
        $application = new Application();
        $application->add(new TddCommand());
        
        $command = $application->find('tdd:generate');
        $commandTester = new CommandTester($command);
        
        $args['command'] = $command->getName();
        
        $commandTester->execute($args);
        
        return $commandTester->getDisplay();
    }
    
    /**
     * Clean generated classes
     */
    public static function tearDownAfterClass()
    {
        $directory = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Tests';        
        if (file_exists($directory))
        {
            TestCase::rmdir_recursive($directory);
        }
    }
    
    /**
     * Test the command with no file rewriting
     * 
     * @ignore
     * @todo : Test failed because of application instanciation in test
     */
    /*public function testTddCommand_noForce()
    {
        $result = $this->executeCommand(array('bundle' => 'Level42/TddBundle'));
        $this->assertTrue(false);
    }*/

    /**
     * Test the command with file rewriting
     * 
     * @ignore
     * @todo : Test failed because of application instanciation in test
     */
    /*public function testTddCommand_Force()
    {
        $result = $this->executeCommand(array('bundle' => 'Level42/TddBundle', '--force' => 'force'));
        $this->assertTrue(false);
    }*/

    /**
     * Test the command with a bad bundle name
     * 
     * @ignore
     * @todo : Test failed because of application instanciation in test
     * @
     */
    /*public function testTddCommand_NoBundle()
    {
        $result = $this->executeCommand(array('bundle' => 'Level42/TddBundle'));
        $this->assertTrue(false);
    }*/
}