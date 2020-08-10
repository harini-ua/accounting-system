<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarForm extends Component
{

    public $id;
    public $title;
    public $model;
    public $button;

    /**
     * SidebarForm constructor.
     *
     * @param $id
     * @param $title
     * @param $model
     * @param $button
     */
    public function __construct($id, $title, $model, $button = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->model = $model;
        $this->button = $button ?? __('Save Changes');
    }

    /**
     * @return string
     */
    public function resource()
    {
        return $this->model->getTable();
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
