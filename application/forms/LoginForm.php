<?php

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