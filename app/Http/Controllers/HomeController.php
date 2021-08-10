<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // $movies = Movie::all()->sortByDesc(function($movie) {
        //     return $movie->ratings->avg('rating');
        // })->take(100);
        $movies = Movie::join('ratings as r', 'r.movie_id', 'movies.id')
        ->join('categories as c', 'c.id', 'movies.category_id')
        ->select('movies.*','c.name', DB::Raw('Avg(r.rating) as rating,count(r.rating) as rating_ct'))
        ->groupBy('movies.id')->orderBy('rating', 'desc')->take(100)->get();

        return view('home', compact('movies'));
    }
}
