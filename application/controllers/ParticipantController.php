<?php

require_once(APPLICATION_PATH . "/forms/LoginForm.php");
require_once(APPLICATION_PATH . "/forms/RegisterForm.php");
require_once(APPLICATION_PATH . "/forms/VoteForm.php");

class ParticipantController extends Kartaca_Controller
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
        $this->_participant = parent::getActiveParticipant();
    }

    public function indexAction()
    {
        $this->view->title = "First Checkpoint";
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
        $this->view->title = "First Checkpoint";
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
        $this->view->title = "Name Yourself!";
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
        if ($this->_participant === null) {
            throw new Exception("We don't like trespassers, do you know that? Either knock the door or don't come at all...");
        }
        parent::isParticipanActive();

        $this->view->title = "Votes I'm Subscribed";
        $_voteTable = new VoteTable();
        $_votes = $_voteTable->findVotesSubscribedBy($this->_participant->id);
        $_answers = array();
        $_selectedAnswers = array();
        $_forms = array();
        foreach ($_votes as $_v) {
            $_answers[$_v->id] = $_v->findAnswers();
            $_selectedAnswers[$_v->id] = $_v->isVotedBy($this->_participant->id);
            if (null === $_selectedAnswers[$_v->id]) {
                $_f = new VoteForm();
                $_f->setAnswers($_answers[$_v->id]);
                $_f->setVote($_v->id);
                $_forms[$_v->id] = clone $_f;
            }
        }
        $this->view->votes = $_votes;
        $this->view->answers = $_answers;
        $this->view->selectedAnswers = $_selectedAnswers;
        $this->view->forms = $_forms;
    }

    private function _sendActivationEmail(Participant $p)
    {
        mail($p->email, "Activate Yourself", "Click on this link to activate your account: {$p->createActivationLink()}");
    }

}