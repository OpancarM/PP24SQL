$(".addToCart").on("click", function () {
    let productId = $(this).data("id");
    $.ajax({
      url: "/orders/addToCart/" + productId,
      success: function (result) {
        if (result == "OK") {
          $("#shopping-icon").load(location.href + " #shopping-icon>*", "");
        } else {
          alert(result);
        }
      },
    });
  });