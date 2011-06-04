<?php
class AddPostForm extends Zend_Form
{

    public function init()
    {
        $this->setAction(APPLICATION_BASEURL . "/posts/update");
        $this->setMethod("post");

        $_title = $this->createElement("text", "title")
            ->setLabel("Title")
            ->setRequired();

        $_body = $this->createElement("textarea", "body")
            ->setLabel("Body")
            ->setRequired();

        $_permalink = $this->createElement("text", "permalink")
            ->setLabel("Permalink")
            ->setRequired();

        $_owner = $this->createElement("hidden", "owner")
            ->setValue(1); //Set it to a default user, as we don't have a login yet...

        $_post = $this->createElement("hidden", "post");

        $_submitBtn = $this->createElement("submit", "Save");

        $this->addElements(array(
            "title" => $_title,
            "body" => $_body,
            "permalink" => $_permalink,
            "submit" => $_submitBtn,
            "owner" => $_owner,
            "post" => $_post,
        ));
    }

    public function setPost(Post $post)
    {
        $this->getElement("title")->setValue($post->title);
        $this->getElement("body")->setValue($post->body);
        $this->getElement("permalink")->setValue($post->permalink);
        $this->getElement("owner")->setValue($post->owner);
        $this->getElement("post")->setValue($post->id);
    }

    public function isNewPostForm()
    {
        return $this->getElement("post")->getValue() == "";
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

