<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Transaction;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with('transaction')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('feedbacks.index', compact('feedbacks'));
    }

    public function create($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $existing = Feedback::where('transaction_id',$transactionId)->first();
        
        if ($existing) {
            return redirect()->route('reports.feedback')->with('info','Feedback sudah ada.');
        }
        
        return view('feedbacks.create', compact('transaction'));
    }

    public function store(Request $request, $transactionId)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Feedback::create([
            'transaction_id' => $transactionId,
            'rating' => $data['rating'],
            'comment' => $data['comment'],
        ]);

        return redirect()->route('reports.feedback')->with('success','Terima kasih atas feedback Anda!');
    }
}
