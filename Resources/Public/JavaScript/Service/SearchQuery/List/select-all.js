/**
 * @type {string}
 */
const buttonSelector = '#js-search-query-select-all';

/**
 * @type {string}
 */
const itemSelector = '.js-search-query-list-item';

/**
 * @type {HTMLObjectElement|Element}
 */
const buttonElement = document.querySelector(buttonSelector);

/**
 * @type {NodeListOf<Element>}
 */
const itemElements = document.querySelectorAll(itemSelector);

export const listenButton = () => buttonElement.addEventListener('click', () => toggleItems());

const toggleItems = () => {
  itemElements.forEach((item) => {
    if (item.getAttribute('checked')) {
      item.removeAttribute('checked');
      item.checked = false;
    } else {
      item.setAttribute('checked', 'checked');
      item.checked = true;
    }
  });
}
