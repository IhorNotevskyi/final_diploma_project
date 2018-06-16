import React from "react";
import {
    BrowserRouter as Router,
    Route,
    Link,
    Redirect,
    withRouter
} from "react-router-dom";

import { Grid, Row, Col, Navbar, Nav, NavItem } from "react-bootstrap";

import ProductList from "./components/ProductList";

////////////////////////////////////////////////////////////
// 1. Click the public page
// 2. Click the protected page
// 3. Log in
// 4. Click the back button, note the URL each time

const AuthExample = () => (
    <Router>
        <div>
        <Navbar inverse collapseOnSelect>
            <Navbar.Header>
                <Navbar.Brand>
                    <Link to="/">React-Bootstrap</Link>
                </Navbar.Brand>
                <Navbar.Toggle />
            </Navbar.Header>
            <Navbar.Collapse>
                <ul className="nav navbar-nav">
                    <li role="presentation">
                        <Link to="/">Home</Link>
                    </li>
                    <li role="presentation">
                        <Link to="/products">Products</Link>
                    </li>
                </ul>
                <Nav pullRight>
                    <NavItem eventKey={1} href="/login">
                        <AuthButton />
                    </NavItem>
                </Nav>
            </Navbar.Collapse>
        </Navbar>

        <Grid>
            <Row className="">
                <Col xs={12} md={12}>
                    <Route exact path="/" component={Public} />
                    <Route path="/login" component={Login} />
                    <Route exact path="/products" component={ProductList} />
                    <Route path="/products/page/:page" component={ProductList} />
                </Col>
            </Row>
        </Grid>
    </div>
    </Router>
);

const fakeAuth = {
    isAuthenticated: false,
    authenticate(cb) {
        this.isAuthenticated = true;
        setTimeout(cb, 100); // fake async
    },
    signout(cb) {
        this.isAuthenticated = false;
        setTimeout(cb, 100);
    }
};

const AuthButton = withRouter(
    ({ history }) =>
        fakeAuth.isAuthenticated ? (
            <p>
                Welcome!{" "}
                <button
                    onClick={() => {
                        fakeAuth.signout(() => history.push("/"));
                    }}
                >
                    Sign out
                </button>
            </p>
        ) : (
            <p>You are not logged in.</p>
        )
);

const PrivateRoute = ({ component: Component, ...rest }) => (
    <Route
        {...rest}
        render={props =>
            fakeAuth.isAuthenticated ? (
                <Component {...props} />
            ) : (
                <Redirect
                    to={{
                        pathname: "/login",
                        state: { from: props.location }
                    }}
                />
            )
        }
    />
);

const Public = () => <h3>Public</h3>;

class Login extends React.Component {
    state = {
        redirectToReferrer: false
    };

    login = () => {
        fakeAuth.authenticate(() => {
            this.setState({ redirectToReferrer: true });
        });
    };

    render() {
        const { from } = this.props.location.state || { from: { pathname: "/" } };
        const { redirectToReferrer } = this.state;

        if (redirectToReferrer) {
            return <Redirect to={from} />;
        }

        return (
            <div>
                <p>You must log in to view the page at {from.pathname}</p>
                <button onClick={this.login}>Log in</button>
            </div>
        );
    }
}

export default AuthExample;
