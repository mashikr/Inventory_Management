<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sell;
use App\Models\Expense;
use App\Models\Salary;
use App\Models\Employee;

class DashboardController extends Controller
{
    public function calculation(Request $request)
    {
        $date = date("Y-m-d", strtotime($request->date));

        $sells = Sell::whereDate('created_at', $date)
        ->get();

        $calculation = [
            'total_sell' => 0,
            'total_income' => 0,
            'total_item' => 0,
            'total_expense' => 0,
        ];

        if(!empty($sells)) {
            foreach($sells as $sell) {
                $products = json_decode($sell->products);
                foreach($products as $product) {
                    $calculation['total_sell'] += $product->price;
                    $calculation['total_item'] += $product->quantity;
                    $calculation['total_income'] += $product->price - $product->buying_price;
                }
            }
        }

        $expenses = Expense::whereDate('created_at', $date)
        ->get();

        if(!empty($expenses)) {
            foreach($expenses as $expense) {
                $calculation['total_expense'] += $expense->amount;
            }
        }

        $salaries = Salary::whereDate('created_at', $date)
        ->get();

        if(!empty($salaries)) {
            foreach($salaries as $salary) {
                $employee = Employee::find($salary->employee_id);
                $calculation['total_expense'] += $employee->salary;
            }
        }

        return $calculation;

    }

    public function monthdata() {
        $data = [];
        for($i = 1; $i <= Date('t'); $i++) {
            if ($i<=Date('d')) {
                array_push($data, array($i, 0, 0, 0));
            } else {
                array_push($data, array($i, NULL, NULL, NULL));
            }
        }

        $sells = Sell::whereMonth('created_at', Date('m'))->whereYear('created_at', Date('Y'))->get();

        foreach($sells as $sell) {
            $day = Date('d', strtotime($sell->created_at));
            $products = json_decode($sell->products);
            foreach($products as $product) {
                $data[$day-1][1] += $product->price;
                $data[$day-1][2] += $product->price - $product->buying_price;
            }
        }

        $expenses = Expense::whereMonth('created_at', Date('m'))->whereYear('created_at', Date('Y'))->get();

        foreach($expenses as $expense) {
            $day = Date('d', strtotime($expense->created_at));
            $data[$day-1][3] += $expense->amount;
        }

        $salaries = Salary::whereMonth('created_at', Date('m'))->whereYear('created_at', Date('Y'))->get();
        foreach($salaries as $salary) {
            $day = Date('d', strtotime($salary->created_at));
            $employee = Employee::find($salary->employee_id);
            $data[$day-1][3] += $employee->salary;
        }


        return $data;
    }
}

