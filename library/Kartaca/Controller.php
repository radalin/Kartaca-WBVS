<?php

class Kartaca_Controller extends Zend_Controller_Action
{
	public function getActiveParticipant()
	{
		$_t = new ParticipantsTable();
        if (Zend_Auth::getInstance()->getIdentity()) {
            $_participant = $_t->findByEmail(Zend_Auth::getInstance()->getIdentity());
            if ($_participant->is_admin == 1) {
            	define("ADMIN_ENABLED", 1);
            } else {
                define("ADMIN_ENABLED", 0);
            }
            return $_participant;
        }
        define("ADMIN_ENABLED", 0);
        return null;
	}
}