<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $maintenances = Maintenance::where("equipment_id", $request->equipmentId)->get();
        return response()->json([
            'success' => 'Success',
            'message' => 'Grabbed all maintenances data',
            'data' => [
                'equipment' => [
                    'id' => $maintenances[0]->equipment->id,
                    'name' => $maintenances[0]->equipment->name,
                    'type' => $maintenances[0]->equipment->type,
                    'maintenances' => $maintenances->makeHidden(['equipment_id', 'equipment'])
                ]
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
        $maintenance = Maintenance::create([
            'datetime' => $request->datetime,
            'duration' => $request->duration,
            'cost' => $request->cost,
            'equipment_id' => (int) $request->equipmentId
        ]);
        return response()->json([
            'success' => 'Success',
            'message' => 'Inserted new maintenance data',
            'data' => [
                'maintenance' => $maintenance
            ]
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $maintenance = Maintenance::find($request->maintenanceId);
        return response()->json([
            'success' => 'Success',
            'message' => 'Grabbed one maintenance data',
            'data' => [
                'maintenance' => [
                    'id'=> $maintenance->id,
                    'datetime'=> $maintenance->datetime,
                    'duration' => $request->duration,
                    'cost' => $request->cost,
                    'equipment' => [
                        'id' => $maintenance->equipment->id,
                        'name' => $maintenance->equipment->name,
                        'type' => $maintenance->equipment->type,
                    ],
                ]
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $maintenance = Maintenance::find($request->maintenanceId);

        $maintenance->datetime = $request->datetime;
        $maintenance->duration = $request->duration;
        $maintenance->cost = $request->cost;

        $maintenance->save();
        return response()->json([
            'success' => 'Success',
            'message' => 'Updated maintenance data',
            'data' => [
                'maintenance' => $maintenance
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $maintenance = Maintenance::find($request->maintenanceId)->delete();
        return response()->json([
            'success' => 'Success',
            'message' => 'Deleted maintenance data'
        ], 200);
    }
}
