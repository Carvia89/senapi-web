<?php

namespace App\Http\Controllers\Distribution;

use App\Http\Controllers\Controller;
use App\Models\CommandeVente;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    /**
     * Affichage du tableau de commande en attente de livraison /Bureau Fourniture Scolaire.
     */
    public function index()
    {
        // Récupérer les commandes à afficher dans le tableau
        $enregistrements = CommandeVente::where('etat_cmd', 2)
            ->where('category_cmd', 'Interne')
            ->with(['client', 'methodOption', 'classe'])
            ->get();

        return view('dappro.bur-fournitures.mouv-stock.cmdAttente.index',
            compact(
                'enregistrements'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer les numéros de commande distincts où etat_cmd est 1 et category_cmd est "Interne"
        $nums = CommandeVente::select('num_cmd')
            ->where('etat_cmd', 1)
            ->where('category_cmd', 'Interne')
            ->distinct()
            ->get();

        // Récupérer les commandes à afficher dans le tableau
        $enregistrements = CommandeVente::where('etat_cmd', 1)
            ->where('category_cmd', 'Interne')
            ->with(['client', 'methodOption', 'classe'])
            ->get();

        return view('dappro.bur-distributions.commandes.form',
            compact(
                'nums',
                'enregistrements'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider la demande
        $request->validate([
            'num_cmd' => 'required|string',
        ]);

        // Mettre à jour l'état de la commande
        CommandeVente::where('num_cmd', $request->num_cmd)
            ->update(['etat_cmd' => 2]); // Changer l'état de 1 à 2

        return redirect()->back()->with('success', 'Commande transférée avec succès !');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getQuantity($num_cmd)
    {
        $totalQteCmdee = CommandeVente::where('num_cmd', $num_cmd)
            ->sum('qte_cmdee');

        return response()->json(['total_qte_cmdee' => $totalQteCmdee]);
    }
}
