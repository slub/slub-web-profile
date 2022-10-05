// Check e-mail field for valid format; switching of the confirmation field in case of changes and checking for compliance
/**
 * @type {string}
 */
const initEmailSelector = '#form-profile-email';

/**
 * @type {string}
 */
const confirmEmailSelector = '#form-profile-confirm-email';

/**
 * @type {string}
 */
const hiddenEmailConfirmSelector = '#form-profile-changeEmail';

/**
 * @type {Element}
 */
let mailElement = document.querySelector(initEmailSelector);

/**
 * @type {Element}
 */
let confirmMailElement = document.querySelector(confirmEmailSelector);

/**
 * @type {Element}
 */
let hiddenConfirmField = document.querySelector(hiddenEmailConfirmSelector);


if (mailElement) {
    validEmailFormat();
}

function validEmailFormat() {

    mailElement.addEventListener('input', function () {
        let val = mailElement.value;
        if (val != mailElement.input) {
            toggleConfirmMailField();
        }
        const expression = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        let validEmail = expression.test(String(val).toLowerCase());
        if (validEmail) {
            mailElement.setCustomValidity('');
            mailElement.style.borderBottom = '3px solid #009900';
        } else {
            mailElement.setCustomValidity('Enter a valid email format');
            mailElement.style.borderBottom = '3px solid #cc0000';
        }
    });
}

function toggleConfirmMailField() {
    hiddenConfirmField.classList.toggle('hidden');
    confirmMailElement.toggleAttribute('required');
}

function confirmEmailMatch() {
    if (confirmMailElement.value === mailElement.value) {
        confirmMailElement.setCustomValidity('');
        confirmMailElement.style.borderBottom = '3px solid #009900';
    } else {
        confirmMailElement.setCustomValidity('Passwords do not match');
        confirmMailElement.style.borderBottom = '3px solid #cc0000';
    }
}