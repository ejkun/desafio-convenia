<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Fornecedor
 * @package App
 *
 * @method \App\Fornecedor find($id)
 */
class Fornecedor extends Model
{
    protected $table = 'fornecedores';

    public function ativacao()
    {
        return $this->hasOne(AtivacaoFornecedor::class);
    }
}
