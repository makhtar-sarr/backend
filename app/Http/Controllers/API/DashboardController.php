<?php


namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller as Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseController
{
    public function index() {
        return User::all();
    }

    public function user(Request $request) {
        return $request->user();
    }

    public function chartPie() {
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

        $montants['revenu'] = $montantTotalRev;
        $montants['depense'] = $montantTotalDep;
        $dataPie = [];
        $montantTotal = $montantTotalRev + $montantTotalDep;

        foreach ($montants as $key => $value) {
            $dataPie['data'][] = round(($value * 360) / $montantTotal);
            $dataPie['label'][] = $key;
        }

        return $this->sendResponse($dataPie, 'Depenses trouvee.');
    }
}
