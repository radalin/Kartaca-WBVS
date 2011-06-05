<?php

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