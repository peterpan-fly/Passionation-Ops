<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'industry', 'country_region', 'website', 'contact_name', 'contact_email', 'status', 'notes'])]
class Brand extends Model
{
    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }
}
