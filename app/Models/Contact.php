<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'first_name',
        'created_by',
        'updated_by',
        'last_name',
        'address',
        'city_id',
        'phone_list_id',
        'doc_list_id',
        
    ];
    
     public static $createRules= array(
        'first_name' => 'required|unique:contacts,first_name,null,{{$id}}'
    );
}
