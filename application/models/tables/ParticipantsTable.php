<?php

class ParticipantsTable extends Kartaca_Table
{
    protected $_name = "participants";
    protected $_rowClass = "Participant";

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

    public function findByEmail($email)
    {
        $_select = $this->select()
            ->where("email = ?", $email);
        return $this->fetchRow($_select);
    }

    public function findParticipantsSubscribedFor($voteId)
    {
        $_select = $this->select()
            ->setIntegrityCheck(false)
            ->from(array("p" => "participants"))
            ->join(array("s" => "participant_subscriptions"), "s.vote_id = $voteId AND s.participant_id = p.id")
            ->columns("p.*");
        return $this->fetchAll($_select);
    }
}