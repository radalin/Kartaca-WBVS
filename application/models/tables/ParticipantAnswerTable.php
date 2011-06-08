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

class ParticipantAnswerTable extends Kartaca_Table
{
    protected $_name = "participant_answers";
    protected $_rowClass = "ParticipantAnswer";

    public function vote($voteId, $answerId, $participantId)
    {
        if (null === $this->findParticipantAnswerForVote($participantId, $voteId)) {
            $_row = $this->createRow();
            $_row->vote_id = $voteId;
            $_row->answer_id = $answerId;
            $_row->participant_id = $participantId;
            $_row->insert();
            //Now Update the vote count for the answer....
            $_answersTable = new AnswersTable();
            $_answer = $_answersTable->findById($answerId);
            $_answer->vote_count += 1;
            $_answer->save();
        }
    }

    /**
     * 
     *
     * @return null if participant is not voted yet or Answer object
     */
    public function findParticipantAnswerForVote($participantId, $voteId)
    {
        $_t = new AnswersTable();
        $_select = $_t->select()
            ->setIntegrityCheck(false)
            ->from(array("a" => "answers"))
            ->join(array("pa" => "participant_answers"), "pa.vote_id = a.vote_id AND a.id = pa.answer_id")
            ->where("pa.vote_id = ?", $voteId)
            ->where("pa.participant_id = ?", $participantId)
            ->columns("a.*");
        $_result = $_t->fetchRow($_select);
        return $_result;
    }
}