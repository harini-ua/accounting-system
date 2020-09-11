<?php

namespace App\View\Components;

class SidebarForm extends FormAbstract
{
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
