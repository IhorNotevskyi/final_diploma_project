import axios from "axios";

const BASE_API_URL = 'http://127.0.0.1:8000/api';

function loadData(type) {
    return new Promise((resolve) => {
        const url = `${BASE_API_URL}/${type}`;
        axios.get(url, {headers: {Accept: "application/json"}})
            .then(response => resolve(response.data));
    });
}

function getProductData(id) {
    const url = `${BASE_API_URL}/products/` + id;
    return axios.get(url, {headers: {Accept: "application/json"}}).then(response => response.data);
}

export { getProductData, loadData };
