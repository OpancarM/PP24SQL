$(".addToCart").on("click", function () {
    let productId = $(this).data("id");
    $.ajax({
      url: "/cart/addtocart/" + productId,
      success: function (result) {
        if (result == "OK") {
          // Updates badge icon without refreshing window :D
          $("#shopping-icon").load(location.href + " #shopping-icon>*", "");
          // alert("Proizvod uspješno dodan u košaricu!");
        } else {
          alert(result);
        }
      },
    });
  });