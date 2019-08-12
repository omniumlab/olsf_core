<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 02/05/2019
 * Time: 9:29
 */

namespace Core\Entities\Upload;


use Core\Entities\AbstractEntity;
use Core\Handlers\Upload\AbstractUploadHandler;
use Core\Text\TextHandlerInterface;

class UploadEntity extends AbstractEntity
{
    public function __construct(AbstractUploadHandler $handler, TextHandlerInterface $textHandler)
    {
        parent::__construct($handler, new UploadType(), $textHandler);
    }
}
