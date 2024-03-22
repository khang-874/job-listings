<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //Show all listing
    public function index(){
        
        return view('listings.index',[
            'listings' => Listing::latest() -> filter(request(['tag', 'search'])) ->paginate(6)
        ]);
    }
    
    //Show a single listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //Show create form
    public function create(){
        return view('listings.create');
    }

    //Store listing data
    public function store(Request $request){

        
        $formFields = $request -> validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
        
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth() -> id();

        //dd($formFields['logo']);
        Listing::create($formFields);
        
        return redirect('/') -> with('message', 'Listing created successfully!');
    }

    public function edit(Listing $listing){
        //dd($listing->title);
        return view('listings.edit', ['listing' => $listing]);
    }
    //pdate
    public function update(Request $request, Listing $listing){
        //Make sure logged in user is owner
        if($listing->user_id != auth() -> id()){
            abort(403, 'Unauthorized Action');
        }
        $formFields = $request -> validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
        
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        //dd($formFields['logo']);
        $listing->update($formFields);
        
        return back() -> with('message', 'Listing updated successfully!');
    }

    public function destroy(Listing $listing){
        //Make sure logged in user is owner
        if($listing->user_id != auth() -> id()){
            abort(403, 'Unauthorized Action');
        }
        $listing -> delete();
        return redirect('/') -> with('message', 'Listing deleted successfully');
    }

    //Manage listings
    public function manage(){
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
