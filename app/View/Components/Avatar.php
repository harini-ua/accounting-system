<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Avatar extends Component
{
    public $online;
    public $profile;

    /**
     * Create a new component instance.
     *
     * @param $profile
     * @param $online
     *
     * @return void
     */
    public function __construct($profile = false, $online = false)
    {
        $this->profile = $profile;
        $this->online = $online;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.avatar');
    }
}
