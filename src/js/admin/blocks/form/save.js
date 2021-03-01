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

	return (
        <div className="swi-petition-form">
            <form>
                { attributes.firstNameField && (
                    <div className='swi-petition-fname form-group'>
                        <label>{ __('First Name', 'swi-petition' ) }</label>
                        <input type='text' name='swi_petition_fname' placeholder={ __('First Name', 'swi-petition' ) } />
                    </div>
                ) }
                { attributes.lastNameField && (
                    <div className='swi-petition-lname form-group'>
                        <label>{ __('Last Name', 'swi-petition' ) }</label>
                        <input type='text' name='swi_petition_lname' placeholder={ __('Last Name', 'swi-petition' ) } />
                    </div>
                ) }
                { attributes.emailField && (
                    <div className='swi-petition-email form-group'>
                        <label>{ __('Email', 'swi-petition' ) }</label>
                        <input type='email' name='swi_petition_email' placeholder={ __('email@example.org', 'swi-petition' ) } />
                    </div>
                ) }
                { attributes.zipField && (
                    <div className='swi-petition-zip form-group'>
                        <label>{ __('Zip Code', 'swi-petition' ) }</label>
                        <input type='text' name='swi_petition_zip' placeholder={ __('1000', 'swi-petition' ) } />
                    </div>
                ) }
                <div className="alert alert-warning invalid-feedback" role="alert" style={ {display: 'none'} }/>
                <div className="btn-group" role="group">
                    <button className={ 'btn btn-primary' } type='submit'>{ __('Sign the Petition', 'swi-petition' ) }</button>
                </div>
            </form>
        </div>
	);
}
