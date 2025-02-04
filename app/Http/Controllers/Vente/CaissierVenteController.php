<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use App\Models\CommandeVente;
use App\Models\SortieVente;
use App\Models\PrixBulletin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CaissierVenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer les numéros de commande prêts à être payés
        $nums = CommandeVente::where(function($query) {
            $query->where('etat_cmd', 0)->where('category_cmd', 'Interne')
                ->orWhere(function($query) {
                    $query->where('etat_cmd', 0)->where('category_cmd', 'Externe');
                });
        })->select('num_cmd')->distinct()->get();
    
        // Récupérer les commandes avec les critères spécifiés et ajouter la pagination
        $enregistrements = CommandeVente::select('commande_ventes.num_cmd', 'commande_ventes.client_id',
                DB::raw('SUM(commande_ventes.qte_cmdee) as total_qte_cmdee'),
                DB::raw('SUM(sortie_ventes.qte_sortie) as total_qte_sortie'),
                DB::raw('MIN(sortie_ventes.date_sortie) as first_date_sortie'),
                'commande_ventes.type_cmd' // Ajouter le type de commande
            )
            ->leftJoin('sortie_ventes', 'commande_ventes.id', '=', 'sortie_ventes.commande_vente_id')
            ->where('sortie_ventes.etat', 1)
            ->groupBy('commande_ventes.num_cmd', 'commande_ventes.client_id', 'commande_ventes.type_cmd')
            ->paginate(5);
    
        // Récupérer le dernier prix
        $dernierPrix = PrixBulletin::latest()->value('prix'); // Récupérer le dernier prix
    
        // Récupérer les identifiants de l'utilisateur connecté
        $user = Auth::user();
    
        // Retourner la vue avec les numéros de commande et le dernier prix
        return view('dappro.bur-ventes-caissier.facturation.form', compact('nums', 'enregistrements', 'user', 'dernierPrix'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function getDetailsCommand($num_cmd)
    {
        Log::info("Request received for num_cmd: $num_cmd");

        // Récupérer la somme des qte_sortie
        $totalQteSortie = SortieVente::whereHas('commandeVente', function ($query) use ($num_cmd) {
            $query->where('num_cmd', $num_cmd);
        })->where('etat', 1)
          ->sum('qte_sortie');
    
        Log::info("Total quantity sortie: $totalQteSortie");
    
        // Récupérer le dernier prix
        $prixDernier = PrixBulletin::latest()->value('prix');
    
        Log::info("Dernier prix: $prixDernier");
    
        // Récupérer le type de la commande
        $typeCmd = CommandeVente::where('num_cmd', $num_cmd)->value('type_cmd');
    
        return response()->json([
            'totalQteSortie' => $totalQteSortie,
            'prixDernier' => $prixDernier,
            'type_cmd' => $typeCmd
        ]);
    }
}
