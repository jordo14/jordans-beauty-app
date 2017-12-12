/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function ($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function () {
        // JavaScript to be fired on all pages
      },
      finalize: function () {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function () {
        // JavaScript to be fired on the home page
      },
      finalize: function () {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // Products page, note the change from about-us to about_us.
    'products': {
      init: function () {
        // JavaScript to be fired on the products page
      },
      finalize: function () {
        // Isotope Grid
        var $grid = $('.grid').isotope({
          itemSelector: '.grid-item',
          percentPosition: true,
          masonry: {
            columnWidth: '.grid-sizer'
          }
        });

        // Isotope Load more button
        var initShow = 8; //number of items loaded on init & onclick load more button
        var counter = initShow; //counter for load more button
        var iso = $grid.data('isotope'); // get Isotope instance
        var noMoreItems; // Boolean

        loadMore(initShow); //execute function onload

        function loadMore(toShow) {
          $grid.find(".hidden").removeClass("hidden");

          var hiddenElems = iso.filteredItems.slice(toShow, iso.filteredItems.length).map(function (item) {
            return item.element;
          });
          $(hiddenElems).addClass('hidden');
          $grid.isotope('layout');

          //when no more to load, hide show more button
          if (hiddenElems.length == 0) {
            jQuery("#load-more").hide();
            noMoreItems = true;
          } else {
            jQuery("#load-more").show();
          };

        }

        //append load more button
        if (!noMoreItems) {
          $grid.after('<div class="row justify-content-center"><a id="load-more" class="btn btn-gradient btn-lg" data-content="Load More">Load More</a></div>');
        }

        //when load more button clicked
        $("#load-more").click(function () {
          counter = counter + initShow;

          loadMore(counter);
        });

        //when filter button clicked
        $("#filterButton").click(function () {
          var brandSelectValue = $("#brandSelect").val();
          var tagSelectValue = $("#tagSelect").val();
          var typeSelectValue = $("#typeSelect").val();

          var filterString = '';

          if (brandSelectValue) {
            filterString += '.' + brandSelectValue
          }
          if (tagSelectValue) {
            filterString += '.' + tagSelectValue
          }
          if (typeSelectValue) {
            filterString += '.' + typeSelectValue
          }

          if (filterString === '') {
            $grid.isotope({ filter: '' });
            loadMore(initShow);
          } else {
            $grid.isotope({ filter: filterString });
            loadMore(initShow);
          }
        });
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function (func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function () {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function (i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
