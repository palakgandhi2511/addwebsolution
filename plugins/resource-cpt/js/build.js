jQuery(window).ready(function () {
  var type = "",
    topic = "",
    input = "";
  var get_resources_data = function i(type, topic, input) {
    jQuery.ajax({
      type: "post",
      url: ajaxObj.ajax_url,
      data: {
        action: "get_resources_data",
        input: input,
        type: type,
        topic: topic,
      },
      success: function (response) {
        jQuery(document).find(".block-list").html(response);
      },
    });
  };
  jQuery(document).on(
    "keyup",
    '.form-search input[name="search"]',
    function () {
      input = jQuery(this).val();
        get_resources_data(type, topic, input);
    }
  );
  jQuery(document).on(
    "change",
    ".selectdiv select[name='resource_type'],.selectdiv select[name='resource_topic']",
    function () {
      if (jQuery(this).attr("name") == "resource_type") {
        type = jQuery(this).val();
      } else {
        topic = jQuery(this).val();
      }
      get_resources_data(type, topic, input);
    }
  );
});

equalheight = function (container) {
  var currentTallest = 0,
    currentRowStart = 0,
    rowDivs = new Array(),
    $el,
    topPosition = 0;
  jQuery(container).each(function () {
    $el = jQuery(this);
    jQuery($el).height("auto");
    topPostion = $el.position().top;

    if (currentRowStart != topPostion) {
      for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
        rowDivs[currentDiv].height(currentTallest);
      }
      rowDivs.length = 0; // empty the array
      currentRowStart = topPostion;
      currentTallest = $el.height();
      rowDivs.push($el);
    } else {
      rowDivs.push($el);
      currentTallest =
        currentTallest < $el.height() ? $el.height() : currentTallest;
    }
    for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
      rowDivs[currentDiv].height(currentTallest);
    }
  });
};

jQuery(window).load(function () {
  equalheight("ul .block-list__item");
});

jQuery(window).resize(function () {
  equalheight("ul .block-list__item");
});
