"use strict";

function _typeof2(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof2 = function _typeof2(obj) { return typeof obj; }; } else { _typeof2 = function _typeof2(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof2(obj); }

function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    _typeof = function _typeof(obj) {
      return typeof obj;
    };
  } else {
    _typeof = function _typeof(obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}
/**
 *	Custom jQuery Scripts
 *	
 *	Developed by: Lisa DeBona
 */


jQuery(document).ready(function ($) {
  $("select#diff").change(function () {
    var diffResult = $(this).val();
    $('ul.items').find('li.show').removeClass('show');
    $('ul.items').find('li').addClass('hide');

    if (diffResult == '.advanced') {
      $('ul.items').find(diffResult).removeClass('hide');
      $('ul.items').find(diffResult).addClass('show');
    }

    if (diffResult == '.intermediate') {
      $('ul.items').find(diffResult).removeClass('hide');
      $('ul.items').find(diffResult).addClass('show');
    }

    if (diffResult == '.beginner') {
      $('ul.items').find(diffResult).removeClass('hide');
      $('ul.items').find(diffResult).addClass('show');
    }

    if (diffResult == '.all') {
      $('ul.items').find('li.hide').removeClass('hide');
      $('ul.items').find('li').addClass('show');
    }

    if ($(".hide-on-load").hasClass("hide")) {
      $('.hide-on-load').removeClass('hide');
      $('.hide-on-load').addClass('show');
    }
  });
  $("#selectByProgram").change(function () {
    if ($(".hide-on-load").hasClass("hide")) {
      $('.sch-prompt').addClass('hide');
      $('.hide-on-load').removeClass('hide');
      $('.hide-on-load').addClass('show');
      $(".diff-filter-wrap").removeClass('hide');
      $(".diff-filter-wrap").addClass('show');
      $("#fi").find('.select2-container--default').removeAttr("style");
      $("#fi").find('.select2-container--default').addClass("show");
    }
  });
  /* NAVIGATION */

  $(".menu-toggle").on("click", function (e) {
    e.preventDefault();
    $("body").addClass("nav-open");
    $("#site-navigation").addClass("open");
  });
  $("#closeNav,#overlay").on("click", function (e) {
    e.preventDefault();
    $("body").removeClass("nav-open");
    $("#site-navigation").removeClass("open");
    $("#site-navigation *").removeClass("open");
    $("#site-navigation li.parent-link").removeClass("active");
    $("#site-navigation").removeClass("child-open");
  });
  $("#closeNavChild").on("click", function (e) {
    e.preventDefault();
    $("#childrenNavs").removeClass("open");
    $(".children-group").removeClass("open");
    $("#site-navigation li.parent-link").removeClass("active");
    $("#site-navigation").removeClass("child-open");
  });
  $(document).on("click", ".navigation .has-children a.parentlink", function (e) {
    e.preventDefault();
    var link = $(this).attr("href");

    if (link == '#') {
      var child_menu = $(this).attr("data-parent");
      $("#site-navigation li.parent-link").removeClass("active");
      $(".children-group").removeClass("open");

      if ($(".children-group" + child_menu).length > 0) {
        $("#site-navigation").addClass("child-open");
        $("#childrenNavs").addClass("open");
        $(".children-group" + child_menu).addClass("open");
        $(this).addClass("active");
        $(this).parents("li").addClass('active');
      }
    }
  });
  $('[data-fancybox]').fancybox({
    touch: true,
    hash: false,
    youtube: {
      controls: 0,
      showinfo: 0,
      rel: 0
    },
    vimeo: {
      color: 'ffffff'
    }
  });
  $('.zoom-image').fancybox({
    buttons: ['fullScreen', 'close'],
    hash: false
  });
  $("a#inline").fancybox({
    'hideOnContentClick': true
  }); // Reviews

  (function () {
    // store the slider in a local variable
    var $window = $(window),
        flexslider = {
      vars: {}
    }; // tiny helper function to add breakpoints

    function getGridSize() {
      return window.innerWidth < 600 ? 1 : window.innerWidth < 900 ? 3 : 3;
    }

    $(function () {
      SyntaxHighlighter.all();
    });
    $window.load(function () {
      $('.reviews').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 210,
        itemMargin: 25,
        minItems: getGridSize(),
        // use function to pull in initial value
        maxItems: getGridSize() // use function to pull in initial value

      });
    }); // check grid size on resize event

    $window.resize(function () {
      var gridSize = getGridSize();
      flexslider.vars.minItems = gridSize;
      flexslider.vars.maxItems = gridSize;
    });
  })(); // End reviews


  $("div.read-review").click(function () {
    $(this).parent().toggleClass("open");
  });
  var windowHeight = $(window).scrollTop();

  if (windowHeight > 200) {
    $("body").addClass('scrolled');
  }

  $(window).scroll(function () {
    var wHeight = $(window).scrollTop();

    if (wHeight > 200) {
      $("body").addClass('scrolled');
    } else {
      $("body").removeClass('scrolled'); //$('body').removeClass('subnav-clicked');
    }
  });

  if ($("#banner").length > 0 && $("#pageTabs").length > 0) {
    $(window).scroll(function () {
      var tabsHeight = $("#pageTabs").height();

      if ($(".main-description").length > 0) {
        var main = $(".main-description").height();
        tabsHeight = main;
      }

      var bannerHeight = $("#banner").height();
      var screenOffset = bannerHeight + tabsHeight;
      var wHeight = $(window).scrollTop();

      if (wHeight > screenOffset) {
        $("#pageTabs").addClass('fixed-top');
      } else {
        $("#pageTabs").removeClass('fixed-top');
      }
    });
  } // if( $(".subpage-sliders").length > 0 ) {
  // 	$('.subpage-sliders').flexslider({
  // 		animation: "fade",
  // 		smoothHeight: true
  // 	});
  // }


  if ($(".video__vimeo").length > 0) {
    $(".video__vimeo").each(function () {
      var target = $(this);
      var vimeoURL = $(this).attr("data-url");
      var apiURL = 'https://vimeo.com/api/oembed.json?url=' + vimeoURL;
      $.get(apiURL, function (data) {
        var thumbnail = data.thumbnail_url;
        target.css("background-image", "url('" + thumbnail + "')");
      });
    });
  }

  var is_video_playing = false;
  var $slides = $('.flexslider .slides li');

  if ($slides.length > 0) {
    $slides.eq(1).add($slides.eq(-1)).find('img.lazy').each(function () {
      var src = $(this).attr('data-src');
      $(this).removeClass('lazy');
      $(this).attr('src', src).removeAttr('data-src');
    });
  }

  var slideShow = $('.flexslider').flexslider({
    animation: "fade",
    smoothHeight: true,
    before: function before(slider) {
      var $slides = $(slider.slides),
          index = slider.animatingTo,
          current = index,
          nxt_slide = current + 1,
          prev_slide = current - 1;

      if ($slides.length > 0) {
        $slides.eq(current).add($slides.eq(nxt_slide)).add($slides.eq(prev_slide)).find('img.lazy').each(function () {
          var src = $(this).attr('data-src');
          $(this).removeClass('lazy');
          $(this).attr('src', src).removeAttr('data-src');
        });

        if ($slides.eq(current).find('.videoIframe').length > 0) {
          $(".videoIframeDiv").removeClass("playing");
          $(".videoIframe").hide();
          $("body").addClass("current-slide-is-video");
        } else {
          $("body").removeClass("current-slide-is-video");
        }
      }
    },
    start: function start(slider) {
      var $slides = $(slider.slides);

      if ($slides.length > 0) {
        play_flexslider_video(slider);
      }
    }
  });
  $(document).on("click", ".flex-next, .flex-prev", function (e) {
    e.preventDefault();

    if ($("iframe.videoIframe").length > 0) {
      $("iframe.videoIframe").each(function () {
        var type = $(this).attr("data-vid");

        if (type == 'youtube') {
          var parent = $(this).parents(".videoIframeDiv");
          var embedURL = parent.find(".playVidBtn").attr("data-embed");

          if (e.target.outerText == 'Next') {
            $(this).attr("src", embedURL);
          }
        } else if (type == 'vimeo') {
          var iframe = $(this)[0];
          var player = new Vimeo.Player(iframe);
          player.pause();
        }
      });
    }
  });

  function play_flexslider_video(slider) {
    $(document).on("click", ".playVidBtn", function (e) {
      e.preventDefault();
      var type = $(this).attr("data-type");
      var parent = $(this).parents(".videoIframeDiv");

      if (type == 'youtube') {
        var iframeSRC = $(this).attr("data-embed");
        parent.find("iframe.videoIframe")[0].src += "&autoplay=1"; //parent.find("iframe.videoIframe").attr("src",iframeSRC+"&autoplay=1");

        parent.addClass("playing");
        parent.find("iframe.videoIframe").fadeIn();
        is_video_playing = true;
        slider.stop();
      } else if (type == 'vimeo') {
        var iframe = parent.find("iframe.videoIframe")[0];
        var player = new Vimeo.Player(iframe);
        parent.addClass("playing");
        parent.find("iframe.videoIframe").fadeIn();
        player.play();
        slider.stop();
      }
    });
  }

  $(document).on('click', function (e) {
    var tag = $(this);
    var exceptions = ['todayToggle', 'todayLink', 'todayTxt', 'today-options'];
    var elementId = e.target.id;
    var is_open = false;

    if (elementId == 'today-options') {
      $(".topinfo .today").addClass("open");
    } else {
      if ($.inArray(elementId, exceptions) != -1) {
        if ($(".topinfo .today").hasClass("open")) {
          $(".topinfo .today").removeClass("open");
        } else {
          $(".topinfo .today").addClass("open");
        }
      } else {
        $(".topinfo .today").removeClass("open");
      }
    }
  });
  $('a[href*="#"]:not([href="#"])').click(function () {
    var headHeight = $("#masthead").height();
    var offset = headHeight + 80;

    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top - offset
        }, 1000);
        return false;
      }
    }
  });
  /* Load More */

  $(document).on("click", "#loadMoreBtn", function (event) {
    event.preventDefault();
    var loadButton = $(this);
    var pageURL = _typeof2($("a.page-numbers").eq(0)) != undefined ? $("a.page-numbers").attr("href") : '';
    var current_page = $(this).attr("data-current");
    var next_page = parseInt(current_page) + 1;
    var last_page = $(this).attr("data-end");

    if (pageURL) {
      var parts = pageURL.split("pg=");
      var num = parts[1];
      var url = pageURL.replace('pg=' + num, 'pg=' + next_page);
      loadButton.attr("data-current", next_page);
      $(".next-posts").load(url + " .posts-inner .flex-inner", function () {
        var htmlContent = $(".next-posts .flex-inner").html();
        $("#data-container .flex-inner").append(htmlContent);
        $(".next-posts").html("");

        if (next_page == last_page) {
          $(".loadmorediv").html('').hide();
        }
      });
    }
  });
  $('#playYoutube').on('click', function (ev) {
    $(this).hide();
    $(".videoIframeDiv").addClass('play_video');
    $(".videoIframe")[0].src += "&autoplay=1";
    $("#banner").addClass("video-playing");
    ev.preventDefault();
  });
  $('.select-single').select2();
  /*
  *
  *	Wow Animation
  *
  ------------------------------------*/

  new WOW().init();
  $('.js-blocks').matchHeight();
  $('.js-title').matchHeight();
  $(document).on("click", "#toggleMenu", function () {
    $(this).toggleClass('open');
    $('body').toggleClass('open-mobile-menu');
  });
  /* Search Form (Header) */

  $(document).on("click", "#topsearchBtn", function (e) {
    e.preventDefault();
    $("#topSearchBar form").submit();
  });
  $(document).on("click", "#searchHereBtn", function (e) {
    e.preventDefault();
    $(this).toggleClass('search-open');
    $('#topSearchBar').toggleClass('show');
    $('body').toggleClass('search-form-open');
    $("input.search-field").focus();
  });
  $(document).on("click", "#closeTopSearch", function (e) {
    e.preventDefault();
    $('#searchHereBtn').removeClass('search-open');
    $('#topSearchBar').removeClass('show');
    $('body').removeClass('search-form-open'); //$("input.search-field").val("");
  });
  /* Footer Subscribe Form */

  $('#footSubscribeForm input[type="email"]').on("focus", function () {
    $("#footSubscribeForm").addClass('input-focus');
  });
  $('#footSubscribeForm input[type="email"]').on("focusout blur", function () {
    $("#footSubscribeForm").removeClass('input-focus');
  });
  /* Ajax Load More */

  $(document).on("click", "#loadMoreBtn2", function (e) {
    e.preventDefault();
    var moreButton = $(this);
    var target = $(this);
    var perpage = target.attr("data-perpage");
    var posttype = target.attr("data-posttype");
    var paged = target.attr("data-page");
    var base_url = target.attr("data-baseurl");
    var next_page = parseInt(paged) + 1;
    var total_pages = target.attr("data-totalpages");
    var total = parseInt(total_pages);
    target.attr("data-page", next_page);
    var pageURL = currentURL + '?pg=' + paged;
    $("#tempContainer").load(pageURL + " #postLists", function () {
      if ($("#tempContainer #postLists").length > 0) {
        var entries = $("#tempContainer #postLists").html();
        $(".wait").show();
        setTimeout(function () {
          $(entries).appendTo(".archive-posts-wrap #postLists");
          $(".wait").hide();
        }, 600);

        if (next_page > total) {
          moreButton.hide();
        }
      } else {
        moreButton.hide();
      }
    });
  });
  /* Ajax Load More */

  $(document).on("click", "#loadMoreBtn3", function (e) {
    e.preventDefault();
    var moreButton = $(this);
    var target = $(this);
    var perpage = target.attr("data-perpage");
    var posttype = target.attr("data-posttype");
    var paged = target.attr("data-page");
    var base_url = target.attr("data-baseurl");
    var next_page = parseInt(paged) + 1;
    var total_pages = target.attr("data-totalpages");
    var total = parseInt(total_pages);
    target.attr("data-page", next_page);
    var url = window.location.href;
    var countparams = url.split("=");
    var newURL = currentURL + '?pg=' + paged;
    var nextURL = currentURL + '?pg=' + next_page;

    if (countparams.length > 1) {
      var str = url.replace(currentURL, '');
      newURL += str.replace('?', '&');
      nextURL += str.replace('?', '&');
    }

    $("#tempContainer").load(newURL + " #postLists", function () {
      if ($("#tempContainer #postLists").length > 0) {
        var entries = $("#tempContainer #postLists").html();
        $(".wait").show();
        setTimeout(function () {
          $(entries).appendTo(".archive-posts-wrap #postLists");
          $(".wait").hide();
        }, 500);

        if (paged >= total) {
          moreButton.hide();
        }
      }
    });
    /* Hide More Button if end of records */

    $("#tempNext").load(nextURL + " #postLists", function () {
      if ($("#tempNext #postLists").length == 0) {
        moreButton.hide();
      }
    });
  });
  $(document).on("change", "select.facetwp-dropdown", function () {
    var opt = $(this).val();

    if ($(".morebuttondiv").length > 0) {
      $(".morebuttondiv").load(currentURL + " .moreBtnSpan", function () {});
    }
  });

  if ($("#filter-form").length > 0) {
    $(document).on("change", ".select-filter", function (e) {
      e.preventDefault();
      var opt = $(this).val();
      var name_sel_att = $(this).attr("name");
      var url = $("input#baseurl_input").val();
      var params = '';
      var n = 1;
      $(".select-filter").each(function () {
        var nameAtt = $(this).attr("name");
        var delimiter = n == 1 ? '?' : '&';
        var val = $(this).find("option:selected").val();
        params += delimiter + nameAtt + "=" + val;
        n++;
      });
      var base_url = url + params;
      $("#loaderDiv").addClass("show");
      $("#load-post-div").load(base_url + " #load-data-div", function () {
        $('.select-single').select2();
        setTimeout(function () {
          $("#loaderDiv").removeClass("show");
        }, 600);
      });
    });
  }
  /* Align Bottom Page Vertically Center */


  if ($(".explore-other-stuff").length > 0) {
    var totalEntries = $(".explore-other-stuff .entry").length;
    $(".explore-other-stuff .post-type-entries").addClass('column-list-' + totalEntries);
  }
  /* Ajax Load More */


  $('a[href*="#"]:not([href="#"])').click(function () {
    var headHeight = $("#masthead").height();
    var offset = headHeight + 80;

    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top - offset
        }, 1000);
        return false;
      }
    }
  });

  if (typeof params.pid != 'undefined' && params.pid != null) {
    if ($(".faqpid-" + params.pid).length > 0) {
      view_faqs_info(params.pid);
    }
  }

  $(document).on("click", ".faqGroup", function (e) {
    e.preventDefault();
    $(".faqGroup").removeClass('active');
    var postid = $(this).attr("data-id");
    $(this).addClass('active');
    view_faqs_info(postid);
  });

  function view_faqs_info(postid) {
    var headHeight = $("#masthead").height();
    var offset = headHeight + 80;
    var target = $("#faqItems");
    target.show();
    $('html, body').animate({
      scrollTop: target.offset().top - offset
    }, 1000);
    $.ajax({
      url: frontajax.ajaxurl,
      type: 'post',
      dataType: "json",
      data: {
        action: 'get_faq_group',
        post_id: postid
      },
      beforeSend: function beforeSend() {
        $("#loaderDiv").appendTo(".main-faq-items");
        $("#loaderDiv").show();
      },
      success: function success(obj) {
        if (obj.result) {
          $("#faqsContainer").html(obj.result);
          setTimeout(function () {
            $("#loaderDiv").hide();
          }, 500);
          var newURL = currentURL + '?pid=' + postid;
          history.replaceState('', document.title, newURL);
        }
      },
      error: function error() {
        $("#loaderDiv").hide();
      }
    });
  }
  /* More FAQs */


  $(document).on("click", ".morefaqsBtn", function (e) {
    e.preventDefault();
    var morefaqs = $(".morefaqs");
    morefaqs.hide();
    $(".faq-item").each(function () {
      if ($(this).hasClass('hide-faq')) {
        $(this).removeClass('hide-faq').addClass("animated fadeIn");
      }
    });
  });
  /* Load More Entries:
  	 - Race Series 
  */

  $(document).on("click", "#loadMoreEntries", function (e) {
    e.preventDefault();
    var d = new Date();
    var current = $(this).attr('data-current');
    var next = parseInt(current) + 1;
    var totalPages = $(this).attr('data-total-pages');
    $(this).attr('data-current', next);

    if ($("#pagination a.page-numbers").length > 0) {
      var baseURL = $("#pagination a.page-numbers").eq(0).attr("href");
      var parts = baseURL.split("pg=");
      var newURL = parts[0] + 'pg=' + next;
      var nxt = next + 1;
      $("#loaderDiv").show();
      $(".next-posts").load(newURL + " .result", function () {
        var content = $(".next-posts").html();
        $('.next-posts .postbox').addClass("animated fadeIn").appendTo("#data-container .result");
        setTimeout(function () {
          $("#loaderDiv").hide();
        }, 500);
      });

      if (next == totalPages) {
        $(".loadmorediv").hide();
      }
    }
  });
  $(".js-select2").select2({
    closeOnSelect: false,
    placeholder: "Select...",
    allowHtml: true,
    allowClear: true,
    tags: true
  });
  $(document).on("click", ".select2-selection--multiple", function (e) {
    var selectdiv = $(".customselectdiv").innerWidth();
    var w = selectdiv + 2;
    $(".select2-container--default").css("width", w + "px");
  });
  /* Smooth Scrolling */

  $('a[href*="#"]') // Remove links that don't actually link to anything
  .not('[href="#"]').not('[href="#0"]').click(function (event) {
    // On-page links
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']'); // Does a scroll target exist?

      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function () {
          // Callback after animation
          // Must change focus!
          var $target = $(target); //$target.focus();

          if ($target.is(":focus")) {
            // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
            //$target.focus(); // Set focus again
          }

          ;
        });
      }
    }
  });

  Isotope.Item.prototype._create = function () {
    // assign id, used for original-order sorting
    this.id = this.layout.itemGUID++; // transition objects

    this._transn = {
      ingProperties: {},
      clean: {},
      onEnd: {}
    };
    this.sortData = {};
  };

  Isotope.Item.prototype.layoutPosition = function () {
    this.emitEvent('layout', [this]);
  };

  Isotope.prototype.arrange = function (opts) {
    // set any options pass
    this.option(opts);

    this._getIsInstant(); // just filter


    this.filteredItems = this._filter(this.items); // flag for initalized

    this._isLayoutInited = true;
  }; // layout mode that does not position items


  Isotope.LayoutMode.create('none'); // --------------- //
  // init Isotope

  var $grid = $('.employment-grid').isotope({
    itemSelector: '.joblist',
    layoutMode: 'none'
  }); // filter functions
  // bind filter button click

  $('.filters-select').on('change', function () {
    // get filter value from option value
    var filterValue = this.value; // use filterFn if matches value

    filterValue = filterValue;
    $grid.isotope({
      filter: filterValue
    });
  }); // change is-checked class on buttons

  $('.button-group').each(function (i, buttonGroup) {
    var $buttonGroup = $(buttonGroup);
    $buttonGroup.on('click', 'button', function () {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      $(this).addClass('is-checked');
    });
  });
  $('.filters-select-dept').on('change', function () {
    // get filter value from option value
    var filterValue = this.value;
    $('.job-group').removeClass('show-dept');
    $('.' + filterValue).addClass('show-dept');
    setTimeout(function () {
      // alert('layout');
      $grid.isotope('layout');
    }, 1000);
  });
  $('.button-group').each(function (i, buttonGroup) {
    var $buttonGroup = $(buttonGroup);
    $buttonGroup.on('click', 'button', function () {
      $grid.isotope({
        filter: filterValue
      });
    });
  }); // flatten object by concatting values

  function concatValues(obj) {
    var value = '';

    for (var prop in obj) {
      value += obj[prop];
    }

    return value;
  }

  $grid.on('arrangeComplete', function (event, filteredItems) {
    var resultCount = filteredItems.length;

    if (resultCount == 0) {
      //$grid.html("Sorry.No result for these two choices. Please select anothter category.");
      // alert('none');
      $('.message-div').removeClass('noshow');
      $('.message-div').addClass('show');
    } else {
      $('.message-div').addClass('noshow');
      $('.message-div').removeClass('show');
    }
  });
}); // END #####################################    END
"use strict";

