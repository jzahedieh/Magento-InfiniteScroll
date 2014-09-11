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

}