import * as calendar from './Vendor/calendar.js'

/**
 * @type {HTMLElement}
 */
const calendarElement = document.querySelector('#js-widget-event-teaser-calendar');

/**
 * @type {string}
 */
const language = calendarElement.dataset.language;

/**
 * @type {Object}
 */
let translation = {
  'de-DE': {
    'weekDays': ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'],
    'months': ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember']
  },
  'default': {
    'weekDays': ['Mon', 'Due', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    'months': ['January', 'February', 'March', 'April', 'Mai', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
  }
};

/**
 * @param {string} identifier
 * @returns {string[]|*}
 */
const getTranslation = (identifier) => {
  if (translation[identifier] === undefined) {
    identifier = 'default';
  }

  return translation[identifier]
}

new Calendar({
  id: '#js-widget-event-teaser-calendar',
  calendarSize: 'small',
  customMonthValues: getTranslation(language).months,
  customWeekdayValues: getTranslation(language).weekDays,
  eventsData: widgetEventTeaserCalendar
});
