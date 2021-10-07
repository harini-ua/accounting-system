<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class CheckboxFilter extends Component
{
    public $table;
    public $url;
    public $name;
    public $title;
    public $checked;

    /**
     * CheckboxFilter constructor.
     *
     * @param string $table
     * @param string $url
     * @param string $name
     * @param string $title
     * @param boolean $checked
     */
    public function __construct(string $table, string $url, string $name, string $title, $checked = false)
    {
        $this->table = $table;
        $this->url = $url;
        $this->name = $name;
        $this->title = $title;
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.checkbox-filter');
    }
}