function _typeof2(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof2 = function _typeof2(obj) { return typeof obj; }; } else { _typeof2 = function _typeof2(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof2(obj); }

function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    _typeof = function _typeof(obj) {
      return typeof obj;
    };
  } else {
    _typeof = function _typeof(obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}
/**
 *	Custom jQuery Scripts
 *	
 *	Developed by: Lisa DeBona
 */


jQuery(document).ready(function ($) {
  $("select#diff").change(function () {
    var diffResult = $(this).val();
    $('ul.items').find('li.show').removeClass('show');
    $('ul.items').find('li').addClass('hide');

    if (diffResult == '.advanced') {
      $('ul.items').find(diffResult).removeClass('hide');
      $('ul.items').find(diffResult).addClass('show');
    }

    if (diffResult == '.intermediate') {
      $('ul.items').find(diffResult).removeClass('hide');
      $('ul.items').find(diffResult).addClass('show');
    }

    if (diffResult == '.beginner') {
      $('ul.items').find(diffResult).removeClass('hide');
      $('ul.items').find(diffResult).addClass('show');
    }

    if (diffResult == '.all') {
      $('ul.items').find('li.hide').removeClass('hide');
      $('ul.items').find('li').addClass('show');
    }

    if ($(".hide-on-load").hasClass("hide")) {
      $('.hide-on-load').removeClass('hide');
      $('.hide-on-load').addClass('show');
    }
  });
  $("#selectByProgram").change(function () {
    if ($(".hide-on-load").hasClass("hide")) {
      $('.sch-prompt').addClass('hide');
      $('.hide-on-load').removeClass('hide');
      $('.hide-on-load').addClass('show');
      $(".diff-filter-wrap").removeClass('hide');
      $(".diff-filter-wrap").addClass('show');
      $("#fi").find('.select2-container--default').removeAttr("style");
      $("#fi").find('.select2-container--default').addClass("show");
    }
  });
  /* NAVIGATION */

  $(".menu-toggle").on("click", function (e) {
    e.preventDefault();
    $("body").toggleClass("nav-open"); // $(".corpnav").addClass("open");
    //$(".corpnav").addClass("open");
    // $("li.corplink").addClass('active');

    $(".corpnav").toggleClass('open');
  });
  $("#closeNav,#overlay").on("click", function (e) {
    e.preventDefault();
    $("body").removeClass("nav-open");
    /* Close all the elements inside navigation that are opened or active */

    $(".defaultNav").removeClass("open");
    $('.nav__main').show();
    $('.nav__other').removeClass('show').html("");
    $('.prenav li.sitelinks').removeClass("active");
    $(".defaultNav li.parent-link").removeClass("active");
    $(".defaultNav li.parent-link a.parentlink").removeClass("active");
    $('.navigation__children').removeClass("open");
    $('.navigation__children .navchild-inner [data-parent]').removeClass("open");
  });
  $("#closeNavChild").on("click", function (e) {
    e.preventDefault();
    $("#childrenNavs").removeClass("open");
    $(".children-group").removeClass("open");
    $(".corpnav li.parent-link").removeClass("active");
    $(".corpnav").removeClass("child-open");
  });
  $(document).on("click", ".defaultNav .has-children a.parentlink", function (e) {
    e.preventDefault();
    var link = $(this).attr("href");

    if (link == '#') {
      $(".defaultNav li.parent-link").removeClass("active");
      $(".defaultNav li.parent-link a.parentlink").removeClass("active");
      $('.navigation__children').removeClass("open");
      $('.navigation__children .navchild-inner [data-parent]').removeClass("open");
      $(this).addClass("active");
      $(this).parents("li").addClass('active');
      var parent = $(this).parents('.navgroup');
      var child_menu = $(this).attr("data-parent");

      if (parent.find('.navigation__children ' + child_menu).length > 0) {
        parent.find('.navigation__children').addClass('open');
        parent.find('.navigation__children ' + child_menu).addClass("open");
      }
    }
  });
  /* PREV NAV */

  $(document).on('click', '.prenav .sitelinks a[data-nav]', function (e) {
    e.preventDefault();
    var currentParent = $(this).parent();
    var url = $(this).attr('href');
    var target = $(this).attr('data-nav');
    var linkName = $(this).text().trim();
    $('.prenav a[data-nav]').parent().not(currentParent).removeClass('active');
    currentParent.addClass('active');
    $(this).addClass('active');

    if (target == '.default') {
      /* If hashtag points to specific element, add your custom function to hashtag click event.
       * look for ==> $('a[href*="#"]:not([href="#"])').click(function () {}
      */
      if (url == '#') {
        resetDefaultNavs($(this));
      }
    } else {
      if ($(target).length) {
        var navInnerContent = $(target).find('.nav__content').html();
        $('.nav__main').hide();
        $('.nav__other').html(navInnerContent);
        $('.nav__other').addClass('show');
        $('.nav__other').attr('data-for', linkName);
      }
    }
  });
  /* When clicking the link with data-nav='.default', children links go back to default */

  function resetDefaultNavs(selector) {
    if (selector.attr('data-nav') != undefined) {
      if (selector.attr('data-nav') == '.default') {
        $('.navgroup.nav__main').show();
        $('.navgroup.nav__other').removeClass('show');
        $('.navgroup.nav__other').attr('data-for', "");
        $('.prenav li.sitelinks').removeClass("active");
        $(".defaultNav li.parent-link").removeClass("active");
        $(".defaultNav li.parent-link a.parentlink").removeClass("active");
        $('.navigation__children').removeClass("open");
        $('.navigation__children .navchild-inner [data-parent]').removeClass("open");
        selector.addClass('active');
        selector.parent().addClass('active');
      }
    }
  }

  $('[data-fancybox]').fancybox({
    touch: true,
    hash: false,
    youtube: {
      controls: 0,
      showinfo: 0,
      rel: 0
    },
    vimeo: {
      color: 'ffffff'
    }
  });
  $('.zoom-image').fancybox({
    buttons: ['fullScreen', 'close'],
    hash: false
  });
  $("a#inline").fancybox({
    'hideOnContentClick': true
  }); // Reviews

  (function () {
    // store the slider in a local variable
    var $window = $(window),
        flexslider = {
      vars: {}
    }; // tiny helper function to add breakpoints

    function getGridSize() {
      return window.innerWidth < 600 ? 1 : window.innerWidth < 900 ? 3 : 3;
    }

    $(function () {
      SyntaxHighlighter.all();
    });
    $window.load(function () {
      $('.reviews').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 210,
        itemMargin: 25,
        minItems: getGridSize(),
        // use function to pull in initial value
        maxItems: getGridSize() // use function to pull in initial value

      });
    }); // check grid size on resize event

    $window.resize(function () {
      var gridSize = getGridSize();
      flexslider.vars.minItems = gridSize;
      flexslider.vars.maxItems = gridSize;
    });
  })(); // End reviews


  $("div.read-review").click(function () {
    $(this).parent().toggleClass("open");
  });
  var windowHeight = $(window).scrollTop();

  if (windowHeight > 200) {
    $("body").addClass('scrolled');
  }

  $(window).scroll(function () {
    var wHeight = $(window).scrollTop();

    if (wHeight > 200) {
      $("body").addClass('scrolled');
    } else {
      $("body").removeClass('scrolled'); //$('body').removeClass('subnav-clicked');
    }
  });

  if ($("#banner").length > 0 && $("#pageTabs").length > 0) {
    $(window).scroll(function () {
      var tabsHeight = $("#pageTabs").height();

      if ($(".main-description").length > 0) {
        var main = $(".main-description").height();
        tabsHeight = main;
      }

      var bannerHeight = $("#banner").height();
      var screenOffset = bannerHeight + tabsHeight;
      var wHeight = $(window).scrollTop();

      if (wHeight > screenOffset) {
        $("#pageTabs").addClass('fixed-top');
      } else {
        $("#pageTabs").removeClass('fixed-top');
      }
    });
  } // if( $(".subpage-sliders").length > 0 ) {
  // 	$('.subpage-sliders').flexslider({
  // 		animation: "fade",
  // 		smoothHeight: true
  // 	});
  // }


  if ($(".video__vimeo").length > 0) {
    $(".video__vimeo").each(function () {
      var target = $(this);
      var vimeoURL = $(this).attr("data-url");
      var apiURL = 'https://vimeo.com/api/oembed.json?url=' + vimeoURL;
      $.get(apiURL, function (data) {
        var thumbnail = data.thumbnail_url;
        target.css("background-image", "url('" + thumbnail + "')");
      });
    });
  }

  var is_video_playing = false;
  var $slides = $('.flexslider .slides li');

  if ($slides.length > 0) {
    $slides.eq(1).add($slides.eq(-1)).find('img.lazy').each(function () {
      var src = $(this).attr('data-src');
      $(this).removeClass('lazy');
      $(this).attr('src', src).removeAttr('data-src');
    });
  }

  var slideShow = $('.flexslider').flexslider({
    animation: "fade",
    smoothHeight: true,
    before: function before(slider) {
      var $slides = $(slider.slides),
          index = slider.animatingTo,
          current = index,
          nxt_slide = current + 1,
          prev_slide = current - 1;

      if ($slides.length > 0) {
        $slides.eq(current).add($slides.eq(nxt_slide)).add($slides.eq(prev_slide)).find('img.lazy').each(function () {
          var src = $(this).attr('data-src');
          $(this).removeClass('lazy');
          $(this).attr('src', src).removeAttr('data-src');
        });

        if ($slides.eq(current).find('.videoIframe').length > 0) {
          $(".videoIframeDiv").removeClass("playing");
          $(".videoIframe").hide();
          $("body").addClass("current-slide-is-video");
        } else {
          $("body").removeClass("current-slide-is-video");
        }
      }
    },
    start: function start(slider) {
      var $slides = $(slider.slides);

      if ($slides.length > 0) {
        play_flexslider_video(slider);
      }
    }
  });
  $(document).on("click", ".flex-next, .flex-prev", function (e) {
    e.preventDefault();

    if ($("iframe.videoIframe").length > 0) {
      $("iframe.videoIframe").each(function () {
        var type = $(this).attr("data-vid");

        if (type == 'youtube') {
          var parent = $(this).parents(".videoIframeDiv");
          var embedURL = parent.find(".playVidBtn").attr("data-embed");

          if (e.target.outerText == 'Next') {
            $(this).attr("src", embedURL);
          }
        } else if (type == 'vimeo') {
          var iframe = $(this)[0];
          var player = new Vimeo.Player(iframe);
          player.pause();
        }
      });
    }
  });

  function play_flexslider_video(slider) {
    $(document).on("click", ".playVidBtn", function (e) {
      e.preventDefault();
      var type = $(this).attr("data-type");
      var parent = $(this).parents(".videoIframeDiv");

      if (type == 'youtube') {
        var iframeSRC = $(this).attr("data-embed");
        parent.find("iframe.videoIframe")[0].src += "&autoplay=1"; //parent.find("iframe.videoIframe").attr("src",iframeSRC+"&autoplay=1");

        parent.addClass("playing");
        parent.find("iframe.videoIframe").fadeIn();
        is_video_playing = true;
        slider.stop();
      } else if (type == 'vimeo') {
        var iframe = parent.find("iframe.videoIframe")[0];
        var player = new Vimeo.Player(iframe);
        parent.addClass("playing");
        parent.find("iframe.videoIframe").fadeIn();
        player.play();
        slider.stop();
      }
    });
  }

  $(document).on('click', function (e) {
    var tag = $(this);
    var exceptions = ['todayToggle', 'todayLink', 'todayTxt', 'today-options'];
    var elementId = e.target.id;
    var is_open = false;

    if (elementId == 'today-options') {
      $(".topinfo .today").addClass("open");
    } else {
      if ($.inArray(elementId, exceptions) != -1) {
        if ($(".topinfo .today").hasClass("open")) {
          $(".topinfo .today").removeClass("open");
        } else {
          $(".topinfo .today").addClass("open");
        }
      } else {
        $(".topinfo .today").removeClass("open");
      }
    }
  });
  $('a[href*="#"]:not([href="#"])').click(function () {
    var headHeight = $("#masthead").height();
    var offset = headHeight + 80;

    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top - offset
        }, 1000);
        return false;
      }
    }
  });
  /* Load More */

  $(document).on("click", "#loadMoreBtn", function (event) {
    event.preventDefault();
    var loadButton = $(this);
    var pageURL = _typeof2($("a.page-numbers").eq(0)) != undefined ? $("a.page-numbers").attr("href") : '';
    var current_page = $(this).attr("data-current");
    var next_page = parseInt(current_page) + 1;
    var last_page = $(this).attr("data-end");

    if (pageURL) {
      var parts = pageURL.split("pg=");
      var num = parts[1];
      var url = pageURL.replace('pg=' + num, 'pg=' + next_page);
      loadButton.attr("data-current", next_page);
      $(".next-posts").load(url + " .posts-inner .flex-inner", function () {
        var htmlContent = $(".next-posts .flex-inner").html();
        $("#data-container .flex-inner").append(htmlContent);
        $(".next-posts").html("");

        if (next_page == last_page) {
          $(".loadmorediv").html('').hide();
        }
      });
    }
  });
  $('#playYoutube').on('click', function (ev) {
    $(this).hide();
    $(".videoIframeDiv").addClass('play_video');
    $(".videoIframe")[0].src += "&autoplay=1";
    $("#banner").addClass("video-playing");
    ev.preventDefault();
  });
  $('.select-single').select2();
  /*
  *
  *	Wow Animation
  *
  ------------------------------------*/

  new WOW().init();
  $('.js-blocks').matchHeight();
  $('.js-title').matchHeight();
  $(document).on("click", "#toggleMenu", function () {
    $(this).toggleClass('open');
    $('body').toggleClass('open-mobile-menu');
  });
  /* Search Form (Header) */

  $(document).on("click", "#topsearchBtn", function (e) {
    e.preventDefault();
    $("#topSearchBar form").submit();
  });
  $(document).on("click", "#searchHereBtn", function (e) {
    e.preventDefault();
    $(this).toggleClass('search-open');
    $('#topSearchBar').toggleClass('show');
    $('body').toggleClass('search-form-open');
    $("input.search-field").focus();
  });
  $(document).on("click", "#closeTopSearch", function (e) {
    e.preventDefault();
    $('#searchHereBtn').removeClass('search-open');
    $('#topSearchBar').removeClass('show');
    $('body').removeClass('search-form-open'); //$("input.search-field").val("");
  });
  /* Footer Subscribe Form */

  $('#footSubscribeForm input[type="email"]').on("focus", function () {
    $("#footSubscribeForm").addClass('input-focus');
  });
  $('#footSubscribeForm input[type="email"]').on("focusout blur", function () {
    $("#footSubscribeForm").removeClass('input-focus');
  });
  /* Ajax Load More */

  $(document).on("click", "#loadMoreBtn2", function (e) {
    e.preventDefault();
    var moreButton = $(this);
    var target = $(this);
    var perpage = target.attr("data-perpage");
    var posttype = target.attr("data-posttype");
    var paged = target.attr("data-page");
    var base_url = target.attr("data-baseurl");
    var next_page = parseInt(paged) + 1;
    var total_pages = target.attr("data-totalpages");
    var total = parseInt(total_pages);
    target.attr("data-page", next_page);
    var pageURL = currentURL + '?pg=' + paged;
    $("#tempContainer").load(pageURL + " #postLists", function () {
      if ($("#tempContainer #postLists").length > 0) {
        var entries = $("#tempContainer #postLists").html();
        $(".wait").show();
        setTimeout(function () {
          $(entries).appendTo(".archive-posts-wrap #postLists");
          $(".wait").hide();
        }, 600);

        if (next_page > total) {
          moreButton.hide();
        }
      } else {
        moreButton.hide();
      }
    });
  });
  /* Ajax Load More */

  $(document).on("click", "#loadMoreBtn3", function (e) {
    e.preventDefault();
    var moreButton = $(this);
    var target = $(this);
    var perpage = target.attr("data-perpage");
    var posttype = target.attr("data-posttype");
    var paged = target.attr("data-page");
    var base_url = target.attr("data-baseurl");
    var next_page = parseInt(paged) + 1;
    var total_pages = target.attr("data-totalpages");
    var total = parseInt(total_pages);
    target.attr("data-page", next_page);
    var url = window.location.href;
    var countparams = url.split("=");
    var newURL = currentURL + '?pg=' + paged;
    var nextURL = currentURL + '?pg=' + next_page;

    if (countparams.length > 1) {
      var str = url.replace(currentURL, '');
      newURL += str.replace('?', '&');
      nextURL += str.replace('?', '&');
    }

    $("#tempContainer").load(newURL + " #postLists", function () {
      if ($("#tempContainer #postLists").length > 0) {
        var entries = $("#tempContainer #postLists").html();
        $(".wait").show();
        setTimeout(function () {
          $(entries).appendTo(".archive-posts-wrap #postLists");
          $(".wait").hide();
        }, 500);

        if (paged >= total) {
          moreButton.hide();
        }
      }
    });
    /* Hide More Button if end of records */

    $("#tempNext").load(nextURL + " #postLists", function () {
      if ($("#tempNext #postLists").length == 0) {
        moreButton.hide();
      }
    });
  });
  $(document).on("change", "select.facetwp-dropdown", function () {
    var opt = $(this).val();

    if ($(".morebuttondiv").length > 0) {
      $(".morebuttondiv").load(currentURL + " .moreBtnSpan", function () {});
    }
  });

  if ($("#filter-form").length > 0) {
    $(document).on("change", ".select-filter", function (e) {
      e.preventDefault();
      var opt = $(this).val();
      var name_sel_att = $(this).attr("name");
      var url = $("input#baseurl_input").val();
      var params = '';
      var n = 1;
      $(".select-filter").each(function () {
        var nameAtt = $(this).attr("name");
        var delimiter = n == 1 ? '?' : '&';
        var val = $(this).find("option:selected").val();
        params += delimiter + nameAtt + "=" + val;
        n++;
      });
      var base_url = url + params;
      $("#loaderDiv").addClass("show");
      $("#load-post-div").load(base_url + " #load-data-div", function () {
        $('.select-single').select2();
        setTimeout(function () {
          $("#loaderDiv").removeClass("show");
        }, 600);
      });
    });
  }
  /* Align Bottom Page Vertically Center */


  if ($(".explore-other-stuff").length > 0) {
    var totalEntries = $(".explore-other-stuff .entry").length;
    $(".explore-other-stuff .post-type-entries").addClass('column-list-' + totalEntries);
  }
  /* Ajax Load More */


  $('a[href*="#"]:not([href="#"])').click(function () {
    var headHeight = $("#masthead").height();
    var offset = headHeight + 80;

    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top - offset
        }, 1000);
        return false;
      }
    }
  });

  if (typeof params.pid != 'undefined' && params.pid != null) {
    if ($(".faqpid-" + params.pid).length > 0) {
      view_faqs_info(params.pid);
    }
  }

  $(document).on("click", ".faqGroup", function (e) {
    e.preventDefault();
    $(".faqGroup").removeClass('active');
    var postid = $(this).attr("data-id");
    $(this).addClass('active');
    view_faqs_info(postid);
  });

  function view_faqs_info(postid) {
    var headHeight = $("#masthead").height();
    var offset = headHeight + 80;
    var target = $("#faqItems");
    target.show();
    $('html, body').animate({
      scrollTop: target.offset().top - offset
    }, 1000);
    $.ajax({
      url: frontajax.ajaxurl,
      type: 'post',
      dataType: "json",
      data: {
        action: 'get_faq_group',
        post_id: postid
      },
      beforeSend: function beforeSend() {
        $("#loaderDiv").appendTo(".main-faq-items");
        $("#loaderDiv").show();
      },
      success: function success(obj) {
        if (obj.result) {
          $("#faqsContainer").html(obj.result);
          setTimeout(function () {
            $("#loaderDiv").hide();
          }, 500);
          var newURL = currentURL + '?pid=' + postid;
          history.replaceState('', document.title, newURL);
        }
      },
      error: function error() {
        $("#loaderDiv").hide();
      }
    });
  }
  /* More FAQs */


  $(document).on("click", ".morefaqsBtn", function (e) {
    e.preventDefault();
    var morefaqs = $(".morefaqs");
    morefaqs.hide();
    $(".faq-item").each(function () {
      if ($(this).hasClass('hide-faq')) {
        $(this).removeClass('hide-faq').addClass("animated fadeIn");
      }
    });
  });
  /* Load More Entries:
  	 - Race Series 
  */

  $(document).on("click", "#loadMoreEntries", function (e) {
    e.preventDefault();
    var d = new Date();
    var current = $(this).attr('data-current');
    var next = parseInt(current) + 1;
    var totalPages = $(this).attr('data-total-pages');
    $(this).attr('data-current', next);

    if ($("#pagination a.page-numbers").length > 0) {
      var baseURL = $("#pagination a.page-numbers").eq(0).attr("href");
      var parts = baseURL.split("pg=");
      var newURL = parts[0] + 'pg=' + next;
      var nxt = next + 1;
      $("#loaderDiv").show();
      $(".next-posts").load(newURL + " .result", function () {
        var content = $(".next-posts").html();
        $('.next-posts .postbox').addClass("animated fadeIn").appendTo("#data-container .result");
        setTimeout(function () {
          $("#loaderDiv").hide();
        }, 500);
      });

      if (next == totalPages) {
        $(".loadmorediv").hide();
      }
    }
  });
  $(".js-select2").select2({
    closeOnSelect: false,
    placeholder: "Select...",
    allowHtml: true,
    allowClear: true,
    tags: true
  });
  $(document).on("click", ".select2-selection--multiple", function (e) {
    var selectdiv = $(".customselectdiv").innerWidth();
    var w = selectdiv + 2;
    $(".select2-container--default").css("width", w + "px");
  });
  /* Smooth Scrolling */

  $('a[href*="#"]') // Remove links that don't actually link to anything
  .not('[href="#"]').not('[href="#0"]').click(function (event) {
    // On-page links
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']'); // Does a scroll target exist?

      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function () {
          // Callback after animation
          // Must change focus!
          var $target = $(target); //$target.focus();

          if ($target.is(":focus")) {
            // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
            //$target.focus(); // Set focus again
          }

          ;
        });
      }
    }
  });

  Isotope.Item.prototype._create = function () {
    // assign id, used for original-order sorting
    this.id = this.layout.itemGUID++; // transition objects

    this._transn = {
      ingProperties: {},
      clean: {},
      onEnd: {}
    };
    this.sortData = {};
  };

  Isotope.Item.prototype.layoutPosition = function () {
    this.emitEvent('layout', [this]);
  };

  Isotope.prototype.arrange = function (opts) {
    // set any options pass
    this.option(opts);

    this._getIsInstant(); // just filter


    this.filteredItems = this._filter(this.items); // flag for initalized

    this._isLayoutInited = true;
  }; // layout mode that does not position items


  Isotope.LayoutMode.create('none'); // --------------- //
  // init Isotope

  var $grid = $('.employment-grid').isotope({
    itemSelector: '.joblist',
    layoutMode: 'none'
  }); // filter functions
  // bind filter button click

  $('.filters-select').on('change', function () {
    // get filter value from option value
    var filterValue = this.value; // use filterFn if matches value

    filterValue = filterValue;
    $grid.isotope({
      filter: filterValue
    });
  }); // change is-checked class on buttons

  $('.button-group').each(function (i, buttonGroup) {
    var $buttonGroup = $(buttonGroup);
    $buttonGroup.on('click', 'button', function () {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      $(this).addClass('is-checked');
    });
  });
  $('.filters-select-dept').on('change', function () {
    // get filter value from option value
    var filterValue = this.value;
    $('.job-group').removeClass('show-dept');
    $('.' + filterValue).addClass('show-dept');
    setTimeout(function () {
      // alert('layout');
      $grid.isotope('layout');
    }, 1000);
  });
  $('.button-group').each(function (i, buttonGroup) {
    var $buttonGroup = $(buttonGroup);
    $buttonGroup.on('click', 'button', function () {
      $grid.isotope({
        filter: filterValue
      });
    });
  }); // flatten object by concatting values

  function concatValues(obj) {
    var value = '';

    for (var prop in obj) {
      value += obj[prop];
    }

    return value;
  }

  $grid.on('arrangeComplete', function (event, filteredItems) {
    var resultCount = filteredItems.length;

    if (resultCount == 0) {
      //$grid.html("Sorry.No result for these two choices. Please select anothter category.");
      // alert('none');
      $('.message-div').removeClass('noshow');
      $('.message-div').addClass('show');
    } else {
      $('.message-div').addClass('noshow');
      $('.message-div').removeClass('show');
    }
  });
}); // END #####################################    END