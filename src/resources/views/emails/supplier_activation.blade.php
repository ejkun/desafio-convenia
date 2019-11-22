<div>
    <p>
        Informamos que o cadastro da empresa {{ $name }} foi realizado com sucesso com o valor de mensalidade: R$ {{ number_format($value,2,',','.') }}.
        Clique no link abaixo para concluir a ativação.
    </p>
    <br>
    <a href="{{ $url }}"> {{ $url }} </a>
</div>
