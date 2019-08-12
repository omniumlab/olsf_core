<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 16/04/2019
 * Time: 15:59
 */

namespace Core\Fields\Input;


use Core\Commands\CommandInterface;
use Core\Repository\File\FileRepositoryInterface;

class File extends BaseInputField
{
    /** @var FileRepositoryInterface */
    private $fileRepository;

    /** @var string */
    private $folder;

    public function __construct(string $name, string $folder, FileRepositoryInterface $fileRepository, string $inputKeyName = '')
    {
        parent::__construct($name, $inputKeyName);
        $this->fileRepository = $fileRepository;
        $this->folder = $folder;
    }

    public function findValue(CommandInterface $request)
    {
        $name = str_replace(".", "__", $this->getName());
        $this->fileRepository->saveInResource($request->get($name, null, true), $this->folder,
            $request->get($name . "_filename", null, true));
        return parent::findValue($request);
    }

    public function getType()
    {
        return "file";
    }
}
