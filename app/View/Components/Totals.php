<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Totals extends Component
{
    public $title;
    public $options;
    public $relation;
    public $titleColor;

    /**
     * Totals constructor.
     * @param $title
     * @param $options
     * @param $relation
     * @param $titleColor
     */
    public function __construct($options, $relation, $title = '',  $titleColor = '')
    {
        $this->title = $title;
        $this->options = $options;
        $this->relation = $relation;
        $this->titleColor = $titleColor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.totals');
    }
}
