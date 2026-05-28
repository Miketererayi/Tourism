<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryIcon extends Component
{
    public string $slug;
    public int $size;

    public function __construct(string $slug = '', int $size = 24)
    {
        $this->slug = strtolower(trim($slug));
        $this->size = $size;
    }

    public function render(): View|Closure|string
    {
        return view('components.category-icon');
    }
}
