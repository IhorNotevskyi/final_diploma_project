import React, { Component } from "react";
import { BrowserRouter as Router, Route, Link } from "react-router-dom";
import { LinkContainer } from "react-router-bootstrap";
import { Navbar, NavItem, Nav, Form, FormControl, Button } from "react-bootstrap";

import Product from "./components/Product";
import ProductList from "./components/ProductList";
import Home from "./components/Home";
import Contacts from "./components/Contacts";
import Advice from "./components/Advice";

import { getProductsData, getCategoriesData, getTagsData } from "./utils/api";

class App extends Component {
    constructor() {
        super();
        this.state = {
            categories: [],
            products: [],
            tags: []
        };
    }

    getProducts() {
        getProductsData().then((products) => {
            this.setState({products});
            // console.info(this.state.products);
        });
    }

    getCategories() {
        getCategoriesData().then((categories) => {
            this.setState({categories});
            // console.info(this.state.categories);
        });
    }

    getTags() {
        getTagsData().then((tags) => {
            this.setState({tags});
            // console.info(this.state.tags);
        });
    }

    componentDidMount() {
        this.getProducts();
        this.getCategories();
        this.getTags();
    }

    render() {
        return (
            <Router>
                <div>
                    <div style={{minHeight: "calc(100vh - 63px)"}}>
                        <header>
                            <Navbar inverse fixedTop fluid className={"navbar navbar-expand-md navbar-dark fixed-top bg-dark"}>
                                <Navbar.Brand>
                                    <Link to="/" className="text-success">Symfony API - React</Link>
                                </Navbar.Brand>
                                <Navbar.Collapse>
                                    <Nav className={"mr-auto"}>
                                        <LinkContainer className={"nav-item p-2"} to="/">
                                            <NavItem eventKey={1}>Home</NavItem>
                                        </LinkContainer>
                                        <LinkContainer className={"nav-item p-2"} to="/products">
                                            <NavItem  eventKey={2}>Products</NavItem>
                                        </LinkContainer>
                                        <LinkContainer className={"nav-item p-2"} to="/contacts">
                                            <NavItem  eventKey={3}>Contacts</NavItem>
                                        </LinkContainer>
                                        <LinkContainer className={"nav-item p-2"} to="/advice">
                                            <NavItem  eventKey={4}>Advice</NavItem>
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
                                <Home
                                    {...props}
                                    slider={this.state.products.slice(0, 3)}
                                    randomProducts={this.state.products.splice(3, 3)}
                                    categories={this.state.categories}
                                />
                            )} />
                            <Route exact path="/products" component={ProductList} />
                            <Route exact path="/contacts" component={Contacts} />
                            <Route exact path="/advice" component={Advice} />
                            <Route path="/products/category/:category" render={(props) => (
                                <ProductList {...props} categories={this.state.categories} />
                            )} />
                            <Route path="/products/category/:category/page/:page" render={(props) => (
                                <ProductList {...props} categories={this.state.categories} />
                            )} />
                            <Route path="/products/page/:page" component={ProductList} />
                            <Route path="/products/id/:id" component={Product} />
                        </main>
                    </div>
                    <footer className="text-center h4" style={{height: "63px", background: "#17171d", marginBottom: "-100px", color: "#1c8515"}}>
                        <p style={{letterSpacing: ".8px", paddingTop: "18px"}}>&copy; 2018 &mdash; Symfony API - React</p>
                    </footer>
                </div>
            </Router>
        );
    }
}

export default App;
