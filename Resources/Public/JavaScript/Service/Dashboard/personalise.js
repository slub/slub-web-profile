/**
 * @type {string}
 */
const isOpenClass = 'personalise--is-open';

/**
 * @type {string}
 */
const containerSelector = '#js-personalise';

/**
 * @type {string}
 */
const headerSelector = '#js-personalise-header';

/**
 * @type {string}
 */
const closeSelector = '#js-personalise-close';

/**
 * @type {string}
 */
const controllerSelector = '#js-personalise-controller';

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
const closeElement = document.querySelector(closeSelector);

/**
 * @type {string}
 */
const controllerElement = document.querySelector(controllerSelector);


export const initialize = () => {
  
  const listenHeader = () => headerElement.addEventListener('click', () => toggleItem());
  const listenClose = () => closeElement.addEventListener('click', () => toggleItem());


  const toggleItem = () => {
    containerElement.classList.toggle(isOpenClass);

    if (containerElement.classList.contains(isOpenClass)) {
      headerElement.setAttribute('aria-expanded', 'true');
      closeElement.setAttribute('aria-hidden', 'false');
      controllerElement.setAttribute('aria-hidden', 'false');
    } else {
      headerElement.setAttribute('aria-expanded', 'false');
      closeElement.setAttribute('aria-hidden', 'true');
      controllerElement.setAttribute('aria-hidden', 'true');
    }
  }  

  listenHeader();
  listenClose();
}