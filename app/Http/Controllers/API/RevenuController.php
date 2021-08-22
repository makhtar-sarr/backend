<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\Revenu;
use App\Http\Resources\Revenu as RevenuResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RevenuController extends BaseController
{

    public function index()
    {
        $revenus = User::find(Auth::user()->id)->revenusUser;
        return $this->sendResponse(RevenuResource::collection($revenus), 'Posts fetched.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'montant_rev' => 'required|integer|min:1|numeric',
            'categorie_rev_id' => 'required|integer',
            'user_id' => 'integer'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $input['user_id'] = Auth::user()->id;
        $revenu = Revenu::create($input);
        return $this->sendResponse(new RevenuResource($revenu), 'Revenu Creee.');
    }

    public function show($id)
    {
        $revenu = User::find(Auth::user()->id)->revenusUser()->find($id);
        if (is_null($revenu)) {
            return $this->sendError('Revenu introuvable.');
        }
        return $this->sendResponse(new RevenuResource($revenu), 'Revenu trouvee.');
    }

    public function update(Request $request, Revenu $revenu)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'montant_rev' => 'required|integer|min:1|numeric',
            'categorie_rev_id' => 'required|integer'
        ]);

        if(Auth::user()->id != $revenu->user_id) {
            return $this->sendError('Modification echouee, acces non authorise!');
        }

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $revenu->montant_rev = $input['montant_rev'];
        $revenu->categorie_rev_id = $input['categorie_rev_id'];
        $revenu->save();

        return $this->sendResponse(new RevenuResource($revenu), 'Revenu modifiee.');
    }

    public function destroy(Revenu $revenu)
    {
        if(Auth::user()->id != $revenu->user_id) {
            return $this->sendError('Suppression echouee, acces non authorise!');
        }

        $revenu->delete();
        return $this->sendResponse([], 'Revenu supprimee.');
    }
}
