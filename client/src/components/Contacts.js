import React, { Component } from "react";
import { compose, withProps } from "recompose";
import { withScriptjs, withGoogleMap, GoogleMap, Marker } from "react-google-maps";

import ContactsStyles from "./ContactsStyles";

const MapComponent = compose(
    withProps({
        googleMapURL:
            "https://maps.googleapis.com/maps/api/js?key=AIzaSyARwe9PKBO2DfSct8HYzwCwgIIEcJR8HI8&v=3.exp&libraries=geometry,drawing,places",
        loadingElement: <div style={{ height: `100%` }} />,
        containerElement: <div style={{ height: `540px`, margin: "0 30px -50px"}} />,
        mapElement: <div style={{ height: `100%` }} />
    }),
    withScriptjs,
    withGoogleMap
)(props => (
    <GoogleMap defaultZoom={12} defaultCenter={{ lat: 50.4501, lng: 30.6578 }}>
        {props.isMarkerShown && (
            <Marker
                position={{ lat: 50.4501, lng: 30.6578 }}
                title={"Viskozna str., Kyiv, UKRAINE"}
            />
        )}
    </GoogleMap>
));

class Contacts extends Component {
    render() {
        return (
            <ContactsStyles>
                <div className="text-secondary text-xl-center">
                    <p className="lead">
                        <i className="fa fa-map-marker" />
                        <span className="font-weight-bold">Address:</span> Viskozna str., Kyiv, UKRAINE
                    </p>
                    <p className="lead">
                        <i className="fa fa-mobile-phone" />
                        <span className="font-weight-bold">Phone:</span> +38 (099) 999-99-99
                    </p>
                    <p className="lead">
                        <i className="fa fa-envelope-o" />
                        <span className="font-weight-bold">Email:</span> symfony-api-react@symfony.react
                    </p>
                </div>
                <MapComponent isMarkerShown />
            </ContactsStyles>
        );
    }
}

export default Contacts;
