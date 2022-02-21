/**
 * @type {string}
 */
const isOpenClass = 'search-query-list__item--is-open';

/**
 * @type {string}
 */
const titleSelector = '.js-search-query-item-title';

/**
 * @type {string}
 */
const headerSelector = '#js-search-query-list-item-###itemId###-header';

/**
 * @type {string}
 */
const contentSelector = '#js-search-query-list-item-###itemId###-content';

/**
 * @type {NodeList}
 */
const titleElements = document.querySelectorAll(titleSelector);

export const listenAccordion = () => titleElements.forEach((item) => item.addEventListener('click', () => toggleItem(item)));

/**
 * @param {HTMLObjectElement|Element} item
 */
const toggleItem = (item) => {
  const headerId = replaceItemId(headerSelector, parseInt(item.dataset.id));
  const header = document.querySelector(headerId);

  const contentId = replaceItemId(contentSelector, parseInt(item.dataset.id));
  const content = document.querySelector(contentId);

  header.classList.toggle(isOpenClass);
  content.classList.toggle(isOpenClass);
}

/**
 * @param {string} string
 * @param {number} itemId
 * @returns {string}
 */
const replaceItemId = (string, itemId) => string.replace('###itemId###', itemId.toString());
