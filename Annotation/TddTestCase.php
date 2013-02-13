<?php
/**
 * This file is part of Level42TddBundle.
 *
 * (c) Level42
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\TddBundle\Annotation;

/**
 * TddTestCase annotation for methods
 * 
 * @author fperinel
 * 
 * @Annotation
 */
final class TddTestCase extends \Doctrine\Common\Annotations\Annotation 
{
    private $testCases = array();
    
    /**
     * Return list of TestCases
     * 
     * @return TestCase[] List of TestCases
     */
    public function getTestCases()
    {
        foreach ($this->value as $tc)
        {
            $this->testCases[] = new TestCaseAnnotation(
                    isset($tc['method']) ? $tc['method'] : null,
                    isset($tc['description']) ? $tc['description'] : null,
                    isset($tc['result']) ? $tc['result'] : null
            );
        }
        return $this->testCases;
    }
}


/**
 * Test case objet use in TddTestCase annotation
 * 
 * @author fperinel
 */
class TestCaseAnnotation
{
    private $result;
    
    private $description;
    
    private $method;
    
    /**
     * Constructor
     * @param string $method      Method name to use
     * @param string $description Description of the test method
     * @param string $result      Result of the test
     */
    public function __construct($method, $description, $result)
    {
        $this->result = $result;
        $this->description = $description;
        $this->method = $method;
    }
    
    /**
     * Return result value
     * 
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }
    
    /**
     * Return description value
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Return method value
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
}