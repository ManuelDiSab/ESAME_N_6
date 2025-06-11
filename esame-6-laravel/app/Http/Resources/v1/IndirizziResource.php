<?php

namespace App\Http\Resources\v1;

use App\Models\comuni;
use App\Models\Nazione;
use App\Models\TipologiaIndirizzi;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class indirizziResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->getCampi();
    }

    private function getCampi(){
        return [
            "idUser"=>$this->idUser,
            "idTipologiaIndirizzo"=>$this->idTipologiaIndirizzo,
            "tipologia"=>TipologiaIndirizzi::where('idTipologiaIndirizzo',$this->idTipologiaIndirizzo)->value('nome'),
            "idNazione"=>$this->idNazione,
            "nazione"=>Nazione::where('idNazione',$this->idNazione )->value('nome'),
            "idComune"=>$this->idComune,
            "comune"=>comuni::where('idComune', $this->idComune)->value('nome'),
            "indirizzo"=>$this->indirizzo,
            "civico"=>$this->civico,
            "cap"=>$this->cap,
            "provincia"=>$this->provincia
        ];
    }
}
