<?php

class IndexController extends Kartaca_Controller
{

    public function init()
    {
        /* Initialize action controller here */
        parent::getActiveParticipant();
    }

    public function indexAction()
    {
        
    }
}