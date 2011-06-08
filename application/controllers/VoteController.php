<?php
/**
 * This file is part of Kartaca WBVS
 *
 * Kartaca WBVS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * Kartaca WBVS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Kartaca WBVS. If not, see <http://www.gnu.org/licenses/>.
 *
 * @category   Kartaca
 * @copyright  Copyright (c) 2010 Kartaca (http://www.kartaca.com)
 * @license    http://www.gnu.org/licenses/ GPL
 */

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