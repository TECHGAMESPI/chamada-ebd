<?php

namespace App\Livewire\Church;

use App\Models\{Chamada, Igreja};
use Illuminate\Http\Request;
use Livewire\Component;

class Show extends Component
{
    public $igreja;

    public $presencas;
    public function mount(Request $request)
    {
        $this->igreja    = Igreja::find($request->id);
        $this->presencas = $this->recuperaPresencas();
    }
    public function render()
    {
        return view(
            'livewire.church.show',
            [
                'jan' => Chamada::whereMonth('data', '01')->whereYear('data', date('Y'))->where('igreja_id', $this->igreja->id)->count(),
                'fev' => Chamada::whereMonth('data', '02')->whereYear('data', date('Y'))->where('igreja_id', $this->igreja->id)->count(),
                'mar' => Chamada::whereMonth('data', '03')->whereYear('data', date('Y'))->where('igreja_id', $this->igreja->id)->count(),
                'abr' => Chamada::whereMonth('data', '04')->whereYear('data', date('Y'))->where('igreja_id', $this->igreja->id)->count(),
                'mai' => Chamada::whereMonth('data', '05')->whereYear('data', date('Y'))->where('igreja_id', $this->igreja->id)->count(),
                'jun' => Chamada::whereMonth('data', '06')->whereYear('data', date('Y'))->where('igreja_id', $this->igreja->id)->count(),
                'jul' => Chamada::whereMonth('data', '07')->whereYear('data', date('Y'))->where('igreja_id', $this->igreja->id)->count(),
                'ago' => Chamada::whereMonth('data', '08')->whereYear('data', date('Y'))->where('igreja_id', $this->igreja->id)->count(),
                'set' => Chamada::whereMonth('data', '09')->whereYear('data', date('Y'))->where('igreja_id', $this->igreja->id)->count(),
                'out' => Chamada::whereMonth('data', '10')->whereYear('data', date('Y'))->where('igreja_id', $this->igreja->id)->count(),
                'nov' => Chamada::whereMonth('data', '11')->whereYear('data', date('Y'))->where('igreja_id', $this->igreja->id)->count(),
                'dez' => Chamada::whereMonth('data', '12')->whereYear('data', date('Y'))->where('igreja_id', $this->igreja->id)->count(),
            ]
        );
    }

    protected function recuperaPresencas(): int
    {
        return Chamada::where('igreja_id', $this->igreja->id)->whereYear('data', date('Y'))->count();
    }
}
