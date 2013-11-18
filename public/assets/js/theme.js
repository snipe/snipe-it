$(function () {

  // navbar notification popups
  $(".notification-dropdown").each(function (index, el) {
    var $el = $(el);
    var $dialog = $el.find(".pop-dialog");
    var $trigger = $el.find(".trigger");
    
    $dialog.click(function (e) {
        e.stopPropagation()
    });
    $dialog.find(".close-icon").click(function (e) {
      e.preventDefault();
      $dialog.removeClass("is-visible");
      $trigger.removeClass("active");
    });
    $("body").click(function () {
      $dialog.removeClass("is-visible");
      $trigger.removeClass("active");
    });

    $trigger.click(function (e) {
      e.preventDefault();
      e.stopPropagation();
      
      // hide all other pop-dialogs
      $(".notification-dropdown .pop-dialog").removeClass("is-visible");
      $(".notification-dropdown .trigger").removeClass("active")

      $dialog.toggleClass("is-visible");
      if ($dialog.hasClass("is-visible")) {
        $(this).addClass("active");
      } else {
        $(this).removeClass("active");
      }
    });
  });


  // skin changer
  $(".skins-nav .skin").click(function (e) {
    e.preventDefault();
    if ($(this).hasClass("selected")) {
      return;
    }
    $(".skins-nav .skin").removeClass("selected");
    $(this).addClass("selected");
    
    if (!$("#skin-file").length) {
      $("head").append('<link rel="stylesheet" type="text/css" id="skin-file" href="">');
    }
    var $skin = $("#skin-file");
    if ($(this).attr("data-file")) {
      $skin.attr("href", $(this).data("file"));
    } else {
      $skin.attr("href", "");
    }

  });


  // sidebar menu dropdown toggle
  $("#dashboard-menu .dropdown-toggle").click(function (e) {
    e.preventDefault();
    var $item = $(this).parent();
    $item.toggleClass("active");
    if ($item.hasClass("active")) {
      $item.find(".submenu").slideDown("fast");
    } else {
      $item.find(".submenu").slideUp("fast");
    }
  });


  // mobile side-menu slide toggler
  var $menu = $("#sidebar-nav");
  $("body").click(function () {
    if ($menu.hasClass("display")) {
      $menu.removeClass("display");
    }
  });
  $menu.click(function(e) {
    e.stopPropagation();
  });
  $("#menu-toggler").click(function (e) {
    e.stopPropagation();    
    $menu.toggleClass("display");    
  });  


	// build all tooltips from data-attributes
	$("[data-toggle='tooltip']").each(function (index, el) {
		$(el).tooltip({
			placement: $(this).data("placement") || 'top'
		});
	});


  // custom uiDropdown element, example can be seen in user-list.html on the 'Filter users' button
	var uiDropdown = new function() {
  	var self;
  	self = this;
  	this.hideDialog = function($el) {
    		return $el.find(".dialog").hide().removeClass("is-visible");
  	};
  	this.showDialog = function($el) {
    		return $el.find(".dialog").show().addClass("is-visible");
  	};
		return this.initialize = function() {
  		$("html").click(function() {
    		$(".ui-dropdown .head").removeClass("active");
      		return self.hideDialog($(".ui-dropdown"));
    		});
    		$(".ui-dropdown .body").click(function(e) {
      		return e.stopPropagation();
    		});
    		return $(".ui-dropdown").each(function(index, el) {
      		return $(el).click(function(e) {
      			e.stopPropagation();
      			$(el).find(".head").toggleClass("active");
      			if ($(el).find(".head").hasClass("active")) {
        			return self.showDialog($(el));
      			} else {
        			return self.hideDialog($(el));
      			}
      		});
    		});
    	};
  	};

    // instantiate new uiDropdown from above to build the plugins
  	new uiDropdown();


  	// toggle all checkboxes from a table when header checkbox is clicked
  	$(".table th input:checkbox").click(function () {
  		$checks = $(this).closest(".table").find("tbody input:checkbox");
  		if ($(this).is(":checked")) {
  			$checks.prop("checked", true);
  		} else {
  			$checks.prop("checked", false);
  		}  		
  	});


});