/**
 * @fileoverview Helper que implementa funciones extendidas en product.js
 */

/** Variables Compartidas de create.blade.php y edit.blade.php */
export const subcategory = document?.getElementById('subcategory');
export const parent = document?.getElementById('category');
export const plusBTN = document?.getElementById('add-rate');
export const lessBTN = document?.getElementById('remove-rate');
export const tarifasContent = document?.getElementById('rates-container');
export const items = document?.querySelectorAll('.rate-item');

/** 
 * @function Api 
 * @return Categories JSON
 */
export const loadCategories = async () => {
    try {
        const response = await fetch('/categories/json', {
            headers: { 'Accept': 'application/json' }
        });
        return await response.json();
    } catch (e) {
        console.log(e);
    }
}

/**
 * @description Renderiza 1 campo completo de tarifas
 */
export const loadField = (id) => {
    return (
        `<div class="row g-2 mb-2 rate-item" id="rate-${id}">
            <div class="col">
                <input type="number" class="form-control" name="rates[${id}][price]" placeholder="Precio €"
                    step="0.01" min="0" required>
            </div>
            <div class="col">
                <input type="date" class="form-control" name="rates[${id}][start_date]" id="start-${id}" required>
            </div>
            <div class="col">
                <input type="date" class="form-control" name="rates[${id}][end_date]" id="end-${id}" required>
            </div>
        </div>`
    )
}

/**
 * @description Remueve 1 campo de tarifas
 */
export const removeField = () => {
    const items = document.querySelectorAll('.rate-item');
    if (items.length <= 1) return alert('Debes tener al menos 1 tarifa');
    items[items.length - 1].remove();
}

/**
 * @description Cambia las subcategorias al cambiar la categoria padre
 */
export const changeSubCategory = (categories, e) => {
    const options = categories
        .filter(c => c.parent_id == e.target.value)
        .map(c => `<option value="${c.id}">${c.name}</option>`);

    subcategory.innerHTML = options.join('');
    return options.length;
}

/**
 * @description Valida que el periodo sea de al menos 2 meses
 */
export const isValidDate = (startDate, endDate) => {
    const diffMs = new Date(endDate) - new Date(startDate);
    const diffDays = diffMs / (1000 * 60 * 60 * 24);
    const diffMonths = diffDays / 30.44;
    return diffMonths < 2;
}