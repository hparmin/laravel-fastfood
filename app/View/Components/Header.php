<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Cart;

class Header extends Component
{
    /**
     * Create a new component instance.
     */
    public int $cartCount = 0;
    public function __construct()
    {
        $session_id = session()->getId();

        if (auth()->check()) {
            $this->cartCount = Cart::where('user_id', auth()->id())
                ->count();
        }else{
            $this->cartCount = Cart::where('session_id', $session_id)
                ->count();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header');
    }
}
