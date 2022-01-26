import * as utilityAnimation from '../../Utility/animation.js';
import * as utilityLanguage from '../../Utility/language.js';

/**
 * @type {{default: {status: {"200": string, "500": string}}, "de-DE": {status: {"200": string, "500": string}}}}
 */
const wording = {
  'default': {
    'status': {
      200: 'The changes were succesfully saved.',
      500: 'The changes were not saved.',
      501: 'The search query is not saved.'
    }
  },
  'de-DE': {
    'status': {
      200: 'Die Änderungen wurden erfolgreich gespeichert.',
      500: 'Die Änderungen wurden nicht gespeichert.',
      501: 'Die Suchanfrage wurde nicht gespeichert.'
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
  500: [elementId, `${elementId}--error`],
  501: [elementId, `${elementId}--error`]
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
export const initialize = async (statusCode) => {
  const id = `js-${elementId}-${Date.now()}`;

  addMessage(id, statusCode);
  await wait(timeoutMessage);
  utilityAnimation.removeItem(document.getElementById(id));
}

/**
 * @param {string} id
 * @param {number} statusCode
 */
const addMessage = (id, statusCode) => {
  let div = document.createElement('div');

  div.classList.add(...statusCssClass[statusCode]);
  div.id = id;
  div.innerHTML = `
    <link
        rel="stylesheet"
        type="text/css"
        media="all"
        href="/typo3conf/ext/slub_web_profile/Resources/Public/Css/api-message.css"/>
    ${utilityLanguage.getTranslation(wording)['status'][statusCode]}`;

  bodySelector.append(div);
}

/**
 * @param {number} milliseconds
 * @returns {Promise<unknown>}
 */
const wait = async (milliseconds) => new Promise((resolve) => setTimeout(resolve, milliseconds));
