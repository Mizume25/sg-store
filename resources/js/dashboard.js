import * as ds from './helpers/h-dashboard';

// Vite renderiza js en head necesitamos especificar que lo haga una vez la página este cargada
document.addEventListener('DOMContentLoaded', () => {

    /** Cargamos el primer producto */
    const first = document.querySelector('[data-product]');

    /** Renderizamos */
    if (first) {
        const firstproduct = JSON.parse(first.dataset.product);
        ds.showDetail(firstproduct);
    }

    /** Activamos el evento en todos los card */
    document.querySelectorAll('[data-product]').forEach(el => {
        el.addEventListener('click', () => {
            const product = JSON.parse(el.dataset.product);
            ds.showDetail(product);
            console.log(product)
        });
    });
});





