<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;
    
     protected $fillable = [
        'area_resp_id', 'description','created_by','updated_by'
    ];
    
    public static $createRules= array(
        'description' => 'required|unique:cost_centers,description, {{ $area_resp_id }},area_resp_id',
        'area_resp_id' => 'required'
    );
    
}
