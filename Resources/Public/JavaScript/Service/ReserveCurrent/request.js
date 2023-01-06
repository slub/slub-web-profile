
/**
 * @type {string}
 */
const uriUserReserveCurrent = '/?tx_slubwebprofile_ajax[userReserveCurrent]=1';

/**
 * @param {object} data
 * @returns {Promise<any>}
 */
export const deleteReserveCurrent = async (data) => {
    const response = await fetch(uriUserReserveCurrent, {
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
        },
        method: 'POST',
        cache: 'no-cache',
        body: JSON.stringify({
            data: data,
            action: 'delete'
        })
    });

    return response.json();
}



