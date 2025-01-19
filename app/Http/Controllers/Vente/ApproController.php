<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use App\Models\CommandeVente;
use Illuminate\Support\Facades\DB;
use App\Models\PanierSortieFourniture;
use App\Models\SortieFourniture;
use Illuminate\Http\Request;

class ApproController extends Controller
{

    public function index()
    {
        // Récupérer les commandes avec les critères spécifiés et ajouter la pagination
        $enregistrements = CommandeVente::select('commande_ventes.num_cmd', 'commande_ventes.client_id',
                DB::raw('SUM(commande_ventes.qte_cmdee) as total_qte_cmdee'),
                DB::raw('SUM(sortie_fournitures.qte_livree) as total_qte_livree'),
                DB::raw('MIN(sortie_fournitures.date_sortie) as first_date_sortie'))
            ->leftJoin('sortie_fournitures', 'commande_ventes.id', '=', 'sortie_fournitures.commande_vente_id')
            ->where('commande_ventes.etat_cmd', 4)
            ->where('commande_ventes.category_cmd', 'Interne')
            ->groupBy('commande_ventes.num_cmd', 'commande_ventes.client_id')
            ->paginate(5);

        // Retourner la vue avec les enregistrements
        return view('dappro.bur-ventes.approvisionnements.index', compact('enregistrements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer les numéros de commande distincts où etat_cmd est 1 et category_cmd est "Interne"
        $nums = CommandeVente::select('num_cmd')
            ->where('etat_cmd', 3)
            ->where('category_cmd', 'Interne')
            ->distinct()
            ->get();

        // Calcul de la somme totale de 'qte_livree'
        $totalBulletins = PanierSortieFourniture::sum('qte_livree');

        // Récupérer les commandes à afficher dans le tableau
        $enregistrements = PanierSortieFourniture::orderBy('created_at', 'asc')->paginate(15);

        return view('dappro.bur-ventes.approvisionnements.form',
            compact(
                'nums',
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
        // Validation des données
        $request->validate([
            'num_cmd' => 'required',
        ]);

        // Récupérer les commandes avec les sorties correspondantes
        $commandes = CommandeVente::select('commande_ventes.*', 'sortie_fournitures.qte_livree', 'sortie_fournitures.date_sortie')
            ->leftJoin('sortie_fournitures', 'commande_ventes.id', '=', 'sortie_fournitures.commande_vente_id')
            ->where('commande_ventes.num_cmd', $request->num_cmd)
            ->where('commande_ventes.etat_cmd', 3)
            ->where('commande_ventes.category_cmd', 'Interne')
            ->get();

        // Vérifiez si des commandes ont été trouvées
        if ($commandes->isEmpty()) {
            return redirect()->back()->withErrors(['num_cmd' => 'Aucune commande trouvée pour ce numéro.']);
        }

        // Vérifier si la table est vide
        if (PanierSortieFourniture::count() > 0) {
            // Si la table n'est pas vide, vider la table
            PanierSortieFourniture::truncate();
        }

        // Insérer dans la table panier_sortie_fournitures
        foreach ($commandes as $commande) {
            PanierSortieFourniture::create([
                'commande_vente_id' => $commande->id,
                'libelle' => $commande->libelle,
                'client_id' => $commande->client_id,
                'option_id' => $commande->option_id,
                'classe_id' => $commande->classe_id,
                'qte_cmdee' => $commande->qte_cmdee,
                'date_cmd' => $commande->date_cmd,
                'type_cmd' => $commande->type_cmd,
                'category_cmd' => $commande->category_cmd,
                'qte_livree' => $commande->qte_livree, // Récupérer qte_livree
                'date_sortie' => $commande->date_sortie, // Récupérer date_sortie
            ]);
        }

        return redirect()->back()->withInput()->with('success', 'Commande validée avec succès !');
    }


    public function updateEtat(Request $request)
    {
        // Récupérer les données à partir de la table panier_sortie
        $data = PanierSortieFourniture::with('commandeVente')
            ->select('commande_vente_id', 'qte_livree', 'qte_cmdee', 'date_sortie')
            ->get();

        // Vérifiez si des données sont disponibles
        if ($data->isEmpty()) {
            return response()->json(['message' => 'Aucune donnée disponible'], 404);
        }

        // Boucle pour insérer les données dans sortie_fournitures
        foreach ($data as $panier) {
            // Mettre à jour l'état de la commande (l'état de la validation de la réception au bureau vente)
            CommandeVente::where('id', $panier->commande_vente_id)
                ->update(['etat_cmd' => 4]); // Met à jour l'état de la commande à 1

            // Met à jour ou insère la description dans sortie_fournitures
            SortieFourniture::where('commande_vente_id', $panier->commande_vente_id)
                ->update(['description' => 1]);
        }

        // Vider la table panier_sortie_fournitures
        PanierSortieFourniture::truncate();

        return redirect()->route('admin.appro-Vente.index')->with('success', 'Réapprovisionnement effectué avec succès !');
    }
}
