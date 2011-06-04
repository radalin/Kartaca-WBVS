<?php

require_once(APPLICATION_PATH . "/forms/LoginForm.php");
require_once(APPLICATION_PATH . "/forms/RegisterForm.php");

class ParticipantController extends Zend_Controller_Action
{
    /**
     * @var ParticipantTable
     */
    protected static $_table;

    /**
     *
     * @var Participant
     */
    protected $_participant;

    public function init()
    {
        /* Initialize action controller here */
        $this->_table = new ParticipantsTable();
        if (Zend_Auth::getInstance()->getIdentity()) {
            $this->_participant = $this->_table->findByEmail(Zend_Auth::getInstance()->getIdentity());
        }
    }

    public function indexAction()
    {
        if ($this->_getParam("error") == "1") {
            $this->view->showWrongPassError = true;
        } else if ($this->_getParam("error") == "2") {
            $this->view->invalidFormError = true;
        }
        $_form = new LoginForm();
        $this->view->form = $_form;
    }

    public function loginAction()
    {
        //First check if the form is valid...
        $_form = new LoginForm();
        if (!$_form->isValid($_POST)) {
            $this->_redirect(APPLICATION_BASEURL_INDEX . "/participant/index/error/2");
        }

        $_auth = Zend_Auth::getInstance();
        $_authAdapter = Participant::getAuthAdapter();
        $_authAdapter->setIdentity($_form->getUsername())
            ->setCredential(sha1($_form->getPassword()));
        //That's the actual authentication operation
        $_result = $_auth->authenticate($_authAdapter);

        if ($_result->isValid()) {
            $this->view->loggedIn = true;
        } else {
            $this->_redirect(APPLICATION_BASEURL_INDEX . "/participant/index/error/1");
        }
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->view->loggedOut = true;
    }

    public function registerAction()
    {
        $_showError = false;
        $_success = false;
        $_form = new RegisterForm();
        if ($_POST) {
            if ($_form->isValid($_POST)) {
                //Complete the registration here...
                $p = $this->_table->createRow();
                $p->loadFromForm($_form);
                $p->insert();
                $this->_sendActivationEmail($p);
                $_success = true;
            } else {
                $_showError = true;
            }
        }
        if ($_showError) {
            $this->view->showError = true;
        } else if ($_success) {
            $this->view->showSuccess = true;
        }
        $this->view->form = $_form;
    }

    public function subscriptionsAction()
    {
        $_voteTable = new VoteTable();
        $_votes = $_voteTable->findVotesSubscribedBy($this->_participant->id);
        $_answers = array();
        foreach ($_votes as $v) {
            $_answers[$v->id] = $v->findAnswers();
        }
        $this->view->votes = $_votes;
        $this->view->answers = $_answers;
    }

    private function _sendActivationEmail(Participant $p)
    {
        //TODO: Send the email...
    }

}