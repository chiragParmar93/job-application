import React, { Component } from "react";
import axios from "axios";
import { Formik, Field, Form, ErrorMessage, FieldArray, getIn } from 'formik';
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import { validationSchema } from './validationScema';

const InputFeedback = ({ error }) =>
    error ? <div className={"input-feedback error"}>{error}</div> : null;

const initialState = {
    formValue: {
        name: '',
        email: '',
        address: '',
        gender: '',
        phone: '',
        location_id: '',
        expected_ctc: '',
        current_ctc: '',
        notice_period: '',
        languages: [],
        education: [{
            type: "SSC",
            board: '',
            year: '',
            percentage: '',
        },
        {
            type: "HSC",
            board: '',
            year: '',
            percentage: '',
        },
        {
            type: "Graduation",
            board: '',
            year: '',
            percentage: '',
        },
        {
            type: "Master Degree",
            board: '',
            year: '',
            percentage: '',
        }
        ],
        techExperience: [],
        experience: [{
            company: "",
            designation: "",
            start_date: "",
            end_date: "",
        }],
    },
    isLoading: false,
    locationsData: [],
    msg: "",
}
export default class Job extends Component {
    userData;
    constructor(props) {
        super(props);
        this.state = initialState
        this.getInitData()
    }
    getInitData() {
        axios
            .get("http://localhost:8000/api/job/init-data")
            .then((response) => {
                this.setState({ isLoading: false });
                if (response.data.status === 200) {
                    if (response.data.data.languages.length) {
                        let langElement = [];
                        response.data.data.languages.filter((ele) => {
                            let obj = {
                                id: ele.id,
                                language: ele.name.toLowerCase(),
                                read: false,
                                write: false,
                                speak: false,
                            }
                            langElement.push(obj);
                        });
                        const { formValue } = this.state;
                        formValue['languages'] = langElement;
                        this.setState({ formValue })
                    }
                    if (response.data.data.experiences.length) {
                        let techExElement = [];
                        response.data.data.experiences.filter((ele) => {
                            let obj = {
                                id: ele.id,
                                technology: ele.name.toLowerCase(),
                                type: '',
                            }
                            techExElement.push(obj);
                        });
                        const { formValue } = this.state;
                        formValue['techExperience'] = techExElement;
                        this.setState({ formValue })
                    }
                    this.setState({
                        locationsData: response.data.data.locations,
                    });
                }

                if (response.data.status === "failed") {
                    this.setState({ msg: response.data.message });
                    setTimeout(() => {
                        this.setState({ msg: "" });
                    }, 10000);
                }
            });
    }

    onSubmitHandler = (formValue) => {
        axios
            .post("http://localhost:8000/api/job/store", formValue)
            .then((response) => {
                if (response.data.status === 200) {
                    alert(response.data.message);
                    window.location.reload();
                }
                if (response.data.status === "failed") {
                    this.setState({ msg: response.data.message });
                    setTimeout(() => {
                        this.setState({ msg: "" });
                    }, 10000);
                }
            });
    };

