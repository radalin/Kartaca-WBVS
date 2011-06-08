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