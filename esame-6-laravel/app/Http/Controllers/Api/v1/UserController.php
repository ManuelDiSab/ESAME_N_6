<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\AppHelpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UserUpdateRequest;
use App\Http\Resources\v1\UserCollection;
use App\Http\Resources\v1\UserResource;
use App\Models\AnagraficaUtenti;
use App\Models\contattiRecapiti;
use App\Models\ContattoSessioni;
use App\Models\Indirizzo;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    /**
     * Funzione per mostrare la lista degli utenti
     * Può essere fatta una query string per visualizzare utenti attivi o inattivi
     */
    public function indexAdmin()
    {
        if (Gate::allows('admin')) {
            if (Gate::allows('attivo')) {
                $status = request('status'); //Query per lo status

                if ($status == 'attivi') {
                    $collection = User::all()->where('status', 1);
                    return new UserCollection($collection);
                } else if ($status === 'inattivi') {
                    $collection = User::where('status', 0)->get();
                    return new UserCollection($collection);
                }
                // else if(!$status){

                $collection =  User::all()->take(10);
                return new UserCollection($collection);
                // }

            } else {
                abort(403, "Il tuo account è disabilitato");
            }
        } else {
            abort(403, "Ops! Non sei autorizzato!");
        }
    }

    public function showAdmin($idUser)
    {
        if (Gate::allows('admin')) {
            if (Gate::allows('attivo')) {
                $user = User::findOrFail($idUser);
                $data = new UserResource($user);
                if ($data) {
                    return $data;
                } else {
                    return ["message" => "L'utente non esiste"];
                }
            } else {
                abort(403, "Il tuo account non è attivo");
            }
        } else {
            abort(403, "Ops! Non sei autorizzato!");
        }
    }
    /**
     * mostra i dati dell'utente loggato
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $user = Auth::user();
        return AppHelpers::rispostaCustom($user);
    }

    /**
     * 
     */
    public function ricercaUtente($ricerca)
    {
        if (Gate::allows('attivo')) {
            if (Gate::allows('admin')) {
                $utenti = User::where('nome', 'like', "{$ricerca}%")->orWhere('cognome', 'like', "{$ricerca}%")->get();
                return new UserCollection($utenti);
            } else {
                abort(403, "Ops! Non sei autorizzato!");
            }
        } else {
            abort(403, "Il tuo account non è attivo");
        }
    }

    /**
     * 
     * 
     * 
     */
    public function update(UserUpdateRequest $request)
    {
        if (Gate::allows('user')) {
            if (Gate::allows('attivo')) {
                $user = Auth::user();
                $id = $user->idUser;
                $data = $request->validated();
                $validato = User::findOrFail($id)->fill($data);
                $validato->save();
                $new = new UserResource($validato);
                return AppHelpers::rispostaCustom($new, 'Modifica avvenuta con successo');
            }
        }
    }

    /**
     * Funzione per controllare l'utente e ritornare il sale per 
     */
    public function checkUtente()
    {
        if (Gate::allows('attivo')) {
            if (Gate::allows('user')) {
                $NewSalt = hash('sha512', trim(Str::random(200)));
                $user = Auth::user();
                if ($user) {
                    $utente = User::findOrFail($user->idUser);
                    $utente->salt = $NewSalt;
                    $utente->save();
                    return AppHelpers::rispostaCustom($NewSalt, 'Utente trovato');
                } else {
                    $sale = hash('sha512', trim(Str::random(200)));
                    return AppHelpers::rispostaCustom($sale);
                }
            }
        }
    }

    public function cambioPassword(Request $request, $hash)
    {
        if (Gate::allows('attivo')) {
            if (Gate::allows('user')) {
                $validatore =  Validator::make($request->all(), [
                    'new_password' => 'required|string|confirmed|min:8'
                ]);
                if ($validatore->fails()) {
                    $salt = hash('sha512', trim(Str::random(200)));
                    $dati = array('salt' => $salt);
                    return $dati; //Cerco di sviare possibili malintenzionanti mandando un sale che non salvo in DB 
                } else {
                    $user = Auth::user();
                    $salt = $user->salt;
                    $password = $user->password;
                    $pswNascostaDB = AppHelpers::nascondiPassword($password, $salt);
                    $utente = User::where('idUser', $user->idUser)->first();
                    if ($hash == $pswNascostaDB) {
                        $utente->password = $request->new_password;
                        $utente->save();
                        return AppHelpers::rispostaCustom(null, 'Password cambiata con successo');
                    } else {
                        return 'Password vecchia non corretta';
                    }
                }
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function updateStatus(UserUpdateRequest $request, $idUser)
    {
        if (Gate::allows('admin')) {
            if (Gate::allows('attivo')) {
                if ($idUser) {
                    $data = $request->validated();
                    $user = User::findOrFail($idUser)->fill($data);
                    // $user->fill($data);
                    $user->save();
                    $new = new UserResource($user);
                    return $new;
                } else {
                    return response()->json(['message' => 'Utente non trovato'], 404);
                }
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function destroy()
    {
        if (Gate::allows('user')) {
            if (Gate::allows('attivo')) {
                $user = Auth::user();
                $id = $user->idUser;
                //Cancello tutti i dati riguardo all'utente
                $utente = User::findOrFail($id);
                $utente->delete();
                $anagrafica = AnagraficaUtenti::where('idUser', $id);
                $anagrafica->delete();
                $recapiti = contattiRecapiti::where('idUser', $id);
                $recapiti->delete();
                $sessioni = ContattoSessioni::where('idUser', $id);
                $sessioni->delete();
                $indirizzi = Indirizzo::where('idUser', $id);
                $indirizzi->delete();

                return response()->json([
                    "messaggio" => "Il tuo profilo è stato"
                ], 204);
            }
        }
    }
    /**
     * 
     * 
     * 
     */
    public function destroyAdmin($idUser)
    {
        if (Gate::allows('user')) {
            if (Gate::allows('attivo')) {
                $utente = User::findOrFail($idUser);
                $utente->delete();

                return response()->json([
                    "messaggio" => "Utente cancellato correttamente"
                ], 204);
            }
        }
    }
}
