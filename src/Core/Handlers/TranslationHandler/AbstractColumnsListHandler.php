<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 21/03/2019
 * Time: 9:36
 */

namespace Core\Handlers\TranslationHandler;


use App\Roles\PanelRole;
use Core\Auth\Roles\RoleInterface;
use Core\Handlers\ObtainHandlers\ListHandlerInterface;
use Core\Handlers\ObtainHandlers\Propel\ListHandler\AbstractListHandler;
use Core\Output\HttpCodes;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Repository\Translation\TranslationRepositoryInterface;
use Core\Text\TextHandlerInterface;
use Propel\Runtime\ActiveQuery\ModelCriteria;

abstract class AbstractColumnsListHandler extends AbstractListHandler
{


    private $translationrepository;

    public function __construct(ModelCriteria $query, TextHandlerInterface $textHandle, TranslationRepositoryInterface $translationRepository)
    {
        $this->translationrepository = $translationRepository;
        parent::__construct($query, $textHandle);
    }

    public function setup()
    {
        parent::setup();
    }

    public function ignoredColumns(): array
    {
        return [];
    }

    public function handle($command): HandlerResponseInterface
    {

        $data = [];
        $rows = [];
        if ($command->get("tables") !== null) {
            $isIgnoredColumns = array_key_exists($command->get("tables"), $this->ignoredColumns());
            foreach ($this->translationrepository->getColumnsFromTable($command->get("tables"), $isIgnoredColumns ? $this->ignoredColumns()[$command->get("tables")] : ['']) as $key => $value) {
                $rows[] = ["id" => $value, "value" => $value];
            }
        }
        $data["rows"] = $rows;
        $data["total"] = count($rows);

        return new SuccessHandlerResponse(HttpCodes::CODE_OK, $data);
    }
}

