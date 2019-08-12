<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 11/06/2018
 * Time: 16:05
 */

namespace Core\Symfony\Commands;


use Symfony\Component\Console\Input\InputInterface;

class ModelBuildCommand extends \Propel\Bundle\PropelBundle\Command\ModelBuildCommand
{
    protected function createSubCommandInstance()
    {
        $command = parent::createSubCommandInstance();
        $options = $command->getDefinition()->getOptions();

        unset($options["schema-dir"]);

        $command->getDefinition()->setOptions($options);

        return $command;
    }

    protected function getSubCommandArguments(InputInterface $input)
    {
        $outputDir = $this->getApplication()->getKernel()->getRootDir() . '/../src/';

        return [
            '--output-dir' => $outputDir,
        ];
    }

}