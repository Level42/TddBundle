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
interface ClassToTestInterface
{
    /**
     * @TddTestCase({
     *     {"method"="testCase1InterfaceSuccess", "description"="Nominal test case", "result"="Waiting for an object saved in database (with ID)"},
     *     {"method"="testCase1InterfaceFailed", "description"="Failed test case", "result"="Waiting for an error when entity was validated"}
     * })
     */
    public function testCase1();
    
    /**
     * @TddTestCase({
     *     {"method"="testCase2InterfaceSuccess", "description"="Nominal test case", "result"="Waiting for an object saved in database (with ID)"},
     *     {"method"="testCase2InterfaceFailed", "description"="Failed test case", "result"="Waiting for an error when entity was validated"}
     * })
     */
    public function testCase2();
    
    /**
     * @TddTestCase({
     *     {"method"="testCase3InterfaceSuccess", "description"="Nominal test case", "result"="Waiting for an object saved in database (with ID)"},
     *     {"method"="testCase3InterfaceFailed", "description"="Failed test case", "result"="Waiting for an error when entity was validated"}
     * })
     */
    public function testCase3();
    
    /**
     * @TddTestCase({
     *     {"method"="testCase4InterfaceSuccess", "description"="Nominal test case", "result"="Waiting for an object saved in database (with ID)"},
     *     {"method"="testCase4InterfaceFailed", "description"="Failed test case", "result"="Waiting for an error when entity was validated"}
     * })
     */
    public function testCase4();
}