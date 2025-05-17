<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Service;
use App\Models\Part;
use App\Models\ServicePart;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class IndexController extends Controller
{
    public function index()
    {

        $allData = Service::paginate(10);

        return response()->json($allData, 200);
    }

    public function store(Request $request)
    {
        $restructuredParts = [];
        $tempPart = [];

        foreach ($request->parts as $item) {
            if (isset($item['type'])) {
                $tempPart['type'] = $item['type'];
            }
            if (isset($item['amount'])) {
                $tempPart['amount'] = $item['amount'];
            }

            if (count($tempPart) === 2) {
                $restructuredParts[] = $tempPart;
                $tempPart = [];
            }
        }

        $request->merge(['parts' => $restructuredParts]);


        $this->validate($request, [
            'customer' => 'required',
            'phone' => 'required',
            'chasis' => 'required',
            'km' => 'required',
            'bay' => 'required',
            'charge' => 'required',
            'type' => 'required',
            'date' => 'required',
            'time' => 'required',
            'image' => 'required',
            'parts' => 'required|array|min:1',
            'parts.*.type' => 'required',
            'parts.*.amount' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $date = Carbon::parse($request->date)->format('Y-m-d');
            $formattedTimeRange = $this->formatTimeRangeArray($request->time);

            $filePath = 'images/service';
            $fileName = $this->saveFile($request->file('image'), null, $filePath);

            $service = Service::create([
                'customer' => $request->customer,
                'phone' => $request->phone,
                'chasis' => $request->chasis,
                'km' => $request->km,
                'bay' => $request->bay,
                'charge' => $request->charge,
                'type' => $request->type,
                'date' => $date,
                'time' => $formattedTimeRange,
                'image' => $fileName,
            ]);

            $partsData = array_map(function($part) use ($service) {
                return [
                    'service_id' => $service->id,
                    'part_id' => $part['type'],
                    'amount' => $part['amount'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $request->parts);

            ServicePart::insert($partsData);

            DB::commit();

            return response()->json([
                'msg' => 'Service and parts saved successfully',
                'icon' => 'success'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'msg' => 'Failed to save service: ' . $e->getMessage(),
                'icon' => 'error'
            ], 500);
        }
    }



    protected function formatTimeRangeArray($timeRange)
    {

        if (
            is_array($timeRange) &&
            isset($timeRange['hours']) &&
            isset($timeRange['minutes'])
        ) {
            $hours = $timeRange['hours'];
            $minutes = $timeRange['minutes'];

            $formattedString = "{$hours}:{$minutes}";

            return $formattedString;
        } else {
            return $timeRange;
        }
    }

    public function all_parts(){
        $allData = Part::get();
        return response()->json($allData, 200);
    }

    public function saveFile($file, $oldFile = null, $filePath)
    {
        if (!$file) {
            return null;
        }

        try {
            // Delete old file if exists
            if ($oldFile && Storage::exists($filePath.'/'.$oldFile)) {
                Storage::delete($filePath.'/'.$oldFile);
            }

            // Generate unique filename with extension
            $fileName = Str::random(10).time().'.'.$file->getClientOriginalExtension();

            // Store the file
            $file->storeAs($filePath, $fileName);

            return $fileName;

        } catch (\Exception $e) {
            \Log::error('File upload failed: '.$e->getMessage());
            return null;
        }
    }

    public function complete(Request $request, Service $service)
    {
        //Validate
        $this->validate($request,[
            'end_time'           => 'required',
        ]);

        $formattedTimeRange = $this->formatTimeRangeArray($request->end_time);

        $data                = Service::find($service->id);
        $data->end_time          = $formattedTimeRange;
        $success             = $data->save();

        if($success){
            return response()->json(['msg' => 'Updated', 'icon'=>'success'], 200);
        }else{
            return response()->json(['msg' => exception()], 422);
        }
    }
}
