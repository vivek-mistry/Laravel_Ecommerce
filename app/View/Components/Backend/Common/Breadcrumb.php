<?php

namespace App\View\Components\Backend\Common;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $title;
    public $breadcrumb;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $breadcrumb)
    {
        $this->title = $title;
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.backend.common.breadcrumb');
    }
}
