var currentPage = 1;

function loadData(page = 1) {
		currentPage = page;

    $.ajax({
      url: 'api/pagination.php?page=' + page,
      method: 'GET',
      success: function(data) {
        $('#pagination_data').html(data);
      }
    });
}

function previous() {
	if (currentPage > 1)
		loadData(currentPage - 1);
}

function next(max) {
	if (currentPage < max)
		loadData(currentPage + 1);
}

$(document).ready(function() {
  loadData();
});
