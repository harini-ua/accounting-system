<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $title;
    public $model;
    public $type;
    public $field;
    public $default;

    public $min;
    public $max;

    /**
     * Input constructor.
     * @param string $name
     * @param string $title
     * @param null|Model $model
     * @param string $type
     * @param string $field
     * @param null $default
     * @param null|integer $min
     * @param null|integer $max
     */
    public function __construct($name, $title = null, $model = null, $type = 'text', $field = '', $default = null, $min = null, $max = null)
    {
        $this->name = $name;
        $this->title = $title;
        $this->model = $model;
        $this->type = $type;
        $this->field = $field ?: $name;
        $this->default = $default;

        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->default ?? ( $this->model ? $this->model->{$this->field} : old($this->name) );
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.input');
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->name . '_' . spl_object_id($this);
    }
}
