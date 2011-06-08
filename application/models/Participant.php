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
 
class Participant extends Kartaca_Model
{
	public function loadFromForm(Zend_Form $form)
	{
		$this->email = $form->getEmail();
		if (!$form->getPassword() == "") {
			$this->password = sha1($form->getPassword());	
		} 
		$this->fname = $form->getFname();
		$this->lname = $form->getLname();
		$this->company = $form->getCompany();
		if (null !== $form->getIsadmin()) {
			$this->is_admin = $form->getIsadmin();
		}
		if (null !== $form->getIsactive()) {
			$this->is_active = $form->getIsactive();
		}
	}

	public function createActivationLink()
	{
		return md5($this->email . $this->fname . $this->lname . time());
	}

	public static function getAuthAdapter()
	{
		$_authAdapter = new Zend_Auth_Adapter_DbTable();
        $_authAdapter->setTableName('participants')
            ->setIdentityColumn('email')
            ->setCredentialColumn('password');
        return $_authAdapter;
	}
}