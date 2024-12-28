<?php

namespace App\Http\Controllers\Fourniture;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fourniture\EntreeFournRequest;
use App\Models\EntreeFourniture;
use App\Models\Fournisseur;
use App\Models\Kelasi;
use App\Models\Option;
use Illuminate\Http\Request;

class EntreeFournController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options = Option::all();
        $kelasis = Kelasi::all();
        $fournisseurs = Fournisseur::all();

        $entreeFournitures = EntreeFourniture::orderBy('created_at', 'desc')->paginate(25);
        return view('dappro.bur-fournitures.mouv-stock.approvisionnements.index',
            compact(
                'options',
                'kelasis',
                'fournisseurs',
                'entreeFournitures'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = Option::all();
        $kelasis = Kelasi::all();
        $fournisseurs = Fournisseur::all();
        $entreeFournitures = EntreeFourniture::orderBy('created_at', 'desc')->paginate(25);

        return view('dappro.bur-fournitures.mouv-stock.approvisionnements.form',
            compact(
                'options',
                'kelasis',
                'fournisseurs',
                'entreeFournitures'
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
            'quantiteRecu' => 'required|integer|min:1',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'date_entree' => 'required|date',
            'reception' => 'required|string',
            'description' => 'nullable|string|max:255',
        ]);

        // Stockage des détails dans la table (par exemple, dans une base de données ou session)
        EntreeFourniture::create([
            'fournisseur_id' => $validatedData['fournisseur_id'],
            'option_id' => $validatedData['option_id'],
            'classe_id' => $validatedData['classe_id'],
            'quantiteRecu' => $validatedData['quantiteRecu'],
            'date_entree' => $validatedData['date_entree'],
            'reception' => $validatedData['reception'],
            'description' => $validatedData['description'],
        ]);

        // Stocker les identifiants de commande dans la session pour les réutiliser
        session([
            'fournisseur_id' => $validatedData['fournisseur_id'],
            'reception' => $validatedData['reception'],
            'description' => $validatedData['description'],
            'date_entree' => $validatedData['date_entree'],
        ]);

        // Redirection vers la même page avec message de succès
        return redirect()->back()->with('success', 'Article ajouté avec succès.');
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
    public function edit($id)
    {
        $entreeFourniture = EntreeFourniture::findOrFail($id);
        $options = Option::all();
        $classes = Kelasi::all();
        $fournisseurs = Fournisseur::all();

        return view('dappro.bur-fournitures.entrees.edit',
            compact(
                'options',
                'classes',
                'fournisseurs',
                'entreeFourniture'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EntreeFournRequest $request, $id)
    {
        try {
            // Trouver l'enregistrement à mettre à jour
            $entreeFourniture = EntreeFourniture::findOrFail($id);

            // Mettre à jour l'enregistrement
            $entreeFourniture->update($request->validated());

            return to_route('admin.entree-Fourniture.create')
                ->with('success', 'Article mis à jour avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                return back()->withInput()->withErrors(['option_id' => 'Cet enregistrement existe déjà.']);
            } else {
                throw $e; // Traiter d'autres types d'exceptions
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EntreeFourniture $entreeFourniture)
    {
        try {
            // Supprimer l'enregistrement
            $entreeFourniture->delete();

            return to_route('admin.entree-Fourniture.create')
                ->with('success', 'L\'article a été supprimé avec succès !');
        } catch (\Illuminate\Database\QueryException $e) {
            // Gérer les erreurs liées à la base de données
            return back()->withErrors(['message' => 'Erreur lors de la suppression de l\'article.']);
        }
    }
}
