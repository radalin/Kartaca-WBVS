<?php

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

