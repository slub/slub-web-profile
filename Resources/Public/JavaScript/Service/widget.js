import * as script from './script.js'

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
let targetSelector = '#js-widgets-item-###widgetId###'

/**
 * @type {string}
 */
let queryString = '?tx_slubwebprofile_ajax[tt_content]=###widgetId###';

export const initialize = () => {
  const widgets = document.querySelectorAll(widgetsSelector)

  if (widgets.length > 0) {
    widgets.forEach((widget) => {
      const widgetId = parseInt(widget.dataset.widget);
      const uri = widget.dataset.uri;

      loadData(widgetId, uri)
        .then(data => insertData(data, widgetId))
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
const loadData = async (widgetId = 0, uri = '/') => {
  if (widgetId > 0) {
    const response = await fetch(uri + queryString.replace('###widgetId###', widgetId.toString()), {
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
    const id = targetSelector.replace('###widgetId###', widgetId.toString());
    const target = document.querySelector(id);

    target.classList.remove(loadingClass);
    target.innerHTML = data;

    // Script tags are not executed with "innerHtml"
    script.load(data);
  }
}
