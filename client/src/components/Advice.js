import React, { Component } from "react";
import { Form, Field } from "react-final-form";
import SweetAlert from "react-bootstrap-sweetalert";

import feedback from "../img/feedback.png";
import Styles from "./AdviceStyles";
import "../../node_modules/react-bootstrap-sweetalert//lib/dist/SweetAlert";

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
        show: false
    };

    render() {
        return (
            <Styles>
                <div>
                    <img src={feedback} alt="Feedback" />
                </div>
                <h2 className="text-muted">Leave your phone number so our managers can contact you</h2>
                <Form
                    onSubmit={async () => {
                        const sleep = ms => new Promise(resolve => setTimeout(resolve, ms));
                        await sleep(300);
                        // window.alert(JSON.stringify(values, 0, 2));
                        const show = () => this.setState({ show: true });
                        show();
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
                    render={({ handleSubmit, submitting, pristine, values }) => (
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
                                show={this.state.show}
                                success
                                title="Submitted"
                                onConfirm={() => this.setState({ show: false })}
                            >
                                Our managers will contact you within 5 minutes
                            </SweetAlert>
                            {/*<pre>{JSON.stringify(values, 0, 2)}</pre>*/}
                        </form>
                    )}
                />
            </Styles>
        );
    }
}

export default Advice;
