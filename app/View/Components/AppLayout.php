<?php

namespace App\View\Components;

#CLASES
use App\Models\Imagenes;
use App\Models\RedesSociales;
use App\Models\RevisionImagenes;

#OTRAS COSAS
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AppLayout extends Component
{
    public $linkSpotify;
    public $linkYoutube;
    public $linkInstagram;
    public $linkItunes;
    public $nombreUsuario;
    public $isAuthenticated;
    public $imagenPerfil;

    public function __construct()
    {
        $redSocial = RedesSociales::where('nombreRedSocial', 'Youtube')->first();
        $this->linkYoutube = $redSocial->linkRedSocial;

        $redSocial = RedesSociales::where('nombreRedSocial', 'Spotify')->first();
        $this->linkSpotify = $redSocial->linkRedSocial;

        $redSocial = RedesSociales::where('nombreRedSocial', 'Instagram')->first();
        $this->linkInstagram = $redSocial->linkRedSocial;

        $redSocial = RedesSociales::where('nombreRedSocial', 'iTunes')->first();
        $this->linkItunes = $redSocial->linkRedSocial;

        $this->isAuthenticated = Auth::check();

        if ($this->isAuthenticated) {
            $usuario = Auth::user();

            // Obtener el registro de la revisión de imagen
            $existeFoto = RevisionImagenes::where('usuarios_idusuarios', $usuario->idusuarios)
                ->where('tipoDeFoto_idtipoDeFoto', 1)
                ->first();

            if ($existeFoto) {
                // Obtener el registro de la imagen
                $imagenBD = Imagenes::find($existeFoto->imagenes_idimagenes);

                if ($imagenBD) {
                    // Obtener la URL de la imagen
                    $this->imagenPerfil = Storage::url($imagenBD->subidaImg);
                } else {
                    $this->imagenPerfil = asset('img/logo_usuario.png');
                }
            } else {
                // Si no hay foto en la revisión
                $this->imagenPerfil = asset('img/logo_usuario.png');
            }

            // Obtener el nombre de usuario
            $this->nombreUsuario = $usuario->usuarioUser;
        } else {
            // Usuario no autenticado
            $this->imagenPerfil = asset('img/logo_usuario.png');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.AppLayout');
    }
}
