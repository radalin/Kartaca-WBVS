<?php

class Participant extends Kartaca_Model
{
	public function loadFromForm(Zend_Form $form)
	{
		$this->email = $form->getEmail();
		$this->password = sha1($form->getPassword());
		$this->fname = $form->getFname();
		$this->lname = $form->getLname();
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