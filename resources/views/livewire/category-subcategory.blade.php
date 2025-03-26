<div>
  <label for="category_id" class="fw-bold mb-2">Selecione uma Categoria para o Produto</label>
  <select class="form-control mb-2" name="category_id" wire:model.live="selectedCategory" required>
      <option value="">Selecione uma Categoria</option>
      @foreach ($categories as $category)
          <option value="{{ $category->id }}">{{ $category->category_name }}</option>
      @endforeach
  </select>

  <label for="subcategory_id" class="fw-bold mb-2">Selecione uma Subcategoria para o Produto</label>
  <select class="form-control mb-2" name="subcategory_id" required>
      <option value="">Selecione uma Subcategoria</option>
      @forelse ($subcategories as $subcategory)
          <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
      @empty
          <option value="">Nenhuma subcategoria disponível</option>
      @endforelse
  </select>
</div>
