<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use App\Models\ClientVente;
use App\Models\CommandeVente;
use App\Models\Kelasi;
use App\Models\Option;
use App\Models\Panier;
use Illuminate\Http\Request;

class PanierExtController extends Controller
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
        $options = Option::all();
        $kelasis = Kelasi::all();
        $category_cmd = "Externe";
        $clients = ClientVente::all();
        $enregistrements = Panier::orderBy('created_at', 'asc')->paginate(85);

        // Calcul de la somme totale de 'qte_cmdee'
        $totalBulletins = Panier::sum('qte_cmdee');

        // Récupération du dernier numéro de commande
        $lastCommand = CommandeVente::orderBy('num_cmd', 'desc')->first();
        $num_cmd = "CMD0001"; // Valeur par défaut si aucune commande n'existe

        if ($lastCommand) {
            // Extraction du numéro après le préfixe "CMD"
            $lastNum = (int) substr($lastCommand->num_cmd, 3); // Enlève "CMD" et convertit en entier
            $newNum = $lastNum + 1; // Incrémente le numéro
            $num_cmd = "CMD" . str_pad($newNum, 4, '0', STR_PAD_LEFT); // Formate le nouveau numéro
        }

        return view('dappro.bur-ventes.cmdExterne.form',
            compact(
                'options',
                'kelasis',
                'category_cmd',
                'num_cmd',
                'clients',
                'enregistrements',
                'totalBulletins'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des détails des articles
        $validatedData = $request->validate([
            'option_id' => 'required|exists:options,id',
            'classe_id' => 'required|exists:kelasis,id',
            'qte_cmdee' => 'required|integer|min:1',
            'client_id' => 'required|exists:client_ventes,id',
            'date_cmd' => 'required|date',
            'type_cmd' => 'required|string',
            'libelle' => 'required|string|max:255',
        ]);

        // Récupération ou initialisation des données de la commande
        $num_cmd = $request->input('num_cmd');
        $category_cmd = $request->input('category_cmd');

        // Stockage des détails dans le panier (par exemple, dans une base de données ou session)
        Panier::create([
            'num_cmd' => $num_cmd,
            'category_cmd' => $category_cmd,
            'client_id' => $validatedData['client_id'],
            'option_id' => $validatedData['option_id'],
            'classe_id' => $validatedData['classe_id'],
            'qte_cmdee' => $validatedData['qte_cmdee'],
            'date_cmd' => $validatedData['date_cmd'],
            'type_cmd' => $validatedData['type_cmd'],
            'libelle' => $validatedData['libelle'],
        ]);

        // Stocker les identifiants de commande dans la session pour les réutiliser
        session([
            'client_id' => $validatedData['client_id'],
            'type_cmd' => $validatedData['type_cmd'],
            'libelle' => $validatedData['libelle'],
            'date_cmd' => $validatedData['date_cmd'],
        ]);

        // Redirection vers la même page avec message de succès
        return redirect()->back()->with('success', 'Article ajouté au panier avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $panier = Panier::findOrFail($id);
        $options = Option::all();
        $kelasis = Kelasi::all();
        $clients = ClientVente::all();

        return view('dappro.bur-ventes.cmdExterne.edit', [
            'options' => $options,
            'kelasis' => $kelasis,
            'category_cmd' => "Externe", // ou une valeur appropriée
            'num_cmd' => $panier->num_cmd, // ou une logique pour le numéro de commande
            'clients' => $clients,
            'enregistrements' => Panier::orderBy('created_at', 'asc')->paginate(85),
            'panier' => $panier // envoyer l'enregistrement à modifier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validatedData = $request->validate([
            'option_id' => 'required|exists:options,id',
            'classe_id' => 'required|exists:kelasis,id',
            'qte_cmdee' => 'required|integer|min:1',
            'client_id' => 'required|exists:client_ventes,id',
            'date_cmd' => 'required|date',
            'type_cmd' => 'required|string',
            'libelle' => 'required|string|max:255',
        ]);

        // Trouver l'enregistrement à mettre à jour
        $panier = Panier::findOrFail($id);

        // Mettre à jour les détails
        $panier->update([
            'option_id' => $validatedData['option_id'],
            'classe_id' => $validatedData['classe_id'],
            'qte_cmdee' => $validatedData['qte_cmdee'],
            'client_id' => $validatedData['client_id'],
            'date_cmd' => $validatedData['date_cmd'],
            'type_cmd' => $validatedData['type_cmd'],
            'libelle' => $validatedData['libelle'],
        ]);

        // Redirection vers la page d'édition avec les champs vides
        return redirect()->route('admin.commande-Externe.create')->with([
            'success' => 'Article mis à jour avec succès.',
            'option_id' => '',
            'classe_id' => '',
            'qte_cmdee' => '',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Trouver l'enregistrement à supprimer
        $panier = Panier::findOrFail($id);

        // Supprimer l'enregistrement
        $panier->delete();

        // Redirection vers la liste des articles avec un message de succès
        return redirect()->route('admin.commande-Externe.create')->with('success', 'Article supprimé avec succès.');
    }

    public function panierVide(Request $request)
    {
        // Récupérer les données à partir de la table paniers
        $data = Panier::select('num_cmd', 'libelle', 'client_id', 'option_id', 'classe_id', 'qte_cmdee', 'date_cmd', 'type_cmd', 'category_cmd')->get();

        // Vérifiez si des données sont disponibles
        if ($data->isEmpty()) {
            return response()->json(['message' => 'Aucune donnée disponible'], 404);
        }

        // Obtenir le numéro de commande pour la nouvelle commande
        $lastCommand = CommandeVente::orderBy('num_cmd', 'desc')->first();
        $num_cmd = "CMD0001"; // Valeur par défaut si aucune commande n'existe

        if ($lastCommand) {
            $lastNum = (int) substr($lastCommand->num_cmd, 3);
            $newNum = $lastNum + 1;
            $num_cmd = "CMD" . str_pad($newNum, 4, '0', STR_PAD_LEFT);
        }

        // Insérer les données dans la table commande_ventes
        foreach ($data as $item) {
            CommandeVente::create([
                'num_cmd' => $num_cmd,
                'libelle' => $item->libelle,
                'client_id' => $item->client_id,
                'option_id' => $item->option_id,
                'classe_id' => $item->classe_id,
                'qte_cmdee' => $item->qte_cmdee,
                'date_cmd' => $item->date_cmd,
                'type_cmd' => $item->type_cmd,
                'category_cmd' => $item->category_cmd,
            ]);
        }

        // Vider la table paniers
        Panier::truncate();

        return redirect()->route('admin.commande-Externe.create')
                        ->with('success', 'Panier validé avec succès');
    }
}
