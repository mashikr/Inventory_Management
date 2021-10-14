<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'employee_name' => $this->employee->name,
            'employee_salary' => $this->employee->salary,
            'month' => $this->month,
            'year' => $this->year,
            'pay_date' => date('d-m-Y', strtotime($this->created_at))
        ];
    }
}
