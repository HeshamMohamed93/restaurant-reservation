<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\WaitingList;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function checkAvailability(Request $request)
    {
        $validated = $request->validate([
            'datetime' => 'required|date',
            'guests' => 'required|integer|min:1'
        ]);

        $datetime = $validated['datetime'];
        $guests = $validated['guests'];

        $reservedTables = Reservation::where(function ($query) use ($datetime) {
            $query->where('from_time', '<=', $datetime)
                ->where('to_time', '>=', $datetime);
        })->pluck('table_id');

        $availableTables = Table::whereNotIn('id', $reservedTables)
            ->where('capacity', '>=', $guests)
            ->get();

        return response()->json($availableTables);
    }

    public function reserveTable(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'from_time' => 'required|date',
            'to_time' => 'required|date|after:from_time'
        ]);

        $reservationExists = Reservation::where('table_id', $request->table_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('from_time', [$request->from_time, $request->to_time])
                    ->orWhereBetween('to_time', [$request->from_time, $request->to_time]);
            })->exists();

        if ($reservationExists) {
            WaitingList::create([
                'customer_id' => auth()->id(),
                'reservation_id' => null,
                'priority' => WaitingList::max('priority') + 1
            ]);

            return response()->json(['message' => 'All tables are full. You have been added to the waiting list.'], 409);
        }

        $reservation = Reservation::create([
            'table_id' => $request->table_id,
            'customer_id' => auth()->id(),
            'from_time' => $request->from_time,
            'to_time' => $request->to_time
        ]);

        return response()->json(['message' => 'Reservation successful!', 'reservation' => $reservation], 201);
    }
}
