<?php

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