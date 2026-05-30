import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

document.addEventListener('DOMContentLoaded', () => {
    const display = document.getElementById('calendar');

    const calendar = new Calendar (display , {
    plugins: [dayGridPlugin , interactionPlugin],
    initialView: 'dayGridMonth',
    locale: 'es',
    events: '/orders/json'})

    calendar.render();

})