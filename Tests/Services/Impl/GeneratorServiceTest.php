<?php
/**
 * This file is part of Level42TddBundle.
 *
 * (c) Level42
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\TddBundle\Tests\Services\Impl;

use Level42\TddBundle\Exceptions\FileAllreadyExistException;

use Symfony\Bundle\SwiftmailerBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\Container;
use \AppKernel;

use Level42\TddBundle\Services\GeneratorInterface;

/**
 * Class "generator service" used to manipulate
 * test class code
 * 
 * @author fperinel
 */
class GeneratorServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Service container
     * @var Container
     */
    public $container;
    
    /**
     * Generator service to test
     * @var GeneratorInterface
     */
    public $service;
    
    /**
     * Testcase constructor with Kernel instanciation
     */
    public function __construct()
    {
    	$kernel = new AppKernel('test', true);
    	$kernel->loadClassCache();
    	$kernel->boot();
    	$this->container = $kernel->getContainer();
    	
        $this->service = $this->container->get('level42.tdd.generator.service');
    }

    public function testScanForClassToTest()
    {
        $path = "./src/Level42/TddBundle";
        $result = $this->service->scanForClassToTest(str_replace('/', DIRECTORY_SEPARATOR, $path));

        $this->assertCount(2, $result, 'scanForClassToTest error');
    }    

    public function testGetTestCase_Classe()
    {
        $class = "Level42\TddBundle\Tests\Resources\ClassToTestService";
        $result = $this->service->getTestCase($class);
        $this->assertEquals(9, count($result), 'getTestCase error');
    }   

    public function testGetTestCase_Interface()
    {
        $class = "Level42\TddBundle\Tests\Resources\ClassToTestInterface";        
        $result = $this->service->getTestCase($class);        
        $this->assertEquals(8, count($result), 'getTestCase error');
    }         

    public function testGenerateTestClass_Classe()
    {
        $class = "Level42\TddBundle\Tests\Resources\ClassToTestService";
        $result = $this->service->getTestCase($class);
        
        $testClass = $class;        
        $code = $this->service->generateTestClass($testClass, $result);

        file_put_contents("d:\\test.php", $code);
        
        $this->assertEquals(2294, strlen($code), 'generateTestClass error');
    }   

    public function testGenerateTestClass_Interface()
    {
        $class = "Level42\TddBundle\Tests\Resources\ClassToTestInterface";
        $result = $this->service->getTestCase($class);
        
        $testClass = $class;
        $code = $this->service->generateTestClass($testClass, $result);

        $this->assertEquals(2112, strlen($code), 'generateTestClass error');
    }
    
    public function testGetTestClassPath()
    {
        $class = "Level42\TddBundle\Services\Impl\ClassToTestInterface";
        
        $rootPath = $this->container->getParameter('kernel.root_dir');
        $rootPath = substr($rootPath, 0, -4);        
        $classPath = $rootPath.DIRECTORY_SEPARATOR.'src';        
        $expected = str_replace("\\", DIRECTORY_SEPARATOR, $classPath."\Level42\TddBundle\Tests\Services\Impl\ClassToTestInterface.php");
        $expected = str_replace("/", DIRECTORY_SEPARATOR, $expected);
                
        $path = $this->service->getTestClassPath($class);
        $this->assertEquals($expected, $path, 'getTestClassPath error');
    }
    
    public function testSaveTestClass()
    {
        try {
            $path = sys_get_temp_dir().DIRECTORY_SEPARATOR.'test.php';
            $return = $this->service->saveTestClass($path, 'contenu');
            $this->assertTrue(file_exists($path), 'saveTestClass file not found');
            $this->assertTrue(unlink($path), 'saveTestClass unlink exception');
        } catch (Exception $ex) {
            $this->assertTrue(false, 'saveTestClass exception');
        }
    }
    
    public function testSaveTestClass_Exist()
    {
        try {
            $path = sys_get_temp_dir().DIRECTORY_SEPARATOR.'test.php';
            $return = $this->service->saveTestClass($path, 'contenu');
            $this->assertTrue(file_exists($path), 'saveTestClass file not found');
            
            $return = $this->service->saveTestClass($path, 'contenu');
            
            $this->assertTrue(unlink($path), 'saveTestClass unlink exception');
        } catch (FileAllreadyExistException $ex) {
            $this->assertTrue(true);
        } catch (Exception $ex) {
            $this->assertTrue(false, 'saveTestClass exception');
        }
    }  
    
    public function testSaveTestClass_Overwrite()
    {
        try {
            $path = sys_get_temp_dir().DIRECTORY_SEPARATOR.'test.php';
            $return = $this->service->saveTestClass($path, 'contenu', true);
            $this->assertTrue(file_exists($path), 'saveTestClass file not found');
            
            $return = $this->service->saveTestClass($path, 'contenu', true);
            
            $this->assertTrue(unlink($path), 'saveTestClass unlink exception');
        } catch (FileAllreadyExistException $ex) {
            $this->assertTrue(false, 'saveTestClass '.$ex->getMessage());
        } catch (Exception $ex) {
            $this->assertTrue(false, 'saveTestClass exception');
        }
    }      
}
