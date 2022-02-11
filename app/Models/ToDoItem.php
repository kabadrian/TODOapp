<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'completed_at',
        'category'
    ];

//    public function category(){
//        return $this->hasOne(ToDoItemCategory::class);
//    }


}
