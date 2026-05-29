export const manageLink = document.getElementById('manage-link');
export const manageLinkName = document.getElementById('manage-link-name');
export const subcategories = document.getElementById('subcategories');

export const loadProduct = async (id) => {
    try {
        const response = await fetch(`/products/json/${id}`);
        return await response.json();
    } catch (e) {
        console.log(e);
    }
}