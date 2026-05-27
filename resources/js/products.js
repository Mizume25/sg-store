import { end } from '@popperjs/core';
import * as pr from './helpers/h-products';
/**
 * @fileoverview Archivo Main donde organizo funciones del helper */
const categories = await pr.loadCategories();



/** Filtramos subcategorias relativas al padre seleccionado */
(() => {
    pr.subcategory.innerHTML = categories
        .filter(c => c.parent_id == 1)
        .map(c => `<option value="${c.id}">${c.name}</option>`)
        .join('');
})();


/** Events */
/** Evento de alternar categoria hija */
pr.parent.addEventListener('change', (e) => {
    const count = pr.changeSubCategory(categories, e);
    if (count === 0) {
        pr.subcategory.disabled = true;
        pr.subcategory.innerHTML = '<option>Se requiere minimo 1 subcategoria por producto</option>';
    } else {
        pr.subcategory.disabled = false;
    }
});

/** Aumentar o quitar tarifas asociadas */
pr.plusBTN.addEventListener('click', () => {

    let id = pr.items.length;

    pr.tarifasContent.innerHTML += pr.loadField(id);
});

pr.lessBTN.addEventListener('click', () => {
    pr.removeField();
});

/** Comrpobacion de fechas */
pr.tarifasContent.addEventListener('change', (e) => {
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






