import axios from "axios";

const BASE_API_URL = 'http://127.0.0.1:8000';

export { getProductsData, getProductData, getCategoriesData };

function getProductsData() {
    const url = `${BASE_API_URL}/api/products`;
    return axios.get(url, {headers: {Accept: "application/json"}}).then(response => response.data);
}

function getCategoriesData() {
    const url = `${BASE_API_URL}/api/categories`;
    return axios.get(url, {headers: {Accept: "application/json"}}).then(response => response.data);
}

function getProductData(id) {
    const url = `${BASE_API_URL}/api/products/` + id;
    return axios.get(url, {headers: {Accept: "application/json"}}).then(response => response.data);
}
