<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AtivacaoFornecedor extends Model
{
    protected $table = 'ativacao_fornecedores';

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }
}
