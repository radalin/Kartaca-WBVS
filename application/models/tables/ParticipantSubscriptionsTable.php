<?php

class ParticipantSubscriptionsTable extends Kartaca_Table
{
    protected $_name = "participant_subscriptions";
    protected $_rowClass = "ParticipantSubscription";

    public function addParticipantToVote($voteId, $participantId)
    {
        if ($this->isParticipantSubscribedTo($voteId, $participantId)) {
            return;
        } else {
            $_s = $this->createRow();
            $_s->vote_id = $voteId;
            $_s->participant_id = $participantId;
            $_s->insert();
        }
    }

    public function isParticipantSubscribedTo($voteId, $participantId)
    {
        $_select = $this->select()
            ->from("participant_subscriptions")
            ->where("vote_id = ?", $voteId)
            ->where("participant_id = ?", $participantId)
            ->columns("COUNT(*) c");
        $_row = $this->fetchRow($_select);
        return $_row["c"] > 0;
    }
}