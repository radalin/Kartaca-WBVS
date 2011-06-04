<?php

abstract class Kartaca_Table extends Zend_Db_Table
{
	public function findAll()
	{
		$_select = $this->select();
		return $this->fetchAll($_select);
	}
}