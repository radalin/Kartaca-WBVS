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