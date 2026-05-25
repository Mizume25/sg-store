 @extends('layouts.app')
 @section('content')
     <h1 class="mb-3">Editar Categoria</h1>
     {{-- Mensaje de Creacion exitosa --}}
     @if (session('success'))
         <div class="alert alert-success alert-dismissible fade show" role="alert">
             {{ session('success') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
         </div>
     @endif

     <div class="d-flex justify-content-center">
         <div class="card w-50">
             <div class="card-body">
                 <form action="{{ route('categories.update', $category->id) }}" method="POST">
                     @csrf
                     @method('PUT')

                     {{-- Campo Nombre --}}
                     @php $label = $category->parent_id == null  ? __('Categoria') : __('SubCategoria') @endphp
                     <div class="mb-3">
                         <x-input-label for="name" :value="$label" />
                         <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name', $category->name)"
                             required autofocus />
                         <x-input-error :messages="$errors->get('name')" class="mt-2" />
                     </div>

                     {{-- Codigo --}}
                     <div class="mb-3">
                         <x-input-label :value="__('Código')" />
                         <p class="form-control-plaintext fw-bold">{{ $category->code }}</p>
                     </div>

                     {{-- Descripcion --}}
                     <div class="mb-3">
                         <x-input-label for="description" :value="__('Descripcion')" />
                         <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $category->description) }}</textarea>
                     </div>

                     {{-- Subcategorias --}}
                     @if ($category->parent_id == null && $category->children->count() > 0)
                         <div class="mb-3">
                             <x-input-label :value="__('Subcategorías')" />
                             <ul class="list-group mt-1">
                                 @foreach ($category->children as $child)
                                     <li class="list-group-item d-flex justify-content-between align-items-center">
                                         {{ $child->name }}
                                         <a href="{{ route('categories.edit', $child->id) }}"
                                             class="btn btn-sm btn-outline-secondary">
                                             <i class="bi bi-arrow-right"></i>
                                         </a>
                                     </li>
                                 @endforeach
                             </ul>
                         </div>
                     @endif

                     {{-- Categorias Padre --}}
                     @if ($category->parent_id != null)
                         <div class="mb-3">
                             <x-input-label for="category" :value="__('Categoria Padre')" />
                             <select name="category" id="category" class="form-select">
                                 @foreach ($categories as $cat)
                                     @if ($cat->parent_id == null && $cat->id !== $category->id)
                                         <option value="{{ $cat->id }}"
                                             {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                                             {{ $cat->name }}
                                         </option>
                                     @endif
                                 @endforeach
                             </select>
                         </div>
                     @endif


                     {{-- Botones --}}
                     <div class="d-flex gap-2">
                         <button type="button" class="btn btn-dark btn-lg" data-bs-toggle="modal"
                             data-bs-target="#confirmModal">
                             Actualizar
                         </button>
                         <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
                     </div>


                 </form>
             </div>
         </div>
     </div>
 @endsection

 {{-- Modal confirmacion --}}
 <div class="modal fade" id="confirmModal" tabindex="-1">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">¿Confirmar cambios?</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
             </div>
             <div class="modal-body">
                 ¿Estás seguro de que quieres actualizar esta categoría?
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                 <button type="submit" class="btn btn-dark" form="editForm">Confirmar</button>
             </div>
         </div>
     </div>
 </div>
