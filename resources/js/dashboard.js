/** Card donde se mostrara el producto */
const display = document.getElementById('detail-panel');

/**
 * Lista de objetos e itemas a renderizar
 * @param {Array} rates - Tarifas
 * @returns {string} HTML string
 */
const renderRates = (rates) => {
    return rates.map(r =>
        `<li class="list-group-item d-flex justify-content-between">
            <span>${r.start_date} → ${r.end_date}</span>
            <strong>${r.price}€</strong>
        </li>`
    ).join('');
}

/**
 * @param {Array} categories - Array of category objects
 * @returns {string} HTML string
 */
const renderCategories = (categories) => {
    return categories.map(c =>
        `<span class="badge bg-secondary me-1">${c.name}</span>`
    ).join('');
}

/**
 * Renderizado de imagenes a modo slider
 * @param {Array} images - Array of image objects
 * @returns {string} HTML string
 */
const renderImages = (images) => {
    return images.map((i, index) =>
        `<img src="/${i.path}" 
              class="product-img ${index === 0 ? 'active' : ''}">`
    ).join('');
}


// Slideshow
let slideIndex = 0;
let slideInterval;

/**
 * Starts circular slideshow on product images.
 */
const startSlideshow = () => {
    clearInterval(slideInterval);
    const imgs = document.querySelectorAll('.product-img');
    if (imgs.length <= 1) return;
    slideInterval = setInterval(() => {
        imgs[slideIndex].classList.remove('active');
        slideIndex = (slideIndex + 1) % imgs.length;
        imgs[slideIndex].classList.add('active');
    }, 2500);
}


//** Funcion principal que muestra el card */
function showDetail(product) {
    slideIndex = 0;
    display.innerHTML = `
        <div class="card-body">
            <div class="mb-3">${renderImages(product.images)}</div>
            <h4>${product.name}</h4>
            <p class="text-muted small">${product.code}</p>
            <p>${product.description || 'Sin descripción'}</p>
            <hr>
            <p class="fw-bold mb-1">Categorías</p>
            <div class="mb-3">${renderCategories(product.categories)}</div>
            <p class="fw-bold mb-1">Precios</p>
            <ul class="list-group">${renderRates(product.rates)}</ul>
        </div>
    `;
    startSlideshow();
}


// Vite renderiza js en head necesitamos especificar que lo haga una vez la página este cargada
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-product]').forEach(el => {
        el.addEventListener('click', () => {
            const product = JSON.parse(el.dataset.product);
            showDetail(product);
        });
    });
});