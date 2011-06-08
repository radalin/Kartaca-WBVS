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