<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $options;
    public $title;
    public $model;
    public $default;
    public $search;
    public $disabled;
    public $firstTitle;

    /**
     * Select constructor.
     *
     * @param string $name
     * @param        $options
     * @param null   $title
     * @param null   $model
     * @param null   $default
     * @param bool   $search
     * @param bool   $disabled
     * @param string $firstTitle
     */
    public function __construct(
        string $name,
        $options,
        $title = null,
        $model = null,
        $default = null,
        $search = false,
        $disabled = false,
        $firstTitle = ''
    ){
        $this->name = $name;
        $this->options = $options;
        $this->title = $title;
        $this->model = $model;
        $this->default = $default;
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
        if ($this->model !== null) {
            return $this->model->{$this->name} == $option->id ? 'selected' : '';
        }

        return $this->default == $option->id ? 'selected' : '';
    }

    /**
     * @return string
     */
     public function selectedOptionName()
     {
         $optionId = $this->model->{$this->name} ?? null;

         if (old($this->name)) {
             $optionId = old($this->name);
         }

         $option = $this->options->first(function($option) use ($optionId) {
             return $option->id == $optionId;
         });

         return $option->name ?? '';
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
