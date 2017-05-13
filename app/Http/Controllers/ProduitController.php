<?php

namespace App\Http\Controllers;

use App\Produit;
use Illuminate\Http\Request;
use App\Famille;
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

        //Family not exist
        $response = [
            'msg' =>'Family not exist',
            'view_families'=>[
                'href'=>'/api/famille',
                'method'=>'get']
        ];
        if (! $famille = Famille::find($famille_id)){
            $response = [
                'msg' =>'Family not found',
                'view_families'=>[
                    'href'=>'/api/famille',
                    'method'=>'get',]
            ];
            return response()->json($response, 401);
        }


        if ( $product = Produit::find($code)){
            $response = [
                'msg' =>'Product already exist',
                'view_produits'=>[
                    'href'=>'/api/produit',
                    'method'=>'get',]
            ];
            return  response()->json($response, 401);
        };

        //save to database
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
        //product not found

        if ( !$product = Produit::find($id)){
            $response = [
                'msg' =>'Product not found',
                'view_produits'=>[
                    'href'=>'/api/produit',
                    'method'=>'get',]
            ];
            return  response()->json($response, 401);
        };

        //get product from database

        $produits = Produit::where('id',$id)->get();
        $response=[
            'msg' =>'Produits  '.$id,
            'Produits '=>$produits,
            'view_produits'=>[
                'href'=>'/api/produit',
                'method'=>'get',]

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
        $this->validate($request, [
            'code_pr' => 'required',
            'nom' => 'required',
            'famille_id' => 'required',
        ]);

        $code = $request->input('code_pr');
        $nom = $request->input('nom');
        $famille_id = $request->input('famille_id');

        //Product not found
        if (! $produit = Produit::find($id)){
            $response = [
                'msg' =>'Produit not found',
                'view_products'=>[
                    'href'=>'/api/produit',
                    'method'=>'get',]
            ];
            return response()->json($response, 401);
        }

        //Family not exist
        if (! $famille = Famille::find($famille_id)){
            $response = [
                'msg' =>'Family not found',
                'view_families'=>[
                    'href'=>'/api/famille',
                    'method'=>'get',]
            ];
            return response()->json($response, 401);
        }



        $produit->code=$code;
        $produit->nom=$nom;
        $produit->famille_id=$famille_id;

        //update database
        if($produit->update()){
            $produit->view_produit = [
                'href'=>'/api/produit/'.$produit->id,
                'method'=>'GET'
            ];
            $message=[
                'msg'=>'Produit updated',
                'produit' => $produit,
                'view_product_information'=>[
                'href'=>'/api/produit/'.$id,
                'method'=>'get',]
            ];
            return response()->json($message, 201);
        }
        $response = [
            'msg' =>'An error occurred'
        ];

        return  response()->json($response,404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Product not found
        if (! $produit = Produit::find($id)){
            $response = [
                'msg' =>'Produit not found',
                'view_products'=>[
                    'href'=>'/api/produit',
                    'method'=>'get',]
            ];
            return response()->json($response, 401);
        }

        $produit = Produit::find($id)->delete();

        $response = [
            'msg' =>'Product deleted',
            'create'=>[
                'href'=>'/api/produit',
                'method'=>'POST',
                'params'=>',code_pr, nom, designation'
            ]
        ];


        return response()->json($response, 200);

    }
}
