import { useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { TextControl } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, PanelRow, ToggleControl } from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import '../../../../css/block-editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( props ) {
    const blockProps = useBlockProps(),
        postType = useSelect(
            ( select ) => select( 'core/editor' ).getCurrentPostType(),
            []
        ),
        { attributes, className, setAttributes } = props,
        [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );

	return [
        <InspectorControls>
            <PanelBody
                title={ __('Petition! Settings', 'swi-petition' ) }
                initialOpen={ false }
            >
                <PanelRow>
                    <TextControl
                        label={ __( 'Expected number of signatures', 'swi-petition' ) }
                        placeholder={ 'dddd' }
                        value={ meta.swi_petition_goal }
                        type='number'
                        min='1'
                        onChange={ val => setMeta( { ...meta, 'swi_petition_goal': val } ) }
                    />
                </PanelRow>
            </PanelBody>
            <PanelBody
                title={ __("Petition! form fields", 'swi-petition' ) }
                initialOpen={true}
            >
                <PanelRow>
                    <ToggleControl
                        label={ __('First Name', 'swi-petition' ) }
                        checked={ attributes.firstNameField }
                        onChange={ val => setAttributes({ firstNameField: val }) }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __('Last Name', 'swi-petition' ) }
                        checked={ attributes.lastNameField }
                        onChange={ val => setAttributes({ lastNameField: val }) }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __('Email', 'swi-petition' ) }
                        checked={attributes.emailField}
                        onChange={ val => setAttributes({ emailField: val }) }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __('Zip Code', 'swi-petition' ) }
                        checked={ attributes.zipField }
                        onChange={ val => setAttributes({ zipField: val }) }
                    />
                </PanelRow>
            </PanelBody>
            { attributes.zipField && (
                <PanelBody
                    title={ __('Zip Code Settings', 'swi-petition' ) }
                    initialOpen={ true }
                >
                    <PanelRow>
                        <TextControl
                            label={ __( 'Allowed zip code pattern', 'swi-petition' ) }
                            placeholder={ 'dddd' }
                            value={ meta.swi_petition_zip_pattern }
                            onChange={ val => setMeta( { ...meta, 'swi_petition_zip_pattern': val } ) }
                        />
                    </PanelRow>
                    <PanelRow>
                        <TextControl
                            label={ __( 'Allowed zip codes', 'swi-petition' ) }
                            placeholder={ 'Zip codes separated by commas' }
                            value={ meta.swi_petition_allowed_zips }
                            onChange={ val => setMeta( { ...meta, 'swi_petition_allowed_zips': val } ) }
                        />
                    </PanelRow>
                </PanelBody>
            ) }
        </InspectorControls>,
        <div className="swi-petition-form">
            <form {...blockProps}>
                { attributes.firstNameField && (
                    <div className='swi-petition-fname form-group'>
                        <TextControl
                            label={ __('First Name', 'swi-petition' ) }
                            type='text'
                            name='swi_petition_fname'
                        />
                    </div>
                ) }
                { attributes.lastNameField && (
                    <TextControl
                        label={ __('Last Name', 'swi-petition' ) }
                        type='text'
                        className={ className }
                    />
                ) }
                { attributes.emailField && (
                    <TextControl
                        label={ __('Email', 'swi-petition' ) }
                        type='email'
                        className={ className }
                    />
                ) }
                { attributes.zipField && (
                    <TextControl
                        label={ __('Zip Code', 'swi-petition' ) }
                        type='number'
                        className={ className }
                    />
                ) }
                <div>
                    <button type='submit' disabled>{ __('Sign the Petition', 'swi-petition' ) }</button>
                </div>
            </form>
        </div>
	];
}
