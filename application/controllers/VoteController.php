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
        if (Zend_Auth::getInstance()->getIdentity()) {
            $this->_participant = $_t->findByEmail(Zend_Auth::getInstance()->getIdentity());
        } else {
            throw new Exception("We don't like visitors here. You have to login in order to come inside!");
        }
    }

    public function indexAction()
    {
        $this->view->title = "Active Votes";
        $this->view->votes = $this->_table->findAllActive();
    }

    public function subscribeAction()
    {
        $_participantId = $this->_participant->id;
        $_voteId = $this->getRequest()->getParam("vid");
        
        $_t = new ParticipantSubscriptionsTable();
        $_t->addParticipantToVote($_voteId, $_participantId);
        $this->_redirect(APPLICATION_BASEURL_INDEX . "/participant/subscriptions");
    }

    public function voteAction()
    {
        $_voteId = $this->getRequest()->getParam("vid");
        $_answerId = $this->getRequest()->getParam("aid");

        $_t = new ParticipantAnswerTable();
        $_t->vote($_voteId, $_answerId, $this->_participant->id);
        $this->_redirect(APPLICATION_BASEURL_INDEX . "/participant/subscriptions");
    }
}