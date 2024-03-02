<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_request extends Model
{
    use HasFactory;

    protected $table = 'payment_request';

    protected $fillable =  [
        'module_name',
        'form_id',
        'unite_id',
        'paid_amount'
    ];

    protected $appends = [
        'details'
    ];


    public function Unite(){
        return $this->belongsTo(Units::class ,  'unite_id');
    }


    public function getDetailsAttribute(){
        if($this->module_name  == 'order'){
            return Orders::find($this->form_id);
        }else{
            return 'sharawy';
        }
    }

    public function scopeSearch($query, $value)
    {
        $query->where('module_name', 'like', '%' . $value . '%')
        ->orWhere('paid_amount', 'like', '%' . $value . '%')
        ->orWhere('created_at', 'like', '%' . $value . '%')
        ->orWhereHas('Unite', function ($qu) use ($value) {
                $qu->where('unite_name', 'like', '%' . $value . '%');
        });
        // $query->whereHas('V_Action', function ($q) use ($value) {
        //     $q->where('name', 'like', '%' . $value . '%');
        // })->orWhereHas('Unite', function ($qu) use ($value) {
        //     $qu->where('unite_name', 'like', '%' . $value . '%');
        // })->orWhereHas('Unite.Owner', function ($que) use ($value) {
        //     $que->where('first_name', 'like', '%' . $value . '%')->orWhere('last_name', 'like', '%' . $value . '%');
        // })->orWhere('cost', 'like', '%' . $value . '%');
    }


}
