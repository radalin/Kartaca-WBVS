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