<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 07/03/2019
 * Time: 19:11
 */

namespace Core\Entities\Translation;


use Core\Entities\AbstractEntity;
use Core\Entities\EntityTypeInterface;
use Core\Entities\Obtain\ListEntity\ListEntity;
use Core\Entities\Obtain\ListEntity\ListType;
use Core\Entities\Obtain\ListEntity\Options\ListColumn;
use Core\Entities\Obtain\ListEntity\Options\ListEntityOptions;
use Core\Entities\Options\ColumnTypeFormatter\ColumnTypeFormatterInterface;
use Core\Handlers\HandlerInterface;
use Core\Handlers\ObtainHandlers\ListHandlerInterface;
use Core\Repository\Translation\TranslationRepositoryInterface;
use Core\Text\TextHandlerInterface;

abstract class ListTranslationEntity extends AbstractEntity
{
    /** @var TranslationRepositoryInterface */
    private $translation;

    public function __construct(ListHandlerInterface $handler, TextHandlerInterface $textHandler, TranslationRepositoryInterface $translationRepository, ColumnTypeFormatterInterface $columnFormatter)
    {
        parent::__construct($handler, new ListType(), $textHandler);
        $this->setOptions(new ListEntityOptions($handler, $columnFormatter, $textHandler));

        $this->translation = $translationRepository;
    }

    public function setup(TextHandlerInterface $textHandler)
    {
        $options = $this->getOptions();
        $columname = $options->getColumn($this->getTextHandler()->get("Name"));
        $columname->setVisible(true);
        $columname->setVisualName( strtoupper($this->translation->getDefaultLang()));
        $columtable = $options->getColumn("table");
        $columtable->setVisible(false);
        $filtert = $options->getColumn("tables")->setFilterPosition(ListColumn::POSITION_TOP);
        $filtert->setType(HandlerInterface::TYPE_SELECT);
        $filtert->setVisualName($textHandler->get("list_translation_filter_tables"));
        $filtert->setVisible(false);
        $filterColumns = $options->getColumn("columns");
        $filterColumns->setVariable("dependencyColumns", ["tables"]);
        $filterColumns->setForeignListEntityName("translation_columns_list");
        $filterColumns->setFilterPosition(ListColumn::POSITION_TOP);
        $filterColumns->setType("listquery");
        $filterColumns->setVisualName($textHandler->get("Columns"));
        $filterColumns->setVisible(false);
        $tabless = array();
        foreach ($this->getTablesNames() as $tables) {
            $tabless[$tables] = $tables;

        }
        $filtert->setValuesInList($tabless);

        foreach ($this->translation->getLanguages() as $lang) {
            if ($lang !== $this->translation->getDefaultLang()) {
                $columm = $options->getColumn($lang);
                $columm->setVisualName(strtoupper($lang));
                $columm->setEditEntityName("translation_update");
                $columm->setOnEditSendAllFields(true);
            }
        }

    }

    abstract function getTablesNames(): array;

    /**
     * @return \Core\Entities\Options\EntityOptions|\Core\Entities\Options\EntityOptionsInterface|\Core\Entities\Obtain\ListEntity\Options\ListEntityOptions
     */
    public function getOptions()
    {
        return parent::getOptions();
    }
}
