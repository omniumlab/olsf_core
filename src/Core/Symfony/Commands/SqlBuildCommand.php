<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/06/2018
 * Time: 20:03
 */

namespace Core\Symfony\Commands;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SqlBuildCommand extends \Propel\Bundle\PropelBundle\Command\SqlBuildCommand
{
    protected function createSubCommandInstance()
    {
        $command = parent::createSubCommandInstance();
        $options = $command->getDefinition()->getOptions();

        unset($options["schema-dir"]);

        $command->getDefinition()->setOptions($options);

        return $command;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $input->setOption("overwrite", false);
        $output->writeln("<info>ATTENTION: Overwrite parameter INGORED to preserve custom sql files.</info>");
        $output->writeln("");

        return parent::execute($input, $output);
    }


}