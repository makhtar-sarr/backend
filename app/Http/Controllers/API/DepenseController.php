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

        $depense->nom_dep = $input['nom_dep'];
        $depense->montant_dep = $input['montant_dep'];
        $depense->categorie_dep_id = $input['categorie_dep_id'];
        $depense->sous_categorie_dep_id = $input['sous_categorie_dep_id'];
        $depense->description_dep = $input['description_dep'];
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

    public function montantTotal() {
        $depenses = User::find(Auth::user()->id)->depensesUser;
        $montantTotal = 0;

        foreach ($depenses as $depense) {
            $montantTotal += $depense->montant_dep;
        }

        return $this->sendResponse($montantTotal, 'Total trouvee.');
    }

    public function montantReste() {
        $revenus = User::find(Auth::user()->id)->revenusUser;
        $montantTotalRev = 0;

        foreach ($revenus as $revenu) {
            $montantTotalRev += $revenu->montant_rev;
        }

        $depenses = User::find(Auth::user()->id)->depensesUser;
        $montantTotalDep = 0;

        foreach ($depenses as $depense) {
            $montantTotalDep += $depense->montant_dep;
        }

        $reste = $montantTotalRev - $montantTotalDep;

        return $this->sendResponse($reste, 'Solde restant trouve.');
    }

    public function chart() {
        $depenses = User::find(Auth::user()->id)->depensesUser()->orderBy('created_at', 'desc')->get()->groupBy(function($data) {
            return $data->created_at->format('D');
        });

        $montants = [];
        foreach ($depenses as $key => $jour) {
            $montant = 0;
            foreach ($jour as $depense) {
                $montant += $depense->montant_dep;
            }
            $montants['data'][] = $montant;
            $montants['label'][] = $key;
        }

        return $this->sendResponse($montants, 'Depenses trouvee.');
    }

    public function chartMois() {
        $depenses = User::find(Auth::user()->id)->depensesUser()->orderBy('created_at', 'desc')->get()->groupBy(function($data) {
            return $data->created_at->format('M');
        });

        $montants = [];
        foreach ($depenses as $key => $mois) {
            $montant = 0;
            foreach ($mois as $depense) {
                $montant += $depense->montant_dep;
            }
            $montants['data'][] = $montant;
            $montants['label'][] = $key;
        }

        return $this->sendResponse($montants, 'Depenses trouvee.');
    }

    public function chartPie() {
        $depenses = User::find(Auth::user()->id)->depensesUser()->orderBy('categorie_dep_id')->get()->groupBy(function($data) {
            return $data->categorie_dep_id;
        });

        $montants = [];
        $dataPie = [];
        $montantTotal = 0;
        foreach ($depenses as $key => $cat) {
            $montant = 0;
            foreach ($cat as $depense) {
                $montant += $depense->montant_dep;
            }
            $montants[$key] = $montant;
            $montantTotal += $montant;
        }
        foreach ($montants as $key => $value) {
            $dataPie['data'][] = round(($value * 360) / $montantTotal);
            if($key == '1') {
                $dataPie['label'][] = 'Depenses Fixe';
            }
            else {
                $dataPie['label'][] ='Depenses Spontane';
            }
        }

        return $this->sendResponse($dataPie, 'Depenses trouvee.');
    }
}
