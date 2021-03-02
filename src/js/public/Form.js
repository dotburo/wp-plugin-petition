import {getParentElement, nodeArray} from "./helpers";
import validate from "validate.js";
import constraints from "./form-rules";

export default class Form {
    constructor(el, options = {}) {
        this.selectors = Object.assign({
            invalidFeedback: '.invalid-feedback',
            fieldParent: '.form-group',
        }, options.selectors || {});

        this.url = options.url;
        this.include = options.include;

        this.cb = options.cb;
        this.redirect = options.redirect;

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
            .fetch(this.url, {
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
                if (json.data && json.data.error) {
                    this.showErrorMsg(null, [json.data.error], true)
                } else {
                    this.onSuccess();
                }
            })
            .catch(error => {
                this.showErrorMsg(null, [error.message], true)
            })
    }

    onSuccess() {
        if (this.cb) {
            this.cb();
        }
        if (this.redirect) {
            window.location = this.redirect
        }
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
        let value = this.getValue(field),
            errors = validate({[field.name]: value}, {[field.name]: constraints[field.name]});

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

    getValue(field) {
        let fieldType = field.type.toLowerCase();

        if (fieldType === 'checkbox' || fieldType === 'radio') {
            return field.checked
        }

        return field.value
    }

    getValues(serialise = false) {
        let values = {};

        this.getFields().forEach(field => {
            values[field.name] = this.getValue(field)
        });

        if (serialise) {
            values = Object.assign(values, this.include);

            return Object.keys(values).map(k => k + '=' + values[k]).join('&')
        }

        return values;
    }

    getForm(el = this.el) {
        if (el.tagName === 'FORM') return el;
        return this.el.querySelector('form');
    }
}
