/**
 * @type {string}
 */
const addSelector = '#js-search-query-add';

/**
 * @type {string}
 */
const buttonSelector = '#js-search-query-add-button';

/**
 * @type {string}
 */
const contentSelector = '#js-search-query-add-content';

/**
 * @type {string}
 */
const showContentClass = 'result-add-content-show';

/**
 * @type {HTMLObjectElement|Element}
 */
const addElement = document.querySelector(addSelector);

/**
 * @type {HTMLObjectElement|Element}
 */
const buttonElement = document.querySelector(buttonSelector);

/**
 * @type {HTMLObjectElement|Element}
 */
const contentElement = document.querySelector(contentSelector);

/**
 * @returns {string}
 */
export const showAdd = () => addElement.style.display = 'block';

export const listenAddButton = () => buttonElement.addEventListener('click', () => toggleContent());

const toggleContent = () => contentElement.classList.toggle(showContentClass);

export const hideAddResult = () => addElement.remove();
