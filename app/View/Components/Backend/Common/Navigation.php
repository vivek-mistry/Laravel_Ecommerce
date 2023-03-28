<?php

namespace App\View\Components\Backend\Common;

use Illuminate\View\Component;

class Navigation extends Component
{
    public $menuTitle;
    public $faClass;
    public $routes;
    public $activeRoute;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($menuTitle, $faClass, $routes, $activeRoute)
    {
        $this->menuTitle = $menuTitle;
        $this->faClass = $faClass;
        $this->routes = $routes;
        $this->activeRoute = $activeRoute;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.backend.common.navigation');
    }
}
