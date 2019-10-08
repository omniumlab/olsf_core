<?php


namespace Core\Entities\Change\FileManager\MoveTo;


use Core\Entities\EntityTypeBase;

class MoveToType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("file_manager_move_to");
    }
}
