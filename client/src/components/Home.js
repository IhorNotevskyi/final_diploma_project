import React, { Component } from "react";
import { Link } from "react-router-dom";
import { Grid, Row, Col, Carousel } from "react-bootstrap";

class Home extends Component {
    constructor(props) {
        super(props);
        this.state = {
            slider: [],
            randomProducts: [],
            categories: []
        }
    }

    render() {
        return (
            <div>
                <Carousel>
                    { this.props.slider.map(product => (
                        <Carousel.Item key={product.id} className={"carousel-item"}>
                            <img className="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide" />
                            <Row className="container">
                                <Carousel.Caption id="myCarousel">
                                    <h1>{product.title}</h1>
                                    <p>{product.description}</p>
                                    <p>
                                        <Link className="btn btn-lg btn-primary" to={"/products/id/" + product.id} role="button">
                                            View more
                                        </Link>
                                    </p>
                                </Carousel.Caption>
                            </Row>
                        </Carousel.Item>
                    ))}
                </Carousel>
                <Grid>
                    <p className="h2 display-2 text-center" style={{marginBottom: "80px"}}>Categories</p>
                    <Row className={"marketing"} style={{display: "flex", justifyContent: "center", marginBottom: "-35px"}}>
                        { this.props.categories.map(category => (
                        <Col lg={4} key={category.id}>
                            <img className="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder" width={140} height={140} />
                            <h2 style={{marginTop: "10px"}}>{category.name}</h2>
                            <p>{category.description}</p>
                            <p>
                                <Link className="btn btn-primary" to={"/products/category/" + category.id} role="button">
                                    View products
                                </Link>
                            </p>
                        </Col>
                        ))}
                    </Row>
                    <hr className="featurette-divider" />

                    { this.props.randomProducts.map(product => (
                    <Row key={product.id} className={"featurette featurette-divider"} style={{display: "flex", alignItems: "center"}}>
                        <Col md={7}>
                            <h2 className="featurette-heading" style={{marginTop: "20px"}}>{product.title}</h2>
                            <p className="lead">{product.description}</p>
                            <p>
                                <Link className="btn btn-lg btn-primary" to={"/products/id/" + product.id} role="button">
                                    View more
                                </Link>
                            </p>
                        </Col>
                        <Col md={5}>
                            <img className="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="500x500" style={{width: "500px", height: "500px"}} src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22500%22%20height%3D%22500%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20500%20500%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1640a1f19be%20text%20%7B%20fill%3A%23AAAAAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A25pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1640a1f19be%22%3E%3Crect%20width%3D%22500%22%20height%3D%22500%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22184.8984375%22%20y%3D%22261.1%22%3E500x500%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" />
                        </Col>
                    </Row>
                    ))}
                </Grid>
            </div>
        );
    }
}

export default Home;
