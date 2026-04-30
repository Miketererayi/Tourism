<?php

namespace App\View\Components;

use App\Models\Place;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PlaceCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly Place $place,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.place-card');
    }
}
