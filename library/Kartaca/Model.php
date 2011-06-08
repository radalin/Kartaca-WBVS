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
 
abstract class Kartaca_Model extends Zend_Db_Table_Row
{
    protected function _escape($exp, $val)
    {
        return $this->_table->getAdapter()->quoteInto($exp, $val);
    }

    /**
     *
     * @return mixed
     */
    public function insert()
    {
        $_id = $this->_table->insert($this->_data);
        if (is_integer($_id)) {
            $this->id = $_id;
            return $this->id;
        }
        return $_id;
    }

    /**
     *
     * @return int affected rows count
     */
    public function update()
    {
        return $this->_table->update($this->_data, $this->_escape("id = ?", $this->id));
    }
}

