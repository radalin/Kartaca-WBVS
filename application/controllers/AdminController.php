<?php

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
        
        } else if ($_action === "craete") {
            
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
        if ($_action === "del") {
            $_t->deleteById($_pid);
            $this->_redirect(APPLICATION_BASEURL_INDEX . "/admin/participant");
        } else if ($_action === "edit") {
        
        } else if ($_action === "craete") {
            
        }
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