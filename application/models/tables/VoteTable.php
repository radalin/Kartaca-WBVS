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