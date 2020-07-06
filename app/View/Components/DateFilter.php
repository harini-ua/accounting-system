<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DateFilter extends Component
{
    public $table;
    public $url;
    public $start;
    public $end;

    /**
     * DateFilter constructor.
     * @param $table
     * @param $url
     * @param $start
     * @param $end
     */
    public function __construct($table, $start = null, $end = null, $url = '')
    {
        $this->table = $table;
        $this->url = $url;
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.date-filter');
    }
}
