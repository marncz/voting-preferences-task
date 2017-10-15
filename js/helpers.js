window.onload = function () {

  $(("input:radio[name=is_going_to_vote]")).change(function() {
    var radio_value = $(this).val();

    if (radio_value == "no") {
      $("#vote_for_block").hide();
    } else if (radio_value == "yes") {
      $("#vote_for_block").show();
    }
  });

}
