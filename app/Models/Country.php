<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'description','created_by','updated_by'
    ];
    
    public static $createRules= array(
        'description' => 'required|unique:area_resps,description,null,{{$id}}'
    );
}
