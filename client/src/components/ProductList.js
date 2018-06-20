import React, { Component } from "react";
import { Grid, Pagination } from "react-bootstrap";

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
                <Pagination>
                    <Pagination.First />
                    <Pagination.Prev />
                    <Pagination.Item>{1}</Pagination.Item>
                    <Pagination.Ellipsis />

                    <Pagination.Item>{10}</Pagination.Item>
                    <Pagination.Item>{11}</Pagination.Item>
                    <Pagination.Item active>{12}</Pagination.Item>
                    <Pagination.Item>{13}</Pagination.Item>
                    <Pagination.Item disabled>{14}</Pagination.Item>

                    <Pagination.Ellipsis />
                    <Pagination.Item>{20}</Pagination.Item>
                    <Pagination.Next />
                    <Pagination.Last />
                </Pagination>
            </Grid>
        );
    }
}

export default ProductList;
