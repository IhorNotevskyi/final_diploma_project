import React, { Component } from "react";
import { BrowserRouter as Router, Route, Link } from "react-router-dom";
import { LinkContainer } from "react-router-bootstrap";
import { Navbar, NavItem, Nav, Form, FormControl, Button } from "react-bootstrap";

import Product from "./components/Product";
import ProductList from "./components/ProductList";
import Home from "./components/Home";

import { getProductsData, getCategoriesData } from "./utils/api";

class App extends Component {
    state = {
        categories: [],
        products: []
    };

    getProducts() {
        getProductsData().then((products) => {
            this.setState({products});
        });
    }

    getCategories() {
        getCategoriesData().then((categories) => {
            this.setState({categories});
            console.info(this.state);
        });
    }

    componentDidMount() {
        this.getProducts();
        this.getCategories();
    }

    render() {
        return (
            <Router>
                <div>
                    <header>
                        <Navbar inverse fixedTop fluid
                                className={"navbar navbar-expand-md navbar-dark fixed-top bg-dark"}>
                            <Navbar.Brand>
                                <Link to="/">React-Bootstrap</Link>
                            </Navbar.Brand>
                            <Navbar.Collapse>
                                <Nav className={"mr-auto"}>
                                    <LinkContainer className={"nav-item p-2"} to="/">
                                        <NavItem eventKey={1}>Home</NavItem>
                                    </LinkContainer>
                                    <LinkContainer className={"nav-item p-2"} to="/products">
                                        <NavItem  eventKey={2}>Products</NavItem>
                                    </LinkContainer>
                                </Nav>
                                <Navbar.Form pullRight>
                                    <Form inline >
                                        <FormControl className={"mr-sm-2"} type="text" placeholder="Search" />
                                        <Button type="submit" className={"btn-outline-success my-2 my-sm-0"}>Submit</Button>
                                    </Form>
                                </Navbar.Form>
                            </Navbar.Collapse>
                        </Navbar>
                    </header>
                    <main>
                        <Route exact path="/" render={(props) => (
                            <Home {...props} slider={this.state.products.slice(0, 3)} />
                        )} />
                        <Route exact path="/products" component={ProductList} />
                        <Route path="/products/category/:category" component={ProductList} />
                        <Route path="/products/page/:page" component={ProductList} />
                        <Route path="/products/id/:id" component={Product} />
                    </main>
                </div>
            </Router>
        );
    }
}

export default App;
