<?php

class Strategery_Infinitescroll_Test_Config_General extends EcomDev_PHPUnit_Test_Case_Config
{
    /**
     * Test that the module is in the correct code pool
     */
    public function testCodePool()
    {
        $this->assertModuleCodePool('community');
    }

    /**
     * Make sure layout files are accessible and defined.
     */
    public function testLayoutFilesDefinedAndExist()
    {
        $this->assertLayoutFileDefined('frontend', 'strategery-infinitescroll.xml');
        $this->assertLayoutFileExists('frontend', 'strategery-infinitescroll.xml');
    }

    /**
     * Check main configuration nodes have been defined
     */
    public function testConfigXMLNodes()
    {
        $this->assertConfigNodeHasChildren('global/helpers/infinitescroll');
        $this->assertConfigNodeHasChildren('global/blocks/infinitescroll');
    }

}