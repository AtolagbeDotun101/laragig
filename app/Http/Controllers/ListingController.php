<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use auth;

class ListingController extends Controller
{

    //show all listing
    public function index(){
        return view('listings.index', [
        'listings'=> Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
]);
    }

    // create listing
        public function create(){
            return view('listings.create');
        }

    //show single listing
    public function show(Listing $listing){
    return view('listings.show', [
        'listing' => $listing
    ]);
    }

    //store (post) listing
    public function store(Request $request){

         $formField =$request->validate([
            'title' =>'required',
            'company'=>['required',Rule::unique('listings','company')],
            'tags'=>'required',
            'location'=>'required',
            'website'=>'required',
            'email'=>['required', 'email'],
            'description'=>'required',
        ]);

        if($request->hasFile('logo')){
            $formField['logo'] = $request->file('logo')->store('logos', 'public');;
        }

        $formField['user_id'] = auth()->id();
        Listing::create($formField);
        return redirect('/')->with('message', 'Listing created successfully!');
    }

     //edit single listing
    public function edit(Listing $listing){
    return view('listings.edit', [
        'listing' => $listing
    ]);
    }


    //update single listing
     public function update(request $request, Listing $listing){

        // verify user
        if($listing->user_id !== auth()->id()){
            return abort('403', 'UnAuthorized request');
        }

         $formField =$request->validate([
            'title' =>'required',
            'company'=>['required'],
            'tags'=>'required',
            'location'=>'required',
            'website'=>'required',
            'email'=>['required', 'email'],
            'description'=>'required',
        ]);

        if($request->hasFile('logo')){
            $formField['logo'] = $request->file('logo')->store('logos', 'public');;
        }

        $listing->update($formField);
        return back()->with('message', 'Listing updated successfully!');
    }


    
    // delete a listing
    public function delete(Listing $listing){

         if($listing->user_id !== auth()->id()){
            return abort('403', 'UnAuthorized request');
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!');
    }
    
    //manage listing
     public function manage() {
        return view('listings.manage', ['listing' => auth()->user()->listing()->get()]);
    }


}

