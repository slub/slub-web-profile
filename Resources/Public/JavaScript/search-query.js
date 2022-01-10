/**
 * @type {Element}
 */
const addSelector = document.querySelector('#js-search-query-add');

if (addSelector) {
  let addSearchQuery = await import('./Service/SearchQuery/add.js');

  addSearchQuery.showAddButton();
  addSearchQuery.listenAddButton();
}
