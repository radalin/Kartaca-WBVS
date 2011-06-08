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
 
class RegisterForm extends Zend_Form
{
    public function init()
    {
        $this->setAction(APPLICATION_BASEURL_INDEX . "/participant/register");
        $this->setMethod("post");

        $_username = $this->createElement("text", "email")
                ->setLabel("Email")
                ->addValidator("EmailAddress")
                ->setRequired();

        $_password = $this->createElement("password", "password")
                ->setLabel("Password")
                ->setRequired();

        $_fname = $this->createElement("text", "fname")
                ->setLabel("First Name")
                ->setRequired();

        $_lname = $this->createElement("text", "lname")
                ->setLabel("Last Name")
                ->setRequired();

        $_company = $this->createElement("text", "company")
                ->setLabel("Company");

        $_sbmt = $this->createElement("submit", "accept")
                ->setLabel("Accept Me As A Brother!");

        $this->addElements(array(
            $_username,
            $_password,
            $_fname,
            $_lname,
            $_company,
            $_sbmt,
        ));
    }

    public function __call($method, $args)
    {
        //Let's work with some magic here, contary to the AddCommentForm...
        if (substr($method, 0, 3) == "get") { //Only look for method calls starting with "get"
            $_attr = strtolower(str_replace("get", "", $method)); //Don't forget to lower the case as it's "Title" in the string and not "title"
            if (array_key_exists($_attr, $this->_elements)) {
                //So it's one of the items I have in the form, so return the value
                return $this->getElement($_attr)->getValue();
            } else {
                return null;
            }
        }
        //Call the parent's __call too, in order to provide support for parent's magic too...
        parent::__call($method, $args);
    }
}