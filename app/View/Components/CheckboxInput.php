<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CheckboxInput extends Component
{
    public $model;
    public $checkboxName;

    /**
     * CheckboxInput constructor.
     * @param $model
     * @param $checkboxName
     */
    public function __construct($model, $checkboxName)
    {
        $this->model = $model;
        $this->checkboxName = $checkboxName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checkbox-input');
    }

    /**
     * @return mixed
     */
    public function isCheckboxChecked()
    {
        if (old($this->checkboxName)) {
            return true;
        }

        return $this->model ? $this->model->{$this->checkboxName} : false;
    }
}
