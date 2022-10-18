$("#search")
  .autocomplete({
    source: function (req, res) {
      $.ajax({
        url: "/customer/searchcustomer/" + req.term,
        success: function (response) {
          
          res(response);
        },
      });
    },
    minLength: 1,
    select: function (event, ui) {
      $(this).val(ui.item.name)
      return false;
    },
  })
  .autocomplete("instance")._renderItem = function (ul, item) {
  return $("<li>")
    .append("<div>" + item.name + "</div>")
    .appendTo(ul);
};


  
  CKEDITOR.replace('message', {
    height: 300,
    baseFloatZIndex: 10005,
    removeButtons: 'PasteFromWord'
  });

  $(function () {
    $('table.table-sort').tablesort();
});