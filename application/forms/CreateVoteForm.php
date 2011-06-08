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

class CreateVoteForm extends Zend_Form
{
    public function init()
    {
        $this->setAction(APPLICATION_BASEURL_INDEX . "/admin/voteedit?act=save");
        $this->setMethod("post");

        $_name = $this->createElement("text", "vname")
                ->setLabel("Name")
                ->setRequired();

        $_desc = $this->createElement("textarea", "desc")
                ->setLabel("Description")
                ->setRequired();

        $_beginDate = $this->createElement("text", "begindate")
                ->setLabel("Beginning Date")
                ->setRequired();

        $_expireDate = $this->createElement("text", "expiredate")
                ->setLabel("Expire Date")
                ->setRequired();

        $_sbmt = $this->createElement("submit", "submit")
                ->setLabel("Save!");

        $_id = $this->createElement("hidden", "vid");

        $_answers = $this->createElement("hidden", "answers");

        $this->addElements(array(
            $_name,
            $_desc,
            $_beginDate,
            $_expireDate,
            $_id,
            $_answers,
            $_sbmt,
        ));
    }

    public function getAnswersAsArray()
    {
        return explode("----", $this->getElement("answers")->getValue());
            
    }

    public function loadFromModel(Vote $v)
    {
        $this->getElement("vname")->setValue($v->name);
        $this->getElement("desc")->setValue($v->desc);
        $this->getElement("begindate")->setValue($v->begin_date);
        $this->getElement("expiredate")->setValue($v->expire_date);
        $this->getElement("vid")->setValue($v->id);
    }

    public function __call($method, $args)
    {
        //Let's work with some magic here, contary to the AddCommentForm...
        if (substr($method, 0, 3) == "get") { //Only look for method calls starting with "get"
            $_attr = strtolower(str_replace("get", "", $method)); //Don't forget to lower the case as it's "Title" in the string and not "title"
            if (array_key_exists($_attr, $this->_elements)) {
                //So it's one of the items I have in the form, so return the value
                return $this->getElement($_attr)->getValue();
            }
        }
        //Call the parent's __call too, in order to provide support for parent's magic too...
        parent::__call($method, $args);
    }
}