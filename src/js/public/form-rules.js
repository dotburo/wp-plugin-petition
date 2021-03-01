export default {
    swi_petition_fname: {
        presence: {
            allowEmpty: false,
            message: "^This field cannot be blank",
        },
    },
    swi_petition_lname: {
        presence: {
            allowEmpty: false,
            message: "^This field cannot be blank",
        },
    },
    swi_petition_email: {
        presence: {
            allowEmpty: false,
            message: "^This field cannot be blank",
        },
        format: {
            pattern: '^(([^<>()[\\]\\\\.,;:\\s@"]+(\\.[^<>()[\\]\\\\.,;:\\s@"]+)*)|(".+"))@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\])|(([a-zA-Z\\-0-9]+\\.)+[a-zA-Z]{2,}))$',
            message: "^Your email seems wrong",
        }
    },
    swi_petition_zip: {
        presence: {
            allowEmpty: false,
            message: "^This field cannot be blank",
        },
        format: {
            pattern: '^[0-9]{4}$',
            message: "^The zip code format is wrong",
        }
    },
}
