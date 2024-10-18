<?php

namespace App\View\Components;

use App\Models\RedesSociales;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class emailLayout extends Component
{
    public $linkSpotify;
    public $linkYoutube;
    public $linkInstagram;
    public $linkItunes;
    public $links;

    public function linksRedes()
    {
        return $this->links = RedesSociales::whereRaw('nombreRedSocial NOT REGEXP "^[0-9]"')->get();
    }

    public function render(): View|Closure|string
    {
        $recuperoRedesSociales = $this->linksRedes();
        return view('components.EmailLayout', compact('recuperoRedesSociales'));
    }
}
