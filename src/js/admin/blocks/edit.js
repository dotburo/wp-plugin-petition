import config from "../config";
import { useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { TextControl } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, PanelRow, ToggleControl } from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import './editor.scss';

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

    console.log(attributes, className, meta, postType);

	return [
        <InspectorControls>
            <PanelBody
                title="Most awesome settings ever"
                initialOpen={true}
            >
                <PanelRow>
                    <ToggleControl
                        label={ __('First Name' ) }
                        checked={ attributes.firstNameField }
                        onChange={ val => setAttributes({ firstNameField: val }) }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __('Last Name' ) }
                        checked={ attributes.lastNameField }
                        onChange={ val => setAttributes({ lastNameField: val }) }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __('Email' ) }
                        checked={attributes.emailField}
                        onChange={ val => setAttributes({ emailField: val }) }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __('Zip Code' ) }
                        checked={ attributes.zipField }
                        onChange={ val => setAttributes({ zipField: val }) }
                    />
                </PanelRow>
            </PanelBody>
            { attributes.zipField && (
                <PanelBody
                    title={ __('Zip Code Settings', config.textDomain ) }
                    initialOpen={ true }
                >
                    <PanelRow>
                        <TextControl
                            label={ __( 'Allowed zip code pattern', config.textDomain ) }
                            placeholder={ 'dddd' }
                            value={ meta.swi_petition_zip_pattern }
                            onChange={ val => setMeta( { ...meta, 'swi_petition_zip_pattern': val } ) }
                        />
                    </PanelRow>
                    <PanelRow>
                        <TextControl
                            label={ __( 'Allowed zip codes', config.textDomain ) }
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
                            label={ __('First Name' ) }
                            type='text'
                            name='swi_petition_fname'
                        />
                    </div>
                ) }
                { attributes.lastNameField && (
                    <TextControl
                        label={ __('Last Name' ) }
                        type='text'
                        className={ className }
                    />
                ) }
                { attributes.emailField && (
                    <TextControl
                        label={ __('Email' ) }
                        type='email'
                        className={ className }
                    />
                ) }
                { attributes.zipField && (
                    <TextControl
                        label={ __('Zip Code' ) }
                        type='number'
                        className={ className }
                    />
                ) }
            </form>
        </div>
	];
}
