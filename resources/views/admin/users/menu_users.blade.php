<a class="btn {{request()->routeIs('admin.users.edit') ? 'btn-info' : 'btn-outline-info'}} btn-xs mb-3" href="{{route('admin.users.edit',$user->id)}}">Editar</a>
<a class="btn {{request()->routeIs('admin.users.financeiro') ? 'btn-info' : 'btn-outline-info'}} btn-xs mb-3" href="{{route('admin.users.financeiro',$user->id)}}"><i class="fa fa-piggy-bank"></i> Financeiros</a>
<a class="btn {{request()->routeIs('admin.users.faturas') ? 'btn-info' : 'btn-outline-info'}} btn-xs mb-3" href="{{route('admin.users.faturas',$user->id)}}"><i class="fa fa-file-invoice-dollar"></i> Faturas</a>
<a class="btn {{request()->routeIs('admin.users.saques') ? 'btn-info' : 'btn-outline-info'}} btn-xs mb-3" href="{{route('admin.users.saques',$user->id)}}"><i class="fa fa-dollar-sign"></i> Saques</a>
<a class="btn {{request()->routeIs('admin.users.indicacoes') ? 'btn-info' : 'btn-outline-info'}} btn-xs mb-3" href="{{route('admin.users.indicacoes',$user->id)}}"><i class="fa fa-users"></i> Indicações</a>
<a class="btn {{request()->routeIs('admin.users.saldo') ? 'btn-info' : 'btn-outline-info'}} btn-xs mb-3" href="{{route('admin.users.saldo',$user->id)}}"><i class="fa fa-comment-dollar"></i> Saldo</a>
