import React, { Component } from "react";
import { Link } from "react-router-dom";
import { Grid, Pagination } from "react-bootstrap";

import { getProductsData } from "../utils/api";
import Product from "./Product";

class ProductList extends Component {
    constructor() {
        super();
        this.state = {
            products: []
        };
    }

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
        let categoryName;

        if (route.params.category) {
            products = products.filter(item => {
                if (item.category.split("/").pop() === route.params.category) {
                    return item;
                }
            })
        }

        if (this.props.match.params.category) {
            this.props.categories.map(category => {
                if (+category.id === +this.props.match.params.category)
                    categoryName = category.name;
            });
        }

        return (
            <Grid>
                <div className="container">
                    { this.props.match.params.category && <p className="display-3 text-center" style={{margin: "70px 0 -20px"}}>{categoryName}</p> }
                    { products.map(item => (
                        <Product key={item.id} item={item} />
                    ))}
                    <Pagination>
                        <Pagination.First disabled>
                            <Link to="/products/page/1">{1}</Link>
                        </Pagination.First>
                        <Pagination.Prev disabled>
                            <Link to={"/products/page/2"}>{2}</Link>
                        </Pagination.Prev>
                        <Pagination.Last disabled>
                            <Link to="/products/page/3">{3}</Link>
                        </Pagination.Last>
                        <Pagination.Last disabled>
                            <Link to="/products/page/4">{4}</Link>
                        </Pagination.Last>
                        <Pagination.Last disabled>
                            <Link to="/products/page/5">{5}</Link>
                        </Pagination.Last>
                    </Pagination>
                </div>
            </Grid>
        );
    }
}

export default ProductList;
