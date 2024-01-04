<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakeGame extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function Category()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }

}
