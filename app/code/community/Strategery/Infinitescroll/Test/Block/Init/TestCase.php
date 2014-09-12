<?php

abstract class Strategery_Infinitescroll_Test_Block_Init_TestCase extends EcomDev_PHPUnit_Test_Case
{
    /**
     * A full block which acts like a full block class minus constructors
     *
     * @var Strategery_Infinitescroll_Block_Init | PHPUnit_Framework_MockObject_MockObject
     */
    protected $_blockFullMock;

    /**
     * The block build if methods need to be set on the block.
     *
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $_blockMockBuilder;

    /**
     * Setup the test properties.
     */
    protected function setUp()
    {
        $this->_blockMockBuilder = $this->getBlockMockBuilder('infinitescroll/init')
            ->disableOriginalConstructor();

        $this->_blockFullMock = $this->_blockMockBuilder->setMethods(null)
            ->getMock();
    }

}