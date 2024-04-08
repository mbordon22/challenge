<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DiscountFormPeriod extends Component
{
    public $index;
    public $number;

    /**
     * Create a new component instance.
     */
    public function __construct($index)
    {
        $this->index = $index;
        $this->number = " " . $index + 1;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.discount-form-period');
    }
}
