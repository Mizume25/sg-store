/** Card donde se mostrara el producto */
export const display = document.getElementById('detail-panel');
export const card = document.getElementById('select');
export const name = card.querySelector('#name');
export const code = card.querySelector('#code');
export const description = card.querySelector('#description');
export const categories = card.querySelector('#categories');
export const images = card.querySelector('#imagenes');
export const rates = card.querySelector('#prices');
export const editBTN = card.querySelector('#edit-product');
export const deleteBTN = card.querySelector('#delte-product');



/**
 * Lista de objetos e itemas a renderizar
 * @param {Array} rates - Tarifas
 * @returns {string} HTML string
 */
export const renderRates = (rates) => {
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
export const renderCategories = (categories) => {
    return categories.map(c =>
        `<span class="badge bg-secondary me-1">${c.name}</span>`
    ).join('');
}

/**
 * Renderizado de imagenes a modo slider
 * @param {Array} images - Array of image objects
 * @returns {string} HTML string
 */
export const renderImages = (images) => {
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
export const startSlideshow = () => {
    clearInterval(slideInterval);
    const imgs = document.querySelectorAll('.product-img');
    if (imgs.length <= 1) return;
    slideInterval = setInterval(() => {
        imgs[slideIndex].classList.remove('active');
        slideIndex = (slideIndex + 1) % imgs.length;
        imgs[slideIndex].classList.add('active');
    }, 2500);
}


/** Renderizado de card */
export const showDetail = (product) => {
    slideIndex = 0;
    
    /** Renderizamos contenido  */
    images.innerHTML = renderImages(product.images);
    name.textContent = product.name;
    code.textContent = product.code;
    description.textContent = product.description;
    categories.innerHTML = renderCategories(product.categories);
    rates.innerHTML = renderRates(product.rates);

    editBTN.href = `/products/${product.id}/edit`;
    deleteBTN.action = `/products/${product.id}`;
    


}


