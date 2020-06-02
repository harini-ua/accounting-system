<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $title;
    public $model;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $title, $model = null)
    {
        $this->name = $name;
        $this->title = $title;
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->model ? $this->model->{$this->name} : old($this->name);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.input');
    }
}
