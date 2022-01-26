import * as addInitialize from './initialize.js';
import * as messageStatus from '../../Message/status.js';
import * as searchQueryRequest from '../request.js';

/**
 * @type {string}
 */
const submitSelector = '#js-search-query-add-submit';

/**
 * @type {string}
 */
const descriptionSelector = '#js-search-query-add-description';

/**
 * @type {string}
 */
const searchTypeSelector = '#search-modifier-group .search-modifier.active';

/**
 * @type {HTMLObjectElement|Element}
 */
const submitElement = document.querySelector(submitSelector);

/**
 * @type {HTMLObjectElement|Element}
 */
const descriptionElement = document.querySelector(descriptionSelector);

/**
 * @type {({identifier: string, type: string}|{identifier: string, type: string})[]}
 */
const searchTypes = [
  {
    type: 'simple',
    identifier: 'catalog'
  },
  {
    type: 'extended',
    identifier: 'extendedsearch'
  }
];

export const listenSubmit = () => submitElement.addEventListener('click', () => addSearchQuery());

const addSearchQuery = async () => {
  const searchType = getSearchType();
  const query = await getQuery(searchType) ?? [];
  const searchQuery = {
    type: searchType,
    query: query,
    numberOfResults: getNumberOfResults() ?? 0,
    description: getDescription() ?? ''
  };

  addInitialize.hideAddResult();

  if (query.length === 0) {
    await messageStatus.initialize(501);
  } else {
    searchQueryRequest.addSearchQuery(searchQuery)
      .then(data => messageStatus.initialize(parseInt(data.code)))
      .catch(error => console.error(error));
  }
}

/**
 * @returns {string}
 */
const getDescription = () => descriptionElement.value;

/**
 * @returns {number}
 */
const getNumberOfResults = () => parseInt(submitElement.dataset.resultCount);

/**
 * @param {string} searchType
 * @returns []
 */
const getQuery = async (searchType) => {
  const search = await import(`./Types/${searchType}-search.js`);

  return search.getQuery();
}

/**
 * @returns {string|undefined}
 */
const getSearchType = () => {
  // Read here because it can change between initialization and process
  const searchTypeElement = document.querySelector(searchTypeSelector);
  let currentSearchType = {};

  searchTypes.forEach((searchType) => {
    if (searchTypeElement.classList.contains(searchType.identifier)) {
      currentSearchType = searchType;
    }
  });

  return currentSearchType.type;
}
