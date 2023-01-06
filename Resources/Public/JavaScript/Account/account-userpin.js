// Check UserPIN field for compliance
/**
 * @type {string}
 */
const initPinSelector = '#form-userpin-pin';

/**
 * @type {string}
 */
const confirmPinSelector = '#form-userpin-pinRepeat';

/**
 * @type {string}
 */
const confirmPinLength = 4;

/**
 * @type {Array}
 */
const matchPinSelector = [initPinSelector, confirmPinSelector];

/**
 * @type {Element}
 */
const matchPinElements = document.querySelectorAll(matchPinSelector);

/**
 * @type {Element}
 */
let pinElement = document.querySelector(initPinSelector);

/**
 * @type {Element}
 */
let confirmPinElement = document.querySelector(confirmPinSelector);

const initialize = () => {
  matchPinElements.forEach((matchPinElement) => {
    matchPinElement.addEventListener('keyup', () => { confirmPinMatch() });
  });
}

const confirmPinMatch = () => {
  if (confirmPinElement.value.length === confirmPinLength && confirmPinElement.value === pinElement.value) {
    confirmPinElement.setCustomValidity('');
    confirmPinElement.style.borderBottom = '3px solid #009900';
  } else {
    confirmPinElement.setCustomValidity('Passwords do not match');
    confirmPinElement.style.borderBottom = '3px solid #cc0000';
  }
}

initialize();