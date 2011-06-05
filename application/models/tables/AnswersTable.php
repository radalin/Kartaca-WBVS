<?php

class AnswersTable extends Kartaca_Table
{
    protected $_name = "answers";
    protected $_rowClass = "Answer";

    /**
     *
     * @param integer $voteId
     * @return Zend_Db_Table_RowSet
     */
    public function getAnswersForVote($voteId)
    {
        $select = $this->select()
            ->where("vote_id = ?", $voteId);
        return $this->fetchAll($select);
    }

    /**
     *
     * @param integer $id
     * @return Comment
     */
    public function findById($id)
    {
        $_select = $this->select()
            ->where("id = ?", $id);
        return $this->fetchRow($_select);
    }
}