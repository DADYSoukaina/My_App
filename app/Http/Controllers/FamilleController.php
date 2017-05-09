<?php

namespace App\Http\Controllers;

use App\Famille;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Produit;

class FamilleController extends Controller
{

    //show all families
    public function index()
    {
        $familles= Famille::all();

       /* foreach($familles as $famille)
        {
            $famille->view_famille = [
                'href' => 'api/famille/'.$famille->id,
                'method' => 'GET'
            ];
        }*/
        $response=[
            'msg' =>'la Liste des familles',
            'familles'=>$familles,
        ];

        return response()->json($response,200);
    }


    //get creation form
    public function create()
    {
        //
    }


    //store family on server
    public function store(Request $request)
    {

        //validation
        $this->validate($request, [
            'nom' => 'required',
            'designation' => 'required',
        ]);

        //Handling Input
        $nom = $request->input('nom');
        $designation = $request->input('designation');

        //database
        $famille = new Famille([
            'nom' => $nom,
            'designation' => $designation,
        ]);

        //test: famely exist
            if($famille->where('nom',$nom)->first()){
                return  response()->json(['Famille existe'], 401);
            };

            //saving famely data to DB
            if($famille->save()){
                $famille->view_famille = [
                    'href'=>'api/famille/'.$famille->id,
                    'method'=>'GET'
                ];
            //response
                $message=[
                    'msg'=>'Famille created',
                    'famille' => $famille
                ];
                return response()->json($message, 201);
            }
        $response = [
            'msg' =>'An error occurred'
        ];

        return  response()->json($response,404);
    }



    //get single family & all the products of this family
    public function show($id)
    {
        $famille = Famille::where('id',$id)->get();
        $produits=Famille::find($id)->produits()->select('id','code','nom')->get();

        $response=[
            'msg' =>'Les produits de la famille  '.$id,
            'Famille '=>$famille,
            'Produits '=>$produits,
        ];

        return response()->json($response,200);

    }

    //get edit form
    public function edit($id)
    {
        //
    }

    //save update on server
    public function update(Request $request, $id)
    {
        //validation
        $this->validate($request, [
            'nom' => 'required',
            'designation' => 'required',
        ]);


        $nom = $request->input('nom');
        $designation = $request->input('designation');

        $famille=Famille::find($id);

        //test: famely exist
        if($famille->where('nom',$nom)->first()){
            return  response()->json(['Family exist'], 401);
        };

        //insert to database
        $famille->nom = $nom;
        $famille->designation = $designation;

        if(!$famille->update()){
            return  response()->json(['msg'=>'Error during updating'], 404);
        }

        $famille->view_meeting = [
            'href'=>'api/famille/'.$famille->id,
            'method'=>'GET'
        ];

        $response = [
            'msg' =>'Family updated',
            'famille'=>$famille
        ];

        return  response()->json($response,200);

    }

    //delete family on server
    public function destroy($id)
    {

        $produits=Produit::where('famille_id',$id)->delete();
        $famille=Famille::find($id);
         $famille->delete();


        return  response()->json(['family deleted!'],200);




    }
}
