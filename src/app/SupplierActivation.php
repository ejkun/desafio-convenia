<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierActivation extends Model
{
    protected $table = 'suppliers_activations';

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
