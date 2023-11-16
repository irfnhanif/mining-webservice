<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipments = Equipment::all();
        return response()->json([
            'success' => true,
            'message' => 'Grabbed all equipments data',
            'data' => [
                'equipments' => $equipments,
            ]
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $equipment = Equipment::create([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
            'location' => $request->location
        ]);
        return response()->json([
            'success' => 'Success',
            'message' => 'Inserted new equipment data',
            'data' => [
                'equipment' => $equipment
            ]
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Equipment $equipment)
    {
        $equipment = Equipment::find($request->equipmentId);
        return response()->json([
            'success' => 'Success',
            'message' => 'Grabbed one equipment data',
            'data' => [
                'equipment' => [
                    'id' => $equipment->id,
                    'name' => $equipment->name,
                    'type' => $equipment->type,
                    'status' => $equipment->status,
                    'location' => $equipment->location,
                ]
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipment $equipment)
    {
        $equipment = Equipment::find($request->equipmentId);

        $equipment->name = $request->name;
        $equipment->type = $request->type;
        $equipment->status = $request->status;
        $equipment->location = $request->location;

        $equipment->save();
        return response()->json([
            'success' => 'Success',
            'message' => 'Updated equipment data',
            'data' => [
                'equipment' => $equipment
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $equipment = Equipment::find($request->equipmentId)->delete();
        return response()->json([
            'success' => 'Success',
            'message' => 'Deleted equipment data'
        ], 200);
    }
}
