<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Supplier
 * @package App
 *
 * @method \App\Supplier find($id)
 */
class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $fillable = ['nome','email','mensalidade'];

    public function activation()
    {
        return $this->hasOne(SupplierActivation::class);
    }
}
