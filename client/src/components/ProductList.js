import React, { Component } from "react";
import { Link } from "react-router-dom";
import { Grid } from "react-bootstrap";

import { getProductsData } from "../utils/api";
import Product from "./Product";

class ProductList extends Component {
    constructor(props) {
        super(props);
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
                if (item.category.split("/").pop() === route.params.category)
                    return item;
            })
        }

        if (route.params.category) {
            this.props.categories.map(category => {
                if (+category.id === +route.params.category)
                    categoryName = category.name;
            });
        }

        let totalProducts = products.length;
        let perPage = 6;
        let totalPage = Math.ceil(totalProducts / perPage);
        let currentPage = parseInt(route.params.page, 10);
        let page = route.params.page ? currentPage - 1 : 0;
        let allPages = [];

        for (let i = 1; i <= totalPage; i++) {
            allPages.push(i);
        }

        if (route.path === '/products' || route.path === '/products/category/:category' || route.path === '/products/category/:category' || route.path === '/products/category/:category/page/:page')
            currentPage = 1;

        // console.info(route.path);

        return (
            <Grid>
                <div className="container">
                    { route.params.category && <p className="display-3 text-center" style={{margin: "70px 0 -20px"}}>{categoryName}</p> }
                    { products.slice(perPage * page, perPage * (page + 1)).map(item => (
                        <Product key={item.id} item={item} />
                    ))}
                    { (route.path === '/products' || route.path === '/products/page/:page') && totalProducts > perPage &&
                    <nav aria-label="pagination">
                        <ul className="pagination pagination-lg justify-content-center" style={{margin: "150px 0 150px"}}>

                            { totalPage > 3 &&
                            <li key={-2} className={"page-item " + (currentPage === 1 || route.path === '/products' ? "disabled" : "")}>
                                <Link className="page-link" to="/products/page/1">First</Link>
                            </li>
                            }

                            <li key={-1} className={"page-item " + (currentPage === 1 || route.path === '/products' ? "disabled" : "")}>
                                <Link className="page-link" to={"/products/page/" + (currentPage - 1)}>Previous</Link>
                            </li>

                            { allPages.map(page => (
                                <li key={page} className={"page-item " + (currentPage === page ? "active" : "")}>
                                    <Link className="page-link" to={"/products/page/" + page}>{page}</Link>
                                </li>
                            ))}

                            <li key={totalPage + 1} className={"page-item " + (currentPage === totalPage ? "disabled" : "")}>
                                <Link className="page-link" to={"/products/page/" + (currentPage + 1)}>Next</Link>
                            </li>

                            { totalPage > 3 &&
                            <li key={totalPage + 2} className={"page-item " + (currentPage === totalPage ? "disabled" : "")}>
                                <Link className="page-link" to={"/products/page/" + totalPage}>Last</Link>
                            </li>
                            }
                        </ul>
                    </nav>
                    }
                    { (route.path === '/products/category/:category' || route.path === '/products/category/:category/page/:page') && totalProducts > perPage &&
                    <nav aria-label="pagination">
                        <ul className="pagination pagination-lg justify-content-center" style={{margin: "150px 0 150px"}}>

                            { totalPage > 3 &&
                            <li key={-2} className={"page-item " + (currentPage === 1 || route.path === '/products/category/:category' ? "disabled" : "")}>
                                <Link className="page-link" to={route.url + "/page/1"}>First</Link>
                            </li>
                            }

                            <li key={-1} className={"page-item " + (currentPage === 1 || route.path === '/products/category/:category' ? "disabled" : "")}>
                                <Link className="page-link" to={route.url + "/page/" + (currentPage - 1)}>Previous</Link>
                            </li>

                            { allPages.map(page => (
                                <li key={page} className={"page-item " + (currentPage === page ? "active" : "")}>
                                    <Link className="page-link" to={route.url + "/page/" + page}>{page}</Link>
                                </li>
                            ))}

                            <li key={totalPage + 1} className={"page-item " + (currentPage === totalPage ? "disabled" : "")}>
                                <Link className="page-link" to={route.url + "/page/" + (currentPage + 1)}>Next</Link>
                            </li>

                            { totalPage > 3 &&
                            <li key={totalPage + 2} className={"page-item " + (currentPage === totalPage ? "disabled" : "")}>
                                <Link className="page-link" to={route.url + "/page/" + totalPage}>Last</Link>
                            </li>
                            }
                        </ul>
                    </nav>
                    }
                </div>
            </Grid>
        );
    }
}

export default ProductList;
