<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DiscountFormPeriodEdit extends Component
{
    public $index;
    public $number;
    public $discount;
    public $discount_ranges = [];

    /**
     * Create a new component instance.
     */
    public function __construct($index, $discount)
    {
        $this->index = $index;
        $this->discount = $discount;
        $this->number = " " . $index + 1;
        $this->discount_ranges = $this->discount->discount_ranges->toArray()[$index];
        // dump($this->discount_ranges);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.discount-form-period-edit');
    }
}
