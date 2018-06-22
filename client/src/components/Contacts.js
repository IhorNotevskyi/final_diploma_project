import React, { Component } from "react";
import { compose, withProps } from "recompose";
import { withScriptjs, withGoogleMap, GoogleMap, Marker } from "react-google-maps";

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
            <div>
                <div className="text-secondary text-xl-center" style={{margin: "80px 0 70px", letterSpacing: ".5px"}}>
                    <p className="lead">
                        <i className="fa fa-map-marker" style={{marginRight: "7px"}} />
                        <span className="font-weight-bold">Address:</span> Viskozna str., Kyiv, UKRAINE
                    </p>
                    <p className="lead">
                        <i className="fa fa-mobile-phone" style={{marginRight: "7px"}} />
                        <span className="font-weight-bold">Phone:</span> +38 (099) 999-99-99
                    </p>
                    <p className="lead">
                        <i className="fa fa-envelope-o" style={{marginRight: "7px"}} />
                        <span className="font-weight-bold">Email:</span> symfony-api-react@symfony.react
                    </p>
                </div>
                <MapComponent isMarkerShown />
            </div>
        );
    }
}

export default Contacts;
