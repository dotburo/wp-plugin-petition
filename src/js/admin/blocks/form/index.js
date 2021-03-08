import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import Edit from './edit';
import save from './save';
import icon from '../icon';

export function register() {
    registerBlockType('swi-petition/form-block', {
        apiVersion: 2,
        title: __('Petition! Form', 'swi-petition'),
        description: __(
            'Input fields for Petition!',
            'swi-petition'
        ),
        category: 'widgets',
        icon,
        supports: {
            html: false,
        },
        attributes: {
            firstNameField: {
                type: 'string',
                source: 'html',
                selector: '.swi-petition-fname',
            },
            lastNameField: {
                type: 'string',
                source: 'html',
                selector: '.swi-petition-lname',
            },
            emailField: {
                type: 'string',
                source: 'html',
                selector: '.swi-petition-email',
            },
            zipField: {
                type: 'string',
                source: 'html',
                selector: '.swi-petition-zip'
            },
            ageField: {
                type: 'string',
                source: 'html',
                selector: '.swi-petition-age'
            },
            ageFieldLabel: {
                type: 'string',
                source: 'text',
                selector: '.swi-petition-age-label',
            }
        },
        edit: Edit,
        save,
    });
}
