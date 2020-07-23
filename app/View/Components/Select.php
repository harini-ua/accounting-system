<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $title;
    public $options;
    public $model;
    public $disabled;

    /**
     * Select constructor.
     * @param $name
     * @param $title
     * @param $options
     * @param $model
     * @param bool $disabled
     */
    public function __construct($name, $title, $options, $model = null, $disabled = false)
    {
        $this->name = $name;
        $this->title = $title;
        $this->options = $options;
        $this->model = $model;
        $this->disabled = $disabled;
    }

    /**
     * @param $option
     * @return string
     */
    public function selected($option)
    {
        return $this->model->{$this->name} == $option->id ? 'selected' : '';
    }

    /**
     * @return string
     */
    public function disabled()
    {
        return $this->disabled ? 'disabled' : '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.select');
    }
}
