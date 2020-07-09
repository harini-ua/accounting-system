<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Filter extends Component
{
    public $table;
    public $options;
    public $url;
    public $name;
    public $title;
    public $className;

    /**
     * Filter constructor.
     * @param $table
     * @param $options
     * @param $url
     * @param $name
     * @param $title
     * @param $className
     */
    public function __construct($table, $options, $url, $name, $title, $className = 'filter-btn')
    {
        $this->table = $table;
        $this->options = $options;
        $this->url = $url;
        $this->name = $name;
        $this->title = $title;
        $this->className = $className;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
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
