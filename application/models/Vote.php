<?php

class Vote extends Kartaca_Model
{
    /**
     *
     * @return void
     * @author 
     **/
    public function findAnswers()
    {
        $this->_table->setRowClass("Answer");
    	$_select = $this->_table->select()
            ->setIntegrityCheck(false)
            ->from("answers")
            ->where("vote_id = ?", $this->id);
        return $this->_table->fetchAll($_select);
    }

    /**
     * 
     *
     * @return null if participant is not voted yet or Answer object
     */
    public function isVotedBy($participantId)
    {
        $_t = new ParticipantAnswerTable();
        return $_t->findParticipantAnswerForVote($participantId, $this->id);
    }
}