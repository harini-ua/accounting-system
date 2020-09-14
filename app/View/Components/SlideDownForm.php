<?php

namespace App\View\Components;

final class SlideDownForm extends FormAbstract
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.slide-down-form');
    }
}
