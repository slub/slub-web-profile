/**
 * @type {string}
 */
const isOpenClass = 'message-list--is-open';

/**
 * @type {string}
 */
const containerSelector = '#js-message-list';

/**
 * @type {string}
 */
const headerSelector = '#js-message-list-header';

/**
 * @type {string}
 */
const contentSelector = '#js-message-list-content';

/**
 * @type {Element}
 */
const containerElement = document.querySelector(containerSelector);

/**
 * @type {Element}
 */
const headerElement = document.querySelector(headerSelector);

/**
 * @type {Element}
 */
const contentElement = document.querySelector(contentSelector);

export const listenMessage = () => headerElement.addEventListener('click', () => toggleItem());

const toggleItem = () => {
  containerElement.classList.toggle(isOpenClass);

  if (containerElement.classList.contains(isOpenClass)) {
    headerElement.setAttribute('aria-expanded', 'true');
    contentElement.setAttribute('aria-hidden', 'false');
  } else {
    headerElement.setAttribute('aria-expanded', 'false');
    contentElement.setAttribute('aria-hidden', 'true');
  }
}

// No external call, call the "export" direct
listenMessage();
