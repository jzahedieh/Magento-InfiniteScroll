<?php

class Strategery_Infinitescroll_Test_Block_InitGetCurrentPageType extends Strategery_Infinitescroll_Test_Block_Init_TestCase
{

    /**
     * Test the category page is in grid mode.
     */
    public function testCurrentPageTypeIsGrid()
    {
        // set the current category as a grid
        Mage::register('current_category', $this->_categoryMock());

        $this->assertEquals($this->_blockFullMock->getCurrentPageType(), 'grid');

        // have to unregister key in order to set it in other tests.
        Mage::unregister('current_category');
    }

    /**
     * Test the category pag is in list / layered mode.
     */
    public function testCurrentPageTypeIsList()
    {
        // set current category as a list / layered view
        Mage::register('current_category', $this->_categoryMock(true));

        $this->assertEquals($this->_blockFullMock->getCurrentPageType(), 'layer');

        Mage::unregister('current_category');
    }

    /**
     * Test both search methods (standard and advance) from the controller name.
     */
    public function testCurrentPageTypeSearch()
    {
        $block = $this->_blockMockBuilder;
        $block->setMethods(array('getRequest'))->getMock();
        /* @var $block Strategery_Infinitescroll_Block_Init | PHPUnit_Framework_MockObject_MockObject */

        // skip category check
        Mage::register('current_category', false);

        // setup basic controller response objects
        $response_search = new Varien_Object();
        $response_advance = new Varien_Object();
        $response_search->setData(array('controller_name' => 'result'));
        $response_advance->setData(array('controller_name' => 'advanced'));

        // on subsequent call return the search then advance getControllerName response
        $block->expects($this->at(0))->method('getRequest')->willReturn($response_search);
        $block->expects($this->at(1))->method('getRequest')->willReturn($response_advance);

        $this->assertEquals($block->getCurrentPageType(), 'search');
        $this->assertEquals($block->getCurrentPageType(), 'advanced');

        Mage::unregister('current_category');
    }

    /**
     * Test the default behaviour falls back to grid mode if it fails.
     */
    public function testCurrentPageTypeDefaultBehaviour()
    {
        $block = $this->_blockMockBuilder;
        $block->setMethods(array('getRequest'))->getMock();
        /* @var $block Strategery_Infinitescroll_Block_Init | PHPUnit_Framework_MockObject_MockObject */

        // skip category check
        $response = new Varien_Object();
        $response->setData(array('controller_name' => false));
        $block->expects($this->once())->method('getRequest')->willReturn($response);

        // skip category check
        Mage::register('current_category', false);

        $this->assertEquals($block->getCurrentPageType(), 'grid');

        Mage::unregister('current_category');
    }

    /**
     * Mock the the category and apply to register
     *
     * @param bool $getIsAnchorResponse true: to make the list (layer) view.
     * @return Mage_Catalog_Model_Category|PHPUnit_Framework_MockObject_MockObject
     */
    private function _categoryMock($getIsAnchorResponse = false)
    {
        $categoryMock = $this->getModelMockBuilder('catalog/category')
            ->disableOriginalConstructor()
            ->setMethods(array('getIsAnchor'))
            ->getMock();

        $categoryMock->expects($this->once())
            ->method('getIsAnchor')
            ->willReturn($getIsAnchorResponse);

        return $categoryMock;
    }

}