<?php

namespace Minicli\Stencil;

use Minicli\Command\CommandController;
use Minicli\FileNotFoundException;
use Minicli\Input;
use Minicli\Stencil;

class DefaultController extends CommandController
{
    public function handle(): void
    {
        $stencilDir = $this->getApp()->config->stencilDir;
        if (!$stencilDir) {
            throw new \Exception('You must define the $stencilDir config value.');
        }

        $stencil = new Stencil($stencilDir);

        if (!$this->hasParam('template')) {
            throw new \Exception('Missing parameter: template');
        }

        $template = $this->getParam('template');

        $parsedContent = $stencil->applyTemplate($template, $this->getTemplateValues($stencil, $template));

        if ($this->hasParam('output')) {
            file_put_contents($this->getParam('output'), $parsedContent);
            if ($this->getApp()->config->debug) {
                $this->getPrinter()->info("File saved at: " . $this->getParam('output'));
            }
        }

        if ($this->getApp()->config->debug) {
            echo($parsedContent);
        }
    }

    /**
     * @param Stencil $stencil
     * @param string $templateName
     * @return array
     * @throws FileNotFoundException
     */
    public function getTemplateValues(Stencil $stencil, string $templateName): array
    {
        $params = $this->getParams();
        if ($this->hasFlag('i') OR $this->hasFlag('interactive')) {
            $this->getPrinter()->info('Stencil Wizard', true);
            $this->getPrinter()->out("Building file based on: $templateName.tpl");
            $this->getPrinter()->newline();

            $variables = $stencil->scanTemplateVars($templateName);
            $params = $this->inputCollect($variables);
        }

        return $params;
    }

    /**
     * @param array $variables
     * @return array
     */
    public function inputCollect(array $variables): array
    {
        $values = [];
        $input = new Input(': ');

        foreach ($variables as $variable) {
            $this->getPrinter()->newline();
            $this->getPrinter()->out($variable);
            $values[$variable] = $input->read();
        }
        return $values;
    }
}
