<?php

namespace Minicli\Stencil;

use Minicli\Command\CommandController;
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
        $params = $this->getParams();
        $parsedContent = $stencil->applyTemplate($template, $params);

        if ($this->hasParam('output')) {
            file_put_contents($this->getParam('output'), $parsedContent);
        }

        if ($this->getApp()->config->debug) {
            $this->getPrinter()->info($parsedContent);
        }
    }
}