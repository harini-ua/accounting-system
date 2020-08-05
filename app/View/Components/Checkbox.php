<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $name;
    public $title;
    public $model;

    /**
     * Checkbox constructor.
     * @param $name
     * @param $title
     * @param $model
     */
    public function __construct($name, $title, $model)
    {
        $this->name = $name;
        $this->title = $title;
        $this->model = $model;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checkbox');
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->model ? $this->model->{$this->name} : old($this->name);
    }

    public function checked()
    {
        return $this->value() ? 'checked' : '';
    }
}