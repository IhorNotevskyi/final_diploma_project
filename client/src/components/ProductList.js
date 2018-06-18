import React, { Component } from "react";
import { Grid } from "react-bootstrap";

import { getProductsData } from "../utils/api";
import Product from "./Product";

class ProductList extends Component {
    state = {
        products: []
    };

    getProducts() {
        getProductsData().then(products => {
            this.setState({ products });
        });
    }

    componentDidMount() {
        this.getProducts();
    }

    render() {
        let route = this.props.match;
        let products = this.state.products;

        if (route.params.category) {
            products = products.filter(item => {
                if (item.category.split("/").pop() === route.params.category) {
                    return item;
                }
            })
        }

        return (
            <Grid>
                { products.map(item => (
                    <Product key={item.id} item={item}/>
                ))}
            </Grid>
        );
    }
}

export default ProductList;
