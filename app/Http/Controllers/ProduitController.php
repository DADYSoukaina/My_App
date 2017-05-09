<?php

namespace App\Http\Controllers;

use App\Produit;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits= Produit::all();

        /*foreach($produits as $produit)
        {
            $produit->view_produit = [
                'href' => 'api/produit/'.$produit->id,
                'method' => 'GET'
            ];
        }*/
        $response=[
            'msg' =>'List of all products',
            'produits'=>$produits,
        ];

        return response()->json($response,200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code_pr' => 'required',
            'nom' => 'required',
        ]);


        $code = $request->input('code_pr');
        $nom = $request->input('nom');
        $famille_id = $request->input('famille_id');



        $produit = new Produit([
            'code' => $code,
            'nom' => $nom,
            'famille_id' => $famille_id,
        ]);

        if($produit->save()){
            $produit->view_produit = [
                'href'=>'api/produit/'.$produit->id,
                'method'=>'GET'
            ];
            $message=[
                'msg'=>'Produit created',
                'produit' => $produit
            ];
            return response()->json($message, 201);
        }
        $response = [
            'msg' =>'An error occurred'
        ];

        return  response()->json($response,404);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produits = Produit::where('id',$id)->get();
        $response=[
            'msg' =>'Produits  '.$id,
            'Produits '=>$produits,
        ];

        return response()->json($response,200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
