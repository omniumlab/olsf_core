<?php


namespace Core\Entities\Obtain\Inbox;


use Core\Entities\EntityTypeBase;

class InboxType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("inbox");
    }
}
