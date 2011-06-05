<?php

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