$("#search")
  .autocomplete({
    source: function (req, res) {
      $.ajax({
        url: "/product/searchproduct/" + req.term,
        success: function (response) {
          
          res(response);
        },
      });
    },
    minLength: 1,
    select: function (event, ui) {
      submitForm(ui.item);
    },
  })
  .autocomplete("instance")._renderItem = function (ul, item) {
  return $("<li>")
    .append("<div>" + item.name + "</div>")
    .appendTo(ul);
};

function submitForm(item) {
    location.replace('/product/index?search='+item.name)
}