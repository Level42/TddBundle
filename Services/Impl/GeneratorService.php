<?php
/**
 * This file is part of Level42TddBundle.
 *
 * (c) Level42
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\TddBundle\Services\Impl;

use Level42\TddBundle\Exceptions\FileAllreadyExistException;

use Symfony\Component\DependencyInjection\Container;

use Level42\TddBundle\Annotation\TestCaseAnnotation;

use Level42\TddBundle\Annotation\TddTestCase;
use Level42\TddBundle\Annotation\TddClass;

use Level42\TddBundle\Exceptions\BundleNotFoundException;
use Level42\TddBundle\Services\GeneratorInterface;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;

use Doctrine\Common\Annotations\Reader;

/**
 * Class "generator service" used to manipulate
 * test class code
 * 
 * @author fperinel
 * 
 * @Service("level42.tdd.generator.service")
 */
class GeneratorService implements GeneratorInterface 
{

    /**
     * Doctrine annotation reader
     * @var Reader
     */
    protected $reader = null; 
    
    /**
     * Service container 
     * @var Container
     */
    protected $container = null;     
    
    /**
     * 
     * @param Reader $reader Doctrine annotation reader service
     * 
     * @InjectParams({
     *     "reader" = @Inject("annotation_reader"),
     *     "container" = @Inject("service_container")
     * })
     */
    public function __construct(Reader $reader, Container $container)
    {
        $this->reader = $reader;
        $this->container = $container;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Level42\TddBundle\Services\GeneratorInterface::scanForClassToTest()
     */
    public function scanForClassToTest($bundle)
    {
        if(file_exists($bundle) === false)
        {
            throw new BundleNotFoundException($bundle);
        }
        
        $classes = $this->findForClassToTest($bundle);
        
        return $classes;
    }

    /**
     * (non-PHPdoc)
     * @see \Level42\TddBundle\Services\GeneratorInterface::getTestCase()
     */
    public function getTestCase($class) 
    {
        return $this->getTestCases($class);
    }
    
    /**
     * (non-PHPdoc)
     * @see \Level42\TddBundle\Services\GeneratorInterface::generateTestClass()
     */
    public function generateTestClass($testClass, $testCases)
    {
        $code = "";
        $code.= "<?php\n";
        $code.= "namespace ".$this->getTestNamespace($testClass).";\n";
        $code.= "\n";
        $code.= "/**\n";
        $code.= " * Test class for '".$this->getClassname($testClass)."'\n";
        $code.= " */\n";
        $code.= "class ".$this->getTestClassname($testClass)." extends \PHPUnit_Framework_TestCase\n";
        $code.= "{\n";
        foreach ($testCases as $testCase)
        {
            /* @var $testCase TddTestCase */
            $code.= "    /**\n";
            $code.= "     * ".$testCase->getDescription()."\n";
            $code.= "     *\n";
            $code.= "     * Result waiting :\n";
            $code.= "     *   ".$testCase->getResult()."\n";
            $code.= "     */\n";
            $code.= "    public function test".ucfirst($testCase->getMethod())."()\n";
            $code.= "    {\n";
            $code.= "        throw new \Exception('Not implemented');\n";
            $code.= "    }\n";
            $code.= "\n";
        }
        $code.= "}\n";
        
        
        return $code;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Level42\TddBundle\Services\GeneratorInterface::saveTestClass()
     */
    public function saveTestClass($path, $class, $overwrite = false)
    {
        if (file_exists($path) && !$overwrite)
        {
            throw new FileAllreadyExistException($path);
        }
        
        $directory = dirname($path);
                
        if (file_exists($directory) === false)
        {
            mkdir($directory, 0777, true);
        }
        
        return (file_put_contents($path, $class) !== false);  
    }

    /**
     * (non-PHPdoc)
     * @see \Level42\TddBundle\Services\GeneratorInterface::getTestClassPath()
     */
    public function getTestClassPath($className) 
    {
        $rootPath = $this->container->getParameter('kernel.root_dir');
        $rootPath = substr($rootPath, 0, -4);
        
        $classPath = $rootPath.'/src';
        $parts = explode("\\", $className);
        foreach ($parts as $part)
        {
            if (substr($part, -6) == 'Bundle')
            {
                $classPath .= DIRECTORY_SEPARATOR.$part.DIRECTORY_SEPARATOR.'Tests';
            } else {
                $classPath .= DIRECTORY_SEPARATOR.$part;
            }
        }
        return str_replace("/", DIRECTORY_SEPARATOR, str_replace("\\", DIRECTORY_SEPARATOR, $classPath.'Test.php'));
    }
    
    /**
     * Browse recursively a path to find classes
     * 
     * @param string $path Path to scan
     * 
     * @return array Classes find
     */
    protected function findForClassToTest($path) 
    {
        $dir = rtrim($path, '\\'.DIRECTORY_SEPARATOR.'/');
        $result = array();
        
        foreach (scandir($dir) as $f) 
        {
            if ($f !== '..' && $f !== '.') 
            {
                if (is_dir($dir.DIRECTORY_SEPARATOR.$f))
                {
                    $result = array_merge($result, $this->findForClassToTest($dir.DIRECTORY_SEPARATOR.$f));
                } elseif(substr($f, -4) == '.php') {
                    $classFile = $dir.DIRECTORY_SEPARATOR.$f;                    
                    $className = $this->getFullNameClass($classFile);                     
                    if($className != null && $this->isTddEnableForClass($className)) 
                    {
                        $result[$classFile] = $className;
                    }
                }
            }
        }
        
        return $result;
    }
    
    /**
     * Method used to get fullname of a class from file
     * 
     * @param string $classFile File of the class
     * 
     * @return string Fullname of a class
     */
    protected function getFullNameClass($classFile)
    {
        $namespace = null;
        $content = file_get_contents($classFile);
        $rows = explode(chr(10), $content);
       
        $matches = array();
        if(preg_match('/namespace\ +(.+);/i', $content, $matches) == true && count($matches) > 0 )
        {
        	$namespace = $matches[1];
        	$file = basename($classFile, '.php');
        	return trim($namespace."\\".$file);
        }
        
        return null;
    }
    
    
    /**
     * Method used to check if class enable Tdd generator
     * 
     * @param string $class Full classname
     * 
     * @return boolean True if Tdd enable for class
     */
    protected function isTddEnableForClass($class)
    {
        $class = new \ReflectionClass($class);        
        if (!$annotations = $this->reader->getClassAnnotations($class)) {
        	return false;
        }
        
        foreach($annotations as $annotation)
        {
            if ($annotation instanceof TddClass)
            {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Method used to list TestCase from classe
     * 
     * @param string $class Fullname classe
     * 
     * @return TestCaseAnnotation[] List of test methods for the class
     */
    protected function getTestCases($class) 
    {
        $results = array();
        $class = new \ReflectionClass($class);
        $methods = $class->getMethods();
        foreach ($methods as $method)
        {
            if (!$method->isPublic())
            {
                continue;
            }
            
            /* @var $method \ReflectionMethod */
            if (!$annotations = $this->reader->getMethodAnnotations($method)) 
            {
            	continue;
            }
            
            foreach($annotations as $annotation)
            {
            	if ($annotation instanceof TddTestCase)
            	{
            		$results = array_merge($results, $annotation->getTestCases());
            	}
            }
        }
        
        return $results;
    }

    /**
     * Method used to get Test namesapce for test class
     *
     * @param string $class Fullname classe
     *
     * @return string
     */
    protected function getTestNamespace($class)
    {
        $parts = explode("\\", $class);
        array_pop($parts);
        $ns = implode("\\", $parts);
        $ns = str_replace("Bundle", "Bundle\Tests", $ns);        
        return $ns;
    }

    /**
     * Method used to get Test class name from classname
     *
     * @param string $class Fullname classe
     *
     * @return string
     */
    protected function getTestClassname($class)
    {
        $parts = explode("\\", $class);
        $className = array_pop($parts);
        return $className."Test";
    }

    /**
     * Method used to get class name from classname
     *
     * @param string $class Fullname classe
     *
     * @return string
     */
    protected function getClassname($class)
    {
        $parts = explode("\\", $class);
        $className = array_pop($parts);
        return $className;
    }
}
