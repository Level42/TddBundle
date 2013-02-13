<?php
/**
 * This file is part of Level42TddBundle.
 *
 * (c) Level42
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\TddBundle\Services;

use Level42\TddBundle\Annotation\TestCaseAnnotation;

/**
 * Interface to generator service
 * 
 * @author fperinel
 */
interface GeneratorInterface
{
    /**
     * Method used to scan path for discover class
     * to test
     * 
     * @param string $bundle Bundle name
     * 
     * @return array List of class to test
     */
    public function scanForClassToTest($bundle);
    
    /**
     * Method used to get list of testCase for a class
     *
     * @param string $class Fullclass name
     *
     * @return TestCaseAnnotation[] List of test cases
     */
    public function getTestCase($class);
    
    /**
     * Method used to generate test class code
     *
     * @param string               $testClass Test class name
     * @param TestCaseAnnotation[] $testCases List of test cases
     *
     * @return string Code generated
     */
    public function generateTestClass($testClass, $testCases);
    
    /**
     * Method used to saved test class code
     *
     * @param string  $path      Path to saved
     * @param string  $code      Code to saved
     * @param boolean $overwrite Overwrite existing file
     */
    public function saveTestClass($path, $code, $overwrite = false);

    /**
     * Method used to return test filepath for a class
     *
     * @param string $className Fullclass name
     * 
     * @return string Test filepath for a class
     */
    public function getTestClassPath($className);
}
