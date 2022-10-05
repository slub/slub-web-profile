// Check UserPIN field for compliance
/**
 * @type {string}
 */
const initPinSelector = '#form-userpin-new-pin';

/**
 * @type {string}
 */
const confirmPinSelector = '#form-userpin-confirm-new-pin';

/**
 * @type {Element}
 */
let pinElement = document.querySelector(initPinSelector);

/**
 * @type {Element}
 */
let confirmPinElement = document.querySelector(confirmPinSelector);


function confirmPinMatch() {
    if (confirmPinElement.value.length === 4 && confirmPinElement.value === pinElement.value) {
        confirmPinElement.setCustomValidity('');
        confirmPinElement.style.borderBottom = '3px solid #009900';
    } else {
        confirmPinElement.setCustomValidity('Passwords do not match');
        confirmPinElement.style.borderBottom = '3px solid #cc0000';
    }
}