<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\View\Component;
use Illuminate\View\View;

class LinkedSelects extends Component
{
    public $firstName;
    public $firstTitle;
    public $secondName;
    public $secondTitle;
    public $dataUrl;
    public $view;
    public $options;
    public $model;

    /**
     * LinkedSelects constructor.
     * @param $firstName
     * @param $firstTitle
     * @param $secondName
     * @param $secondTitle
     * @param $dataUrl
     * @param $view
     * @param $options
     * @param $model
     */
    public function __construct($firstName, $firstTitle, $secondName, $secondTitle, $dataUrl, $view, $options, $model = null)
    {
        $this->firstName = $firstName;
        $this->firstTitle = $firstTitle;
        $this->secondName = $secondName;
        $this->secondTitle = $secondTitle;
        $this->dataUrl = $dataUrl;
        $this->view = $view;
        $this->options = $options;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view($this->view);
    }

    /**
     * @return Application|UrlGenerator|string
     */
    public function url()
    {
        return url($this->dataUrl);
    }
}
