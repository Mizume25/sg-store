export const manageLink = document.getElementById('manage-link');
export const manageLinkName = document.getElementById('manage-link-name');
export const subcategories = document.getElementById('subcategories');

/**
 * Funcion par obtener productos como respuesta json
 * @param string id 
 * @returns 
 */
export const loadProduct = async (id) => {
    try {
        const response = await fetch(`/api/products/${id}`);
        return await response.json();
    } catch (e) {
        console.log(e);
    }
}