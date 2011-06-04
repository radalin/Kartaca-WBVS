<?php

class AddCommentForm extends Zend_Form
{
    public function init()
    {
        $this->setMethod("post");
        $this->setAction(APPLICATION_BASEURL . "/posts/addcomment");

        $commentator = $this->createElement("text", "commentator")
            ->setLabel("Full Name");

        $email = $this->createElement("text", "email")
            ->setLabel("Email")
            ->setRequired()
            ->addValidator("emailAddress");

        $body = $this->createElement("textarea", "body")
            ->setLabel("Body")
            ->setRequired();

        $title = $this->createElement("text", "title")
            ->setLabel("Title")
            ->setRequired();

        $post = $this->createElement("hidden", "post");

        $postId = $this->createElement("hidden", "postId");

        $submitBtn = $this->createElement("submit", "Add Comment");

        $this->addElements(array(
            $commentator,
            $email,
            $title,
            $body,
            $submitBtn,
            $post,
            $postId,
        ));
    }

    /**
     *
     * @param Post $post
     */
    public function setPost($post)
    {
        $this->getElement("post")->setValue($post->permalink);
        $this->getElement("postId")->setValue($post->id);
    }

    public function getPostPermalink()
    {
        return $this->getElement("post")->getValue();
    }

    public function getPostId()
    {
        return $this->getElement("postId")->getValue();
    }

    public function getCommentator()
    {
        return $this->getElement("commentator")->getValue();
    }

    public function getEmail()
    {
        return $this->getElement("email")->getValue();
    }

    public function getBody()
    {
        return $this->getElement("body")->getValue();
    }

    public function getTitle()
    {
        return $this->getElement("title")->getValue();
    }
}