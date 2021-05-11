<?php
/**
 * Created by PhpStorm.
 * User: atorr
 * Date: 02/05/2019
 * Time: 9:39
 */

namespace Core\Handlers\Upload;


use Core\Commands\CommandInterface;
use Core\Handlers\Handler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Repository\File\FileRepositoryInterface;
use Core\Text\TextHandlerInterface;

abstract class AbstractUploadHandler extends Handler
{
    /** @var FileRepositoryInterface */
    private $fileRepository;

    public function __construct(TextHandlerInterface $textHandler, FileRepositoryInterface $fileRepository,
                                bool $individual = false)
    {
        parent::__construct("POST", $individual, $textHandler);
        $this->fileRepository = $fileRepository;
    }

    abstract function getFolderName(): string;


    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     * @throws \Core\Exceptions\InputRequiredException
     */
    public function handle($command): HandlerResponseInterface
    {
        $id = $command->get("id", null, false);
        $this->fileRepository->uploadResourceByCommand($command, $this->getFolderName(), $id);
        return new SuccessHandlerResponse(HttpCodes::CODE_OK, [], $this->getTextHandler()->get("upload_success_response"));
    }
}
