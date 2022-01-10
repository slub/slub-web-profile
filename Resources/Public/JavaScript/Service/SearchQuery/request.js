/**
 * @type {string}
 */
const uriUserAddSearchQuery = '/?tx_slubwebprofile_ajax[userAddSearchQuery]=1';

/**
 * @param {object} data
 * @returns {Promise<any>}
 */
export const addSearchQuery = async (data) => {
console.log(data);
  /*const response = await fetch(uriUserAddSearchQuery, {
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

  return response.json();*/
}
