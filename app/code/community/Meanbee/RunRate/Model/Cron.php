<?php

class Meanbee_RunRate_Model_Cron
{
	public function reindex ($schedule) {
		Mage::getModel('meanbee_runrate/Observer')->reindex(json_decode($schedule->getMessages()));
	}
}
