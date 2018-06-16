import React, { Component } from "react";
import { Link } from "react-router-dom";
import { getProductsData } from "../utils/api";
import { Pagination } from "react-bootstrap";

class ProductList extends Component {

    constructor() {
        super();
        this.state = { products: [] };
    }

    getProducts() {
        getProductsData().then((products) => {
            this.setState({ products });
        });
    }

    componentDidMount() {
        this.getProducts();
    }


    render() {

        let perPage = 2;
        let page = this.props.match.params.page ? parseInt(this.props.match.params.page, 10) - 1 : 0;

        const { products }  = this.state;

        return (
            <div>
                <h3 className="text-center">Chuck Norris Food Jokes</h3>
                <hr/>

                { products.slice(perPage*page, perPage*(page+1)).map((joke, index) => (
                    <div className="col-sm-6" key={ joke.id }>
                        <div className="panel panel-primary">
                            <div className="panel-heading">
                                <h3 className="panel-title"> <span className="btn">#{ joke.title }</span></h3>
                            </div>
                            <div className="panel-body">
                                <p> { joke.description } </p>
                            </div>
                        </div>
                    </div>
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
                </Pagination>
            </div>
        );
    }
}

export default ProductList;
