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
		if ($form->getIsadmin() == 1) {
			$this->is_admin = 1;
		}
		if ($form->getIsactive()) {
			$this->is_active = 1;
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