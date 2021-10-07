<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Filter extends Component
{
    public $table;
    public $options;
    public $url;
    public $name;
    public $title;
    public $default;
    public $className;
    public $all;

    /**
     * Filter constructor.
     * @param $table
     * @param $options
     * @param $url
     * @param $name
     * @param $title
     * @param mixed $default
     * @param string $className
     * @param bool $all
     */
    public function __construct($table, $options, $url, $name, $title, $default = null, $className = 'filter-btn', $all = true)
    {
        $this->table = $table;
        $this->options = $options;
        $this->url = $url;
        $this->name = $name;
        $this->title = $title;
        $this->default = $default;
        $this->className = $className;
        $this->all = (bool)$all;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.filter');
    }

    /**
     * @return int|void
     */
    public function id()
    {
        return spl_object_id($this);
    }
}
