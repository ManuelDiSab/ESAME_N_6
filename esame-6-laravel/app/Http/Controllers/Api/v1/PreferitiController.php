<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\AppHelpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\FilmResource;
use App\Http\Resources\v1\SerieTvResource;
use App\Models\Film;
use App\Models\FilmPreferiti;
use App\Models\SeriePreferite;
use App\Models\serieTv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PreferitiController extends Controller
{

    public function AddFilmPreferiti($idFilm)
    {
        if (Gate::allows('user')) {
            if (Gate::allows('attivo')) {
                $user = Auth::user();
                $idUser = $user->idUser;
                if (FilmPreferiti::where('idUser', $idUser)->where('idFilm', $idFilm)->exists()) {
                    return AppHelpers::rispostaCustom(null, 'Il film è già nei preferiti');
                } else{
                    $preferito = FilmPreferiti::create([
                    'idUser' => $idUser,
                    'idFilm' => $idFilm
                ]);}
                return AppHelpers::rispostaCustom($preferito, 'Film agginuto alla lista preferiti');
            }
        }
    }

    public function AddSeriePreferite($idSerie)
    {
        if (Gate::allows('user')) {
            if (Gate::allows('attivo')) {
                $user = Auth::user();
                $idUser = $user->idUser;
                if (SeriePreferite::where('idUser', $idUser)->where('idSerie', $idSerie)->exists()) {
                    return AppHelpers::rispostaCustom(null, 'La serie è già nei preferiti');
                } else {
                    $preferito = SeriePreferite::create([
                        'idUser' => $idUser,
                        'idSerie' => $idSerie
                    ]);
                    return AppHelpers::rispostaCustom($preferito, 'Serie aggiunta alla lista preferiti');
                }
            }
        }
    }

    public function EliminaFilmDaiPreferiti($idFilm)
    {
        if (Gate::allows('user')) {
            if (Gate::allows('attivo')) {
                $user = Auth::user();
                $idUser = $user->idUser;
                $cancellato = FilmPreferiti::where('idUser', $idUser)->where('idFilm', $idFilm)->get();
                FilmPreferiti::where('idUser', $idUser)->where('idFilm', $idFilm)->delete();
                return AppHelpers::rispostaCustom($cancellato, 'Film cancellato dalla lista preferiti');
            }
        }
    }

    public function indexFilm()
    {
        if (Gate::allows('user')) {
            if (Gate::allows('attivo')) {
                $user = Auth::user();
                $idUser = $user->idUser;
                $filmPreferiti = FilmPreferiti::where('idUser', $idUser)->get('idFilm');
                $tmp_film = array();
                $num = count($filmPreferiti);
                foreach ($filmPreferiti as $x) {
                    array_push($tmp_film, new FilmResource(Film::findOrFail($x->idFilm)));
                }
                return AppHelpers::rispostaCustom($tmp_film);
            }
        }
    }
    public function indexSerie()
    {
        if (Gate::allows('user')) {
            if (Gate::allows('attivo')) {
                $user = Auth::user();
                $idUser = $user->idUser;
                $seriePreferite = SeriePreferite::where('idUser', $idUser)->get('idSerie');
                $serie = array();
                $num = count($seriePreferite);
                foreach ($seriePreferite as $x) {
                    array_push($serie, new SerieTvResource(serieTv::findOrFail($x->idSerie)));
                }
                return AppHelpers::rispostaCustom($serie);
            }
        }
    }
}
