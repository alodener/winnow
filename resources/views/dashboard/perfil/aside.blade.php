<aside class="col-lg-3 col-md-4 border-end pb-5 mt-n5">
    <div class="position-sticky top-0">
        <div class="text-center pt-5">
            <div class="d-table position-relative mx-auto mt-2 mt-lg-4 pt-5 mb-3">
                <img src="/imagem/logo/logo_icon.png" class="d-block rounded-circle" width="120" alt="{{Auth::user()->name}}">
            </div>
            <h2 class="h5 mb-1">{{Auth::user()->name}}</h2>
            <p class="mb-3 pb-3">{{Auth::user()->username}}</p>
            <button type="button" class="btn btn-secondary w-100 d-md-none mt-n2 mb-3" data-bs-toggle="collapse" data-bs-target="#account-menu">
                <i class="bx bxs-user-detail fs-xl me-2"></i>
                Menu Conta
                <i class="bx bx-chevron-down fs-lg ms-1"></i>
            </button>
            <div id="account-menu" class="list-group list-group-flush collapse d-md-block">
                <a href="{{route('dashboard.perfil.index')}}" class="list-group-item list-group-item-action d-flex align-items-center {{request()->routeIs('dashboard.perfil.index') ?"active":""}}">
                    <i class="bx bx-cog fs-xl opacity-60 me-2"></i>
                    Detalhes da Conta
                </a>
                <a href="{{route('dashboard.enderecos.index')}}" class="list-group-item list-group-item-action d-flex align-items-center {{request()->routeIs('dashboard.enderecos.index') ?"active":""}}">
                    <i class="bx bx-map fs-xl opacity-60 me-2"></i>
                    Endereço
                </a>
            </div>
        </div>
    </div>
</aside>
