<?php

class VoteController extends Zend_Controller_Action
{
	/**
	 * @var VoteTable
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
        $this->_table = new VoteTable();
        //Active participant...
        $_t = new ParticipantsTable();

        $this->_participant = $_t->findByEmail(Zend_Auth::getInstance()->getIdentity());
    }

    public function indexAction()
    {
        $this->view->votes = $this->_table->findAllActive();
        $this->view->pid = $this->_participant->id;
    }

    public function subscribeAction()
    {
        $_participantId = $this->getRequest()->getParam("pid");
        $_voteId = $this->getRequest()->getParam("vid");
        
        $_t = new ParticipantSubscriptionsTable();
        $_t->addParticipantToVote($_voteId, $_participantId);
        //$this->_forward("subscriptions", "participant")
        exit();
    }
}