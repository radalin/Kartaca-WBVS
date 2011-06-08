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

require_once(APPLICATION_PATH . "/forms/ParticipantInfoUpdateForm.php");

class ParticipantUpdateForm extends ParticipantInfoUpdateForm
{
	public function init()
	{
		parent::init();
		$this->setAction(APPLICATION_BASEURL_INDEX . "/participant/update");

		$this->removeElement("isadmin");
		$this->removeElement("isactive");
	}

	public function loadFromModel(Participant $p)
	{
    	$this->getElement("pid")->setValue($p->id);
    	$this->getElement("email")->setValue($p->email);
    	$this->getElement("fname")->setValue($p->fname);
    	$this->getElement("lname")->setValue($p->lname);
    	$this->getElement("company")->setValue($p->company);

    	$this->getElement("password")->setRequired(false);

    	$this->getElement("email")->setAttrib('readonly', true);
	}

	public function __call($method, $args)
    {
        //Let's work with some magic here, contary to the AddCommentForm...
        if (substr($method, 0, 3) == "get") { //Only look for method calls starting with "get"
            $_attr = strtolower(str_replace("get", "", $method)); //Don't forget to lower the case as it's "Title" in the string and not "title"
            if (array_key_exists($_attr, $this->_elements)) {
                //So it's one of the items I have in the form, so return the value
                return $this->getElement($_attr)->getValue();
            } else {
            	return null;
            }
        }
        //Call the parent's __call too, in order to provide support for parent's magic too...
        parent::__call($method, $args);
    }
}