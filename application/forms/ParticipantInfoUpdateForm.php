<?php

require_once(APPLICATION_PATH . "/forms/RegisterForm.php");


class ParticipantInfoUpdateForm extends RegisterForm
{
	public function init()
    {
    	parent::init();
        $this->setAction(APPLICATION_BASEURL_INDEX . "/admin/participantedit?act=save");
        $this->getElement("accept")->setLabel("Change These");

        $_id = $this->createElement("hidden", "pid");

        $this->addElement($_id);
	}

	public function loadFromModel(Participant $p)
	{
		$this->getElement("pid")->setValue($p->id);
		$this->getElement("email")->setValue($p->email);
		$this->getElement("fname")->setValue($p->fname);
		$this->getElement("lname")->setValue($p->lname);
		$this->getElement("company")->setValue($p->company);
	}
}