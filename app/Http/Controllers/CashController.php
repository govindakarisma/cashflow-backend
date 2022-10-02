<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CashController extends Controller
{
    public function store()
    {
        request()->validate([
            'name' => 'required',
            'amount' => 'required|numeric',
        ]);

        $user = Auth::user();
        $slug = request('name') . "-" . Str::random(6);
        $when = request('when') ?? now();

        $user->cashes()->create([
            'name' => request('name'),
            'slug' => Str::slug($slug),
            'when' => $when,
            'amount' => request('amount'),
            'description' => request('description'),
        ]);

        $response = [
            "message" => "The transaction has been save"
        ];

        return response()->json($response);
    }
}
