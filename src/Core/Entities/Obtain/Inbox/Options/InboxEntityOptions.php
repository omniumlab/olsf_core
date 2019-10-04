<?php


namespace Core\Entities\Obtain\Inbox\Options;


use Core\Entities\Options\EntityOptions;

class InboxEntityOptions extends  EntityOptions implements InboxEntityOptionsInterface
{
    /*
     * entity_get: string
     * entity_compose: string
     * entity_user_autocomplete: string
     */


    function setEntityGet(string $name): InboxEntityOptionsInterface
    {
        $this->setVariable("entity_get", $name);
        return $this;
    }

    function setEntityCompose(string $name): InboxEntityOptionsInterface
    {
        $this->setVariable("entity_compose", $name);
        return $this;
    }

    function setEntityUserAutocomplete(string $name): InboxEntityOptionsInterface
    {
        $this->setVariable("entity_user_autocomplete", $name);
        return $this;
    }
}
