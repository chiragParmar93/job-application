import * as Yup from 'yup';

export const validationSchema = Yup.object().shape({
    name: Yup.string()
        .required('Name is required'),
    email: Yup.string()
        .email('Email is invalid')
        .required('Email is required'),
    phone: Yup.string()
        .min(10, 'Phone must be at least 10 characters')
        .required('Phone is required'),
    gender: Yup.string()
        .required('Gender is required'),
    experience: Yup.array()
        .of(Yup.object().shape({
            company: Yup.string().required('Company name is required'),
            designation: Yup.string().required('Designation is required'),
        }))
})
