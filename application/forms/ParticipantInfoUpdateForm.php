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

require_once(APPLICATION_PATH . "/forms/RegisterForm.php");

class ParticipantInfoUpdateForm extends RegisterForm
{
    public function init()
    {
        parent::init();
        $this->setAction(APPLICATION_BASEURL_INDEX . "/admin/participantedit?act=save");

        $this->getElement("accept")->setLabel("Change These");

        $_isActive = $this->createElement("checkbox", "isactive")
            ->setValue("1")
            ->setLabel("Active?");
        $this->addElement($_isActive);

        $_isAdmin = $this->createElement("checkbox", "isadmin")
            ->setValue("1")
            ->setLabel("Administrator?");
        $this->addElement($_isAdmin);

        $_id = $this->createElement("hidden", "pid");
        $this->addElement($_id);

        //Add the submit button to the last order...
        $_sbmt = $this->getElement("accept");
        $this->removeElement("accept");
        $this->addElement($_sbmt);
    }

    public function loadFromModel(Participant $p)
    {
        $this->getElement("pid")->setValue($p->id);
        $this->getElement("email")->setValue($p->email);
        $this->getElement("fname")->setValue($p->fname);
        $this->getElement("lname")->setValue($p->lname);
        $this->getElement("company")->setValue($p->company);

        $this->getElement("password")->setRequired(false);

        $this->getElement("isadmin")->setChecked((int)$p->is_admin === 1);
        $this->getElement("isactive")->setChecked((int)$p->is_active === 1);

        $this->getElement("email")->setAttrib('readonly', true);
   }
}