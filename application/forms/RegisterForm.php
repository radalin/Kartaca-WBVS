<?php

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
        if (substr($method, 0, 3) == "get") {
            $_elementName = str_replace("get", "", strtolower($method));
            $_val = $this->getElement($_elementName)->getValue();
            if ($_val !== null) {
                return $_val;
            }
        }
    }
}