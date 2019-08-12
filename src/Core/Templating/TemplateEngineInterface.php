<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 18/07/2018
 * Time: 19:00
 */

namespace Core\Templating;


interface TemplateEngineInterface
{
    public function render(string $file, array $parameters = []): string;
}