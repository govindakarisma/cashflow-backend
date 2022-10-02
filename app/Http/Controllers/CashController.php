<?php

namespace App\Http\Controllers;

use App\Http\Resources\CashResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CashController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $debit = $user->cashes()
            ->whereBetween('when', [now()->firstOfMonth(), now()])
            ->where('amount', '>=', 0)
            ->get('amount')->sum('amount');

        $credit = $user->cashes()
            ->whereBetween('when', [now()->firstOfMonth(), now()])
            ->where('amount', '<', 0)
            ->get('amount')->sum('amount');

        $balances = $user->cashes()->get('amount')->sum('amount');

        $transactions = $user->cashes()
            ->whereBetween('when', [now()->firstOfMonth(), now()])
            ->latest()->get();

        $reponse = [
            'balances' => formatPrice($balances),
            'debit' => formatPrice($debit),
            'credit' => formatPrice($credit),
            'transactions' => CashResource::collection($transactions)
        ];

        return response()->json($reponse);
    }

    public function store()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        request()->validate([
            'name' => 'required',
            'amount' => 'required|numeric',
        ]);

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
