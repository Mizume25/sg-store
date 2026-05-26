/**
 * @fileoverview Helper que implementa funciones extendidas en product.js
 */


/** Variables */
export const subcategory = document.getElementById('subcategory');
export const parent = document.getElementById('category');
export const plusBTN = document.getElementById('add-rate');
export const lessBTN = document.getElementById('remove-rate');
export const tarifasContent = document.getElementById('rates-container');


/**
 * Renderiza un campo de tarifa
 * @param {number} index - Índice del campo
 * @returns {string} HTML string
 */


/** 
 * @function Api 
 * @return Categories JSON
 */
export const loadCategories = async () => {
    try {

        const response = await fetch('/products/create', {
            headers: { 'Accept': 'application/json' }
        });
        const categories = await response.json();

        return categories;

    } catch (e) {
        console.log(e);
    }
}


/**
 * @description Renderiza 1 campo completo de tarifas
 */
export const loadField = (count) => {
    return (
        `<div class="row g-2 mb-2 rate-item" id=rate-${count}>
            <div class="col">
                    <input type="number" class="form-control" name="rates[${count}][price]" placeholder="Precio €"
                                        step="0.01" min="0" required>
            </div>

            <div class="col">
                    <input type="date" class="form-control" name="rates[${count}][start_date]" required>
            </div>

            <div class="col">
                    <input type="date" class="form-control" name="rates[${count}][end_date]" required>
            </div>
        </div>`
    )
}

/**
 * @description Remueve 1 campo de tarifas
 */
export const removeField = (count) => {

    if (count === 0) return alert('Debes tener al menos 1 tarifa para este producto');

    document.getElementById(`rate-${count}`).remove();

}


export const changeSubCategory = (categories, e) => {
    const options = categories
        .filter(c => c.parent_id == e.target.value)
        .map(c => `<option value="${c.id}">${c.name}</option>`);
    
    subcategory.innerHTML = options.join('');
    
    return options.length;
}

