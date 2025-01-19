<?php

namespace App\Http\Controllers\Distribution;

use App\Http\Controllers\Controller;
use App\Models\CommandeVente;
use App\Models\SortieFourniture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;


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

    public function indexColisage()
    {
        // Récupérer les numéros de commande distincts où etat_cmd est 1 et category_cmd est "Interne"
        $nums = CommandeVente::select('num_cmd')
            ->where('etat_cmd', 3)
            ->where('category_cmd', 'Interne')
            ->distinct()
            ->get();

        // Récupérer les commandes avec les critères spécifiés
        $enregistrements = CommandeVente::select('commande_ventes.num_cmd', 'commande_ventes.client_id',
                DB::raw('SUM(commande_ventes.qte_cmdee) as total_qte_cmdee'),
                DB::raw('SUM(sortie_fournitures.qte_livree) as total_qte_livree'),
                DB::raw('MIN(sortie_fournitures.date_sortie) as first_date_sortie'))
            ->leftJoin('sortie_fournitures', 'commande_ventes.id', '=', 'sortie_fournitures.commande_vente_id')
            ->where('commande_ventes.etat_cmd', 3)
            ->where('commande_ventes.category_cmd', 'Interne')
            ->groupBy('commande_ventes.num_cmd', 'commande_ventes.client_id')
            ->get();

        // Retourner la vue avec les enregistrements
        return view('dappro.bur-distributions.liste-colisage.index', compact('nums', 'enregistrements'));
    }

    public function downloadColis(Request $request)
    {
        // Récupérer le numéro de commande sélectionné
        $numCmd = $request->input('num_cmd');

        // Récupérer les enregistrements liés à ce numéro de commande
        $enregistrements = SortieFourniture::select(
            'sortie_fournitures.qte_livree',
            'kelasis.designation as classe_designation',
            'options.designation as option_designation'
        )
        ->join('commande_ventes', 'sortie_fournitures.commande_vente_id', '=', 'commande_ventes.id')
        ->join('options', 'commande_ventes.option_id', '=', 'options.id') // Jointure avec options
        ->join('kelasis', 'commande_ventes.classe_id', '=', 'kelasis.id') // Jointure avec classes
        ->where('commande_ventes.num_cmd', $numCmd)
        ->get();

        // Calculer la somme des quantités livrées
        $totalQteLivree = $enregistrements->sum('qte_livree');

        //date de livraison
        $dateLivraison = now()->format('d/m/Y');

        // Extraire le suffixe du numéro de commande
        preg_match('/CMD(\d+)/', $numCmd, $matches);
        $suffixe = isset($matches[1]) ? $matches[1] : '0000'; // Récupérer le numéro

        // Construire le numéro de livraison
        $annee = now()->format('y'); // Obtenir l'année en cours au format "Y"
        $numeroLivraison = 'COL' . str_pad($suffixe, 4, '0', STR_PAD_LEFT) . '/' . $annee;

        // Charger la vue dans le PDF
        $pdf = Pdf::loadView('dappro.bur-distributions.liste-colisage.ListeColi',
            compact('enregistrements', 'numCmd', 'dateLivraison', 'numeroLivraison', 'totalQteLivree'));

        // Configurer le format du papier et l'orientation
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('');

    }

    public function indexNote()
    {
        // Récupérer les numéros de commande distincts où etat_cmd est 1 et category_cmd est "Interne"
        $nums = CommandeVente::select('num_cmd')
            ->where('etat_cmd', 3)
            ->where('category_cmd', 'Interne')
            ->distinct()
            ->get();

        // Récupérer les commandes avec les critères spécifiés
        $enregistrements = CommandeVente::select('commande_ventes.num_cmd', 'commande_ventes.client_id',
                DB::raw('SUM(commande_ventes.qte_cmdee) as total_qte_cmdee'),
                DB::raw('SUM(sortie_fournitures.qte_livree) as total_qte_livree'),
                DB::raw('MIN(sortie_fournitures.date_sortie) as first_date_sortie'))
            ->leftJoin('sortie_fournitures', 'commande_ventes.id', '=', 'sortie_fournitures.commande_vente_id')
            ->where('commande_ventes.etat_cmd', 3)
            ->where('commande_ventes.category_cmd', 'Interne')
            ->groupBy('commande_ventes.num_cmd', 'commande_ventes.client_id')
            ->get();

        // Retourner la vue avec les enregistrements
        return view('dappro.bur-distributions.note-envoie.index', compact('enregistrements', 'nums'));
    }

    public function downloadNote(Request $request)
    {
        // Récupérer le numéro de commande sélectionné
        $numCmd = $request->input('num_cmd');

        // Récupérer les enregistrements liés à ce numéro de commande
        $enregistrements = SortieFourniture::select(
            'sortie_fournitures.qte_livree',
            'kelasis.designation as classe_designation',
            'options.designation as option_designation',
            DB::raw('(SELECT prix FROM prix_bulletins ORDER BY created_at DESC LIMIT 1) as prix_unitaire') // Récupérer le dernier prix unitaire
        )
        ->join('commande_ventes', 'sortie_fournitures.commande_vente_id', '=', 'commande_ventes.id')
        ->join('options', 'commande_ventes.option_id', '=', 'options.id') // Jointure avec options
        ->join('kelasis', 'commande_ventes.classe_id', '=', 'kelasis.id') // Jointure avec classes
        ->where('commande_ventes.num_cmd', $numCmd)
        ->get();

        // Calculer la somme des quantités livrées
        $totalQteLivree = $enregistrements->sum('qte_livree');

        //date de livraison
        $dateLivraison = now()->format('d/m/Y');

        // Extraire le suffixe du numéro de commande
        preg_match('/CMD(\d+)/', $numCmd, $matches);
        $suffixe = isset($matches[1]) ? $matches[1] : '0000'; // Récupérer le numéro

        // Construire le numéro de la note d'envoie
        $annee = now()->format('y'); // Obtenir l'année en cours au format "Y"
        $numeroNote = 'NEV' . str_pad($suffixe, 4, '0', STR_PAD_LEFT) . '/' . $annee;

        // Récupérer la modalité de paiement
        $typeCmd = CommandeVente::where('num_cmd', $numCmd)->value('type_cmd');

        // Charger la vue dans le PDF
        $pdf = Pdf::loadView('dappro.bur-distributions.note-envoie.NoteEnvoie',
            compact('enregistrements', 'numCmd', 'dateLivraison', 'numeroNote', 'totalQteLivree', 'typeCmd'));

        // Configurer le format du papier et l'orientation
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('');

    }
}
