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

class LoginForm extends Zend_Form
{
    public function init()
    {
        $this->setAction(APPLICATION_BASEURL_INDEX . "/participant/login");
        $this->setMethod("post");

        $_username = $this->createElement("text", "username")
                ->setLabel("Email")
                ->setRequired();

        $_password = $this->createElement("password", "password")
                ->setLabel("Password")
                ->setRequired();

        $_sbmt = $this->createElement("submit", "let-me-in")
                ->setLabel("Let Me In!");

        $this->addElements(array(
            $_username,
            $_password,
            $_sbmt,
        ));
    }

    public function getUsername()
    {
        return $this->getElement("username")->getValue();
    }

    public function getPassword()
    {
        return $this->getElement("password")->getValue();
    }
}