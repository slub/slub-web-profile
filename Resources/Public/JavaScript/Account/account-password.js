// Password strength-estimator (zxcvbn) and compliance with confirm field

/**
 * @type {string}
 */
const initPwSelector = '#form-password-newPassword';

/**
 * @type {string}
 */
const confirmPwSelector = '#form-password-passwordRepeat';

/**
 * @type {Array}
 */
const matchPwSelector = [initPwSelector, confirmPwSelector];

/**
 * @type {Element}
 */
const matchPwElements = document.querySelectorAll(matchPwSelector);

/**
 * @type {Element}
 */
let pwElement = document.querySelector(initPwSelector);

/**
 * @type {Element}
 */
let confirmPwElement = document.querySelector(confirmPwSelector);


if (pwElement) {
  initPasswordStrength();
}

const initialize = () => {
  matchPwElements.forEach((matchPwElement) => {
    matchPwElement.addEventListener('keyup', () => { confirmPwMatch() });
  });
}

function initPasswordStrength() {

  pwElement.addEventListener('input', function () {
    let val = pwElement.value;
    let result = zxcvbn(val).score;

    switch (result) {
      case 0:
        pwElement.style.borderBottom = '3px solid #cc0000';
        break;
      case 1:
        pwElement.style.borderBottom = '3px solid #ff9999';
        break;
      case 2:
        pwElement.style.borderBottom = '3px solid #cc9900';
        break;
      case 3:
        pwElement.style.borderBottom = '3px solid #ff8800';
        break;
      case 4:
        pwElement.style.borderBottom = '3px solid #009900';
        break;
      default:
        pwElement.style.borderBottom = '3px solid transparent';
    }
  });
}

const confirmPwMatch = () => {
  if (confirmPwElement.value.length >= 8 && confirmPwElement.value === pwElement.value) {
    confirmPwElement.setCustomValidity('');
    confirmPwElement.style.borderBottom = '3px solid #009900';
  } else {
    confirmPwElement.setCustomValidity('Passwords do not match');
    confirmPwElement.style.borderBottom = '3px solid #cc0000';
  }
}

initialize();