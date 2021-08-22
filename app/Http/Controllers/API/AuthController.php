<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends BaseController
{

    public function signin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $authUser = Auth::user();
            $user = User::find($authUser->id);
            $success['token'] =  $user->createToken('SDAuth')->plainTextToken;
            $success['prenom'] =  $authUser->prenom;
            $success['nom'] =  $authUser->nom;

            return $this->sendResponse($success, 'Utilisateur connecte');
        }
        else{
            return $this->sendError('Non autorise.', ['error'=>'Non autorise'], 401);
        }
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prenom' => 'required|string|min:3|max:150',
            'nom' => 'required|string|min:2|max:100',
            'poste' => 'required|string|min:3|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('SDAuth')->plainTextToken;
        $success['prenom'] =  $user->prenom;
        $success['nom'] =  $user->nom;
        $success['poste'] =  $user->poste;

        return $this->sendResponse($success, 'Utilisateur cree avec succes.');
    }

    public function logout(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $user->tokens()->delete();
        $success['logout'] = '';

        return $this->sendResponse($success, 'Utilisateur deconnecte.');
    }
}
