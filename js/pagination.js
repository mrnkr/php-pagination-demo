var currentPage = 1;
var currentFilter = getParameterByName('filter') || '';

/**
 * Requests from api/pagination.php the data for gym members
 * within the page specified. The page number gets ignored
 * when a filter is provided.
 * 
 * As the request is fulfilled put the retreived html inside
 * the element with id pagination_data
 * 
 * @param {number} page - page number to request
 * @param {number} filter - numeric id for the activity all users participate in
 */
function loadData(page = currentPage, filter = currentFilter) {
  currentPage = page;
  currentFilter = filter;

  $.ajax({
    url: 'api/pagination.php?page=' + page + (filter.length ? '&activity_id=' + filter : ''),
    method: 'GET',
    success: function (data) {
      $('#pagination_data').html(data);
    }
  });
}

/**
 * Request the previous page
 */
function previous() {
  if (currentPage > 1)
    loadData(currentPage - 1, currentFilter);
}

/**
 * Request the next page
 * 
 * @param {number} max - last page with content 
 */
function next(max) {
  if (currentPage < max)
    loadData(currentPage + 1, currentFilter);
}

/**
 * Get a query param from the url by name
 * 
 * @param {string} name 
 * @param {string} url 
 * @returns {string} something like url.queryParams.get(name)
 */
function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

/** 
 * As soon as the document is loaded set the currently
 * selected filter to the one provided in query params
 * and request the first page of data
 */
$(document).ready(function () {
  $('select').val(currentFilter);
  loadData();
});

/**
 * Listen to changes in the filter selection.
 * Everytime a new activity is selected navigate to the
 * same page but with a different filter
 */
$('select').change(function (e) {
  if (e.target.value)
    window.location.href = 'admin.php?filter=' + e.target.value;
  else
    window.location.href = 'admin.php';
});
