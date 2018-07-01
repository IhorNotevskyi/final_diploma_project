import React, { Component } from "react";
import { BrowserRouter as Router, Route, Link } from "react-router-dom";
import { LinkContainer } from "react-router-bootstrap";
import { Navbar, NavItem, Nav, Form, FormControl, Button } from "react-bootstrap";

import Product from "./Product";
import ProductList from "./ProductList";
import Home from "./Home";
import Contacts from "./Contacts";
import Advice from "./Advice";

import { loadData } from "../utils/api";

class App extends Component {
    constructor() {
        super();
        this.state = {
            products: [],
            categories: [],
            tags: []
        };
    }

    componentDidMount() {
        Promise.all(['products', 'categories', 'tags'].map(loadData))
            .then((response) => {
                this.setState({
                    products: response[0],
                    categories: response[1],
                    tags: response[2],
                });
            });
    }

    render() {
        let firstThreeProducts = this.state.products.slice(0, 3);
        let threeRandomProducts = this.state.products.slice(3).sort(() => 0.5 - Math.random()).slice(0, 3);
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
                                        <LinkContainer className={"nav-item p-2"} to="/products/page/1">
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
                                        <Form inline>
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
                                    slider={firstThreeProducts}
                                    randomProducts={threeRandomProducts}
                                    categories={this.state.categories}
                                />
                            )} />
                            <Route exact path="/products/id/:id" component={Product} />
                            <Route exact path="/contacts" component={Contacts} />
                            <Route exact path="/advice" component={Advice} />
                            <Route exact path="/products/page/:page" component={ProductList} />
                            <Route exact path="/products/category/:category/page/:page" render={(props) => (
                                <ProductList
                                    {...props}
                                    categories={this.state.categories}
                                />
                            )} />
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
