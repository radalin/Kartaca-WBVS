<?php

require_once(APPLICATION_PATH . "/forms/ParticipantInfoUpdateForm.php");

class AdminController extends Kartaca_Controller
{

    /**
     *
     * @var Participant
     */
    protected $_participant;

    public function init()
    {
        /* Initialize action controller here */
        $this->_participant = parent::getActiveParticipant();
        //Active participant...
        if (ADMIN_ENABLED !== 1) {
            throw new Exception("Get out of my sight! You don't belong here!");
        }
        parent::isParticipanActive();
    }

    public function voteAction()
    {
        $this->view->title = "Manage Votes";
        $_t = new VoteTable();
        $this->view->votes = $_t->findAll();
    }

    public function voteeditAction()
    {
        $_action = $this->getRequest()->getParam("act");
        $_vid = $this->getRequest()->getParam("vid");
        $_t = new VoteTable();
        if ($_action === "del") {
            $_t->deleteById($_vid);
            $this->_redirect(APPLICATION_BASEURL_INDEX . "/admin/vote");
        } else if ($_action === "edit") {
            $_form = new ParticipantInfoUpdateForm();
            //TODO: fill the form with actual values...
            $this->view->form = $_form;
        } else if ($_action === "create") {
            $_form = new ParticipantInfoUpdateForm();
            //TODO: fill the form with actual values...
            $this->view->form = $_form;
        } else if ($_action === "save") {
            
        }
    }

    public function participantAction()
    {
        $this->view->title = "Manage Participants";
        $_t = new ParticipantsTable();
        $this->view->participants = $_t->findAll();
    }

    public function participanteditAction()
    {
        $_action = $this->getRequest()->getParam("act");
        $_pid = $this->getRequest()->getParam("pid");
        $_t = new ParticipantsTable();
        $_form = new ParticipantInfoUpdateForm();
        if ($_action === "del") {
            $_t->deleteById($_pid);
            $this->_redirect(APPLICATION_BASEURL_INDEX . "/admin/participant");
        } else if ($_action === "edit") {
            //TODO: fill the form with actual values...
            $_participant = $_t->findById($_pid);
            $_form->loadFromModel($_participant);
        } else if ($_action === "create") {
        } else if ($_action === "save") {
            $_participant = null;
            if ($_pid != "") {
                $_participant = $_t->findById($_pid);
                $_form->loadFromModel($_participant);
            }
            if ($_form->isValid($_POST)) {
                if ($_pid == "") {
                    $_participant = $_t->createRow();
                    $_participant->loadFromForm($_form);
                    $_participant->insert();
                } else {
                    $_participant->loadFromForm($_form);
                    $_participant->save();
                }
                $this->_redirect(APPLICATION_BASEURL_INDEX . "/admin/participant");
            } else {
                $this->view->errorMsg = "Correct the errors below...";
            }
        }
        $this->view->form = $_form;
    }

    public function exportAction()
    {
        $_type = $this->getRequest()->getParam("type");
        $_table = null;
        if ($_type === "p") {
            $_table = new ParticipantsTable();
        } else if ($_type === "v") {
            $_table = new VoteTable();
        } else {
            throw new Exception("What the hell? What do you mean with that?");
        }
        //TODO: Find the ZF equivalent...
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=export.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        $_result = $_table->toCsv();
        echo $_result;
        exit();
    }
}