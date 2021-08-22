<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\CategorieRev;
use App\Http\Resources\CategorieRev as CategorieRevResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategorieRevController extends BaseController
{

    public function index()
    {
        $categorieRevs = User::find(Auth::user()->id)->categorieRevsUser;
        return $this->sendResponse(CategorieRevResource::collection($categorieRevs), 'Categorie trouvee.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nom_cat' => 'required|string|min:4|max:150|unique:categorie_revs,nom_cat',
            'description_cat' => 'string|max:255',
            'user_id'
        ]);
        $input['user_id'] = Auth::user()->id;
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $categorieRev = CategorieRev::create($input);
        return $this->sendResponse(new CategorieRevResource($categorieRev), 'Categorie creee avec succes.');
    }


    public function show($id)
    {
        $categorieRev = User::find(Auth::user()->id)->categorieRevsUser()->find($id);
        if (is_null($categorieRev)) {
            return $this->sendError('Categorie introuvable.');
        }
        return $this->sendResponse(new CategorieRevResource($categorieRev), 'Categorie trouvee.');
    }


    public function update(Request $request, CategorieRev $categorieRev)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nom_cat' => 'required|min:4|max:150|unique:categorie_revs,nom_cat,except,id',
            'description_cat' => 'string|max:255'
        ]);

        if(Auth::user()->id != $categorieRev->user_id) {
            return $this->sendError('Modification echouee, acces non authorise!');
        }

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $categorieRev->nom_cat = $input['nom_cat'];
        $categorieRev->description_cat = $input['description_cat'];
        $categorieRev->save();

        return $this->sendResponse(new CategorieRevResource($categorieRev), 'Categorie modifiee.');
    }

    public function destroy(CategorieRev $categorieRev)
    {
        if(Auth::user()->id != $categorieRev->user_id) {
            return $this->sendError('Supression echouee, acces non authorise!');
        }

        $categorieRev->delete();
        return $this->sendResponse([], 'Categorie supprimee.');
    }
}
