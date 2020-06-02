<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectOld extends Component
{
    public $name;
    public $title;
    public $options;
    public $disabled;

    /**
     * SelectOld constructor.
     * @param $name
     * @param $title
     * @param $options
     * @param bool $disabled
     */
    public function __construct($name, $title, $options, $disabled = false)
    {
        $this->name = $name;
        $this->title = $title;
        $this->options = $options;
        $this->disabled = $disabled;
    }

    public function selected($option)
    {
        return old($this->name) == $option->id ? 'selected' : '';
    }

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
