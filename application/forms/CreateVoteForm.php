<?php

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

        $this->addElements(array(
            $_name,
            $_desc,
            $_beginDate,
            $_expireDate,
            $_id,
            $_sbmt,
        ));
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