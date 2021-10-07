<?php

namespace App\View\Components;

use Illuminate\View\View;

class Textarea extends Input
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.textarea');
    }
}
