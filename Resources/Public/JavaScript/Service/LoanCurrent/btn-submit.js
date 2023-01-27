/**
 * @type {string}
 */
const itemSelector = '.js-loan-current-item';

/**
 * @type {string}
 */
const submitSelector = '#js-loan-current-renew';

/**
 * @type {string}
 */
const selectAllSelector = '#js-loan-current-select-all';

/**
 * @type {string}
 */
const modalCheckboxSelector = '#renewLoanConfirm';

/**
 * @type {NodeListOf<Element>}
 */
const itemElements = document.querySelectorAll(itemSelector);

/**
 * @type {HTMLObjectElement|Element}
 */
const submitElement = document.querySelector(submitSelector);

/**
 * @type {HTMLObjectElement|Element}
 */
const selectAllElement = document.querySelector(selectAllSelector);

/**
 * @type {HTMLObjectElement|Element}
 */
const modalCheckboxElement = document.querySelector(modalCheckboxSelector);

/**
 * @type {string}
 */
const submitText = submitElement.innerHTML;

export const listenCheckItems = () => {
  itemElements.forEach((itemElement) => {
    itemElement.addEventListener('change', () => { toggleSubmitBtn(itemElement) });
  });
  selectAllElement.addEventListener('click', () => toggleSubmitBtn());
}

const toggleSubmitBtn = (itemElement) => {
  let count = 0;

  for (var i = 0; i < itemElements.length; i++) {
    if (itemElements[i].type === 'checkbox' && itemElements[i].checked === true) {
      count++;
    }
  }

  if (count > 0) {
    submitElement.removeAttribute('disabled');
    submitElement.textContent = count + submitText;
    
    dataSubmitBtn(itemElement);

  } else {
    submitElement.setAttribute('disabled', '');
    submitElement.textContent = submitText + ''; 
  }
}

const dataSubmitBtn = (itemElement) => {
  let dueDays = itemElement.getAttribute('data-days-to-due');
  modalCheckboxElement.getElementsByClassName('days-to-due')[0].innerHTML = dueDays;
}