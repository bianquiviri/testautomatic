<?php

namespace App\Http\Controllers;

use App\Models\employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class EmployeeController extends Controller
{
    #private $apiUrl = 'https://api.airtable.com/v0/appAhNU5xlXu8ry7H/Payouts';


    public function index()
    {
        try {
            $this->populateEmployTable();
            $employees = employee::groupBy('name')->select('name')->get();
            $i = '';
            foreach ($employees as $employee) {
                $i++;
                $payroll =  employee::select(DB::raw('round(sum(amount)) as payroll'))
                    ->where('name', $employee->name)->first();
                $dataemployee = employee::where('name', $employee->name)->first();
                $data[$i] = array(
                    'Number' => $dataemployee->number,
                    'Name' => $dataemployee->name,
                    'Date' => Carbon::parse($dataemployee->date)->format('j F, Y'),
                    'payroll' =>'$'.$payroll->payroll
                );
            }

            return response()->json(['Payouts' => $data], '200');
        } catch (\Exception $ext) {
            return response()->json(['error', $ext->getMessage()], '500');
        }
    }

    private function populateEmployTable()
    {
        try {
            // clean all data for employ table
            employee::truncate();
            $response = Http::withToken(env('API_TOKEN'))->get(env('API_URL'))->json();
            for ($i = 0; $i < count($response['records']); $i++) {
                $newEmployee = new  employee();
                $newEmployee->id_employe = $response['records'][$i]['id'];
                for ($j = 0; $j < count($response['records'][$i]['fields']); $j++) {
                    $newEmployee->number = $response['records'][$i]['fields']['Number'];
                    $newEmployee->name =   $response['records'][$i]['fields']['Name'];
                    $newEmployee->date =   $response['records'][$i]['fields']['Date'];
                    $newEmployee->amount = $response['records'][$i]['fields']['Amount'];
                }
                $newEmployee->save();
            }
        } catch (\Exception $Exception) {
            return $Exception->getMessage();
        }
    }
}
