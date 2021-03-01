import {getParentElement, nodeArray} from "./helpers";
import validate from "validate.js";
import constraints from "./form-rules";

export default class Form {
    constructor(el, options = {}) {
        this.selectors = {
            invalidFeedback: '.invalid-feedback',
            fieldParent: '.form-group',
        }

        this.el = el;
        this.form = this.getForm(el);
        this.formFeedback = this.el.querySelector('form > ' + this.selectors.invalidFeedback);

        this.bindForm();
    }

    bindForm() {
        this.form.addEventListener('input', e => {
            this.validateField(e.target);
        });

        this.form.addEventListener('submit', e => {
            e.preventDefault();

            if (this.validateFields(true)) {
                this.submit();
            }

            return false;
        })
    }

    submit() {
        window
            .fetch(window.swiPetition.url, {
                method: 'POST',
                body: this.getValues(true),
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
                },
            })
            .then(response => {
                if (response.ok) {
                    this.clearFields();
                }
                return response.json()
            })
            .then(json => {
                if (json.data.error) {
                    this.showErrorMsg(null, [json.data.error], true)
                } else {
                    //this.showSuccessMsg();
                }
            })
            .catch(error => {
                this.showErrorMsg(null, [error.message], true)
            })
    }

    validateFields(useGlobalFeedback = true) {
        let fields = this.getFields();

        for (let i = 0; i < fields.length; i++) {
            if (!this.validateField(fields[i], useGlobalFeedback)) {
                return false;
            }
        }

        return true
    }

    validateField(field, useGlobalFeedback = false) {
        let errors = validate({[field.name]: field.value}, {[field.name]: constraints[field.name]});

        if (errors && errors[field.name]) {
            return this.showFieldError(field, errors[field.name], useGlobalFeedback);
        }

        return this.hideFieldError(field);
    }

    showFieldError(field, errors, useGlobalFeedback = false) {
        let parent = getParentElement(field, this.selectors.fieldParent),
            msgElement = parent.querySelector(this.selectors.invalidFeedback);

        this.showErrorMsg(msgElement, errors, useGlobalFeedback);

        field.classList.add('is-invalid');

        return false;
    }

    showErrorMsg(el, errors, useGlobalFeedback = false) {
        el = el ? el : ( useGlobalFeedback ? this.formFeedback : null );

        if (el) {
            el.textContent = errors.shift();
            el.style.display = 'block';
        }
    }

    hideFieldError(field) {
        let parent = getParentElement(field, this.selectors.fieldParent),
            msgElement = parent.querySelector(this.selectors.invalidFeedback);

        if (msgElement) msgElement.style.display = 'none'
        else if (this.formFeedback) this.formFeedback.style.display = 'none'

        field.classList.remove('is-invalid');

        return true;
    }

    clearFields() {
        this.getFields().forEach(field => field.value = '');
    }

    getFields(el = this.el) {
        return nodeArray(el.querySelectorAll('input, textarea, select'));
    }

    getValues(serialise = false) {
        let values = {};

        this.getFields().forEach(field => ( values[field.name] = field.value ));

        if (serialise) {
            values._ajax_nonce = window.swiPetition.nonce;
            values.action = 'swi_petition_submit';
            values.swi_petition = window.swiPetition.id;

            return Object.keys(values).map(k => k + '=' + values[k]).join('&')
        }

        return values;
    }

    getForm(el = this.el) {
        if (el.tagName === 'FORM') return el;
        return this.el.querySelector('form');
    }
}