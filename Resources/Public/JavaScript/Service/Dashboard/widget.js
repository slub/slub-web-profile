import * as utilityAnimation from '../../Utility/animation.js';
import * as script from '../../Utility/script.js';
import * as dashboardController from './controller.js';
import * as dashboardRequest from './request.js';
import * as apiMessageStatus from '../ApiMessage/status.js';

/**
 * @type {string}
 */
const loadingClass = 'js-widgets-loading';

/**
 * @type {string}
 */
const widgetTemplateSelector = '#js-widget-template';

/**
 * @type {string}
 */
const widgetsContainerSelector = '#js-dashboard-widgets';

/**
 * @type {string}
 */
const widgetsSelector = `${widgetsContainerSelector} > .js-widgets-item`;

/**
 * @type {string}
 */
const widgetSelector = '#js-widgets-item-###widgetId###'

/**
 * @type {string}
 */
const closeButtonSelector = '#js-widget-btn-close-###widgetId###';

/**
 * @type {string}
 */
const configWidgetSelector = '#js-widgets-item-###widgetId###';

/**
 * @type {string}
 */
const widgetContentSelector = '#js-widget-content-###widgetId###';


/**
 * @type {string}
 */
const queryString = '?tx_slubwebprofile_ajax[tt_content]=###widgetId###';

export const initialize = () => {
  const widgets = document.querySelectorAll(widgetsSelector);

  if (widgets.length > 0) {
    widgets.forEach((widget) => {
      const widgetId = parseInt(widget.dataset.widgetId);
      const uri = getWidgetUri();

      loadWidget(widgetId, uri)
        .then(data => insertData(data, widgetId))
        .then(() => addConfigBtn(widgetId))
        .then(() => listenConfigBtn(widgetId))
        .then(() => listenCloseButton(widgetId))
        .catch(error => console.error(error));
    });
  }
}

/**
 * @param widgetId
 * @param uri
 * @returns {Promise<string>}
 */
const loadWidget = async (widgetId = 0, uri = '/') => {
  if (widgetId > 0) {
    const queryStringId = replaceWidgetId(queryString, widgetId);
    const response = await fetch(uri + queryStringId, {
      headers: {
        'Content-Type': 'application/html; charset=utf-8'
      },
      method: 'GET',
      cache: 'no-cache'
    });

    return response.text();
  }
}

/**
 * @param {string} data
 * @param {number} widgetId
 */
const insertData = (data= '', widgetId = 0) => {
  if (data.length > 0 || widgetId > 0) {
    const widgetSelectorId = replaceWidgetId(widgetSelector, widgetId);
    const target = document.querySelector(widgetSelectorId);

    target.classList.remove(loadingClass);
    target.innerHTML = data;

    // Script tags are not executed with "innerHtml"
    script.load(data);
  }
}

/**
 * @param {object} settings contains id and type
 */
const insertWidgetContainer = (settings) => {
  const container = document.querySelector(widgetsContainerSelector);
  let template = document.querySelector(widgetTemplateSelector).innerHTML;

  template = template.replaceAll('###id###', settings.id);

  container.insertAdjacentHTML('beforeend', template);
}

/**
 * @param {number} widgetId
 */
const addConfigBtn = (widgetId) => {
  const id = replaceWidgetId(configWidgetSelector, widgetId);
  const widgetHeader = document.querySelector(id + ' header');

  let configBtn = document.createElement('button');
  configBtn.classList.add('btn-config');
  widgetHeader.appendChild(configBtn);
}

/**
 * @param {number} widgetId
 */
const listenConfigBtn = (widgetId) => {
  const id = replaceWidgetId(configWidgetSelector, widgetId);
  const configBtn = document.querySelector(id + ' .btn-config');

  configBtn.addEventListener('click', () => toggleConfigModus(widgetId));
}

/**
 * @param {number} widgetId
 */
const toggleConfigModus = (widgetId) => {
  const openWidgetId = replaceWidgetId(widgetSelector, widgetId);
  const configWidget = document.querySelector(openWidgetId);
  configWidget.classList.toggle('widget-configmode');

  const closeId = replaceWidgetId(closeButtonSelector, widgetId);
  const closeButton = document.querySelector(closeId);
  closeButton.classList.toggle('d-none');

  const contentId = replaceWidgetId(widgetContentSelector, widgetId);
  const widgetContent = document.querySelector(contentId);
  widgetContent.classList.toggle('widget-blurred');
}

/**
 * @param {number} widgetId
 */
const listenCloseButton = (widgetId) => {
  const id = replaceWidgetId(closeButtonSelector, widgetId);
  const closeButton = document.querySelector(id);

  closeButton && closeButton.addEventListener('click', () => hideWidget(widgetId));
}

/**
 * @param {number} widgetId
 */
export const hideWidget = (widgetId) => {
  const widgetSelectorId = replaceWidgetId(widgetSelector, widgetId);
  const widget = document.querySelector(widgetSelectorId);

  dashboardController.toggleItem(widgetId);
  utilityAnimation.removeItem(widget);

  updateUserProfile();
}

/**
 * @param {object} settings contains id and type
 */
export const addWidget = (settings) => {
  const uri = getWidgetUri();
  const widgetId = parseInt(settings.id);

  dashboardController.toggleItem(widgetId);
  insertWidgetContainer(settings);
  loadWidget(widgetId, uri)
    .then(data => insertData(data, widgetId))
    .then(() => addConfigBtn(widgetId))
    .then(() => listenConfigBtn(widgetId))
    .then(() => listenCloseButton(widgetId))
    .catch(error => console.error(error));
  updateUserProfile();
}

/**
 * @returns {[]}
 */
const getActiveWidgets = () => {
  const widgets = document.querySelectorAll(widgetsSelector);
  let types = [];

  widgets.length > 0 && widgets.forEach((widget) => {
    if (!widget.dataset.removing) {
      const widgetId = parseInt(widget.dataset.widgetId);
      const widgetSettings = dashboardController.getItemSettings(widgetId);

      types.push(widgetSettings.type);
    }
  });

  return types;
}

const updateUserProfile = () => {
  dashboardRequest.updateWidgets(getPageUid(), getActiveWidgets())
    .then(data => apiMessageStatus.initialize(parseInt(data.code)))
    .catch(error => console.error(error));
}

/**
 * @param {string} string
 * @param {number} widgetId
 * @returns {string}
 */
const replaceWidgetId = (string, widgetId) => string.replace('###widgetId###', widgetId.toString());

/**
 * @returns {string}
 */
const getWidgetUri = () => document.querySelector(widgetsContainerSelector).dataset.uri;

/**
 * @returns {number}
 */
const getPageUid = () => parseInt(document.querySelector(widgetsContainerSelector).dataset.pageUid);
