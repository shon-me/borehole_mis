<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $validate = $request->validate([
            'record_date' => 'required|date',
            'narration' => 'required|string',
            'amount' => 'required|numeric',
            'plot_id' => 'required|integer|exists:plots,id'
        ]);

        $payment = new Payment();
        $payment->record_date = $validate['record_date'];
        $payment->narration = $validate['narration'];
        $payment->amount = $validate['amount'];
        $payment->plot_id = $validate['plot_id'];

        try {
            $payment->save();
            return response()->json([
                'message' => 'Payment saved succesfully.',
                'payment' => $payment
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error trying to save.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function readAllPayments()
    {
        try {
            $payments = Payment::all();
            return response()->json([
                'payments' => $payments
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error trying to fetch.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function readPayment($id)
    {
        try {
            $payments = Payment::where('id', $id)->first;
            return response()->json([
                'payments' => $payments
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error trying to fetch.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePayment($id, Request $request)
    {
        $validate = $request->validate([
            'record_date' => 'required|date',
            'narration' => 'required|string',
            'amount' => 'required|numeric',
            'plot_id' => 'required|integer|exists:plots,id'
        ]);

        $payment = Payment::where('id', $id)->first();
        $payment->record_date = $validate['record_date'];
        $payment->narration = $validate['narration'];
        $payment->amount = $validate['amount'];
        $payment->plot_id = $validate['plot_id'];

        try {
            $payment->save();
            return response()->json([
                'message' => 'Payment updated succesfully.',
                'payment' => $payment
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error trying to update.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deletePayment($id)
    {
        try {
            $payment = Payment::where('id', $id)->first();
            if (!$payment) {
                return response()->json("Record not found.");
            }

            $payment->delete();
            return response()->json("Record deleted succesfully.");
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error trying to delete.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function searchPayment($name)
    {
        try {
            $payments = Payment::where('record_date', 'LIKE', "%{$name}%")->first;
            return response()->json([
                'payments' => $payments
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error trying to fetch.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
