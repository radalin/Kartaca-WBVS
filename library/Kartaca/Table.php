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
 
abstract class Kartaca_Table extends Zend_Db_Table
{
	public function findAll()
	{
		return $this->fetchAll();
	}

	public function toCsv()
	{
		$_select = $this->select();
		$_items = $this->fetchAll($_select);
		$_str = "";
		$_count = count($_items);
		if ($_count > 0) {
			$_str .= implode(",", array_keys($_items[0]->toArray())) . "\n";
		}
		for ($i = 0; $i < $_count; $i++) {
			$_str .= implode(",", $_items[$i]->toArray()) . "\n";
		}
		return $_str;
	}

	public function deleteById($id)
	{
		$where = $this->_db->quoteInto('id = ?', $id);
		$this->delete($where);
	}
}