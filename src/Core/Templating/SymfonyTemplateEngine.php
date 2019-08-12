<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 18/07/2018
 * Time: 19:02
 */

namespace Core\Templating;


use Core\Text\TextHandlerInterface;
use Symfony\Component\Templating\EngineInterface;

class SymfonyTemplateEngine implements TemplateEngineInterface
{
    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    private $engine;
    /**
     * @var \Core\Text\TextHandlerInterface
     */
    private $textHandler;


    /**
     * TemplateEngine constructor.
     *
     * @param \Symfony\Component\Templating\EngineInterface $engine
     * @param \Core\Text\TextHandlerInterface $textHandler
     */
    public function __construct(EngineInterface $engine, TextHandlerInterface $textHandler)
    {
        $this->engine = $engine;
        $this->textHandler = $textHandler;
    }

    public function render(string $file, array $parameters = []): string
    {
        $parameters["text"] = $this->textHandler;

        return $this->engine->render($file, $parameters);
    }
}