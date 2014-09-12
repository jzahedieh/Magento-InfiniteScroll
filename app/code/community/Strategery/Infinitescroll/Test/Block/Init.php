<?php

class Strategery_Infinitescroll_Test_Block_Init extends Strategery_Infinitescroll_Test_Block_Init_TestCase
{
    /**
     * Test each possible mode that is handled when determining mode from controller request.
     */
    public function testGetProductListModeFromRequest()
    {
        $block = $this->_blockMockBuilder;
        $block->setMethods(array('getRequest'))->getMock();
        /* @var $block Strategery_Infinitescroll_Block_Init | PHPUnit_Framework_MockObject_MockObject */

        // set the getParam responses for the request
        $block->expects($this->at(0))->method('getRequest')->willReturn(
            new Varien_Object(array('param' => array('mode' => 'grid')))
        );
        $block->expects($this->at(1))->method('getRequest')->willReturn(
            new Varien_Object(array('param' => array('mode' => 'list')))
        );
        $block->expects($this->at(2))->method('getRequest')->willReturn(
            new Varien_Object(array('param' => array('mode' => 'other')))
        );

        $this->assertEquals('grid', $block->getProductListMode()); //grid
        $this->assertEquals('list', $block->getProductListMode()); //list
        $this->assertEquals('grid', $block->getProductListMode()); //default

    }

    /**
     * Test when mode cannot be determined by request use configuration set to use grid by default
     *
     * @loadFixture
     */
    public function testGetProductListModeFromConfigGrid()
    {
        $block = $this->_blockMockBuilder;
        $block->setMethods(array('getRequest'))->getMock();
        /* @var $block Strategery_Infinitescroll_Block_Init | PHPUnit_Framework_MockObject_MockObject */

        $block->expects($this->atLeastOnce())->method('getRequest')->willReturn(new Varien_Object());

        $this->assertEquals('grid', $block->getProductListMode());
    }

    /**
     * Test when mode cannot be determined by request use configuration set to use list by default
     *
     * @loadFixture
     */
    public function testGetProductListModeFromConfigList()
    {
        $block = $this->_blockMockBuilder;
        $block->setMethods(array('getRequest'))->getMock();
        /* @var $block Strategery_Infinitescroll_Block_Init | PHPUnit_Framework_MockObject_MockObject */

        $block->expects($this->atLeastOnce())->method('getRequest')->willReturn(new Varien_Object());

        $this->assertEquals('list', $block->getProductListMode());
    }

    /**
     * Test when mode cannot be determined by request or configuration.
     *
     * @loadFixture
     */
    public function testGetProductListModeFromConfigDefault()
    {
        $block = $this->_blockMockBuilder;
        $block->setMethods(array('getRequest'))->getMock();
        /* @var $block Strategery_Infinitescroll_Block_Init | PHPUnit_Framework_MockObject_MockObject */

        $block->expects($this->atLeastOnce())->method('getRequest')->willReturn(new Varien_Object());

        $this->assertEquals('grid', $block->getProductListMode());

    }

    /**
     * Test external finding of image and skin directory from config data.
     */
    public function testGetLoaderImage()
    {
        $block = $this->_blockMockBuilder;
        $block->setMethods(array('getConfigData'))->getMock();
        /* @var $block Strategery_Infinitescroll_Block_Init | PHPUnit_Framework_MockObject_MockObject */

        $block->expects($this->at(0))->method('getConfigData')->with('design/loading_img')->willReturn(
            'http://fake.tld/spinner.png'
        );
        $block->expects($this->at(1))->method('getConfigData')->with('design/loading_img')->willReturn(
            'images/spinner.png'
        );

        // external resource
        $this->assertEquals('http://fake.tld/spinner.png', $block->getLoaderImage());

        // skin directory location
        $this->assertEquals(Mage::getDesign()->getSkinUrl('images/spinner.png'), $block->getLoaderImage());
    }

    /**
     * Test configuration data can be escaped by quotes for safe use in javascript.
     *
     * @loadFixture
     */
    public function testGetConfigData()
    {
        $block = $this->_blockFullMock;

        $this->assertEquals("I'm testing", $block->getConfigData('test/config'));

        $this->assertEquals(
            Mage::helper('infinitescroll')->jsQuoteEscape("I'm testing"),
            $block->getConfigData('test/config', true)
        );

    }
}