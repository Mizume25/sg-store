import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

const product = document.getElementById('edit-producto');
const fecha = document.getElementById('edit-fecha');
const unidades = document.getElementById('edit-unidades');
const form = document.getElementById('edit-order')
const edit = document.getElementById('edit-form');
const del = document.getElementById('delete-form')
const amount = document.getElementById('edit-monto');

/**
 * Renderiza detalles de pedido
 * @param {*} info 
 */
const rednerDetail = (info) => {

    form.hidden = false;
    const e = info.event;
    const p = e.extendedProps;

    product.value = p.product;
    fecha.value = e.startStr
    unidades.value = p.units
    amount.value = e.title

    edit.action = `/orders/${e.id}`;
    del.action = `/orders/${e.id}`;

    
};

/**
 * Renderiza calendario
 */
document.addEventListener('DOMContentLoaded', () => {
    const display = document.getElementById('calendar');

    const calendar = new Calendar(display, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        locale: 'es',
        eventColor: '#2c7be5',
        events: '/api/orders',
        eventClick: rednerDetail
    })

    calendar.render();

})

