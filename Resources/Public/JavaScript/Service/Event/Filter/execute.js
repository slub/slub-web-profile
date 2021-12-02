import * as buildFilter from './build.js';

/**
 * @type {string}
 */
const eventListItemSelector = '.js-eventtiles-item';

/**
 * @type {string}
 */
const resultItemHideClass = 'event-filter__tiles-result--hide';

/**
 * @param {object} filter
 */
const executeFilter = (filter) => {
  const chosenId = parseInt(filter.dataset.filterId);
  const eventListItems = document.querySelectorAll(eventListItemSelector);

  activateFilterInList(filter);

  if (eventListItems.length > 0) {
    eventListItems.forEach((eventListItem) => filterItem(eventListItem, chosenId));
  }
}

/**
 * @param {object} resultType
 */
const executeResultType = (resultType) => {
  const chosenId = parseInt(resultType.dataset.filterId);
  const filter = document.querySelector(`[data-filter-id="${chosenId}"]`);

  executeFilter(filter);
}

/**
 * @param {object} activeElement
 */
const activateFilterInList = (activeElement) => {
  const elements = document.querySelectorAll(`.${buildFilter.filterItemClassJs}`);

  if (elements.length > 0) {
    elements.forEach((element) => element.classList.remove(buildFilter.filterItemActiveClass));
    activeElement.classList.add(buildFilter.filterItemActiveClass);
  }
}

/**
 * @param {object} element
 * @param {number} chosenId
 */
const filterItem = (element, chosenId) => {
  const items = element.querySelectorAll(buildFilter.itemsSelector);
  let filterIds = [];

  if (items.length > 0) {
    items.forEach((item) => filterIds = [(parseInt(item.dataset.filterId)), ...filterIds]);
  }

  if (filterIds.includes(chosenId) || chosenId === 0) {
    element.classList.remove(resultItemHideClass);
  } else {
    element.classList.add(resultItemHideClass);
  }
}

export const listenEvents = () => {
  const filterItems = document.querySelectorAll(`.${buildFilter.filterItemClass}`);
  const resultTypes = document.querySelectorAll(buildFilter.itemsSelector);

  filterItems.forEach((filterItem) => {
    filterItem.addEventListener('click', () => executeFilter(filterItem));
  });

  resultTypes.forEach((resultType) => {
    resultType.addEventListener('click', () => executeResultType(resultType));
  });
}
