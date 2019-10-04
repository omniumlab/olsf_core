<?php


namespace Core\Entities\Obtain\Inbox\Options;


interface InboxEntityOptionsInterface
{
    function setEntityGet(string $name): InboxEntityOptionsInterface;

    function setEntityCompose(string $name): InboxEntityOptionsInterface;

    function setEntityUserAutocomplete(string $name): InboxEntityOptionsInterface;
}
