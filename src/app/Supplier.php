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

    public static function total()
    {
        return Supplier::query()
            ->selectRaw('IFNULL(SUM(mensalidade),0) as total_mensalidades, COUNT(id) as qtd_fornecedores')
            ->where('ativo','=',1)
            ->first();
    }
}
