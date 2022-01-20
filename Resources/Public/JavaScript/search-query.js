/**
 * @type {Element}
 */
const addSelector = document.querySelector('#js-search-query-add');

if (addSelector) {
  let initialize = await import('./Service/SearchQuery/Add/initialize.js');
  let process = await import('./Service/SearchQuery/Add/process.js');

  initialize.showAdd();
  initialize.listenAddButton();
  process.listenSubmit();
}
