<?php

namespace Kiryi\Viewyi;

use Kiryi\Viewyi\Helper;

class Engine
{
    const TEMPLATENAME_INTERNAL_BASE = 'base';

    private ?Helper\Builder $builder = null;

    private array $data = [];
    private string $view = '';

    public function __construct($config = null)
    {
        $initializer = (new Helper\Initializer($config));
        
        $this->builder = new Helper\Builder($initializer->getConfig());
    }

    public function assign(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    public function reset(): void
    {
        $this->data = [];
    }

    public function render(string $template): string
    {
        $this->view .= $this->build($template);

        return $this->view;
    }

    public function display(string $headTemplate, string $title): void
    {
        $data = [
            'title' => $title,
            'head' => $this->build($headTemplate),
            'body' => $this->view,
        ];

        $display = $this->builder->build($this::TEMPLATENAME_INTERNAL_BASE, $data, false);
        
        $this->reset();
        $this->view = '';

        echo $display;
    }

    private function build(string $template): string
    {
        return $this->builder->build($template, $this->data);
    }
}
