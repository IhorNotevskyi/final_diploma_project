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
                        <Carousel.Item key={product.id} className={"carousel-item bg-white"}>
                            <div className="d-flex justify-content-center">
                                <img className="first-slide" src={product.image} alt="Slide" style={{width: "80%"}} />
                            </div>
                            <Row className="container">
                                <Carousel.Caption id="myCarousel">
                                    <h1>{product.title}</h1>
                                    <p style={{width: "90%"}}>{product.description}</p>
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
                    <Row className="marketing d-flex justify-content-center" style={{marginBottom: "-35px"}}>
                        { this.props.categories.map(category => (
                            <Col lg={4} key={category.id}>
                                <img className="rounded-circle" src={category.image} alt="Category Car" style={{width: "160px", height: "160px"}} />
                                <h2 style={{marginTop: "10px"}}>{category.name}</h2>
                                <p>{category.description}</p>
                                <p>
                                    <Link className="btn btn-primary" to={"/products/category/" + category.id + "/page/1"} role="button">
                                        View products
                                    </Link>
                                </p>
                            </Col>
                        ))}
                    </Row>
                    <hr className="featurette-divider" />

                    { this.props.randomProducts.map(product => (
                        <Row key={product.id} className="featurette featurette-divider d-flex align-items-center">
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
                                <img className="featurette-image img-fluid mx-auto" src={product.image} alt="500x500" style={{width: "500px", height: "500px"}} />
                            </Col>
                        </Row>
                    ))}
                </Grid>
            </div>
        );
    }
}

export default Home;
