<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarForm extends Component
{

    public $id;
    public $title;
    public $model;
    public $button;
    public $resource;

    /**
     * SidebarForm constructor.
     *
     * @param $id
     * @param $title
     * @param $model
     * @param null $button
     * @param null $resource
     */
    public function __construct($id, $title, $model, $button = null, $resource = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->model = $model;
        $this->button = $button ?? __('Save Changes');
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function resource()
    {
        if ($this->resource) {
            return $this->resource->getTable();
        }
        return $this->model->getTable();
    }

    /**
     * @return mixed
     */
    public function model()
    {
        return $this->resource ?? $this->model;
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
