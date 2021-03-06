<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use App\Assignment;

class TransactionController extends Controller
{
    /**
     * List all transactions from the DB
     * Limits the amount to be returned
     *
     * @param int limit
     */
    public function index(int $limit = 5)
    {
        return Transaction::paginate($limit);
        $transactions = Transaction::get();

        return response()->json([
            'status'=> 'success',
            'transactions' => $transactions->toArray()
        ], 200);
    }
    /**
     * Display a listing of the resource by assignment.
     *
     * @param  int  $assignmentId
     * @return \Illuminate\Http\Response
     */
    public function indexByAssignment($id)
    {
        $transactions = Transaction::where('assignment_id', $id)->get();

        return response()->json([
            'status'=> 'success',
            'transactions' => $transactions->toArray()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $assignmentId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'userId' => 'required|numeric',
            'assignmentId' => 'required|numeric',
            'token' => 'required|string'
        ]);

        $amount = round($request->input('amount')*100);

        $user = User::findOrFail($request->input('userId'));
        $paymentMethod = $request->input('token');

        if(!$user->stripe_id) $user->createAsStripeCustomer();
        // else if($user->hasPaymentMethod()) {
        //     dd('using default');
        //     $paymentMethod = $user->defaultPaymentMethod();
        // }
        // } else {
            
        $user->addPaymentMethod($paymentMethod);

        $assignment = Assignment::findOrFail($request->input('assignmentId'));
        $charge;

        try {
            $charge = $user->charge($amount, $paymentMethod);
            
        } catch (IncompletePayment $exception) {
            
            return response()->json([
                'status'=> 'failure',
                'error' => $exception->toArray()
            ], 200);
        }

        $transaction = new Transaction;
        $transaction->amount = $request->input('amount');
        $transaction->assignment_id = $request->input('assignmentId');
        $transaction->stripe_id = $charge->id;

        $transaction->save();

        $assignment->amount_paid = $transaction->amount;
        $assignment->save();

        return response()->json([
            'status'=> 'success',
            'transaction' => $transaction->toArray()
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'transaction' => $transaction->toArray()
        ]);
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
        $request->validate([
            'amount' => 'required|numeric|min:0'
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->amount = $request->input('amount');

        $transaction->save();

        return response()->json([
            'status'=> 'success',
            'transaction' => $transaction->toArray()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->delete();

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
