// Get Finalized Order details
$(".modal").on("click", function () {
  let orderId = $(this).data("id");
  $.ajax({
    url: "/order/getFinalizedDetails/" + orderId,
    success: function (response, result) {
      if (result == "success") {
        $("#modal" + orderId).foundation('open');
        let array = JSON.parse(response);
        let sum = 0;
        for (var i = 0; i < array.length; i++) {
          
          sum += parseFloat(array[i].price);
          $("<tr>")
            .append("<td>" + array[i].name + "</td>")
            .append("<td class=\"text-center\">" + array[i].quantity + "</td>")
            .append("<td>" + numeral(array[i].productPrice).format('0,0.00') + " kn</td>")
            .append("<td>" + numeral(array[i].price).format('0,0.00') + " kn</td>")
            .appendTo("#order" + orderId);
        }
        let total = sum;
        var formattedTotal = numeral(total).format('0,0.00');
        $("<span>").append('Sveukupuno: ' + formattedTotal + ' kn').appendTo("#sum" + orderId);
      } else {
        alert("Dogodila se greška. Pokusajte ponovo!");
      }
    },
  });
});

// Cleaning values from modal when closing
(function ($, window, undefined) {
    'use strict';
  
    $('[data-reveal]').on('closed.zf.reveal', function () {
      var modal = $(this);
      $(".order").empty();
      $(".sum").empty();
    });
  
    $(document).foundation();
  
  
  })(jQuery, this);