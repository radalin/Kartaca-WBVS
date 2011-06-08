<?php
/**
 * This file is part of Kartaca WBVS
 *
 * Kartaca WBVS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * Kartaca WBVS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Kartaca WBVS. If not, see <http://www.gnu.org/licenses/>.
 *
 * @category   Kartaca
 * @copyright  Copyright (c) 2010 Kartaca (http://www.kartaca.com)
 * @license    http://www.gnu.org/licenses/ GPL
 */

class Kartaca_Controller extends Zend_Controller_Action
{
	public function getActiveParticipant()
	{
		$_t = new ParticipantsTable();
        if (Zend_Auth::getInstance()->getIdentity()) {
            $_participant = $_t->findByEmail(Zend_Auth::getInstance()->getIdentity());
            if ((int)$_participant->is_active === 1) {
                define("USER_ACTIVE", 1);
            } else {
                define("USER_ACTIVE", 0);
            }
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

    public function isParticipanActive()
    {
        if (USER_ACTIVE !== 1) {
            throw new Exception("What?! First <em>activate</em> yourself!");
        }
    }
}