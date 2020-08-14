<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $options;
    public $title;
    public $model;
    public $search;
    public $disabled;
    public $firstTitle;

    /**
     * Select constructor.
     * @param $name
     * @param $options
     * @param $title
     * @param $model
     * @param $search
     * @param bool $disabled
     * @param $firstTitle
     */
    public function __construct($name, $options, $title = null, $model = null, $search = false, $disabled = false, $firstTitle = '')
    {
        $this->name = $name;
        $this->options = $options;
        $this->title = $title;
        $this->model = $model;
        $this->search = $search;
        $this->disabled = $disabled;
        $this->firstTitle = $firstTitle;
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
     * @return bool
     */
    public function isDefaultOption()
    {
        return (bool) $this->firstTitle;
    }

    /**
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function defaultOptionName()
    {
        return $this->firstTitle ? __("- Select {$this->firstTitle} -") : __("- Select -");
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
