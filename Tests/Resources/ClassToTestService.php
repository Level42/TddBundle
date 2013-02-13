<?php
/**
 * This file is part of Level42TddBundle.
 *
 * (c) Level42
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\TddBundle\Tests\Resources;

use Level42\TddBundle\Annotation\TddTestCase;
use Level42\TddBundle\Annotation\TddClass;

/**
 * Resources class used with tests
 * 
 * @TddClass()
 */
class ClassToTestService implements ClassToTestInterface
{
    private $privateAttribute;
    
    public $publicAttribute;
    
    protected $protectedAttribute;

    /**
     * (non-PHPdoc)
     * @see \Level42\TddBundle\Tests\Resources\ClassToTestInterface::testCase1()
     * 
     * @TddTestCase({
     *     {"method"="testCase3Success", "description"="Nominal test case", "result"="Waiting for an object saved in database (with ID)"},
     *     {"method"="testCase3Failed", "description"="Failed test case", "result"="Waiting for an error when entity was validated"},
     *     {"method"="testCase3Exception", "description"="Exception test case", "result"="Waiting for an Exception rised by database"}
     * })
     */
    public function testCase1()
    {
        // TODO: Auto-generated method stub

    }
    
    /**
     * (non-PHPdoc)
     * @see \Level42\TddBundle\Tests\Resources\ClassToTestInterface::testCase2()
     * 
     * @TddTestCase({
     *     {"method"="testCase3Success", "description"="Nominal test case", "result"="Waiting for an object saved in database (with ID)"},
     *     {"method"="testCase3Failed", "description"="Failed test case", "result"="Waiting for an error when entity was validated"}
     * })
     */
    public function testCase2()
    {
        // TODO: Auto-generated method stub

    }
    
    /**
     * (non-PHPdoc)
     * @see \Level42\TddBundle\Tests\Resources\ClassToTestInterface::testCase3()
     * 
     * @TddTestCase({
     *     {"method"="testCase3Success", "description"="Nominal test case", "result"="Waiting for an object saved in database (with ID)"},
     *     {"method"="testCase3Failed", "description"="Failed test case", "result"="Waiting for an error when entity was validated"},
     *     {"method"="testCase3NotGranted", "description"="Failed test case when no granted call", "result"="Waiting for an error when entity was validated"}
     * })
     */
    public function testCase3()
    {
        // TODO: Auto-generated method stub

    }
    
    /**
     * (non-PHPdoc)
     * @see \Level42\TddBundle\Tests\Resources\ClassToTestInterface::testCase4()
     * 
     * @TddTestCase({
     *     {"method"="testCase4Success", "description"="Nominal test case", "result"="Waiting for an object saved in database (with ID)"}
     * })
     */
    public function testCase4()
    {
        // TODO: Auto-generated method stub

    }
    
    /**
     * 
     * @TddTestCase({
     *     {"method"="testCase5ProtectedKO", "description"="Will not be generated", "result"="none"}
     * })
     */
    protected function testCase5Protected()
    {
        
    }
    
    /**
     *
     * @TddTestCase({
     *     {"method"="testCase5privateKO", "description"="Will not be generated", "result"="none"}
     * })
     */
    private function testCase5private()
    {
        
    }

}
