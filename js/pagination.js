var currentPage = 1;
var currentFilter = getParameterByName('filter') || '';

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

function previous() {
  if (currentPage > 1)
    loadData(currentPage - 1, currentFilter);
}

function next(max) {
  if (currentPage < max)
    loadData(currentPage + 1, currentFilter);
}

function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

$(document).ready(function () {
  $('select').val(currentFilter);
  loadData();
});

$('select').change(function (e) {
  if (e.target.value)
    window.location.href = 'admin.php?filter=' + e.target.value;
  else
    window.location.href = 'admin.php';
});
