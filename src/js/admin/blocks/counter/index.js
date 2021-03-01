import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import '../../../../css/block-editor.scss';

export function register() {
    registerBlockType('swi-petition/counter-block', {
        apiVersion: 2,
        title: __('Counter Block', 'swi-petition'),
        description: __(
            'Counter for Petition!',
            'swi-petition'
        ),
        category: 'widgets',
        icon: 'smiley',
        supports: {
            html: false,
        },
        attributes: {
            hasCounter: {
                type: 'string',
                source: 'html',
                selector: '.swi-petition-counter',
            },
        },
        edit: () => {
            return (
                <div className='swi-petition-counter'>
                    <div className="swi-petition-counter-number">9682</div>
                    <svg><circle r="50" cx="70" cy="70"/></svg>
                </div>
            );
        },
        save: () => {
            return (
                <div className='swi-petition-counter'/>
            );
        }
    });
}
