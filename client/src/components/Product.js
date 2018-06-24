import React, { Component } from "react";
import { Link } from "react-router-dom";
import { Grid, Row, Col } from "react-bootstrap";

import { getProductData } from "../utils/api";

class Product extends Component {
    constructor(props) {
        super(props);
        this.state = {}
    }

    getProduct(id) {
        getProductData(id).then((products) => {
            this.setState(products);
        });
    }

    componentDidMount() {
        if (this.props.item) {
            this.setState(this.props.item);
            return;
        }

        this.getProduct(this.props.match.params.id);
    }

    render() {
        let productTags = [];
        let tags = this.state.tags;
        for (let key in tags) {
            productTags.push(tags[key]);
        }

        return (
            <Grid style={{marginTop: "150px"}}>
                <Row className={"featurette featurette-divider"}  style={{display: "flex", alignItems: "center"}}>
                    <Col md={5}>
                        <img className="featurette-image img-fluid mx-auto" src={this.state.image} alt="Car" style={{width: "500px", height: "500px"}} />
                    </Col>
                    <Col md={7}>
                        <h2 className="featurette-heading" style={{margin: " 15px 0"}}>{this.state.title}</h2>
                        <p className="lead">{this.state.description}</p>
                        { this.props.item ? (
                            <p>
                                <Link className="btn btn-lg btn-primary" to={"/products/id/" + this.state.id} role="button">
                                    View more
                                </Link>
                            </p>) : (
                             <div>
                                <p className="h3 text-danger">{this.state.price} $</p>
                                 <div style={{marginTop: "30px"}}>
                                     { productTags.map(item => (
                                         <small key={item.id} className="text-white rounded" style={{marginRight: "7px", padding: "10px", background: "#8063a6", letterSpacing: ".7px"}}>{item.name}</small>
                                     ))}
                                 </div>
                             </div>
                        )}
                    </Col>
                </Row>
            </Grid>
        )
    }
}

export default Product;
