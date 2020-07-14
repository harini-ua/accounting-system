<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $title;
    public $model;
    public $type;

    /**
     * Input constructor.
     * @param $name
     * @param $title
     * @param null $model
     * @param string $type
     */
    public function __construct($name, $title, $model = null, $type = 'text')
    {
        $this->name = $name;
        $this->title = $title;
        $this->model = $model;
        $this->type = $type;
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
