<?php

namespace App\View\Components;

use Illuminate\View\View;

class SidebarForm extends FormAbstract
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.sidebar-form');
    }
}
