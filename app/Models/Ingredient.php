<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function stock(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Stock::class);
    }
}
