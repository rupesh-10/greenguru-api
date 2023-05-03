<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //

    public function dashboard()
    {
        $shops = Shop::all();
        $recommendations = Recommendation::all();
        return view('welcome', compact('shops', 'recommendations'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function createShop(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'location' => 'required|max:255',
            'description' => 'required',
            'rating' => 'required|integer|min:0|max:5',
        ]);

        $shop = new Shop();
        $shop->name = $validatedData['name'];
        $shop->location = $validatedData['location'];
        $shop->description = $validatedData['description'];
        $shop->rating = $validatedData['rating'];
        $shop->save();

        return redirect('/');
    }

    public function createRecommendation(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'image' => 'required|image',
            'cure' => 'required|max:255',
            'disease_name' => 'required|max:255',
        ]);

        // Get the image file and store it in the "public" disk
        $image = $request->file('image')->store('public');

        // Create a new recommendation with the input data
        $recommendation = new Recommendation([
            'image' => $image,
            'cure' => $validatedData['cure'],
            'disease_name' => $validatedData['disease_name'],
            'user_id' => 1
        ]);

        // Save the recommendation to the database
        $recommendation->save();

        // Redirect back to the list of recommendations
        return redirect('/');
    }

    public function deleteShop(Shop $shop)
    {
        $shop->delete();
        return redirect('/');
    }

    public function deleteRecommendation(Recommendation $recommendation)
    {
        $recommendation->delete();
        return redirect('/');
    }
}
