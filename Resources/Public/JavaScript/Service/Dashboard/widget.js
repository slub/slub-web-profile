import * as script from '../../Utility/script.js'
import * as controller from './controller.js'

/**
 * @type {string}
 */
const loadingClass = 'js-widgets-loading';

/**
 * @type {string}
 */
const widgetsSelector = '#js-dashboard-widgets > .js-widgets-item';

/**
 * @type {string}
 */
let widgetSelector = '#js-widgets-item-###widgetId###'

/**
 * @type {string}
 */
const closeButtonSelector = '#js-widget-close-button-###widgetId###';

/**
 * @type {string}
 */
let queryString = '?tx_slubwebprofile_ajax[tt_content]=###widgetId###';

export const initialize = () => {
  const widgets = document.querySelectorAll(widgetsSelector);

  if (widgets.length > 0) {
    widgets.forEach((widget) => {
      const widgetId = parseInt(widget.dataset.widget);
      const uri = widget.dataset.uri;

      loadWidget(widgetId, uri)
        .then(data => insertData(data, widgetId))
        .then(() => listenCloseButton(widgetId))
        .catch(error => console.error(error));
    });
  }
}

/**
 *
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
 * @param {number} widgetId
 */
const listenCloseButton = (widgetId) => {
  const id = replaceWidgetId(closeButtonSelector, widgetId);
  const closeButton = document.querySelector(id);

  if (closeButton) {
    closeButton.addEventListener('click', () => hideWidget(widgetId));
  }
}

/**
 * @param {number} widgetId
 */
const hideWidget = (widgetId) => {
  const widgetSelectorId = replaceWidgetId(widgetSelector, widgetId);
  const widget = document.querySelector(widgetSelectorId);

  removeWidget(widget);
console.log(getActiveWidgets());
  // call Service/user.js -> updateDashboardSettings()
  // give the active widgets or call the function getActiveWidgets from there
}

const getActiveWidgets = () => {
  const widgets = document.querySelectorAll(widgetsSelector);
  let types = [];

  widgets.length > 0 && widgets.forEach((widget) => !widget.dataset.removing && types.push(widget.dataset.type));

  return types;
}

/**
 * @param {string} string
 * @param {number} widgetId
 * @return {string}
 */
const replaceWidgetId = (string, widgetId) => string.replace('###widgetId###', widgetId.toString());

/**
 * @param {HTMLObjectElement|Element} widget
 * @param {number} opacity
 */
const removeWidget = (widget, opacity= 1) => {
  if (opacity === 1) {
    controller.hideItem(parseInt(widget.dataset.widget));
    widget.setAttribute('data-removing', '1');
  }

  widget.style.opacity < 0 && widget.remove();

  setTimeout(() => {
    opacity -= 0.1;
    widget.style.opacity = opacity.toString();

    removeWidget(widget, opacity);
  }, 50);
}
