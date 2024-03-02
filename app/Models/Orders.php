<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        "client_id",
        "unite_id",
        "serial",
        "order_costs",
        "paid_amount",
        "status",
        "deleted"
    ];


    public function Order_status(){

    }

    public function Client(){
        return  $this->belongsTo(Clients::class,'client_id',);
    }


    public function Tickets(){
        return $this->hasMany(Ticket::class ,'order_id');
    }

}
