<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $t = new ParticipantsTable();
        $list = $t->findParticipantsSubscribedFor(1);
        foreach ($list as $el) {
        	var_dump($el->email);
        }
        var_dump($t->findAll());
    }
}