<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\SousCategorieDep;
use App\Http\Resources\SousCategorieDep as SousCategorieDepResource;
use App\Models\CategorieDep;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SousCategorieDepController extends BaseController
{

    public function index()
    {
        $sousCategorieDeps['mySousCat'] = User::find(Auth::user()->id)->sousCategorieDepsUser;
        if (Auth::user()->id != 1) {
            $sousCategorieDeps['default'] = User::find(1)->sousCategorieDepsUser;
        }
        return $this->sendResponse(SousCategorieDepResource::collection($sousCategorieDeps), 'Posts fetched.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nom_sous_cat' => 'required|string|unique:sous_categorie_deps,nom_sous_cat',
            'categorie_dep_id' => 'required',
            'desc_sous_cat' => 'string',
            'user_id' => 'interger'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $input['user_id'] = Auth::user()->id;
        $sousCategorieDep = SousCategorieDep::create($input);
        return $this->sendResponse(new SousCategorieDepResource($sousCategorieDep), 'Post created.');
    }


    public function show($id)
    {
        $sousCategorieDep = User::find(Auth::user()->id)->sousCategorieDepsUser()->find($id);
        if (is_null($sousCategorieDep)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new SousCategorieDepResource($sousCategorieDep), 'Post fetched.');
    }


    public function update(Request $request, SousCategorieDep $sousCategorieDep)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nom_sous_cat' => 'required|string|unique:sous_categorie_deps,nom_sous_cat',
            'categorie_dep_id' => 'required',
            'desc_sous_cat' => 'string'
        ]);

        if(Auth::user()->id != $sousCategorieDep->user_id) {
            return $this->sendError('Modification echouee, acces non authorise!');
        }

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $sousCategorieDep->nom_sous_cat = $input['nom_sous_cat'];
        $sousCategorieDep->categorie_dep_id = $input['categorie_dep_id'];
        $sousCategorieDep->desc_sous_cat = $input['desc_sous_cat'];
        $sousCategorieDep->save();

        return $this->sendResponse(new SousCategorieDepResource($sousCategorieDep), 'Categorie modifiee.');
    }

    public function destroy(SousCategorieDep $sousCategorieDep)
    {
        if(Auth::user()->id != $sousCategorieDep->user_id) {
            return $this->sendError('Supression echouee, acces non authorise!');
        }

        $sousCategorieDep->delete();
        return $this->sendResponse([], 'Post deleted.');
    }

    public function getSousCatByCat($id) {
        $sousCategorieDeps = CategorieDep::find($id)->sousCategorieDeps;
        return $this->sendResponse(SousCategorieDepResource::collection($sousCategorieDeps), 'Posts fetched.');
    }
}
