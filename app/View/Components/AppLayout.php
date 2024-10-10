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
use Illuminate\Support\Facades\Artisan;

class AppLayout extends Component
{
    public $links;
    public $nombreUsuario;
    public $isAuthenticated;
    public $imagenPerfil;

    public function __construct()
    {
        // Ejecutar el comando para actualizar el estado
        Artisan::call('shows:update-status');

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
    #Recupero las redes y muestro en la vista
    public function linksRedes()
    {
        return $this->links = RedesSociales::whereRaw('nombreRedSocial NOT REGEXP "^[0-9]"')->get();
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $links = $this->linksRedes();
        return view('components.AppLayout');
    }
}
