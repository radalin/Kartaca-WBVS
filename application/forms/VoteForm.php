<?php

class VoteForm extends Zend_Form
{
    public function init()
    {
        $this->setAction(APPLICATION_BASEURL_INDEX . "/vote/vote");
        $this->setMethod("post");

        $_options = $this->createElement("radio", "aid")
                ->setRequired();

        $_vote = $this->createElement("hidden", "vid");

        $_sbmt = $this->createElement("submit", "choose-answer")
                ->setLabel("So My Answer Shall Be!");

        $this->addElements(array(
            $_options,
            $_vote,
            $_sbmt,
        ));
    }

    /**
     * @return void
     */
    public function setAnswers($answers)
    {
    	foreach ($answers as $_a) {
    		$this->getElement("aid")
    			->addMultiOption($_a->id, $_a->text);
    	}
    }

    public function setVote($voteId)
    {
    	$this->getElement("vid")->setValue($voteId);
    }
}