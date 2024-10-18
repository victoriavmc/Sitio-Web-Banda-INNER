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

    public function __construct()
    {
        $this->linkYoutube = redessociales::where('nombreRedSocial', 'Youtube')->first()->linkRedSocial;
        $this->linkSpotify = redessociales::where('nombreRedSocial', 'Spotify')->first()->linkRedSocial;
        $this->linkInstagram = redessociales::where('nombreRedSocial', 'Instagram')->first()->linkRedSocial;
        $this->linkItunes = redessociales::where('nombreRedSocial', 'iTunes')->first()->linkRedSocial;
        $this->links = redessociales::all()->pluck('linkRedSocial', 'nombreRedSocial');
    }

    public function render(): View|Closure|string
    {
        return view('components.EmailLayout');
    }
}
