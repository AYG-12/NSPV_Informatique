<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    protected $fillable = ['date', 'count'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }
}
