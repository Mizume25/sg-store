 @extends('layouts.app')
 @section('content')
     <div class="d-flex justify-content-center">
         <div class="card w-100 w-lg-50">
             <div class="card-body">
                 <form action="{{ route('categories.update', $category->id) }}" method="POST" id="editForm">
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
                     @if ($category->parent_id == null && $category->childrens->count() > 0)
                         <div class="mb-3">
                             <x-input-label :value="__('Subcategorías')" />
                             <ul class="list-group mt-1">
                                 @foreach ($category->childrens as $child)
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
                     {{-- Botones en una línea --}}
                     <div class="d-flex flex-column flex-lg-row gap-2 align-items-lg-center mt-3">
                         <button type="button" class="btn btn-dark btn-lg" data-bs-toggle="modal"
                             data-bs-target="#confirmModal">
                             Actualizar
                         </button>
                         <a href="{{ route('categories.create') }}" class="btn btn-secondary btn-lg">Cancelar</a>

                         {{-- Eliminar empujado a la derecha --}}
                         <button type="button" class="btn btn-danger btn-lg ms-lg-auto" data-bs-toggle="modal"
                             data-bs-target="#deleteCategory">
                             <i class="bi bi-trash"></i> Eliminar
                         </button>
                     </div>


                 </form>
                 <form action="{{ route('categories.destroy', $category->id) }}" method="POST" id="deleteForm">
                     @csrf
                     @method('DELETE')
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
                 <button type="submit" form="editForm" class="btn btn-dark">Confirmar</button>
             </div>
         </div>
     </div>
 </div>

 <div class="modal fade" id="deleteCategory" tabindex="-1">

     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">¿Desea borrar esta categoria?</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
             </div>
             <div class="modal-body">
                 ¿Estás seguro de que quieres eliminar esta categoría?
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                 <button type="submit" form="deleteForm" class="btn btn-danger">Eliminar</button>
             </div>
         </div>
     </div>
 </div>
