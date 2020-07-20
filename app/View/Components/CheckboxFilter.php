<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CheckboxFilter extends Component
{
    public $table;
    public $url;
    public $name;
    public $title;

    /**
     * CheckboxFilter constructor.
     * @param $table
     * @param $url
     * @param $name
     * @param $title
     */
    public function __construct($table, $url, $name, $title)
    {
        $this->table = $table;
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
        return view('components.checkbox-filter');
    }
}
