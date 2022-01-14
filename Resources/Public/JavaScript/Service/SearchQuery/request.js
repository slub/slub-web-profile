/**
 * @type {string}
 */
const uriUserSearchQuery = '/?tx_slubwebprofile_ajax[userSearchQuery]=1';

/**
 * @param {object} data
 * @returns {Promise<any>}
 */
export const addSearchQuery = async (data) => {
  const response = await fetch(uriUserSearchQuery, {
    headers: {
      'Content-Type': 'application/json; charset=utf-8'
    },
    method: 'POST',
    cache: 'no-cache',
    body: JSON.stringify({
      data: data,
      action: 'add'
    })
  });

  return response.json();
}
