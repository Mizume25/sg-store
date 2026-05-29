import * as cat from './helpers/h-categories';
import * as pr from './helpers/h-products';

const id = document.querySelector('[data-id]')?.dataset.id;

const categories = await pr.loadCategories();
const product = await cat.loadProduct(id);

const parentCategory = product.categories.find(c => c.parent_id == null);


/** Render inicial */
if (pr.parent) {

    /** Selecciona categoria padre del producto */
    pr.parent.innerHTML = categories
        .filter(c => c.parent_id == null)
        .map(c => `<option value="${c.id}" ${c.id == parentCategory?.id ? 'selected' : ''}>${c.name}</option>`)
        .join('');

    /** Renderiza subcategorias y selecciona la principal */
    pr.subcategory.innerHTML = categories
        .filter(c => c.parent_id == parentCategory?.id)
        .map(c => `<option value="${c.id}" ${product.categories.some(pc => pc.id == c.id) ? 'selected' : ''}>${c.name}</option>`)
        .join('');

    /** Renderiza checkboxes adicionales */
    cat.subcategories.innerHTML = categories
        .filter(c => c.parent_id == parentCategory?.id)
        .filter(c => c.id != parseInt(pr.subcategory.value))
        .map(c => `
            <div class="form-check mb-2 ms-3">
                <input type="checkbox" name="subcategories[]" value="${c.id}"
                    class="form-check-input" ${product.categories.some(pc => pc.id == c.id) ? 'checked' : ''}>
                <label class="form-check-label">${c.name}</label>
            </div>`)
        .join('');

    cat.manageLink.href = `/categories/${parentCategory?.id}/edit`;
    cat.manageLinkName.textContent = parentCategory?.name;
}

/** Evento cambio de categoria padre */
pr.parent?.addEventListener('change', (e) => {
    const count = pr.changeSubCategory(categories, e);
    if (count === 0) {
        pr.subcategory.disabled = true;
        pr.subcategory.innerHTML = '<option>Se requiere minimo 1 subcategoria por producto</option>';
    } else {
        pr.subcategory.disabled = false;
    }

    const selected = categories.find(c => c.id == e.target.value);
    cat.manageLink.href = `/categories/${e.target.value}/edit`;
    cat.manageLinkName.textContent = selected?.name;

    cat.subcategories.innerHTML = categories
        .filter(c => c.parent_id == parseInt(e.target.value))
        .filter(c => c.id != parseInt(pr.subcategory.value))
        .map(c => `
            <div class="form-check mb-2 ms-3">
                <input type="checkbox" name="subcategories[]" value="${c.id}"
                    class="form-check-input">
                <label class="form-check-label">${c.name}</label>
            </div>`)
        .join('');
});


pr.subcategory?.addEventListener('change', () => {
    cat.subcategories.innerHTML = categories
        .filter(c => c.parent_id == parseInt(pr.parent.value))
        .filter(c => c.id != parseInt(pr.subcategory.value))
        .map(c => `
            <div class="form-check mb-2 ms-3">
                <input type="checkbox" name="subcategories[]" value="${c.id}"
                    class="form-check-input">
                <label class="form-check-label">${c.name}</label>
            </div>`)
        .join('');
});


