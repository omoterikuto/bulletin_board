$(function() {
  $('.message-bar').fadeOut(5000);
  var sort = ['desc', 'asc', 'name-desc', 'name-asc']
  $.each(sort,function(index, value) {
    $(`#${value}`).on('click', function() {
    $(`#sort_${value}`).submit();
  });
  });
  $('#my_file').on("change", function() {
    var file = this.files[0];
    if(file != null) {
      $('label[for=my_file]').text(file.name);
    }
  });
});