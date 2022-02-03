/**
 * @param {array} data
 * @param {string} fileName
 */
export const create = async (data, fileName) => {
  const csv = data.map(item => item.join(';')).join('\n');
  const csvContent = `data:text/csv;charset=utf-8,%EF%BB%BF ${encodeURI(csv)}`;

  download(csvContent, fileName);
}

/**
 * @param {string} uri
 * @param {string} fileName
 */
const download = (uri, fileName) => {
  const link = document.createElement('a');

  link.setAttribute('href', uri);
  link.setAttribute('download', `${fileName}.csv`);

  document.body.appendChild(link);

  link.click();
}
