import * as utilityLanguage from '../../Utility/language.js'

/**
 * @type {{default: {status: {"200": string, "500": string}}, "de-DE": {status: {"200": string, "500": string}}}}
 */
const wording = {
  'default': {
    'status': {
      200: 'The changes were succesfully saved.',
      500: 'The changes were not saved.'
    }
  },
  'de-DE': {
    'status': {
      200: 'Die Änderungen wurden erfolgreich gespeichert.',
      500: 'Die Änderungen wurden nicht gespeichert.'
    }
  }
};

/**
 * @type {string}
 */
const elementId = 'api-message-status';

/**
 * @type {{"200": string, "500": string}}
 */
const statusCssClass = {
  200: [elementId, `${elementId}--successful`],
  500: [elementId, `${elementId}--error`]
}

/**
 * How long the message is visible in milliseconds
 *
 * @type {number}
 */
const timeoutMessage = 2000;

/**
 * @type {HTMLBodyElement}
 */
const bodySelector = document.querySelector('body');

/**
 * @param {number} statusCode
 */
export const initialize = (statusCode) => {
  const id = `js-${elementId}-${Date.now()}`;

  addMessage(id, statusCode);
  setTimeout(() => removeMessage(document.getElementById(id)), timeoutMessage);
}

/**
 * @param {string} id
 * @param {number} statusCode
 */
const addMessage = (id, statusCode) => {
  let div = document.createElement('div');

  div.classList.add(...statusCssClass[statusCode]);
  div.id = id;
  div.innerText = utilityLanguage.getTranslation(wording)['status'][statusCode];

  bodySelector.append(div);
}

/**
 * @param {HTMLObjectElement|Element} message
 * @param {number} opacity
 */
const removeMessage = (message, opacity= 1) => {
  message.style.opacity < 0 && message.remove();

  setTimeout(() => {
    opacity -= 0.1;
    message.style.opacity = opacity.toString();

    removeMessage(message, opacity);
  }, 50);
}