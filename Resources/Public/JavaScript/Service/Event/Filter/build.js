/**
 * @type {string}
 */
export const filterItemClass = 'event-filter__item';

/**
 * @type {string}
 */
export const filterItemClassJs = 'js-event-filter-item';

/**
 * @type {string}
 */
export const filterItemActiveClass = 'event-filter__item--active';

/**
 * @type {string}
 */
const filterListClass = 'event-filter__list';

/**
 * @type {string}
 */
const filterShowClass = 'event-filter--show';

/**
 * @type {string}
 */
const filterSelector = '#js-event-filter';

/**
 * @type {string}
 */
const listItemCategoryClass = 'event-list-item__category';

/**
 * @type {string}
 */
export const itemsSelector = '[data-filter-id]';

/**
 * @returns {[]}
 */
const prepareFilter = () => {
  const elements = document.querySelectorAll(itemsSelector);
  let items = [];

  if (elements.length > 0) {
    elements.forEach((item) => {
      items = addItem(item, items);
      item.classList.add(listItemCategoryClass);
    });

    items.sort((a, b) => a.title.localeCompare(b.title, undefined, { caseFirst: 'upper' }));
  }

  return items;
}

/**
 * @param {[]} items
 */
const buildFilter = (items) => {
  let filterItems = getFilterItems(items);

  if (filterItems.length > 0) {
    let filterList = document.createElement('ul');
    filterList.classList.add(filterListClass);
    filterList.innerHTML = filterItems;

    let filter = document.querySelector(filterSelector);
    filter.append(filterList);
    filter.classList.add(filterShowClass);
  }
}

/**
 * @param {[]} items
 * @returns {string}
 */
const getFilterItems = (items) => {
  let filterItems = '';

  if (items.length > 0) {
    items.forEach((item) => {
      let cssClass = `${filterItemClassJs} ${filterItemClass}`;

      if (parseInt(item.id) === 0) {
        cssClass += ` ${filterItemActiveClass}`;
      }

      filterItems += `
        <li data-filter-id="${item.id}" class="${cssClass}">
            ${item.title}
        </li>`;
    });
  }

  return filterItems;
}

/**
 * @param {object} itemData
 * @param {array} items
 * @returns {[]}
 */
const addItem = (itemData, items) => {
  const item = {
    'id': itemData.dataset.filterId,
    'title': itemData.innerText
  }

  if (items.some(item => item.id === itemData.dataset.filterId) === false) {
    items = [item, ...items];
  }

  return items;
}

/**
 * @param {array} items
 * @returns {[]}
 */
const addDefaultItem = (items) => {
  const item = {
    'id': '0',
    'title': document.querySelector(filterSelector).dataset.filterReset
  }

  items = [item, ...items];

  return items;
}

export const initialize = () => {
  let items = prepareFilter();
  items = addDefaultItem(items);

  buildFilter(items);
}
