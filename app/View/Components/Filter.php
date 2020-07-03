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

    /**
     * Filter constructor.
     * @param $table
     * @param $options
     * @param $url
     * @param $name
     * @param $title
     */
    public function __construct($table, $options, $url, $name, $title)
    {
        $this->table = $table;
        $this->options = $options;
        $this->url = $url;
        $this->name = $name;
        $this->title = $title;
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
}
