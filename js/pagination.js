$(document).ready(function() {
  function loadData(page = 1) {
    $.ajax({
      url: 'https://192.168.1.10/api/pagination.php?page=' + page,
      method: 'GET',
      success: function(data) {
        $('#pagination_data').html(data);
      }
    });
  }

  loadData();
});
