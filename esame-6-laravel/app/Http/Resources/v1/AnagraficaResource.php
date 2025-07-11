<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnagraficaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'idNazione' => $this->idNazione,
            'cod_fis' => $this->cod_fis,
            'dataNascita'=> $this->dataNascita,
            'sesso'=>$this->sesso,
            'idUser'=>$this->idUser,
            'comuneNascita'=>$this->comuneNascita       
            ];
    }

}
