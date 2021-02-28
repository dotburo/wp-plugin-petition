import { __ } from '@wordpress/i18n';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
export default function save( { attributes, className } ) {
    console.log("saving",attributes);
	return (
        <div className="swi-petition-form">
            <form>
                { attributes.firstNameField && (
                    <div className='swi-petition-fname form-group'>
                        <label>{ __('First Name' ) }</label>
                        <input type='text' name='swi_petition_fname' />
                    </div>
                ) }
                { attributes.lastNameField && (
                    <div className='swi-petition-lname form-group'>
                        <label>{ __('Last Name' ) }</label>
                        <input type='text' name='swi_petition_lname' />
                    </div>
                ) }
                { attributes.emailField && (
                    <div className='swi-petition-email form-group'>
                        <label>{ __('Email' ) }</label>
                        <input type='email' name='swi_petition_email' />
                    </div>
                ) }
                { attributes.zipField && (
                    <div className='swi-petition-zip form-group'>
                        <label>{ __('Zip Code' ) }</label>
                        <input type='text' name='swi_petition_zip' />
                    </div>
                ) }
            </form>
        </div>
	);
}
