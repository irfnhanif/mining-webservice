<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sensors = Sensor::where("equipment_id", $request->equipmentId)->get();

        if (!$sensors) {
            return response()->json([
                'success' => false,
                'message' => 'Sensors data not found',
            ], 404);
        }

        return response()->json([
            'success' => 'Success',
            'message' => 'Grabbed all sensors data',
            'data' => [
                'equipment' => [
                    'id' => $sensors[0]->equipment->id,
                    'name' => $sensors[0]->equipment->name,
                    'type' => $sensors[0]->equipment->type,
                    'sensors' => $sensors->makeHidden(['equipment_id', 'equipment'])
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
        $this->validate($request, [
            'name' => 'required|string',
            'type' => 'required|string',
        ]);

        $sensor = Sensor::create([
            'name' => $request->name,
            'type' => $request->type,
            'equipment_id' => (int) $request->equipmentId,
        ]);

        return response()->json([
            'success' => 'Success',
            'message' => 'Inserted new sensor data',
            'data' => [
                'sensor' => $sensor
            ]
        ], 200);
    }

    public function storeData(Request $request)
    {
        $this->validate($request, [
            'availability' => 'required|integer|between:0,100',
            'utilization' => 'required|integer|between:0,100',
        ]);

        $sensor_id = DB::table('sensor_data')->insertGetId([
            'availability' => $request->availability,
            'utilization' => $request->utilization,
            'sensor_id' => (int) $request->sensorId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $sensor = DB::table('sensor_data')->where('id', $sensor_id)->first();

        return response()->json([
            'success' => 'Success',
            'message' => 'Inserted new sensor metrics data',
            'data' => [
                'sensor' => $sensor
            ]
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $sensor = Sensor::find($request->sensorId);
        $data = DB::table('sensor_data')->select('id', 'availability', 'utilization', 'created_at')->where('sensor_id', '=', $request->sensorId)->whereDate('created_at', '=', date('Y-m-d'))->orderBy('created_at', 'desc')->get();


        if (!$sensor) {
            return response()->json([
                'success' => false,
                'message' => 'Sensor data not found',
            ], 404);
        }

        return response()->json([
            'success' => 'Success',
            'message' => 'Grabbed one sensor data',
            'data' => [
                'sensor' => [
                    'id' => $sensor->id,
                    'name' => $sensor->name,
                    'type' => $sensor->type,
                    'equipment' => [
                        'id' => $sensor->equipment->id,
                        'name' => $sensor->equipment->name,
                        'type' => $sensor->equipment->type,
                    ],
                    'data' => $data
                ]
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $sensor = Sensor::find($request->sensorId);

        if (!$sensor) {
            return response()->json([
                'success' => false,
                'message' => 'Sensor data not found',
            ], 404);
        }

        $this->validate($request, [
            'name' => 'required|string',
            'type' => 'required|string',
        ]);

        $sensor->name = $request->name;
        $sensor->type = $request->type;

        $sensor->save();

        return response()->json([
            'success' => true,
            'message' => 'Updated sensor data',
            'data' => [
                'sensor' => $sensor
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $sensor = Sensor::find($request->sensorId);

        if (!$sensor) {
            return response()->json([
                'success' => false,
                'message' => 'Sensor data not found',
            ], 404);
        }

        DB::table('sensor_data')->where('sensor_id', '=', (int) $request->sensorId)->delete();

        $sensor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted sensor data'
        ], 200);
    }
}
