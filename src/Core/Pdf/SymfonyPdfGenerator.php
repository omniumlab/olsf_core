<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 17/01/2019
 * Time: 11:28
 */

namespace Core\Pdf;


use Core\Config\GlobalConfigInterface;
use Core\Symfony\RootDirObtainerInterface;
use Core\Templating\TemplateEngineInterface;

class SymfonyPdfGenerator implements PdfGeneratorInterface
{

    /** @var string */
    private $rootDir;

    /** @var TemplateEngineInterface */
    private $templateEngine;

    /** @var \Knp\Snappy\Pdf */
    private $pdfGenerator;

    /** @var GlobalConfigInterface  */
    private $globalConfig;

    /** @var RootDirObtainerInterface */
    private $rootDirObtainer;

    function __construct(GlobalConfigInterface $globalConfig,
                         TemplateEngineInterface $templateEngine,
                         RootDirObtainerInterface $rootDirObtainer)
    {
        $this->globalConfig = $globalConfig;
        $this->pdfGenerator = $globalConfig->getPdf();
        $this->templateEngine = $templateEngine;
        $this->rootDirObtainer = $rootDirObtainer;
        $this->rootDir = $rootDirObtainer->getRootDir();
    }

    function generate(string $resource, string $templateName, int $id = null, array $parameters = [])
    {
        $hasId = $id !== null;
        $resourceDir = $hasId ? $resource . "/" : "";
        $dir = $this->rootDirObtainer->getPublicDir() . "/pdf/" . $resourceDir . $resource . ($hasId ? "_" . $id : "") . '.pdf';
        $this->pdfGenerator->setOption('user-style-sheet', $this->rootDir . "/app/Resources/views/pdf/css/" . $templateName . ".css");

        if ($this->globalConfig->isLinux())
            $this->pdfGenerator->setBinary($this->rootDir . "/app/pdf/linux/wkhtmltox/bin/wkhtmltopdf");
        else
            $this->pdfGenerator->setBinary($this->rootDir . "/app/pdf/windows/wkhtmltopdf/bin/wkhtmltopdf.exe");

        $this->deleteExistingFiles($dir);

        $this->pdfGenerator->generateFromHtml(
            $this->templateEngine->render(
                "pdf/" . $templateName . ".html.twig",
                $parameters
            ),
            $dir
        );
    }

    private function deleteExistingFiles(string $dir)
    {
        $files = glob($dir);

        foreach ($files as $file){
            unlink($file);
        }
    }
}
