<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 24/04/2019
 * Time: 12:51
 */

namespace Core\Entities\Download;


use Core\Entities\EntityTypeBase;

class DownloadType extends EntityTypeBase
{
    public function __construct()
    {
        parent::__construct("download");
    }
}
