let __ = wp.i18n.__,
    sprintf = wp.i18n.sprintf,
    fName = __( "First Name", 'swi-petition' ),
    lName = __( "Last Name", 'swi-petition' ),
    email = __( "Email", 'swi-petition' ),
    zip = __( "Zip Code", 'swi-petition' );

export default {
    swi_petition_fname: {
        presence: {
            allowEmpty: false,
            message: '^' + sprintf( __("The %s field cannot be blank.", 'swi-petition' ), fName ),
        },
    },
    swi_petition_lname: {
        presence: {
            allowEmpty: false,
            message: '^' + sprintf( __("This %s field cannot be blank.", 'swi-petition' ), lName ),
        },
    },
    swi_petition_email: {
        presence: {
            allowEmpty: false,
            message: '^' + sprintf( __("This %s field cannot be blank.", 'swi-petition' ), email ),
        },
        format: {
            pattern: '^(([^<>()[\\]\\\\.,;:\\s@"]+(\\.[^<>()[\\]\\\\.,;:\\s@"]+)*)|(".+"))@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\])|(([a-zA-Z\\-0-9]+\\.)+[a-zA-Z]{2,}))$',
            message: '^' + __( "Your email address seems wrong.", 'swi-petition' ),
        }
    },
    swi_petition_zip: {
        presence: {
            allowEmpty: false,
            message: '^' + sprintf( __("This %s field cannot be blank.", 'swi-petition' ), zip ),
        },
        format: {
            pattern: '^[0-9]{4}$',
            message: '^' + __( "The zip code format is wrong.", 'swi-petition' ),
        }
    },
    swi_petition_age: {
        presence: {
            message: '^' + __( "Please confirm your age.", 'swi-petition' ),
        },
        inclusion: {
            within: [true],
            message: '^' + __( "Please confirm your age.", 'swi-petition' ),
        }
    },
}
