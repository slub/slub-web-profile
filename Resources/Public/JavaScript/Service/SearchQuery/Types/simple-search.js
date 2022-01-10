/**
 * @type {string}
 */
const inputSelector = '#main-search-input';

/**
 * @type {string}
 */
const fieldSelector = '#search-in-field-options .search-in-field-option.selected';

/**
 * @returns {array}
 */
export const getQuery = () => {
  const input = getQueryInput();
  let query = [];

  input.length > 0 && query.push({
    field: getQueryField(),
    input: input
  });

  return query;
}

/**
 * @returns {string}
 */
const getQueryInput = () => document.querySelector(inputSelector).value;

/**
 * @returns {string}
 */
const getQueryField = () => document.querySelector(fieldSelector).getAttribute('name');
