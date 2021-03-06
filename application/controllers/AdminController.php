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

require_once(APPLICATION_PATH . "/forms/ParticipantInfoUpdateForm.php");
require_once(APPLICATION_PATH . "/forms/CreateVoteForm.php");

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
        $this->view->title = "Create New/Change";
        $_action = $this->getRequest()->getParam("act");
        $_vid = $this->getRequest()->getParam("vid");
        $_t = new VoteTable();
        $_form = new CreateVoteForm();
        $this->view->answers = array();
        $this->view->answerEditingEnabled = false;
        if ($_action === "del") {
            $_t->deleteById($_vid);
            $this->_redirect(APPLICATION_BASEURL_INDEX . "/admin/vote");
        } else if ($_action === "edit") {
            //TODO: fill the form with actual values...
            $_vote = $_t->findById($_vid);
            $_form->loadFromModel($_vote);
            $this->view->answers = $_vote->findAnswers();
        } else if ($_action === "create") {
            $this->view->answerEditingEnabled = true;
        } else if ($_action === "save") {
            $_vote = null;
            if ($_vid != "") {
                $_vote = $_t->findById($_vid);
                $_form->loadFromModel($_vote);
            }
            if ($_form->isValid($_POST)) {
                if ($_vid == "") {
                    $_vote = $_t->createRow();
                    $_vote->loadFromForm($_form);
                    $_newVid = $_vote->insert();
                    //Now Let's go for the answers...
                    $_answerList = $_form->getAnswersAsArray();
                    $_answerTable = new AnswersTable();
                    foreach ($_answerList as $_text) {
                        $_answerRow = $_answerTable->createRow();
                        $_answerRow->vote_id = $_newVid;
                        $_answerRow->text = $_text;
                        $_answerRow->vote_count = 0;
                        $_answerRow->insert();
                    }
                } else {
                    $_vote->loadFromForm($_form);
                    $_vote->save();
                }
                $this->_redirect(APPLICATION_BASEURL_INDEX . "/admin/vote");
            } else {
                $this->view->errorMsg = "Correct the errors below...";
            }
        }
        $this->view->form = $_form;
    }

    public function participantAction()
    {
        $this->view->title = "Manage Participants";
        $_t = new ParticipantsTable();
        $this->view->participants = $_t->findAll();
    }

    public function participanteditAction()
    {   
        $this->view->title = "Create New/Change";
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
                //$this->_redirect(APPLICATION_BASEURL_INDEX . "/admin/participant");
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