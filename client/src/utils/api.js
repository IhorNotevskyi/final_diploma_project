import axios from 'axios';

const BASE_API_URL = 'http://127.0.0.1:8000';

export {getProductsData};

function getProductsData() {
    const url = `${BASE_API_URL}/api/products`;
    return axios.get(url, {headers: {Accept: "application/json"}}).then(response => response.data);
}
