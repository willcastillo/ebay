<?php

namespace Ebay\Service;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-05-27 at 16:06:33.
 */
class FindingTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Finding
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Finding;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers Ebay\Service\Finding::makeRequest
     * @todo   Implement testMakeRequest().
     */
    public function testMakeRequest() {
        
        $request = new \Ebay\Common\Request('Get');
        
        $this->object->makeRequest($request);
    }

}