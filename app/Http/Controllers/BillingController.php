<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function createBilling(Request $request)
    {
        $validate = $request->validate([
            'record_date' => 'required|date',
            'meter_reading' => 'required|numeric',
            'units_used' => 'required|numeric',
            'amount' => 'required|numeric',
            'plot_id' => 'required|integer|exists:plots,id'
        ]);

        $billing = new Billing();
        $billing->record_date = $validate['record_date'];
        $billing->meter_reading = $validate['meter_reading'];
        $billing->units_used = $validate['units_used'];
        $billing->amount = $validate['amount'];
        $billing->plot_id = $validate['plot_id'];

        try {
            $billing->save();
            return response()->json([
                'message' => 'Billing saved succesfully.',
                'billing' => $billing
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error trying to save.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function readAllBillings()
    {
        try {
            $billings = Billing::all();
            return response()->json([
                'billings' => $billings
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error trying to fetch.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function readBilling($id)
    {
        try {
            $billings = Billing::where('id', $id)->first;
            return response()->json([
                'billings' => $billings
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error trying to fetch.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateBilling($id, Request $request)
    {
        $validate = $request->validate([
            'record_date' => 'required|date',
            'meter_reading' => 'required|numeric',
            'units_used' => 'required|numeric',
            'amount' => 'required|numeric',
            'plot_id' => 'required|integer|exists:plots,id'
        ]);

        $billing = Billing::where('id', $id)->first();
        $billing->record_date = $validate['record_date'];
        $billing->meter_reading = $validate['meter_reading'];
        $billing->units_used = $validate['units_used'];
        $billing->amount = $validate['amount'];
        $billing->plot_id = $validate['plot_id'];

        try {
            $billing->save();
            return response()->json([
                'message' => 'Billing updated succesfully.',
                'billing' => $billing
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error trying to update.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteBilling($id)
    {
        try {
            $billing = Billing::where('id', $id)->first();
            if (!$billing) {
                return response()->json("Record not found.");
            }

            $billing->delete();
            return response()->json("Record deleted succesfully.");
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error trying to delete.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function searchBilling($name)
    {
        try {
            $billings = Billing::where('record_date', 'LIKE', "%{$name}%")->first;
            return response()->json([
                'billings' => $billings
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error trying to fetch.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
