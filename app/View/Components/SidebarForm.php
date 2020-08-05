<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarForm extends Component
{

    public $id;
    public $title;
    public $model;

    /**
     * SidebarForm constructor.
     * @param $id
     * @param $title
     * @param $model
     */
    public function __construct($id, $title, $model)
    {
        $this->id = $id;
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
        return view('components.sidebar-form');
    }
}
