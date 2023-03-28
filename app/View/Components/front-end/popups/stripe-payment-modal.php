<?php

namespace App\View\Components\front-end\popups;

use Illuminate\View\Component;

class stripe-payment-modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.front-end.popups.stripe-payment-modal');
    }
}
