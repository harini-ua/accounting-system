<?php

namespace App\View\Components;

use Illuminate\Support\Carbon;

class Date extends Input
{
    /**
     * @return mixed|string
     */
    public function value()
    {
        return $this->model ? $this->model->{$this->name} : $this->date();
    }

    /**
     * @return mixed|string
     */
    protected function date()
    {
        return old($this->name) ?: Carbon::now()->format('d-m-Y');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.date');
    }

    /**
     * @return string
     */
    public function disabled()
    {
        return $this->disabled ? 'disabled' : '';
    }
}
