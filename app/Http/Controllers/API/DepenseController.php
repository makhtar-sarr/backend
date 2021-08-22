<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\Depense;
use App\Http\Resources\Depense as DepenseResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DepenseController extends BaseController
{

    public function index()
    {
        $depenses = User::find(Auth::user()->id)->depensesUser;
        return $this->sendResponse(DepenseResource::collection($depenses), 'Depenses trouvee.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nom_dep' => 'required|string|min:4|max:150',
            'montant_dep' => 'required|integer|min:1|numeric',
            'categorie_dep_id' => 'required|integer',
            'sous_categorie_dep_id' => 'nullable|integer',
            'description_dep' => 'nullable|string|max:255',
            'user_id' => 'interger'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $input['user_id'] = Auth::user()->id;
        $depense = Depense::create($input);
        return $this->sendResponse(new DepenseResource($depense), 'Depense ajoutee avec succes.');
    }

    public function show($id)
    {
        $depense = User::find(Auth::user()->id)->depensesUser()->find($id);
        if (is_null($depense)) {
            return $this->sendError('Denpense introuvable.');
        }
        return $this->sendResponse(new DepenseResource($depense), 'Depense trouvee.');
    }


    public function update(Request $request, Depense $depense)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nom_dep' => 'required|string|alpha|min:4|max:150',
            'montant_dep' => 'required|integer|min:1|numeric',
            'categorie_dep_id' => 'required|integer',
            'sous_categorie_dep_id' => 'integer',
            'description_dep' => 'string|max:255'
        ]);

        if(Auth::user()->id != $depense->user_id) {
            return $this->sendError('Modification echouee, acces non authorise!');
        }

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $depense->nomDep = $input['nom_dep'];
        $depense->montantDep = $input['montant_dep'];
        $depense->idCatDep = $input['categorie_dep_id'];
        $depense->idSousCat = $input['sous_categorie_dep_id'];
        $depense->descriptionDep = $input['description_dep'];
        $depense->save();

        return $this->sendResponse(new DepenseResource($depense), 'Depense modifiee.');
    }

    public function destroy(Depense $depense)
    {
        if(Auth::user()->id != $depense->user_id) {
            return $this->sendError('Suppression echouee, acces non authorise!');
        }

        $depense->delete();
        return $this->sendResponse([], 'Depense supprimee.');
    }
}
