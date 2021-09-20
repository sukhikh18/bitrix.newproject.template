(function(window) {
    'use strict';

    if (!!window.FormResultNew)
        return;

    window.FormResultNew = function (params) {
        this.formPosting = false;
        this.isFormValid = true;
        this.form = document.querySelector('[data-form="' + params.AreaId + '"]');
        this.modal = this.form.closest('.modal');
        // Do not cache sessid (make it from meta)
        let metaSessid = document.head.querySelector('meta[name="sessid"]');
        if (metaSessid && metaSessid.content) this.form.sessid.value = metaSessid.content;

        BX.bind(this.form, 'submit', BX.proxy(this.submit, this));
        BX.ready(BX.delegate(this.formInput, this));
    };

    window.FormResultNew.prototype =
    {
        getFormInputs: function() {
            return this.form.querySelectorAll('input');
        },

        getRequiredFormInputs: function() {
            return this.form.querySelectorAll('input[required]');
        },

        addInputError: function(context, msg) {
        	let label = context.closest('label'),
        		error = label.querySelector('.input__error');

        	if (! this.isInputError(context)) {
        		label.classList.add('error');
        		if (msg) error.innerHTML = msg;
        	}

            this.isFormValid = false;
        },

        removeInputError: function(context) {
            context.closest('label').classList.remove('error');
        },

        isInputError: function(context) {
            return context.closest('label').classList.contains('error');
        },

        /**
         * Check empty field.
         */
        validateEmpty: function() {
            let requiredInputs = this.getRequiredFormInputs();

            if (0 < requiredInputs.length) {
                for (let i = 0; i < requiredInputs.length; i++) {
                    let input = requiredInputs[i];

                    if ('checkbox' === input.getAttribute('type') && ! input.checked) {
                        this.addInputError(input);
                    }

                    else if (input.value.length === 0) {
                        this.addInputError(input, 'Поле обязательно для заполнения');
                    }
                }
            }
        },

        /**
         * Client validate form before submit
         */
        formValidate: function() {
            this.isFormValid = true;
            this.validateEmpty();

            let inputs = this.getFormInputs();

            for (let i = 0; i < inputs.length; i++) {
                let input = inputs[i];

                if ('tel' === input.getAttribute('type')) {
                	if ('+7 (___) ___-__-__' === input.value) {
                		this.addInputError(input, 'Поле обязательно для заполнения');
                	}
                    else if (0 > input.value.search(/\+7\s?\({0,1}9[0-9]{2}\){0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}/)) {
                    	this.addInputError(input, 'Введен неверный телефон');
                    }
                }

                else if ('email' === input.getAttribute('type')) {
                    if (0 > input.value.search(/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/i)) {
                        this.addInputError(input, 'Введен неверный E-mail');
                    }
                }
            }

            return this.isFormValid;
        },

        submit: function(e) {
            e.preventDefault();

            if (this.formValidate() && ! this.formPosting) {
                this.formPosting = true;
                let request = new XMLHttpRequest();

                // Save context link.
                let self = this;
                request.onreadystatechange = function() {
                    if (4 === request.readyState) {
                        if (200 === request.status) {
                            self.successMessage(request.response);
                        } else {
                            self.errorMessage();
                        }

                        self.formPosting = false;
                    }
                }

                request.open('POST', this.form.getAttribute('action'));
                request.send(new FormData(this.form));
            }
        },

        /**
         * Clear error on input
         */
        formInput: function() {
            let self = this;
            let inputs = this.getFormInputs();

            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', function() {
                    // Also any checkbox changes.
                    if (self.isInputError(this)) {
                        self.removeInputError(this);
                    }
                });
            }
        },

        errorMessage: function() {
            alert('Ошибка! Попробуйте позже или обратитесь к администратору сайта.');
        },

        successMessage: function(response) {
            let result = BX.parseJSON(response);
            if ('N' === result.SUCCESS) {
                this.errorMessage();
                return console.error(result.ERROR);
            }

            let triumph = this.modal ?
                this.modal.querySelector('.triumph') :
                this.form.nextElementSibling.classList.contains('triumph') ? this.form.nextElementSibling : null;

            if (triumph) {
                triumph.classList.add('active');
            } else {
                // Catch undefined triumph.
                alert('Заявка отправлена. Мы свяжемся с вами в ближайшее время!');
            }
        },
    }
})(window);
