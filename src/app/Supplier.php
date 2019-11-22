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
    protected $fillable = ['name','email','monthlyPayment'];

    public function activation()
    {
        return $this->hasOne(SupplierActivation::class);
    }

    public static function total()
    {
        return Supplier::query()
            ->selectRaw('IFNULL(SUM(monthlyPayment),0) as total_payments, COUNT(id) as suppliers_qtt')
            ->where('active','=',1)
            ->first();
    }
}
