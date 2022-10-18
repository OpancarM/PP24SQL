$(".deleteFromCart").on("click", function () {
    let productId = $(this).data("id");
    $.ajax({
      url: "/orders/removefromcart/" + productId,
      success: function (result) {
        if (result == "OK") {
          $.ajax({
            url: "/shoppingorder/numberofuniqueproducts/",
            success: function (result) {
              if (result == 0) {
                
                $("#content").load(location.href + " #content>*", "");
              }
            },
          });
          $("#shopping-icon").load(location.href + " #shopping-icon>*", "");
          $("#product" + productId).remove();
          $("#sumTotal").load(location.href + " #sumTotal", "");
        } else {
          alert("Dogodila se greška. Pokusajte ponovo!");
        }
      },
    });
  });