<?php

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