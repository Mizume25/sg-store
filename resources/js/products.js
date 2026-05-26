import * as pr from './helpers/h-products';
/**
 * @fileoverview Archivo main
 */
const categories = await pr.loadCategories();



/** Filtramos subcategorias relativas al padre seleccionado */
(() => {
    pr.subcategory.innerHTML = categories
        .filter(c => c.parent_id == 1)
        .map(c => `<option value="${c.id}">${c.name}</option>`)
        .join('');
})();


/** Events */
pr.parent.addEventListener('change', (e) => {
    const count = pr.changeSubCategory(categories, e);
    if(count === 0) {
        pr.subcategory.disabled = true;
        pr.subcategory.innerHTML = '<option>Se requiere minimo 1 subcategoria por producto</option>';
    } else {
        pr.subcategory.disabled = false;
    }
});

let count = 0;
pr.plusBTN.addEventListener('click', () => {
    count++;
    pr.tarifasContent.innerHTML += pr.loadField(count);
});

pr.lessBTN.addEventListener('click', () => {
    pr.removeField(count);
    count--;
});






