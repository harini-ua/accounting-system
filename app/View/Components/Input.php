<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $title;
    public $model;
    public $type;
    public $field;

    /**
     * Input constructor.
     * @param $name
     * @param $title
     * @param null $model
     * @param string $type
     * @param string $field
     */
    public function __construct($name, $title, $model = null, $type = 'text', $field = '')
    {
        $this->name = $name;
        $this->title = $title;
        $this->model = $model;
        $this->type = $type;
        $this->field = $field ?: $name;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->model ? $this->model->{$this->field} : old($this->name);
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

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->name . '_' . spl_object_id($this);
    }
}
