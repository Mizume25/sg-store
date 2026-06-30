<!-- Props de Modal   -->
@props([
    'id' => 'confirmDelete',
    'title' => '¿Desea borrar este elemento?',
    'message' => '¿Estás seguro de que quieres eliminar este elemento?',
    'form' => 'deleteForm',
    'confirmText' => 'Eliminar',
])

<div class="modal fade" id="{{ $id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{ $message }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="{{ $form }}" class="btn btn-danger">{{ $confirmText }}</button>
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