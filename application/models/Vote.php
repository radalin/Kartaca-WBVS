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
            ->where("vote_id = 1");
        return $this->_table->fetchAll($_select);
    }
}