    render() {
        const { locationsData, formValue, msg } = this.state;
        return (
            <div>
                <h2 className="mb-4">Application form</h2>
                {msg && (
                    <div>
                        {msg}
                    </div>
                )}
                <Formik
                    initialValues={formValue}
                    validationSchema={validationSchema}
                    onSubmit={values => { this.onSubmitHandler(values) }}
                    render={({ errors, touched, values, setFieldValue }) => (
                        <Form>
                            <h5>Basic Details</h5>
                            <div className="form-group">
                                <label htmlFor="name">Name</label>
                                <Field name="name" type="text" className={'form-control' + (errors.name && touched.name ? ' is-invalid' : '')} />
                                <ErrorMessage name="name" component="div" className="invalid-feedback" />
                            </div>
                            <div className="form-group">
                                <label htmlFor="email">Email</label>
                                <Field name="email" type="email" className={'form-control' + (errors.email && touched.email ? ' is-invalid' : '')} />
                                <ErrorMessage name="email" component="div" className="invalid-feedback" />
                            </div>
                            <div className="form-group">
                                <label htmlFor="gender">Gender</label>
                                <div role="group" className="m-2" aria-labelledby="my-radio-group">
                                    <label className="mr-2">
                                        <Field type="radio" name="gender" value="male" /> Male
                                    </label>
                                    <label>
                                        <Field type="radio" name="gender" value="female" /> Female
                                    </label>
                                    {touched['gender'] && <InputFeedback error={errors['gender']} />}
                                </div>
                            </div>
                            <div className="form-group">
                                <label htmlFor="phone">Phone</label>
                                <Field name="phone" type="text" className={'form-control' + (errors.phone && touched.phone ? ' is-invalid' : '')} />
                                <ErrorMessage name="phone" component="div" className="invalid-feedback" />
                            </div>

                            <div className="form-group">
                                <label htmlFor="address">Address</label>
                                <Field name="address" type="text" className={'form-control' + (errors.address && touched.address ? ' is-invalid' : '')} />
                                <ErrorMessage name="address" component="div" className="invalid-feedback" />
                            </div>
                            <hr></hr>
                            <h5 className="mt-4">Education details</h5>
                            <FieldArray name="education"
                                render={({ }) => (
                                    <div>
                                        {values.education.map((p, index) => {
                                            const educationType = `education[${index}].type`;

                                            const board = `education[${index}].board`;
                                            const touchedboardName = getIn(touched, board);
                                            const errorboardName = getIn(errors, board);

                                            const year = `education[${index}].year`;
                                            const touchedyearName = getIn(touched, year);
                                            const erroryearName = getIn(errors, year);

                                            const percentage = `education[${index}].percentage`;
                                            const touchedpercentageName = getIn(touched, percentage);
                                            const errorpercentageName = getIn(errors, percentage);

                                            return (
                                                <div key={p.id}>
                                                    <div class="row">
                                                        <div class="col-2 form-group">
                                                            <label>{getIn(values, educationType)}</label>
                                                        </div>
                                                        <div class="col-6 form-group">
                                                            <label>Board</label>
                                                            <Field
                                                                name={board}
                                                                type="text"
                                                                className={'form-control' + (errorboardName && touchedboardName ? ' is-invalid' : '')}
                                                            />
                                                        </div>
                                                        <div class="col-2 form-group">
                                                            <label>Year</label>
                                                            <Field
                                                                name={year}
                                                                type="number"
                                                                className={'form-control' + (erroryearName && touchedyearName ? ' is-invalid' : '')}
                                                            />
                                                        </div>
                                                        <div class="col-2 form-group">
                                                            <label>Percentage</label>
                                                            <Field
                                                                name={percentage}
                                                                type="number"
                                                                className={'form-control' + (errorpercentageName && touchedpercentageName ? ' is-invalid' : '')}
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            )
                                        })}
                                    </div>
                                )}
                            />
                            <hr className="mt-2 mb-2"></hr>
                            <h5>Work Experience</h5>
                            <FieldArray name="experience"
                                render={({ remove, push }) => (
                                    <div>
                                        {values.experience.map((p, index) => {
                                            const company = `experience[${index}].company`;
                                            const touchedCompanyName = getIn(touched, company);
                                            const errorCompanyName = getIn(errors, company);

                                            const designation = `experience[${index}].designation`;
                                            const touchedDesignationName = getIn(touched, designation);
                                            const errorDesignationName = getIn(errors, designation);

                                            const startDate = `experience[${index}].start_date`;
                                            const EndDate = `experience[${index}].end_date`;

                                            return (
                                                <div key={p.id}>
                                                    <div class="row">
                                                        <div class="col-6 form-group">
                                                            <label>Company</label>
                                                            <Field
                                                                name={company}
                                                                type="text"
                                                                className={'form-control' + (errorCompanyName && touchedCompanyName ? ' is-invalid' : '')}
                                                            />
                                                            <ErrorMessage name={company} component="div" className="invalid-feedback" />
                                                        </div>
                                                        <div class="col-6 form-group">
                                                            <label>Designation</label>
                                                            <Field
                                                                name={designation}
                                                                type="text"
                                                                className={'form-control' + (errorDesignationName && touchedDesignationName ? ' is-invalid' : '')}
                                                            />
                                                            <ErrorMessage name={designation} component="div" className="invalid-feedback" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6 form-group">
                                                            <DatePicker
                                                                placeholderText="Start Date"
                                                                label="Start Date"
                                                                selected={getIn(values, startDate) || ''}
                                                                value={getIn(values, startDate)}
                                                                dateFormat="yyyy-MM-dd"
                                                                className="form-control"
                                                                name={startDate}
                                                                onChange={date => setFieldValue(startDate, date)}
                                                                placeholderText="Click to select a start date"
                                                            />
                                                            <ErrorMessage name={startDate} component="div" className="invalid-feedback" />
                                                        </div>
                                                        <div class="col-6 form-group">
                                                            <DatePicker
                                                                placeholderText="End Date"
                                                                label="End Date"
                                                                selected={getIn(values, EndDate) || ''}
                                                                value={getIn(values, EndDate) || ''}
                                                                dateFormat="yyyy-MM-dd"
                                                                className="form-control"
                                                                name={EndDate}
                                                                onChange={date => setFieldValue(EndDate, date)}
                                                                placeholderText="Click to end date"
                                                            />
                                                            <ErrorMessage name={EndDate} component="div" className="invalid-feedback" />
                                                        </div>
                                                    </div>
                                                    {index != 0 && (
                                                        <button
                                                            className={`button btn-default`}
                                                            margin="normal"
                                                            type="button"
                                                            color="secondary"
                                                            variant="outlined"
                                                            onClick={() => remove(index)}
                                                        >
                                                            Remove
                                                        </button>)
                                                    }
                                                </div>
                                            )
                                        })}
                                        <div className="form-group mt-4">
                                            <button
                                                className={'btn btn-secondary mb-4'}
                                                type="button"
                                                variant="outlined"
                                                onClick={() =>
                                                    push({ company: "", designation: "", start_date: "", end_date: "" })
                                                }                                        >
                                                Add Experience
                                                </button>
                                        </div>
                                    </div>
                                )}
                            />
                            <hr className="mt-2 mb-2"></hr>
                            <h5>Known Languages</h5>
                            <FieldArray
                                name="languages"
                                render={({ insert, remove, push }) => (
                                    <div>
                                        {values.languages.map((p, index) => {
                                            const nameField = `languages[${index}].language`
                                            return (
                                                <div key={p.id}>
                                                    <div class="row">
                                                        <div class="col-2 form-group">
                                                            <label>{getIn(values, nameField)}</label>
                                                        </div>
                                                        <div class="col-2 form-group">
                                                            <Field
                                                                type="checkbox"
                                                                name={`languages[${index}].read`}
                                                                checked={getIn(values, `languages[${index}].read`) || false}
                                                                value={getIn(values, `languages[${index}].read`) || false}
                                                            />
                                                            <label>&nbsp; Read</label>
                                                        </div>
                                                        <div class="col-2 form-group">
                                                            <Field
                                                                type="checkbox"
                                                                name={`languages[${index}].write`}
                                                                checked={getIn(values, `languages[${index}].write`) || false}
                                                                value={getIn(values, `languages[${index}].write`) || false}
                                                            />
                                                            <label>&nbsp; Write</label>
                                                        </div>
                                                        <div class="col-2 form-group">
                                                            <Field
                                                                type="checkbox"
                                                                name={`languages[${index}].speak`}
                                                                checked={getIn(values, `languages[${index}].speak`) || false}
                                                                value={getIn(values, `languages[${index}].speak`) || false}
                                                            />
                                                            <label>&nbsp; Speak</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            )
                                        })}
                                    </div>
                                )}
                            />
                            <hr className="mt-2 mb-2"></hr>
                            <h5>Technical Experience</h5>
                            <FieldArray name="techExperience"
                                render={({ insert, remove, push }) => (
                                    <div>
                                        {values.techExperience.map((p, index) => {
                                            const techExField = `techExperience[${index}].technology`
                                            return (
                                                <div key={p.id}>
                                                    <div class="row">
                                                        <div class="col-2 form-group">
                                                            <label>{getIn(values, techExField)}</label>
                                                        </div>
                                                        <div class="col-8 form-group pr-2">
                                                            <Field type="radio" name={`techExperience[${index}].type`} value="beginner" />
                                                            <label>&nbsp; Beginner &nbsp;</label>
                                                            <Field type="radio" name={`techExperience[${index}].type`} value="mediator" />
                                                            <label>&nbsp; Mediator &nbsp;</label>
                                                            <Field type="radio" name={`techExperience[${index}].type`} value="expert" />
                                                            <label>&nbsp; Expert &nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            )
                                        })}
                                    </div>
                                )}
                            />

                            <hr className="mt-2 mb-2"></hr>
                            <h5>Preference Details</h5>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label htmlFor="location_id">Preferred Location</label>
                                    <Field as="select" name="location_id" className={'form-control' + (errors.location_id && touched.location_id ? ' is-invalid' : '')}>
                                        {locationsData.map((location) => (
                                            <option value={location.id}>{location.name}</option>
                                        ))}
                                    </Field>
                                </div>
                                <div class="col-6 form-group">
                                    <label htmlFor="expected_ctc">Expected CTC</label>
                                    <Field name="expected_ctc" type="text" className={'form-control' + (errors.expected_ctc && touched.expected_ctc ? ' is-invalid' : '')} />
                                    <ErrorMessage name="expected_ctc" component="div" className="invalid-feedback" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label htmlFor="current_ctc">Current CTC</label>
                                    <Field name="current_ctc" type="text" className={'form-control' + (errors.current_ctc && touched.current_ctc ? ' is-invalid' : '')} />
                                    <ErrorMessage name="current_ctc" component="div" className="invalid-feedback" />
                                </div>
                                <div class="col-6 form-group">
                                    <label>Notice Period</label>
                                    <Field name="notice_period" type="text" className={'form-control' + (errors.notice_period && touched.notice_period ? ' is-invalid' : '')} />
                                    <ErrorMessage name="notice_period" component="div" className="invalid-feedback" />
                                </div>
                            </div>

                            <div className="form-group">
                                <button type="submit" className="btn btn-primary mr-2">Submit</button>
                            </div>
                        </Form>
                    )}
                />
            </div>
        );
    }
}
