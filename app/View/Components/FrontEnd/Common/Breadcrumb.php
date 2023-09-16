<?php

namespace App\View\Components\FrontEnd\Common;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $navlink;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($navlink)
    {
        $this->navlink = $navlink;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.front-end.common.breadcrumb');
    }
}
