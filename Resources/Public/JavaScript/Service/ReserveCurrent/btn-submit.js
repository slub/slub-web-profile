/**
 * @type {string}
 */
const itemSelector = '.js-reserve-current-item';

/**
 * @type {string}
 */
const submitSelector = '#js-reserve-current-delete';

/**
 * @type {string}
 */
const selectAllSelector = '#js-reserve-current-select-all';

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
 * @type {string}
 */
const submitText = submitElement.innerHTML;

export const listenCheckItems = () => {
  itemElements.forEach((itemElement) => {
    itemElement.addEventListener('change', () => { toggleSubmitBtn() });
  });
  selectAllElement.addEventListener('click', () => toggleSubmitBtn());
}

const toggleSubmitBtn = () => {
  let count = 0;

  for (var i = 0; i < itemElements.length; i++) {
    if (itemElements[i].type === 'checkbox' && itemElements[i].checked === true) {
      count++;
    }
  }

  if (count > 0) {
    submitElement.removeAttribute('disabled');
    submitElement.textContent = count + submitText;

  } else {
    submitElement.setAttribute('disabled', '');
    submitElement.textContent = submitText + '';
  }
}
