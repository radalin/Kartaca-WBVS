<?php

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