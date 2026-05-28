import { end } from '@popperjs/core';
import * as pr from './helpers/h-products';
/**
 * @fileoverview Archivo Main donde organizo funciones del helper */
const categories = await pr.loadCategories();
const parentCategory = pr.product?.categories.find(c => c.parent_id == null);



/** Filtramos subcategorias relativas al padre seleccionado */

if (pr.parent) {
    (() => {

        /** Render de create */
        if (pr.product == null) {

            /** Renderiza el primer elemento */
            pr.subcategory.innerHTML = categories
                .filter(c => c.parent_id == 1)
                .map(c => `<option value="${c.id}">${c.name}</option>`)
                .join('');


        } else {

             /** Renderiza categorias padre, y selecciona el category padre del producto */
            pr.parent.innerHTML = categories
                .filter(c => c.parent_id == null)
                .map(c => `<option value="${c.id}" ${c.id == parentCategory?.id ? 'selected' : ''}>${c.name}</option>`)
                .join('');

             /**  Renderiza subcategorias y selecciona subcategoria actual*/
            pr.subcategory.innerHTML = categories
                .filter(c => c.parent_id == parentCategory?.id)
                .map(c => `<option value="${c.id}" ${(pr.product?.categories ?? []).some(pc => pc.id == c.id) ? 'selected' : ''}>${c.name}</option>`)
                .join('');

            /**  Checkbox de subcategorias dsponibles y selecciona las subcategorias añadidas */
            pr.subcategories.innerHTML = categories
                .filter(c => c.parent_id == parentCategory?.id)
                .map(c => `
        <div class="form-check mb-2 ms-3">
            <input type="checkbox" name="subcategories[]" value="${c.id}"
                class="form-check-input" ${(pr.product?.categories ?? []).some(pc => pc.id == c.id) ? 'checked' : ''}>
            <label class="form-check-label">${c.name}</label>
        </div>`)
                .join('');
        }




    })();

}



/** Events */
/** Evento de alternar categoria hija */
pr.parent?.addEventListener('change', (e) => {
    const count = pr.changeSubCategory(categories, e, pr.product?.categories ?? null);
    if (count === 0) {
        pr.subcategory.disabled = true;
        pr.subcategory.innerHTML = '<option>Se requiere minimo 1 subcategoria por producto</option>';
    } else {
        pr.subcategory.disabled = false;
    }
});

/** Aumentar o quitar tarifas asociadas */
pr.plusBTN?.addEventListener('click', () => {

    let id = pr.items.length;

    pr.tarifasContent.innerHTML += pr.loadField(id);
});

pr.lessBTN?.addEventListener('click', () => {
    pr.removeField();
});

/** Comrpobacion de fechas */
pr.tarifasContent?.addEventListener('change', (e) => {
    if (e.target.matches('[name*="start_date"], [name*="end_date"]')) {

        // Padre del input
        const rateItem = e.target.closest('.rate-item');



        // Valores de las fechas 
        const startInput = rateItem.querySelector('[name*="start_date"]');
        const endInput = rateItem.querySelector('[name*="end_date"]');

        //Valores
        const startDate = startInput.value;
        const endDate = endInput.value;


        const errorExistente = rateItem.querySelector('small.text-danger');
        if (errorExistente) errorExistente.remove();

        // 2. Crea el elemento solo si hay error
        let mensaje = '';

        if (startDate && new Date(startDate) < new Date())
            mensaje = 'ERROR: La fecha de inicio no puede ser anterior o igual a la fecha actual';

        if (startDate && endDate && new Date(startDate) >= new Date(endDate))
            mensaje = 'ERROR: La fecha de inicio no puede ser mayor o igual a la fecha final';


        if (startDate && endDate && pr.isValidDate(startDate, endDate)) {
            mensaje = 'ERROR: El periodo mínimo es de 2 meses';
        }


        startInput.setCustomValidity('');
        endInput.setCustomValidity('');
        // 3. Solo añade al DOM si hay mensaje
        if (mensaje) {
            const messageErr = document.createElement('small');
            messageErr.classList.add('text-danger');
            messageErr.textContent = mensaje;
            rateItem.appendChild(messageErr);

            startInput.setCustomValidity('Este Campo es invalido');
            endInput.setCustomValidity('Este campo es invalido');
        }

    }
})






