<?php


namespace Core\Entities\Change\Inbox;


use Core\Entities\EntityTypeBase;

class ComposeType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("inbox_compose");
    }
}
