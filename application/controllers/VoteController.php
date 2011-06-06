<?php

class VoteController extends Kartaca_Controller
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
        $this->_participant = parent::getActiveParticipant();
        //Active participant...
        if (null === $this->_participant){
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
        parent::isParticipanActive();
        $_participantId = $this->_participant->id;
        $_voteId = $this->getRequest()->getParam("vid");
        
        $_t = new ParticipantSubscriptionsTable();
        $_t->addParticipantToVote($_voteId, $_participantId);
        $this->_redirect(APPLICATION_BASEURL_INDEX . "/participant/subscriptions");
    }

    public function voteAction()
    {
        parent::isParticipanActive();
        $_voteId = $this->getRequest()->getParam("vid");
        $_answerId = $this->getRequest()->getParam("aid");

        $_t = new ParticipantAnswerTable();
        $_t->vote($_voteId, $_answerId, $this->_participant->id);
        $this->_redirect(APPLICATION_BASEURL_INDEX . "/participant/subscriptions");
    }
}