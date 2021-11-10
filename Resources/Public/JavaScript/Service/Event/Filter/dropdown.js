import * as buildFilter from './build.js';

/**
 * @type {string}
 */
const eventFilterLabelSelector = '#js-event-filter-label';

/**
 * @type {string}
 */
const filterListShowClass = 'event-filter__list--show';

/**
 * @type {string}
 */
const filterLabelOpenClass = 'event-filter__label--open';

/**
 * @param {object} filterLabel
 */
const executeDropdown = (filterLabel) => {
  const filterList = document.querySelector(`#${buildFilter.filterListId}`);

  filterList.classList.toggle(filterListShowClass);
  filterLabel.classList.toggle(filterLabelOpenClass);
}

export const listenEvents = () => {
  const filterLabel = document.querySelector(eventFilterLabelSelector);

  filterLabel.addEventListener('click', () => executeDropdown(filterLabel));
}
