<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;
use Monolog\Handler\IFTTTHandler;

class Input extends Component
{
    public $name;
    public $title;
    public $model;
    public $value;
    public $type;
    public $field;
    public $default;
    public $disabled;
    public $icon;
    public $readonly;

    public $min;
    public $max;

    /**
     * Input constructor.
     *
     * @param string       $name
     * @param null         $title
     * @param null|Model   $model
     * @param string       $type
     * @param string       $value
     * @param string       $field
     * @param null         $default
     * @param null|integer $min
     * @param null|integer $max
     * @param bool         $disabled
     * @param string       $icon
     * @param bool         $readonly
     */
    public function __construct(
        string $name, $title = null, $model = null, $type = 'text', $value = null, $field = '',
        $default = null, $min = null, $max = null, $disabled = false, $icon = '', $readonly = false
    )
    {
        $this->name = $name;
        $this->title = $title;
        $this->model = $model;
        $this->value = $value;
        $this->type = $type;
        $this->field = $field ?: $name;
        $this->default = $default;
        $this->disabled = $disabled;
        $this->icon = $icon;
        $this->readonly = $readonly;

        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        if (old($this->name)) {
            return old($this->name);
        }

        if ($this->value) {
            return $this->value;
        }

        return $this->model->{$this->field} ?? $this->default;
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

    /**
     * @return string
     */
    public function disabled()
    {
        return $this->disabled ? 'disabled' : '';
    }

    /**
     * @return string
     */
    public function readonly()
    {
        return $this->disabled ? 'readonly' : '';
    }
}
