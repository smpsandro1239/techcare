@extends('seller.layouts.layout')

@section('seller_page_title')
    Gerir Produtos
@endsection

@section('seller_layout')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Todos os Produtos Adicionados por Si</h5>
                <a href="{{ route('vendor.product.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Adicionar Novo Produto
                </a>
            </div>

            @if (session('message'))
                <div class="alert alert-success my-3 mx-3">
                    <i class="fas fa-check-circle"></i> {{ session('message') }}
                </div>
            @endif

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome do Produto</th>
                                <th scope="col">Preço</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ Str::limit($product->product_name, 50) }}</td>
                                    <td>{{ number_format($product->regular_price, 2, ',', '.') }} €</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Botão Editar -->
                                            <a href="{{ route('vendor.product.edit', $product->id) }}"
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <!-- Botão Deletar -->
                                            <form action="{{ route('vendor.product.destroy', $product->id) }}"
                                                  method="POST"
                                                  style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Tem certeza que deseja deletar este produto?')">
                                                    <i class="fas fa-trash-alt"></i> Deletar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Nenhum produto encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginação (se aplicável) -->
            @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="card-footer bg-light">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .table th, .table td {
        vertical-align: middle;
        background: transparent !important; /* Remove qualquer fundo das células */
    }

    .table tbody tr {
        background: transparent !important; /* Remove o fundo das linhas */
    }

    .table tbody tr:hover {
        background-color: #333 !important; /* Cor de fundo ao passar o mouse */
    }

    .btn-group .btn {
        margin-right: 5px;
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .btn-group .btn:hover {
        transform: translateY(-2px);
    }

    .alert {
        border-radius: 8px;
    }

    .table-dark th {
        background-color: #343a40 !important;
        color: #fff !important;
    }

    /* Ajuste para o texto da mensagem "Nenhum produto encontrado" */
    .text-muted {
        color: #bbb !important;
    }
</style>
@endsection
