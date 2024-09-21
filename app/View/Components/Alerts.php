<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alerts extends Component
{
    public $class;
    public $class2;
    public $type;

    public function __construct($type = 'Info')
    {
        switch ($type) {
            case 'Info':
                $this->type = 'Info';
                $this->class = 'bg-gray-800 text-blue-400 border-blue-400';
                $this->class2 = 'bg-gray-800 text-blue-400 hover:bg-gray-700';
                break;

            case 'Danger':
                $this->type = 'Danger';
                $this->class = 'bg-gray-800 text-red-400 border-red-400';
                $this->class2 = 'bg-gray-800 text-red-400 hover:bg-gray-700';
                break;

            case 'Success':
                $this->type = 'Success';
                $this->class = 'bg-gray-800 text-green-400 border-green-400';
                $this->class2 = 'bg-gray-800 text-green-400 hover:bg-gray-700';
                break;

            case 'Warning':
                $this->type = 'Warning';
                $this->class = 'bg-gray-800 text-yellow-400 border-yellow-400';
                $this->class2 = 'bg-gray-800 text-yellow-400 hover:bg-gray-700';
                break;

            case 'Dark':
                $this->type = 'Dark';
                $this->class = 'bg-gray-800 text-gray-300 border-gray-300';
                $this->class2 = 'bg-gray-800 text-gray-300 hover:bg-gray-700';
                break;

            default:
                $this->type = 'Info';
                $this->class = 'bg-gray-800 text-blue-400';
                $this->class2 = 'bg-gray-800 text-blue-400 hover:bg-gray-700';
                break;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.Alerts');
    }
}
