/**
 * @type {number}
 */
const countFieldSets = 4;

/**
 * @type {string}
 */
const inputSelector = '#extended-search-input-###fieldSetId###';

/**
 * @type {string}
 */
const fieldSelector = '#extended-search-select-###fieldSetId###';

/**
 * @returns {*[]}
 */
export const getQuery = () => {
  let query = [];

  for (let i = 0; i < countFieldSets; i++) {
    const input = getQueryInput(replaceFieldSetId(inputSelector, i));

    input.length > 0 && query.push({
      field: getQueryField(replaceFieldSetId(fieldSelector, i)),
      input: input
    });
  }

  return query;
}

/**
 * @param {string} selector
 * @returns {string}
 */
const getQueryInput = (selector) => document.querySelector(selector).value;

/**
 * @param {string} selector
 * @returns {string}
 */
const getQueryField = (selector) => {
  const field = document.querySelector(selector);

  return field.options[field.selectedIndex].getAttribute('name');
}

/**
 * @param {string} string
 * @param {number} fieldSetId
 * @returns {string}
 */
const replaceFieldSetId = (string, fieldSetId) => string.replace('###fieldSetId###', fieldSetId.toString());
