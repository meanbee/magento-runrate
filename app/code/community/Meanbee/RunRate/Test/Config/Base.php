<?php
class Meanbee_RunRate_Test_Config_Base extends EcomDev_PHPUnit_Test_Case_Config
{
    /**
     * @test
     */
    public function testClassAlias()
    {
        $this->assertHelperAlias('meanbee_runrate/test', 'Meanbee_RunRate_Helper_Test');
        $this->assertModelAlias('meanbee_runrate/test', 'Meanbee_RunRate_Model_Test');
        $this->assertBlockAlias('meanbee_runrate/test', 'Meanbee_RunRate_Block_Test');
    }
}
