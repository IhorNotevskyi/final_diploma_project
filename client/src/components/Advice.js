import React, { Component } from "react";
import axios from 'axios';
import { Form, Field } from "react-final-form";
import SweetAlert from "react-bootstrap-sweetalert";

import feedback from "../img/feedback.png";
import AdviceStyles from "./AdviceStyles";

const normalizePhone = value => {
    if (!value)
        return;

    const onlyNums = value.replace(/[^\d]/g, "");

    if (onlyNums.length <= 3)
        return onlyNums;
    if (onlyNums.length <= 7)
        return `(${onlyNums.slice(0, 3)}) ${onlyNums.slice(3, 7)}`;

    return `(${onlyNums.slice(0, 3)}) ${onlyNums.slice(3, 6)}-${onlyNums.slice(6, 10)}`;
};

const normalizeName = value => {
    if (!value)
        return;

    const nameSymbols = value.replace(/[^A-Za-z' ]/g, "");

    return `${nameSymbols.slice(0, 50)}`;
};

const normalizeMessage = value => {
    if (!value)
        return;

    const messageSymbols = value.replace(/[^\w\s,.?!@$%^&*`~()/\\{};:"'\-+[\]#№]/g, "");

    return `${messageSymbols.slice(0, 255)}`;
};

class Advice extends Component {
    state = {
        showSuccess: false,
        showError: false,
        errorTitle: '',
        errorMessage: ''
    };

    render() {
        return (
            <AdviceStyles>
                <div>
                    <img src={feedback} alt="Feedback" />
                </div>
                <h2 className="text-muted">Leave your phone number so our managers can contact you</h2>
                <Form
                    onSubmit={async values => {
                        axios.post(`http://localhost:8000/api/callbacks`, values)
                            .then(() => {
                                this.setState({ showSuccess: true });
                            }).catch(error => {
                                error.response.data.violations.map((value) => {
                                    let fieldName = value.propertyPath[0].toUpperCase() + value.propertyPath.slice(1);
                                    this.setState({ errorTitle: 'Invalid value in the field "' + fieldName + '"' });
                                    this.setState({ errorMessage: value.message.slice(0, -1) });
                                });
                                this.setState({ showError: true });
                            });
                    }}
                    validate={values => {
                        const errors = {};
                        const phonePattern = /^\(\w{3}\) \w{3}-\w{4}$/;

                        if (!values.phone)
                            errors.phone = "Required field";

                        if (values.phone && !phonePattern.test(values.phone))
                            errors.phone = "Wrong phone";

                        return errors;
                    }}
                    initialValues={{}}
                    render={({ handleSubmit, submitting, pristine }) => (
                        <form onSubmit={handleSubmit}>
                            <Field name="name" parse={normalizeName}>
                                {({ input, meta }) => (
                                    <div>
                                        <label className="font-weight-bold text-muted" style={{letterSpacing: ".7px", marginTop: "5px"}}>
                                            <i className="fa fa-user-circle" />
                                            Name
                                        </label>
                                        <input {...input} type="text" placeholder="MaxLength 50 symbols (Latin, space and ')" />
                                        {meta.error && meta.touched && <span>{meta.error}</span>}
                                    </div>
                                )}
                            </Field>
                            <Field name="phone" parse={normalizePhone}>
                                {({ input, meta }) => (
                                    <div>
                                        <label className="font-weight-bold text-muted" style={{letterSpacing: ".7px", marginTop: "5px"}}>
                                            <i className="fa fa-phone-square" />
                                            Phone
                                            <span style={{color: "red"}}> *</span>
                                        </label>
                                        <input {...input} type="text" placeholder="(999) 999-9999" />
                                        {meta.error && meta.touched && <span style={{marginTop: "7px"}}>{meta.error}</span>}
                                    </div>
                                )}
                            </Field>
                            <Field name="message" parse={normalizeMessage}>
                                {({ input, meta }) => (
                                    <div>
                                        <label className="font-weight-bold text-muted">
                                            <i className="fa fa-edit" />
                                            Message
                                        </label>
                                        <textarea {...input} placeholder="MaxLength 255 symbols (Latin and all characters except > and <)" />
                                        {meta.error && meta.touched && <span>{meta.error}</span>}
                                    </div>
                                )}
                            </Field>
                            <div className="buttons">
                                <button type="submit" disabled={submitting || pristine}>
                                    Submit
                                </button>
                            </div>
                            <SweetAlert
                                show={this.state.showSuccess}
                                success
                                confirmBtnBsStyle="default"
                                confirmBtnStyle={{background: "blue", color: "#fff"}}
                                title="Submitted"
                                onConfirm={() => this.setState({ showSuccess: false })}
                            >
                                Our managers will contact you within 5 minutes
                            </SweetAlert>
                            <SweetAlert
                                show={this.state.showError}
                                danger
                                confirmBtnBsStyle="default"
                                confirmBtnStyle={{background: "blue", color: "#fff"}}
                                title="Not submitted"
                                onConfirm={() => this.setState({ showError: false })}
                            >
                                <p className="font-weight-bold h4">{this.state.errorTitle}</p>
                                <p>{this.state.errorMessage}</p>
                            </SweetAlert>
                        </form>
                    )}
                />
            </AdviceStyles>
        );
    }
}

export default Advice;
