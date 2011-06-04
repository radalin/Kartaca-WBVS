<?php

class VoteTable extends Kartaca_Table
{
    protected $_name = "vote";
    protected $_rowClass = "Vote";

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

    public function findAllActive()
    {
        $_select = $this->select()
            ->where("expire_date > CURRENT_TIMESTAMP");
        return $this->fetchAll($_select);
    }

    /**
     * 
     *
     * @return Vote[]
     * @author 
     */
    public function findVotesSubscribedBy($participantId)
    {
        $_select = $this->select()
            ->setIntegrityCheck(false)
            ->from(array("v" => "vote"))
            ->join(
                array("s" => "participant_subscriptions"),
                "s.vote_id = v.id AND s.participant_id = " . $this->_db->quote($participantId)
            )
            ->columns("v.*");
        return $this->fetchAll($_select);
    }
}