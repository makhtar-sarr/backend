<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\CategorieDep;
use App\Http\Resources\CategorieDep as CategorieDepResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategorieDepController extends BaseController
{

    public function index()
    {
        $categorieDeps['myCat'] = User::find(Auth::user()->id)->categorieDepsUser;
        if (Auth::user()->id != 1) {
            $categorieDeps['default'] = User::find(1)->categorieDepsUser;
        }

        return $this->sendResponse(CategorieDepResource::collection($categorieDeps), 'Categorie trouvee.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nom_cat' => 'required|string|min:4|max:150|unique:categorie_deps,nom_cat',
            'description_cat' => 'string|max:255',
            'user_id' => 'integer'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $input['user_id'] = Auth::user()->id;
        $categorieDep = CategorieDep::create($input);
        return $this->sendResponse(new CategorieDepResource($categorieDep), 'Categorie cree avec succes.');
    }


    public function show($id)
    {
        $categorieDep = User::find(Auth::user()->id)->categorieDepsUser()->find($id);
        if (is_null($categorieDep)) {
            return $this->sendError('Categorie introuvable.');
        }
        return $this->sendResponse(new CategorieDepResource($categorieDep), 'Post fetched.');
    }

    public function update(Request $request, CategorieDep $categorieDep)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nom_cat' => 'required|string|min:4|max:150|unique:categorie_deps,nom_cat,except,id',
            'description_cat' => 'string|max:255'
        ]);

        if(Auth::user()->id != $categorieDep->user_id) {
            return $this->sendError('Modification echouee, acces non authorise!');
        }

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $categorieDep->nom_cat = $input['nom_cat'];
        $categorieDep->description_cat = $input['description_cat'];
        $categorieDep->save();

        return $this->sendResponse(new CategorieDepResource($categorieDep), 'Categorie modifiee.');
    }

    public function destroy(CategorieDep $categorieDep)
    {
        if(Auth::user()->id != $categorieDep->user_id) {
            return $this->sendError('Supression echouee, acces non authorise!');
        }

        $categorieDep->delete();
        return $this->sendResponse([], 'Categorie supprimee.');
    }


}
