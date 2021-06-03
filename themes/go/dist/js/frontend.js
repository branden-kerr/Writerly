/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./.dev/assets/shared/js/frontend/frontend.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./.dev/assets/shared/js/frontend/components/primary-menu.js":
/*!*******************************************************************!*\
  !*** ./.dev/assets/shared/js/frontend/components/primary-menu.js ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _vendor_responsive_nav__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../vendor/responsive-nav */ "./.dev/assets/shared/js/frontend/vendor/responsive-nav.js");
/* harmony import */ var _vendor_responsive_nav__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_vendor_responsive_nav__WEBPACK_IMPORTED_MODULE_0__);
/* global TenUp */

/**
 * Hook up navigation.
 */

var init = function init() {
  if (TenUp) {
    TenUp.navigation({
      target: '#header__navigation',
      toggle: '#nav-toggle',
      // eslint-disable-next-line
      sub_menu_open: goFrontend.openMenuOnHover ? 'hover' : 'click'
    });
  }

  document.addEventListener('keydown', lockMenuFocus);
};
/**
 * Lock tabbing to the main navigation only.
 */


function lockMenuFocus(evt) {
  var e = event || evt; // for cross-browser compatibility

  var charCode = e.which || e.keyCode;

  if (charCode !== 9 || !jQuery('body').hasClass('menu-is-open')) {
    return;
  }

  var $element = jQuery(':focus'),
      mainMenuLength = jQuery('ul.primary-menu').children().length,
      currentIndex = jQuery($element).closest('li').index(),
      isShiftTab = event.shiftKey && event.keyCode == 9;

  if ($element.closest('ul').hasClass('sub-menu')) {
    return;
  }

  currentIndex = isShiftTab ? currentIndex - 1 : currentIndex + 1;

  if ($element.attr('id') === 'nav-toggle') {
    if (isShiftTab) {
      return;
    }

    setTimeout(function () {
      jQuery('ul.primary-menu li:first-child a')[0].focus();
    }, 10);
  } // Menu link


  if ($element.parents('ul.primary-menu').length > 0) {
    if (currentIndex < 0 && isShiftTab || currentIndex === mainMenuLength) {
      setTimeout(function () {
        jQuery('#nav-toggle').focus();
      }, 10);
    }
  }
}

;
/* harmony default export */ __webpack_exports__["default"] = (init);

/***/ }),

/***/ "./.dev/assets/shared/js/frontend/components/search-toggle.js":
/*!********************************************************************!*\
  !*** ./.dev/assets/shared/js/frontend/components/search-toggle.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var searchToggle = function searchToggle() {
  var searchToggle = document.getElementById('header__search-toggle');

  if (!searchToggle) {
    return;
  }

  var performToggle = function performToggle(element) {
    var toggle = element;
    var target = document.querySelector(toggle.dataset.toggleTarget);

    if (target.classList.contains('show-modal')) {
      // Hide the modal.
      target.classList.remove('active');
      setTimeout(function () {
        target.classList.remove('show-modal');
        toggle.focus();
      }, 250);
    } else {
      // Show the modal.
      target.classList.add('show-modal');
      setTimeout(function () {
        target.classList.add('active');

        if (toggle.dataset.setFocus) {
          var focusElement = document.querySelector(toggle.dataset.setFocus);

          if (focusElement) {
            var searchTerm = focusElement.value;
            focusElement.value = '';
            focusElement.focus();
            focusElement.value = searchTerm;
          }
        }
      }, 10);
    }
  };

  document.querySelectorAll('*[data-toggle-target]').forEach(function (element) {
    element.addEventListener('click', function (event) {
      event.preventDefault();
      performToggle(element);
    });
  }); // Close modal on escape key press.

  document.addEventListener('keyup', function (event) {
    if (event.keyCode === 27) {
      event.preventDefault();
      document.querySelectorAll('.search-modal.active').forEach(function (element) {
        performToggle(document.querySelector('*[data-toggle-target="' + element.dataset.modalTargetString + '"]'));
      });
    }
  }); // Close modal on outside click.

  document.addEventListener('click', function (event) {
    var target = event.target;
    var modal = document.querySelector('.search-modal.active');

    if (target === modal) {
      performToggle(document.querySelector('*[data-toggle-target="' + modal.dataset.modalTargetString + '"]'));
    }
  });
  document.addEventListener('keydown', lockSearchFocus);
};
/**
 * Lock tabbing to the search form only.
 */


function lockSearchFocus(evt) {
  var e = event || evt; // for cross-browser compatibility

  var charCode = e.which || e.keyCode;

  if (charCode !== 9 || !jQuery('div.search-modal').hasClass('active')) {
    return;
  }

  var $element = jQuery(':focus'),
      isShiftTab = event.shiftKey && event.keyCode == 9;

  if ($element.hasClass('search-form__input') && isShiftTab) {
    setTimeout(function () {
      jQuery('.search-input__button').focus();
    }, 10);
  }

  if ($element.hasClass('search-input__button') && !isShiftTab) {
    setTimeout(function () {
      jQuery('input.search-form__input').focus();
    }, 10);
  }
}

;
/* harmony default export */ __webpack_exports__["default"] = (searchToggle);

/***/ }),

/***/ "./.dev/assets/shared/js/frontend/components/woo-menu-cart.js":
/*!********************************************************************!*\
  !*** ./.dev/assets/shared/js/frontend/components/woo-menu-cart.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var menuObject = document.getElementById('header__cart-toggle');
var siteOverlay = document.getElementById('site-overlay');
var sideNav = document.getElementById('site-nav--cart');
var sideNavClose = document.getElementById('site-close-handle');

var wooMenuCart = function wooMenuCart() {
  if (null === menuObject || null === siteOverlay || null === sideNavClose) {
    return;
  }

  document.body.classList.add('has-woo-cart-slideout');
  menuObject.addEventListener('click', function (event) {
    event.preventDefault();
    toggleSideNavVisibility();
  });
  siteOverlay.addEventListener('click', toggleSideNavVisibility);
  sideNavClose.addEventListener('click', toggleSideNavVisibility);
};

var toggleSideNavVisibility = function toggleSideNavVisibility(event) {
  sideNav.classList.toggle('active');
  siteOverlay.classList.toggle('active');
  document.body.classList.toggle('sidebar-move');
};

/* harmony default export */ __webpack_exports__["default"] = (wooMenuCart);

/***/ }),

/***/ "./.dev/assets/shared/js/frontend/frontend.js":
/*!****************************************************!*\
  !*** ./.dev/assets/shared/js/frontend/frontend.js ***!
  \****************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var css_vars_ponyfill__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! css-vars-ponyfill */ "./node_modules/css-vars-ponyfill/dist/css-vars-ponyfill.esm.js");
/* harmony import */ var _components_primary_menu_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/primary-menu.js */ "./.dev/assets/shared/js/frontend/components/primary-menu.js");
/* harmony import */ var _components_search_toggle_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/search-toggle.js */ "./.dev/assets/shared/js/frontend/components/search-toggle.js");
/* harmony import */ var _components_woo_menu_cart_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/woo-menu-cart.js */ "./.dev/assets/shared/js/frontend/components/woo-menu-cart.js");
/* harmony import */ var lodash_debounce__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! lodash/debounce */ "./node_modules/lodash/debounce.js");
/* harmony import */ var lodash_debounce__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(lodash_debounce__WEBPACK_IMPORTED_MODULE_4__);




 // we need an alias for debounce otherwise it conflicts with customizer

Object(_components_primary_menu_js__WEBPACK_IMPORTED_MODULE_1__["default"])();
Object(_components_search_toggle_js__WEBPACK_IMPORTED_MODULE_2__["default"])();
Object(_components_woo_menu_cart_js__WEBPACK_IMPORTED_MODULE_3__["default"])();
Object(css_vars_ponyfill__WEBPACK_IMPORTED_MODULE_0__["default"])();
document.addEventListener('DOMContentLoaded', function () {
  var hasSelectiveRefresh = 'undefined' !== typeof wp && wp.customize && wp.customize.selectiveRefresh && wp.customize.navMenusPreview.NavMenuInstancePartial; // partial-content-rendered might render multiple times for some reason, let's make sure to debouce this.

  var init = lodash_debounce__WEBPACK_IMPORTED_MODULE_4___default()(function () {
    // we need to remove this before calling primary menu again.
    document.body.classList.remove('has-offscreen-nav');
    Object(_components_primary_menu_js__WEBPACK_IMPORTED_MODULE_1__["default"])();
    Object(_components_search_toggle_js__WEBPACK_IMPORTED_MODULE_2__["default"])();
  }, 1000);

  if (hasSelectiveRefresh) {
    wp.customize.selectiveRefresh.bind('partial-content-rendered', function (placement) {
      var changedHeaderVariation = placement && 'null' !== placement.container[0].parentNode && 'header_variation' === placement.partial.id;

      if (changedHeaderVariation) {
        init();
      }
    });
  }
});

/***/ }),

/***/ "./.dev/assets/shared/js/frontend/vendor/responsive-nav.js":
/*!*****************************************************************!*\
  !*** ./.dev/assets/shared/js/frontend/vendor/responsive-nav.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/********************************

	Name: WordPress Accessible Responsive Navigation Menu
	Usage:

	TenUp.build_menu({

		'target'		:	'#primary-nav',      // the selector of the nav menu <ul>
		'toggle'		:	'#js-menu-toggle',   // the ID of the link you're using to open/close the small screen menu
		'sub_menu_open'	:	'hover'

	}, function() {

		console.log('Amazing callback function!');

	});

********************************/

/* eslint-disable */
(function () {
  'use strict'; // Define global TenUp object if it doesn't exist

  if ('object' !== _typeof(window.TenUp)) {
    window.TenUp = {};
  }
  /*
  	Cache and define some variables
  */
  // init function


  TenUp.navigation = function (options, callback) {
    var defaults = {
      'target': '#primary-nav',
      'toggle': '#js-menu-toggle',
      'sub_menu_open': 'hover'
    };
    var opt; // Map all default settings to user defined options if they exist

    for (opt = 0; opt < defaults.length; opt = opt + 1) {
      if (typeof options[opt] === 'undefined') {
        options[opt] = defaults[opt];
      }
    }

    var menu = document.querySelector(options.target); // Bail out if there's no menu

    if (!menu) {
      return;
    }

    var menu_id = menu.getAttribute('id');
    var menu_toggle = document.querySelector(options.toggle);
    var aria_controls = menu_toggle.getAttribute('aria-controls');
    var sub_menu_acion = options.sub_menu_open;
    var current_menu_item = menu.querySelector('.current-menu-item');
    var menu_items_with_children = menu.querySelectorAll('.menu-item-has-children');
    var menu_items_with_children_count = menu_items_with_children.length;
    var currentTarget;
    var target;
    var i; // Listener for the menu open/close action

    function listener_menu(e) {
      // Stop links from firing
      e.preventDefault();

      if (document.body.classList.contains('menu-is-open')) {
        // Close the menu
        menu.setAttribute('aria-hidden', 'true');
        menu_toggle.setAttribute('aria-expanded', 'false'); // Bubble to the document

        document.body.classList.remove('menu-is-open');
      } else {
        // Open the menu
        menu.setAttribute('aria-hidden', 'false');
        menu_toggle.setAttribute('aria-expanded', 'true'); // Set focus to the first link

        menu.querySelectorAll('a')[0].focus(); // Bubble to the document

        document.body.classList.add('menu-is-open');
      }
    }

    ; // listener_menu()
    // Listener for submenu on click

    function listener_submenu_click(e) {
      currentTarget = e.currentTarget;
      target = e.target;

      if (target.tagName === 'svg' || target.tagName === 'path') {
        target = currentTarget.closest('.menu-item > a');
      } else {
        console.log(target.previousSibling.previousSibling.href);

        if (goFrontend.isMobile) {
          if (target.tagName === 'A') {
            return;
          }

          if (target.tagName === 'UL') {
            var tempURL = target.previousSibling.previousSibling.href;

            if (null !== tempURL) {
              window.location.href = tempURL;
              return;
            }
          }
        }
      }

      if (target.getAttribute('aria-haspopup')) {
        // Stop links from firing
        e.preventDefault(); // Stop events from bubbling up to parent elements

        e.stopPropagation();
        var parent_menu = target.parentNode;
        var sub_menu = parent_menu.querySelector('.sub-menu');
        var all_open_menus = menu.querySelectorAll('.child-has-focus');
        var all_open_menus_count = all_open_menus.length;
        var all_open_menu_triggers = menu.querySelectorAll('.child-has-focus > a.submenu-is-open');
        var all_open_menu_triggers_count = all_open_menu_triggers.length;
        var t;

        if (get_screen_size('has-full-nav')) {
          if (all_open_menu_triggers_count > 0) {
            // Make sure only 1 menu item can be opened at a time
            for (t = 0; t < all_open_menu_triggers_count; t = t + 1) {
              // Check if the open menu is top-level, if so, close it
              if (parent_menu.parentNode === menu) {
                menu_sub_close(all_open_menu_triggers[t]);
              }
            } // for

          } // if

        } // if


        if ((e.target.nodeName === 'A' || target.tagName === 'A') && target.classList.contains('submenu-is-open')) {
          // The menu is already open, so this should be a close action
          menu_sub_close(target);
        } else {
          menu_sub_close_all(); // The menu is closed, so this click should open it

          menu_sub_open(target); // Reset the focus

          sub_menu.querySelectorAll('a')[0].focus();
        }
      }
    }

    ; // listener_submenu_click()
    // When "hover", this is how focus should act

    function listener_submenu_focus(e) {
      var currentTarget = e.currentTarget;
      var target = e.target;
      var parent_menu = target.parentNode;
      var sub_menu = parent_menu.querySelector('.sub-menu');
      var all_open_menu_triggers = menu.querySelectorAll('.child-has-focus > a.submenu-is-open');
      var all_open_menu_triggers_count = all_open_menu_triggers.length;
      var t;

      if (get_screen_size('has-full-nav')) {
        if (all_open_menu_triggers_count > 0) {
          // Make sure only 1 menu item can be opened at a time
          for (t = 0; t < all_open_menu_triggers_count; t = t + 1) {
            // Check if the open menu is top-level, if so, close it
            if (parent_menu.parentNode === menu) {
              menu_sub_close(all_open_menu_triggers[t]);
            }
          }
        }
      }

      menu_sub_open(target);
    }

    ; // Listener for the window resize

    var listener_window = debounce(function (e) {
      if (get_screen_size('has-offscreen-nav')) {
        menu_create();
      } else {
        menu_destroy();
      }
    }, 100); // listener_window()
    // Close the menu if you click somewhere else

    function listener_close_open_menus(e) {
      var open_menus = menu.querySelectorAll('.submenu-is-open');
      var open_menus_count = open_menus.length;
      var opn; // if the event is keyup and it was the ESC key

      if (e.type === 'keyup' && e.keyCode == 27) {
        // We were getting some errors, so let's add in a checkpoint
        if (open_menus_count) {
          // Loop through all the open menus and close them
          for (opn = 0; opn < open_menus.length; opn = opn + 1) {
            menu_sub_close(open_menus[opn]);
          } // for
          // Return focus to the first open menu


          if (sub_menu_acion === 'click') {
            open_menus[0].focus();
          }
        } // if
        // If the event was a mouseup

      } else if (e.type === 'mouseup') {
        if (!menu.contains(e.target) && menu.querySelector('.submenu-is-open')) {
          // We were getting some error, so let's add in a second checkpoint
          if (open_menus_count) {
            for (opn = 0; opn < open_menus.length; opn = opn + 1) {
              menu_sub_close(open_menus[opn]);
            } // for

          }
        } // if

      }
    }

    ; // listener_close_open_menus()

    function menu_sub_close(open_item) {
      if (open_item && open_item.classList) {
        open_item.classList.remove('submenu-is-open');
        open_item.parentNode.classList.remove('child-has-focus');
      }

      if (open_item && open_item.parentNode && open_item.parentNode.querySelector('.sub-menu')) {
        open_item.parentNode.querySelector('.sub-menu').setAttribute('aria-hidden', 'true');
      }
    }

    ; // menu_sub_close()

    function menu_sub_close_all() {
      var open_menus = menu.querySelectorAll('.submenu-is-open');
      var open_menus_count = open_menus.length;
      var opn; // We were getting some errors, so let's add in a checkpoint

      if (open_menus_count) {
        // Loop through all the open menus and close them
        for (opn = 0; opn < open_menus.length; opn = opn + 1) {
          menu_sub_close(open_menus[opn]);
        } // for

      } // if

    }

    ; // menu_sub_close()

    function menu_sub_open(closed_item) {
      closed_item.classList.add('submenu-is-open');
      closed_item.parentNode.classList.add('child-has-focus');

      if (closed_item.parentNode.querySelector('.sub-menu')) {
        closed_item.parentNode.querySelector('.sub-menu').setAttribute('aria-hidden', 'false');
      }
    }

    ; // menu_sub_open()
    // Method to create the small screen menu

    function menu_create() {
      if (!document.body.classList.contains('has-offscreen-nav')) {
        if (!document.body.classList.contains('menu-is-open')) {
          menu.setAttribute('aria-hidden', 'true');
          menu_toggle.setAttribute('aria-expanded', 'false');
        } else {
          menu.setAttribute('aria-hidden', 'false');
          menu_toggle.setAttribute('aria-expanded', 'true');
        } // Loop through all submenus and bind events when needed


        for (i = 0; i < menu_items_with_children_count; i = i + 1) {
          var svgElements = menu_items_with_children[i].querySelectorAll('svg');

          for (var q = 0; q < svgElements.length; q = q + 1) {
            svgElements[q].addEventListener('click', listener_submenu_click);
          }

          menu_items_with_children[i].removeEventListener('focusin', listener_submenu_focus);
        } // for
        // Bind the event


        menu_toggle.addEventListener('click', listener_menu); // Add the body class to prevent this from running again

        document.body.classList.add('has-offscreen-nav');
        document.body.classList.remove('has-full-nav');
      }
    }

    ; // menu_create()
    // Method to destroy the small screen menu

    function menu_destroy() {
      var tmp_open;
      var tmp_open_count;
      var t;

      if (!document.body.classList.contains('has-full-nav')) {
        // Remove aria-hidden, because we don't need it.
        menu.removeAttribute('aria-hidden'); // Loop through all submenus and bind events when needed

        for (i = 0; i < menu_items_with_children_count; i = i + 1) {
          if (sub_menu_acion !== 'click') {
            menu_items_with_children[i].removeEventListener('click', listener_submenu_click);
            menu_items_with_children[i].addEventListener('focusin', listener_submenu_focus);
            menu.classList.remove('uses-click');
          }
        } // If we're not using click, the open menus need to be reset


        if (sub_menu_acion !== 'click') {
          tmp_open = document.querySelectorAll('.child-has-focus');
          tmp_open_count = tmp_open.length;

          for (t = 0; t < tmp_open_count; t = t + 1) {
            tmp_open[t].classList.remove('child-has-focus');
            tmp_open[t].querySelector('.submenu-is-open').classList.remove('submenu-is-open');
            tmp_open[t].querySelector('.sub-menu').setAttribute('aria-hidden', 'true');
          }
        } // Unbind the event


        menu_toggle.removeEventListener('click', listener_menu); // Add the body class to prevent this from running again

        document.body.classList.add('has-full-nav');
        document.body.classList.remove('has-offscreen-nav');
      }
    }

    ; // Check init menu state

    if (get_screen_size('has-offscreen-nav')) {
      menu_create();
    } // If aria-controls isn't set, set it


    if (!aria_controls) {
      menu_toggle.setAttribute('aria-controls', menu_id);
    }

    if (current_menu_item) {
      current_menu_item.querySelector('a').setAttribute('aria-current', 'page');
    }
    /*
    	Events
    */
    // Debounced resize event to create and destroy the small screen menu options


    window.addEventListener('resize', listener_window); // Close the submenus by clicking off of them or hitting ESC

    document.addEventListener('mouseup', listener_close_open_menus);
    document.addEventListener('keyup', listener_close_open_menus);
    /*
    	Hiding and showing submenus (click, focus, hover)
    */
    // Loop through all items with sub menus and bind focus to them for tabbing

    for (i = 0; i < menu_items_with_children_count; i = i + 1) {
      // Let a screen reader know this menu has a submenu by hooking into the first link
      menu_items_with_children[i].querySelector('a').setAttribute('aria-haspopup', 'true'); // Hide and label each sub menu

      menu_items_with_children[i].querySelector('.sub-menu').setAttribute('aria-hidden', 'true');
      menu_items_with_children[i].querySelector('.sub-menu').setAttribute('aria-label', 'Submenu'); // If the screen is small or the action is set to click

      if (get_screen_size('has-offscreen-nav') || sub_menu_acion === 'click') {
        menu_items_with_children[i].addEventListener('click', listener_submenu_click);
        var svgElements = menu_items_with_children[i].querySelectorAll('svg');

        for (var z = 0; z < svgElements.length; z = z + 1) {
          svgElements[z].addEventListener('click', listener_submenu_click);
        }

        menu.classList.add(sub_menu_acion === 'click' ? 'uses-click' : 'uses-hover');
      } else if (sub_menu_acion !== 'click') {
        if (get_screen_size('has-full-nav')) {
          menu_items_with_children[i].addEventListener('mouseover', listener_submenu_focus);
          menu_items_with_children[i].addEventListener('mouseout', function () {
            var open_menus = menu.querySelectorAll('.submenu-is-open');
            var open_menus_count = open_menus.length;
            var opn; // We were getting some errors, so let's add in a checkpoint

            if (open_menus_count) {
              // Loop through all the open menus and close them
              for (opn = 0; opn < open_menus_count; opn = opn + 1) {
                menu_sub_close(open_menus[opn]);
              } // for

            }
          });
          menu_items_with_children[i].addEventListener('focusin', listener_submenu_focus);
          menu_items_with_children[i].querySelectorAll('.sub-menu').forEach(function (submenu) {
            submenu.addEventListener('mouseover', function (event) {
              submenu.parentElement.classList.add('child-has-focus');
              submenu.previousElementSibling.classList.add('submenu-is-open');
            }, false);
          });
        } // if

      } // if

    } // for
    // Execute the callback function


    if (typeof callback === 'function') {
      callback.call();
    }
  }; // build_menu()

  /*
  	Helper functions
  */
  // Get screen size from getComputedStyle (so we don't have to define each breakpoint twice) -- Values are set in CSS --


  function get_screen_size(sizeString) {
    var size = window.getComputedStyle(document.body, ':before').getPropertyValue('content');

    if (size && size.indexOf(sizeString) !== -1) {
      return true;
    }
  }

  ; // Debounce

  function debounce(func, wait, immediate) {
    var timeout;
    return function () {
      var context = this,
          args = arguments;

      var later = function later() {
        timeout = null;
        if (!immediate) func.apply(context, args);
      };

      var callNow = immediate && !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) func.apply(context, args);
    };
  }

  ;
})();

/***/ }),

/***/ "./node_modules/css-vars-ponyfill/dist/css-vars-ponyfill.esm.js":
/*!**********************************************************************!*\
  !*** ./node_modules/css-vars-ponyfill/dist/css-vars-ponyfill.esm.js ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/*!
 * css-vars-ponyfill
 * v2.4.3
 * https://jhildenbiddle.github.io/css-vars-ponyfill/
 * (c) 2018-2021 John Hildenbiddle <http://hildenbiddle.com>
 * MIT license
 */
function _extends() {
    _extends = Object.assign || function(target) {
        for (var i = 1; i < arguments.length; i++) {
            var source = arguments[i];
            for (var key in source) {
                if (Object.prototype.hasOwnProperty.call(source, key)) {
                    target[key] = source[key];
                }
            }
        }
        return target;
    };
    return _extends.apply(this, arguments);
}

/*!
 * get-css-data
 * v2.0.0
 * https://github.com/jhildenbiddle/get-css-data
 * (c) 2018-2021 John Hildenbiddle <http://hildenbiddle.com>
 * MIT license
 */ function getUrls(urls) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    var settings = {
        mimeType: options.mimeType || null,
        onBeforeSend: options.onBeforeSend || Function.prototype,
        onSuccess: options.onSuccess || Function.prototype,
        onError: options.onError || Function.prototype,
        onComplete: options.onComplete || Function.prototype
    };
    var urlArray = Array.isArray(urls) ? urls : [ urls ];
    var urlQueue = Array.apply(null, Array(urlArray.length)).map((function(x) {
        return null;
    }));
    function isValidCss(cssText) {
        var isHTML = cssText && cssText.trim().charAt(0) === "<";
        return cssText && !isHTML;
    }
    function onError(xhr, urlIndex) {
        settings.onError(xhr, urlArray[urlIndex], urlIndex);
    }
    function onSuccess(responseText, urlIndex) {
        var returnVal = settings.onSuccess(responseText, urlArray[urlIndex], urlIndex);
        responseText = returnVal === false ? "" : returnVal || responseText;
        urlQueue[urlIndex] = responseText;
        if (urlQueue.indexOf(null) === -1) {
            settings.onComplete(urlQueue);
        }
    }
    var parser = document.createElement("a");
    urlArray.forEach((function(url, i) {
        parser.setAttribute("href", url);
        parser.href = String(parser.href);
        var isIElte9 = Boolean(document.all && !window.atob);
        var isIElte9CORS = isIElte9 && parser.host.split(":")[0] !== location.host.split(":")[0];
        if (isIElte9CORS) {
            var isSameProtocol = parser.protocol === location.protocol;
            if (isSameProtocol) {
                var xdr = new XDomainRequest;
                xdr.open("GET", url);
                xdr.timeout = 0;
                xdr.onprogress = Function.prototype;
                xdr.ontimeout = Function.prototype;
                xdr.onload = function() {
                    if (isValidCss(xdr.responseText)) {
                        onSuccess(xdr.responseText, i);
                    } else {
                        onError(xdr, i);
                    }
                };
                xdr.onerror = function(err) {
                    onError(xdr, i);
                };
                setTimeout((function() {
                    xdr.send();
                }), 0);
            } else {
                console.warn("Internet Explorer 9 Cross-Origin (CORS) requests must use the same protocol (".concat(url, ")"));
                onError(null, i);
            }
        } else {
            var xhr = new XMLHttpRequest;
            xhr.open("GET", url);
            if (settings.mimeType && xhr.overrideMimeType) {
                xhr.overrideMimeType(settings.mimeType);
            }
            settings.onBeforeSend(xhr, url, i);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status < 400 && isValidCss(xhr.responseText)) {
                        onSuccess(xhr.responseText, i);
                    } else if (xhr.status === 0 && isValidCss(xhr.responseText)) {
                        onSuccess(xhr.responseText, i);
                    } else {
                        onError(xhr, i);
                    }
                }
            };
            xhr.send();
        }
    }));
}

/**
 * Gets CSS data from <style> and <link> nodes (including @imports), then
 * returns data in order processed by DOM. Allows specifying nodes to
 * include/exclude and filtering CSS data using RegEx.
 *
 * @preserve
 * @param {object}   [options] The options object
 * @param {object}   [options.rootElement=document] Root element to traverse for
 *                   <link> and <style> nodes.
 * @param {string}   [options.include] CSS selector matching <link> and <style>
 *                   nodes to include
 * @param {string}   [options.exclude] CSS selector matching <link> and <style>
 *                   nodes to exclude
 * @param {object}   [options.filter] Regular expression used to filter node CSS
 *                   data. Each block of CSS data is tested against the filter,
 *                   and only matching data is included.
 * @param {boolean}  [options.skipDisabled=true] Determines if disabled
 *                   stylesheets will be skipped while collecting CSS data.
 * @param {boolean}  [options.useCSSOM=false] Determines if CSS data will be
 *                   collected from a stylesheet's runtime values instead of its
 *                   text content. This is required to get accurate CSS data
 *                   when a stylesheet has been modified using the deleteRule()
 *                   or insertRule() methods because these modifications will
 *                   not be reflected in the stylesheet's text content.
 * @param {function} [options.onBeforeSend] Callback before XHR is sent. Passes
 *                   1) the XHR object, 2) source node reference, and 3) the
 *                   source URL as arguments.
 * @param {function} [options.onSuccess] Callback on each CSS node read. Passes
 *                   1) CSS text, 2) source node reference, and 3) the source
 *                   URL as arguments.
 * @param {function} [options.onError] Callback on each error. Passes 1) the XHR
 *                   object for inspection, 2) soure node reference, and 3) the
 *                   source URL that failed (either a <link> href or an @import)
 *                   as arguments
 * @param {function} [options.onComplete] Callback after all nodes have been
 *                   processed. Passes 1) concatenated CSS text, 2) an array of
 *                   CSS text in DOM order, and 3) an array of nodes in DOM
 *                   order as arguments.
 *
 * @example
 *
 *   getCssData({
 *     rootElement : document,
 *     include     : 'style,link[rel="stylesheet"]',
 *     exclude     : '[href="skip.css"]',
 *     filter      : /red/,
 *     skipDisabled: true,
 *     useCSSOM    : false,
 *     onBeforeSend(xhr, node, url) {
 *       // ...
 *     }
 *     onSuccess(cssText, node, url) {
 *       // ...
 *     }
 *     onError(xhr, node, url) {
 *       // ...
 *     },
 *     onComplete(cssText, cssArray, nodeArray) {
 *       // ...
 *     }
 *   });
 */ function getCssData(options) {
    var regex = {
        cssComments: /\/\*[\s\S]+?\*\//g,
        cssImports: /(?:@import\s*)(?:url\(\s*)?(?:['"])([^'"]*)(?:['"])(?:\s*\))?(?:[^;]*;)/g
    };
    var settings = {
        rootElement: options.rootElement || document,
        include: options.include || 'style,link[rel="stylesheet"]',
        exclude: options.exclude || null,
        filter: options.filter || null,
        skipDisabled: options.skipDisabled !== false,
        useCSSOM: options.useCSSOM || false,
        onBeforeSend: options.onBeforeSend || Function.prototype,
        onSuccess: options.onSuccess || Function.prototype,
        onError: options.onError || Function.prototype,
        onComplete: options.onComplete || Function.prototype
    };
    var sourceNodes = Array.apply(null, settings.rootElement.querySelectorAll(settings.include)).filter((function(node) {
        return !matchesSelector(node, settings.exclude);
    }));
    var cssArray = Array.apply(null, Array(sourceNodes.length)).map((function(x) {
        return null;
    }));
    function handleComplete() {
        var isComplete = cssArray.indexOf(null) === -1;
        if (isComplete) {
            cssArray.reduce((function(skipIndices, value, i) {
                if (value === "") {
                    skipIndices.push(i);
                }
                return skipIndices;
            }), []).reverse().forEach((function(skipIndex) {
                return [ sourceNodes, cssArray ].forEach((function(arr) {
                    return arr.splice(skipIndex, 1);
                }));
            }));
            var cssText = cssArray.join("");
            settings.onComplete(cssText, cssArray, sourceNodes);
        }
    }
    function handleSuccess(cssText, cssIndex, node, sourceUrl) {
        var returnVal = settings.onSuccess(cssText, node, sourceUrl);
        cssText = returnVal !== undefined && Boolean(returnVal) === false ? "" : returnVal || cssText;
        resolveImports(cssText, node, sourceUrl, (function(resolvedCssText, errorData) {
            if (cssArray[cssIndex] === null) {
                errorData.forEach((function(data) {
                    return settings.onError(data.xhr, node, data.url);
                }));
                if (!settings.filter || settings.filter.test(resolvedCssText)) {
                    cssArray[cssIndex] = resolvedCssText;
                } else {
                    cssArray[cssIndex] = "";
                }
                handleComplete();
            }
        }));
    }
    function parseImportData(cssText, baseUrl) {
        var ignoreRules = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : [];
        var importData = {};
        importData.rules = (cssText.replace(regex.cssComments, "").match(regex.cssImports) || []).filter((function(rule) {
            return ignoreRules.indexOf(rule) === -1;
        }));
        importData.urls = importData.rules.map((function(rule) {
            return rule.replace(regex.cssImports, "$1");
        }));
        importData.absoluteUrls = importData.urls.map((function(url) {
            return getFullUrl(url, baseUrl);
        }));
        importData.absoluteRules = importData.rules.map((function(rule, i) {
            var oldUrl = importData.urls[i];
            var newUrl = getFullUrl(importData.absoluteUrls[i], baseUrl);
            return rule.replace(oldUrl, newUrl);
        }));
        return importData;
    }
    function resolveImports(cssText, node, baseUrl, callbackFn) {
        var __errorData = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : [];
        var __errorRules = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : [];
        var importData = parseImportData(cssText, baseUrl, __errorRules);
        if (importData.rules.length) {
            getUrls(importData.absoluteUrls, {
                onBeforeSend: function onBeforeSend(xhr, url, urlIndex) {
                    settings.onBeforeSend(xhr, node, url);
                },
                onSuccess: function onSuccess(cssText, url, urlIndex) {
                    var returnVal = settings.onSuccess(cssText, node, url);
                    cssText = returnVal === false ? "" : returnVal || cssText;
                    var responseImportData = parseImportData(cssText, url, __errorRules);
                    responseImportData.rules.forEach((function(rule, i) {
                        cssText = cssText.replace(rule, responseImportData.absoluteRules[i]);
                    }));
                    return cssText;
                },
                onError: function onError(xhr, url, urlIndex) {
                    __errorData.push({
                        xhr: xhr,
                        url: url
                    });
                    __errorRules.push(importData.rules[urlIndex]);
                    resolveImports(cssText, node, baseUrl, callbackFn, __errorData, __errorRules);
                },
                onComplete: function onComplete(responseArray) {
                    responseArray.forEach((function(importText, i) {
                        cssText = cssText.replace(importData.rules[i], importText);
                    }));
                    resolveImports(cssText, node, baseUrl, callbackFn, __errorData, __errorRules);
                }
            });
        } else {
            callbackFn(cssText, __errorData);
        }
    }
    if (sourceNodes.length) {
        sourceNodes.forEach((function(node, i) {
            var linkHref = node.getAttribute("href");
            var linkRel = node.getAttribute("rel");
            var isLink = node.nodeName.toLowerCase() === "link" && linkHref && linkRel && linkRel.toLowerCase().indexOf("stylesheet") !== -1;
            var isSkip = settings.skipDisabled === false ? false : node.disabled;
            var isStyle = node.nodeName.toLowerCase() === "style";
            if (isLink && !isSkip) {
                getUrls(linkHref, {
                    mimeType: "text/css",
                    onBeforeSend: function onBeforeSend(xhr, url, urlIndex) {
                        settings.onBeforeSend(xhr, node, url);
                    },
                    onSuccess: function onSuccess(cssText, url, urlIndex) {
                        var sourceUrl = getFullUrl(linkHref);
                        handleSuccess(cssText, i, node, sourceUrl);
                    },
                    onError: function onError(xhr, url, urlIndex) {
                        cssArray[i] = "";
                        settings.onError(xhr, node, url);
                        handleComplete();
                    }
                });
            } else if (isStyle && !isSkip) {
                var cssText = node.textContent;
                if (settings.useCSSOM) {
                    cssText = Array.apply(null, node.sheet.cssRules).map((function(rule) {
                        return rule.cssText;
                    })).join("");
                }
                handleSuccess(cssText, i, node, location.href);
            } else {
                cssArray[i] = "";
                handleComplete();
            }
        }));
    } else {
        settings.onComplete("", []);
    }
}

function getFullUrl(url, base) {
    var d = document.implementation.createHTMLDocument("");
    var b = d.createElement("base");
    var a = d.createElement("a");
    d.head.appendChild(b);
    d.body.appendChild(a);
    b.href = base || document.baseURI || (document.querySelector("base") || {}).href || location.href;
    a.href = url;
    return a.href;
}

function matchesSelector(elm, selector) {
    var matches = elm.matches || elm.matchesSelector || elm.webkitMatchesSelector || elm.mozMatchesSelector || elm.msMatchesSelector || elm.oMatchesSelector;
    return matches.call(elm, selector);
}

var balancedMatch = balanced;

function balanced(a, b, str) {
    if (a instanceof RegExp) a = maybeMatch(a, str);
    if (b instanceof RegExp) b = maybeMatch(b, str);
    var r = range(a, b, str);
    return r && {
        start: r[0],
        end: r[1],
        pre: str.slice(0, r[0]),
        body: str.slice(r[0] + a.length, r[1]),
        post: str.slice(r[1] + b.length)
    };
}

function maybeMatch(reg, str) {
    var m = str.match(reg);
    return m ? m[0] : null;
}

balanced.range = range;

function range(a, b, str) {
    var begs, beg, left, right, result;
    var ai = str.indexOf(a);
    var bi = str.indexOf(b, ai + 1);
    var i = ai;
    if (ai >= 0 && bi > 0) {
        begs = [];
        left = str.length;
        while (i >= 0 && !result) {
            if (i == ai) {
                begs.push(i);
                ai = str.indexOf(a, i + 1);
            } else if (begs.length == 1) {
                result = [ begs.pop(), bi ];
            } else {
                beg = begs.pop();
                if (beg < left) {
                    left = beg;
                    right = bi;
                }
                bi = str.indexOf(b, i + 1);
            }
            i = ai < bi && ai >= 0 ? ai : bi;
        }
        if (begs.length) {
            result = [ left, right ];
        }
    }
    return result;
}

function parseCss(css) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    var defaults = {
        preserveStatic: true,
        removeComments: false
    };
    var settings = _extends({}, defaults, options);
    var errors = [];
    function error(msg) {
        throw new Error("CSS parse error: ".concat(msg));
    }
    function match(re) {
        var m = re.exec(css);
        if (m) {
            css = css.slice(m[0].length);
            return m;
        }
    }
    function open() {
        return match(/^{\s*/);
    }
    function close() {
        return match(/^}/);
    }
    function whitespace() {
        match(/^\s*/);
    }
    function comment() {
        whitespace();
        if (css[0] !== "/" || css[1] !== "*") {
            return;
        }
        var i = 2;
        while (css[i] && (css[i] !== "*" || css[i + 1] !== "/")) {
            i++;
        }
        if (!css[i]) {
            return error("end of comment is missing");
        }
        var str = css.slice(2, i);
        css = css.slice(i + 2);
        return {
            type: "comment",
            comment: str
        };
    }
    function comments() {
        var cmnts = [];
        var c;
        while (c = comment()) {
            cmnts.push(c);
        }
        return settings.removeComments ? [] : cmnts;
    }
    function selector() {
        whitespace();
        while (css[0] === "}") {
            error("extra closing bracket");
        }
        var m = match(/^(("(?:\\"|[^"])*"|'(?:\\'|[^'])*'|[^{])+)/);
        if (m) {
            return m[0].trim().replace(/\/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*\/+/g, "").replace(/"(?:\\"|[^"])*"|'(?:\\'|[^'])*'/g, (function(m) {
                return m.replace(/,/g, "‌");
            })).split(/\s*(?![^(]*\)),\s*/).map((function(s) {
                return s.replace(/\u200C/g, ",");
            }));
        }
    }
    function declaration() {
        if (css[0] === "@") {
            return at_rule();
        }
        match(/^([;\s]*)+/);
        var comment_regexp = /\/\*[^*]*\*+([^/*][^*]*\*+)*\//g;
        var prop = match(/^(\*?[-#/*\\\w]+(\[[0-9a-z_-]+\])?)\s*/);
        if (!prop) {
            return;
        }
        prop = prop[0].trim();
        if (!match(/^:\s*/)) {
            return error("property missing ':'");
        }
        var val = match(/^((?:\/\*.*?\*\/|'(?:\\'|.)*?'|"(?:\\"|.)*?"|\((\s*'(?:\\'|.)*?'|"(?:\\"|.)*?"|[^)]*?)\s*\)|[^};])+)/);
        var ret = {
            type: "declaration",
            property: prop.replace(comment_regexp, ""),
            value: val ? val[0].replace(comment_regexp, "").trim() : ""
        };
        match(/^[;\s]*/);
        return ret;
    }
    function declarations() {
        if (!open()) {
            return error("missing '{'");
        }
        var d;
        var decls = comments();
        while (d = declaration()) {
            decls.push(d);
            decls = decls.concat(comments());
        }
        if (!close()) {
            return error("missing '}'");
        }
        return decls;
    }
    function keyframe() {
        whitespace();
        var vals = [];
        var m;
        while (m = match(/^((\d+\.\d+|\.\d+|\d+)%?|[a-z]+)\s*/)) {
            vals.push(m[1]);
            match(/^,\s*/);
        }
        if (vals.length) {
            return {
                type: "keyframe",
                values: vals,
                declarations: declarations()
            };
        }
    }
    function at_keyframes() {
        var m = match(/^@([-\w]+)?keyframes\s*/);
        if (!m) {
            return;
        }
        var vendor = m[1];
        m = match(/^([-\w]+)\s*/);
        if (!m) {
            return error("@keyframes missing name");
        }
        var name = m[1];
        if (!open()) {
            return error("@keyframes missing '{'");
        }
        var frame;
        var frames = comments();
        while (frame = keyframe()) {
            frames.push(frame);
            frames = frames.concat(comments());
        }
        if (!close()) {
            return error("@keyframes missing '}'");
        }
        return {
            type: "keyframes",
            name: name,
            vendor: vendor,
            keyframes: frames
        };
    }
    function at_page() {
        var m = match(/^@page */);
        if (m) {
            var sel = selector() || [];
            return {
                type: "page",
                selectors: sel,
                declarations: declarations()
            };
        }
    }
    function at_page_margin_box() {
        var m = match(/@(top|bottom|left|right)-(left|center|right|top|middle|bottom)-?(corner)?\s*/);
        if (m) {
            var name = "".concat(m[1], "-").concat(m[2]) + (m[3] ? "-".concat(m[3]) : "");
            return {
                type: "page-margin-box",
                name: name,
                declarations: declarations()
            };
        }
    }
    function at_fontface() {
        var m = match(/^@font-face\s*/);
        if (m) {
            return {
                type: "font-face",
                declarations: declarations()
            };
        }
    }
    function at_supports() {
        var m = match(/^@supports *([^{]+)/);
        if (m) {
            return {
                type: "supports",
                supports: m[1].trim(),
                rules: rules()
            };
        }
    }
    function at_host() {
        var m = match(/^@host\s*/);
        if (m) {
            return {
                type: "host",
                rules: rules()
            };
        }
    }
    function at_media() {
        var m = match(/^@media([^{]+)*/);
        if (m) {
            return {
                type: "media",
                media: (m[1] || "").trim(),
                rules: rules()
            };
        }
    }
    function at_custom_m() {
        var m = match(/^@custom-media\s+(--[^\s]+)\s*([^{;]+);/);
        if (m) {
            return {
                type: "custom-media",
                name: m[1].trim(),
                media: m[2].trim()
            };
        }
    }
    function at_document() {
        var m = match(/^@([-\w]+)?document *([^{]+)/);
        if (m) {
            return {
                type: "document",
                document: m[2].trim(),
                vendor: m[1] ? m[1].trim() : null,
                rules: rules()
            };
        }
    }
    function at_x() {
        var m = match(/^@(import|charset|namespace)\s*([^;]+);/);
        if (m) {
            return {
                type: m[1],
                name: m[2].trim()
            };
        }
    }
    function at_rule() {
        whitespace();
        if (css[0] === "@") {
            var ret = at_x() || at_fontface() || at_media() || at_keyframes() || at_supports() || at_document() || at_custom_m() || at_host() || at_page() || at_page_margin_box();
            if (ret && !settings.preserveStatic) {
                var hasVarFunc = false;
                if (ret.declarations) {
                    hasVarFunc = ret.declarations.some((function(decl) {
                        return /var\(/.test(decl.value);
                    }));
                } else {
                    var arr = ret.keyframes || ret.rules || [];
                    hasVarFunc = arr.some((function(obj) {
                        return (obj.declarations || []).some((function(decl) {
                            return /var\(/.test(decl.value);
                        }));
                    }));
                }
                return hasVarFunc ? ret : {};
            }
            return ret;
        }
    }
    function rule() {
        if (!settings.preserveStatic) {
            var balancedMatch$1 = balancedMatch("{", "}", css);
            if (balancedMatch$1) {
                var hasVarDecl = /:(?:root|host)(?![.:#(])/.test(balancedMatch$1.pre) && /--\S*\s*:/.test(balancedMatch$1.body);
                var hasVarFunc = /var\(/.test(balancedMatch$1.body);
                if (!hasVarDecl && !hasVarFunc) {
                    css = css.slice(balancedMatch$1.end + 1);
                    return {};
                }
            }
        }
        var sel = selector() || [];
        var decls = settings.preserveStatic ? declarations() : declarations().filter((function(decl) {
            var hasVarDecl = sel.some((function(s) {
                return /:(?:root|host)(?![.:#(])/.test(s);
            })) && /^--\S/.test(decl.property);
            var hasVarFunc = /var\(/.test(decl.value);
            return hasVarDecl || hasVarFunc;
        }));
        if (!sel.length) {
            error("selector missing");
        }
        return {
            type: "rule",
            selectors: sel,
            declarations: decls
        };
    }
    function rules(core) {
        if (!core && !open()) {
            return error("missing '{'");
        }
        var node;
        var rules = comments();
        while (css.length && (core || css[0] !== "}") && (node = at_rule() || rule())) {
            if (node.type) {
                rules.push(node);
            }
            rules = rules.concat(comments());
        }
        if (!core && !close()) {
            return error("missing '}'");
        }
        return rules;
    }
    return {
        type: "stylesheet",
        stylesheet: {
            rules: rules(true),
            errors: errors
        }
    };
}

function parseVars(cssData) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    var defaults = {
        parseHost: false,
        store: {},
        onWarning: function onWarning() {}
    };
    var settings = _extends({}, defaults, options);
    var reVarDeclSelectors = new RegExp(":".concat(settings.parseHost ? "host" : "root", "$"));
    if (typeof cssData === "string") {
        cssData = parseCss(cssData, settings);
    }
    cssData.stylesheet.rules.forEach((function(rule) {
        if (rule.type !== "rule" || !rule.selectors.some((function(s) {
            return reVarDeclSelectors.test(s);
        }))) {
            return;
        }
        rule.declarations.forEach((function(decl, i) {
            var prop = decl.property;
            var value = decl.value;
            if (prop && prop.indexOf("--") === 0) {
                settings.store[prop] = value;
            }
        }));
    }));
    return settings.store;
}

function stringifyCss(tree) {
    var delim = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "";
    var cb = arguments.length > 2 ? arguments[2] : undefined;
    var renderMethods = {
        charset: function charset(node) {
            return "@charset " + node.name + ";";
        },
        comment: function comment(node) {
            return node.comment.indexOf("__CSSVARSPONYFILL") === 0 ? "/*" + node.comment + "*/" : "";
        },
        "custom-media": function customMedia(node) {
            return "@custom-media " + node.name + " " + node.media + ";";
        },
        declaration: function declaration(node) {
            return node.property + ":" + node.value + ";";
        },
        document: function document(node) {
            return "@" + (node.vendor || "") + "document " + node.document + "{" + visit(node.rules) + "}";
        },
        "font-face": function fontFace(node) {
            return "@font-face" + "{" + visit(node.declarations) + "}";
        },
        host: function host(node) {
            return "@host" + "{" + visit(node.rules) + "}";
        },
        import: function _import(node) {
            return "@import " + node.name + ";";
        },
        keyframe: function keyframe(node) {
            return node.values.join(",") + "{" + visit(node.declarations) + "}";
        },
        keyframes: function keyframes(node) {
            return "@" + (node.vendor || "") + "keyframes " + node.name + "{" + visit(node.keyframes) + "}";
        },
        media: function media(node) {
            return "@media " + node.media + "{" + visit(node.rules) + "}";
        },
        namespace: function namespace(node) {
            return "@namespace " + node.name + ";";
        },
        page: function page(node) {
            return "@page " + (node.selectors.length ? node.selectors.join(", ") : "") + "{" + visit(node.declarations) + "}";
        },
        "page-margin-box": function pageMarginBox(node) {
            return "@" + node.name + "{" + visit(node.declarations) + "}";
        },
        rule: function rule(node) {
            var decls = node.declarations;
            if (decls.length) {
                return node.selectors.join(",") + "{" + visit(decls) + "}";
            }
        },
        supports: function supports(node) {
            return "@supports " + node.supports + "{" + visit(node.rules) + "}";
        }
    };
    function visit(nodes) {
        var buf = "";
        for (var i = 0; i < nodes.length; i++) {
            var n = nodes[i];
            if (cb) {
                cb(n);
            }
            var txt = renderMethods[n.type](n);
            if (txt) {
                buf += txt;
                if (txt.length && n.selectors) {
                    buf += delim;
                }
            }
        }
        return buf;
    }
    return visit(tree.stylesheet.rules);
}

function walkCss(node, fn) {
    node.rules.forEach((function(rule) {
        if (rule.rules) {
            walkCss(rule, fn);
            return;
        }
        if (rule.keyframes) {
            rule.keyframes.forEach((function(keyframe) {
                if (keyframe.type === "keyframe") {
                    fn(keyframe.declarations, rule);
                }
            }));
            return;
        }
        if (!rule.declarations) {
            return;
        }
        fn(rule.declarations, node);
    }));
}

var VAR_PROP_IDENTIFIER = "--";

var VAR_FUNC_IDENTIFIER = "var";

function transformCss(cssData) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    var defaults = {
        preserveStatic: true,
        preserveVars: false,
        variables: {},
        onWarning: function onWarning() {}
    };
    var settings = _extends({}, defaults, options);
    if (typeof cssData === "string") {
        cssData = parseCss(cssData, settings);
    }
    walkCss(cssData.stylesheet, (function(declarations, node) {
        for (var i = 0; i < declarations.length; i++) {
            var decl = declarations[i];
            var type = decl.type;
            var prop = decl.property;
            var value = decl.value;
            if (type !== "declaration") {
                continue;
            }
            if (!settings.preserveVars && prop && prop.indexOf(VAR_PROP_IDENTIFIER) === 0) {
                declarations.splice(i, 1);
                i--;
                continue;
            }
            if (value.indexOf(VAR_FUNC_IDENTIFIER + "(") !== -1) {
                var resolvedValue = resolveValue(value, settings);
                if (resolvedValue !== decl.value) {
                    resolvedValue = fixNestedCalc(resolvedValue);
                    if (!settings.preserveVars) {
                        decl.value = resolvedValue;
                    } else {
                        declarations.splice(i, 0, {
                            type: type,
                            property: prop,
                            value: resolvedValue
                        });
                        i++;
                    }
                }
            }
        }
    }));
    return stringifyCss(cssData);
}

function fixNestedCalc(value) {
    var reCalcVal = /calc\(([^)]+)\)/g;
    (value.match(reCalcVal) || []).forEach((function(match) {
        var newVal = "calc".concat(match.split("calc").join(""));
        value = value.replace(match, newVal);
    }));
    return value;
}

function resolveValue(value) {
    var settings = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    var __recursiveFallback = arguments.length > 2 ? arguments[2] : undefined;
    if (value.indexOf("var(") === -1) {
        return value;
    }
    var valueData = balancedMatch("(", ")", value);
    function resolveFunc(value) {
        var name = value.split(",")[0].replace(/[\s\n\t]/g, "");
        var fallback = (value.match(/(?:\s*,\s*){1}(.*)?/) || [])[1];
        var match = Object.prototype.hasOwnProperty.call(settings.variables, name) ? String(settings.variables[name]) : undefined;
        var replacement = match || (fallback ? String(fallback) : undefined);
        var unresolvedFallback = __recursiveFallback || value;
        if (!match) {
            settings.onWarning('variable "'.concat(name, '" is undefined'));
        }
        if (replacement && replacement !== "undefined" && replacement.length > 0) {
            return resolveValue(replacement, settings, unresolvedFallback);
        } else {
            return "var(".concat(unresolvedFallback, ")");
        }
    }
    if (!valueData) {
        if (value.indexOf("var(") !== -1) {
            settings.onWarning('missing closing ")" in the value "'.concat(value, '"'));
        }
        return value;
    } else if (valueData.pre.slice(-3) === "var") {
        var isEmptyVarFunc = valueData.body.trim().length === 0;
        if (isEmptyVarFunc) {
            settings.onWarning("var() must contain a non-whitespace string");
            return value;
        } else {
            return valueData.pre.slice(0, -3) + resolveFunc(valueData.body) + resolveValue(valueData.post, settings);
        }
    } else {
        return valueData.pre + "(".concat(resolveValue(valueData.body, settings), ")") + resolveValue(valueData.post, settings);
    }
}

var isBrowser = typeof window !== "undefined";

var isNativeSupport = isBrowser && window.CSS && window.CSS.supports && window.CSS.supports("(--a: 0)");

var counters = {
    group: 0,
    job: 0
};

var defaults = {
    rootElement: isBrowser ? document : null,
    shadowDOM: false,
    include: "style,link[rel=stylesheet]",
    exclude: "",
    variables: {},
    onlyLegacy: true,
    preserveStatic: true,
    preserveVars: false,
    silent: false,
    updateDOM: true,
    updateURLs: true,
    watch: null,
    onBeforeSend: function onBeforeSend() {},
    onError: function onError() {},
    onWarning: function onWarning() {},
    onSuccess: function onSuccess() {},
    onComplete: function onComplete() {},
    onFinally: function onFinally() {}
};

var regex = {
    cssComments: /\/\*[\s\S]+?\*\//g,
    cssKeyframes: /@(?:-\w*-)?keyframes/,
    cssMediaQueries: /@media[^{]+\{([\s\S]+?})\s*}/g,
    cssUrls: /url\((?!['"]?(?:data|http|\/\/):)['"]?([^'")]*)['"]?\)/g,
    cssVarDeclRules: /(?::(?:root|host)(?![.:#(])[\s,]*[^{]*{\s*[^}]*})/g,
    cssVarDecls: /(?:[\s;]*)(-{2}\w[\w-]*)(?:\s*:\s*)([^;]*);/g,
    cssVarFunc: /var\(\s*--[\w-]/,
    cssVars: /(?:(?::(?:root|host)(?![.:#(])[\s,]*[^{]*{\s*[^;]*;*\s*)|(?:var\(\s*))(--[^:)]+)(?:\s*[:)])/
};

var variableStore = {
    dom: {},
    job: {},
    user: {}
};

var cssVarsIsRunning = false;

var cssVarsObserver = null;

var cssVarsSrcNodeCount = 0;

var debounceTimer = null;

var isShadowDOMReady = false;

/**
 * Fetches, parses, and transforms CSS custom properties from specified
 * <style> and <link> elements into static values, then appends a new <style>
 * element with static values to the DOM to provide CSS custom property
 * compatibility for legacy browsers. Also provides a single interface for
 * live updates of runtime values in both modern and legacy browsers.
 *
 * @preserve
 * @param {object}   [options] Options object
 * @param {object}   [options.rootElement=document] Root element to traverse for
 *                   <link> and <style> nodes
 * @param {boolean}  [options.shadowDOM=false] Determines if shadow DOM <link>
 *                   and <style> nodes will be processed.
 * @param {string}   [options.include="style,link[rel=stylesheet]"] CSS selector
 *                   matching <link re="stylesheet"> and <style> nodes to
 *                   process
 * @param {string}   [options.exclude] CSS selector matching <link
 *                   rel="stylehseet"> and <style> nodes to exclude from those
 *                   matches by options.include
 * @param {object}   [options.variables] A map of custom property name/value
 *                   pairs. Property names can omit or include the leading
 *                   double-hyphen (—), and values specified will override
 *                   previous values
 * @param {boolean}  [options.onlyLegacy=true] Determines if the ponyfill will
 *                   only generate legacy-compatible CSS in browsers that lack
 *                   native support (i.e., legacy browsers)
 * @param {boolean}  [options.preserveStatic=true] Determines if CSS
 *                   declarations that do not reference a custom property will
 *                   be preserved in the transformed CSS
 * @param {boolean}  [options.preserveVars=false] Determines if CSS custom
 *                   property declarations will be preserved in the transformed
 *                   CSS
 * @param {boolean}  [options.silent=false] Determines if warning and error
 *                   messages will be displayed on the console
 * @param {boolean}  [options.updateDOM=true] Determines if the ponyfill will
 *                   update the DOM after processing CSS custom properties
 * @param {boolean}  [options.updateURLs=true] Determines if relative url()
 *                   paths will be converted to absolute urls in external CSS
 * @param {boolean}  [options.watch=false] Determines if a MutationObserver will
 *                   be created that will execute the ponyfill when a <link> or
 *                   <style> DOM mutation is observed
 * @param {function} [options.onBeforeSend] Callback before XHR is sent. Passes
 *                   1) the XHR object, 2) source node reference, and 3) the
 *                   source URL as arguments
 * @param {function} [options.onError] Callback after a CSS parsing error has
 *                   occurred or an XHR request has failed. Passes 1) an error
 *                   message, and 2) source node reference, 3) xhr, and 4 url as
 *                   arguments.
 * @param {function} [options.onWarning] Callback after each CSS parsing warning
 *                   has occurred. Passes 1) a warning message as an argument.
 * @param {function} [options.onSuccess] Callback after CSS data has been
 *                   collected from each node and before CSS custom properties
 *                   have been transformed. Allows modifying the CSS data before
 *                   it is transformed by returning any string value (or false
 *                   to skip). Passes 1) CSS text, 2) source node reference, and
 *                   3) the source URL as arguments.
 * @param {function} [options.onComplete] Callback after all CSS has been
 *                   processed, legacy-compatible CSS has been generated, and
 *                   (optionally) the DOM has been updated. Passes 1) a CSS
 *                   string with CSS variable values resolved, 2) an array of
 *                   output <style> node references that have been appended to
 *                   the DOM, 3) an object containing all custom properies names
 *                   and values, and 4) the ponyfill execution time in
 *                   milliseconds.
 * @param {function} [options.onFinally] Callback in modern and legacy browsers
 *                   after the ponyfill has finished all tasks. Passes 1) a
 *                   boolean indicating if the last ponyfill call resulted in a
 *                   style change, 2) a boolean indicating if the current
 *                   browser provides native support for CSS custom properties,
 *                   and 3) the ponyfill execution time in milliseconds.
 * @example
 *
 *   cssVars({
 *     rootElement   : document,
 *     shadowDOM     : false,
 *     include       : 'style,link[rel="stylesheet"]',
 *     exclude       : '',
 *     variables     : {},
 *     onlyLegacy    : true,
 *     preserveStatic: true,
 *     preserveVars  : false,
 *     silent        : false,
 *     updateDOM     : true,
 *     updateURLs    : true,
 *     watch         : false,
 *     onBeforeSend(xhr, node, url) {},
 *     onError(message, node, xhr, url) {},
 *     onWarning(message) {},
 *     onSuccess(cssText, node, url) {},
 *     onComplete(cssText, styleNode, cssVariables, benchmark) {},
 *     onFinally(hasChanged, hasNativeSupport, benchmark)
 *   });
 */ function cssVars() {
    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
    var msgPrefix = "cssVars(): ";
    var settings = _extends({}, defaults, options);
    function handleError(message, sourceNode, xhr, url) {
        if (!settings.silent && window.console) {
            console.error("".concat(msgPrefix).concat(message, "\n"), sourceNode);
        }
        settings.onError(message, sourceNode, xhr, url);
    }
    function handleWarning(message) {
        if (!settings.silent && window.console) {
            console.warn("".concat(msgPrefix).concat(message));
        }
        settings.onWarning(message);
    }
    function handleFinally(hasChanged) {
        settings.onFinally(Boolean(hasChanged), isNativeSupport, getTimeStamp() - settings.__benchmark);
    }
    if (!isBrowser) {
        return;
    }
    if (settings.watch) {
        settings.watch = defaults.watch;
        addMutationObserver(settings);
        cssVars(settings);
        return;
    } else if (settings.watch === false && cssVarsObserver) {
        cssVarsObserver.disconnect();
        cssVarsObserver = null;
    }
    if (!settings.__benchmark) {
        if (cssVarsIsRunning === settings.rootElement) {
            cssVarsDebounced(options);
            return;
        }
        var srcNodes = Array.apply(null, settings.rootElement.querySelectorAll('[data-cssvars]:not([data-cssvars="out"])'));
        settings.__benchmark = getTimeStamp();
        settings.exclude = [ cssVarsObserver ? '[data-cssvars]:not([data-cssvars=""])' : '[data-cssvars="out"]', "link[disabled]:not([data-cssvars])", settings.exclude ].filter((function(selector) {
            return selector;
        })).join(",");
        settings.variables = fixVarNames(settings.variables);
        srcNodes.forEach((function(srcNode) {
            var hasStyleCache = srcNode.nodeName.toLowerCase() === "style" && srcNode.__cssVars.text;
            var hasStyleChanged = hasStyleCache && srcNode.textContent !== srcNode.__cssVars.text;
            if (hasStyleCache && hasStyleChanged) {
                srcNode.sheet && (srcNode.sheet.disabled = false);
                srcNode.setAttribute("data-cssvars", "");
            }
        }));
        if (!cssVarsObserver) {
            var outNodes = Array.apply(null, settings.rootElement.querySelectorAll('[data-cssvars="out"]'));
            outNodes.forEach((function(outNode) {
                var dataGroup = outNode.getAttribute("data-cssvars-group");
                var srcNode = dataGroup ? settings.rootElement.querySelector('[data-cssvars="src"][data-cssvars-group="'.concat(dataGroup, '"]')) : null;
                if (!srcNode) {
                    outNode.parentNode.removeChild(outNode);
                }
            }));
            if (cssVarsSrcNodeCount && srcNodes.length < cssVarsSrcNodeCount) {
                cssVarsSrcNodeCount = srcNodes.length;
                variableStore.dom = {};
            }
        }
    }
    if (document.readyState !== "loading") {
        if (isNativeSupport && settings.onlyLegacy) {
            var hasVarChange = false;
            if (settings.updateDOM) {
                var targetElm = settings.rootElement.host || (settings.rootElement === document ? document.documentElement : settings.rootElement);
                Object.keys(settings.variables).forEach((function(key) {
                    var varValue = settings.variables[key];
                    hasVarChange = hasVarChange || varValue !== getComputedStyle(targetElm).getPropertyValue(key);
                    targetElm.style.setProperty(key, varValue);
                }));
            }
            handleFinally(hasVarChange);
        } else if (!isShadowDOMReady && (settings.shadowDOM || settings.rootElement.shadowRoot || settings.rootElement.host)) {
            getCssData({
                rootElement: defaults.rootElement,
                include: defaults.include,
                exclude: settings.exclude,
                skipDisabled: false,
                onSuccess: function onSuccess(cssText, node, url) {
                    var isUserDisabled = (node.sheet || {}).disabled && !node.__cssVars;
                    if (isUserDisabled) {
                        return false;
                    }
                    cssText = cssText.replace(regex.cssComments, "").replace(regex.cssMediaQueries, "");
                    cssText = (cssText.match(regex.cssVarDeclRules) || []).join("");
                    return cssText || false;
                },
                onComplete: function onComplete(cssText, cssArray, nodeArray) {
                    parseVars(cssText, {
                        store: variableStore.dom,
                        onWarning: handleWarning
                    });
                    isShadowDOMReady = true;
                    cssVars(settings);
                }
            });
        } else {
            cssVarsIsRunning = settings.rootElement;
            getCssData({
                rootElement: settings.rootElement,
                include: settings.include,
                exclude: settings.exclude,
                skipDisabled: false,
                onBeforeSend: settings.onBeforeSend,
                onError: function onError(xhr, node, url) {
                    var responseUrl = xhr.responseURL || getFullUrl$1(url, location.href);
                    var statusText = xhr.statusText ? "(".concat(xhr.statusText, ")") : "Unspecified Error" + (xhr.status === 0 ? " (possibly CORS related)" : "");
                    var errorMsg = "CSS XHR Error: ".concat(responseUrl, " ").concat(xhr.status, " ").concat(statusText);
                    handleError(errorMsg, node, xhr, responseUrl);
                },
                onSuccess: function onSuccess(cssText, node, url) {
                    var isUserDisabled = (node.sheet || {}).disabled && !node.__cssVars;
                    if (isUserDisabled) {
                        return false;
                    }
                    var isLink = node.nodeName.toLowerCase() === "link";
                    var isStyleImport = node.nodeName.toLowerCase() === "style" && cssText !== node.textContent;
                    var returnVal = settings.onSuccess(cssText, node, url);
                    cssText = returnVal !== undefined && Boolean(returnVal) === false ? "" : returnVal || cssText;
                    if (settings.updateURLs && (isLink || isStyleImport)) {
                        cssText = fixRelativeCssUrls(cssText, url);
                    }
                    return cssText;
                },
                onComplete: function onComplete(cssText, cssArray) {
                    var nodeArray = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : [];
                    var currentVars = _extends({}, variableStore.dom, variableStore.user);
                    var hasVarChange = false;
                    variableStore.job = {};
                    nodeArray.forEach((function(node, i) {
                        var nodeCSS = cssArray[i];
                        node.__cssVars = node.__cssVars || {};
                        node.__cssVars.text = nodeCSS;
                        if (regex.cssVars.test(nodeCSS)) {
                            try {
                                var cssTree = parseCss(nodeCSS, {
                                    preserveStatic: settings.preserveStatic,
                                    removeComments: true
                                });
                                parseVars(cssTree, {
                                    parseHost: Boolean(settings.rootElement.host),
                                    store: variableStore.dom,
                                    onWarning: handleWarning
                                });
                                node.__cssVars.tree = cssTree;
                            } catch (err) {
                                handleError(err.message, node);
                            }
                        }
                    }));
                    _extends(variableStore.job, variableStore.dom);
                    if (settings.updateDOM) {
                        _extends(variableStore.user, settings.variables);
                        _extends(variableStore.job, variableStore.user);
                    } else {
                        _extends(variableStore.job, variableStore.user, settings.variables);
                        _extends(currentVars, settings.variables);
                    }
                    hasVarChange = counters.job > 0 && Boolean(Object.keys(variableStore.job).length > Object.keys(currentVars).length || Boolean(Object.keys(currentVars).length && Object.keys(variableStore.job).some((function(key) {
                        return variableStore.job[key] !== currentVars[key];
                    }))));
                    if (hasVarChange) {
                        resetCssNodes(settings.rootElement);
                        cssVars(settings);
                    } else {
                        var outCssArray = [];
                        var outNodeArray = [];
                        var hasKeyframesWithVars = false;
                        if (settings.updateDOM) {
                            counters.job++;
                        }
                        nodeArray.forEach((function(node, i) {
                            var isSkip = !node.__cssVars.tree;
                            if (node.__cssVars.tree) {
                                try {
                                    transformCss(node.__cssVars.tree, _extends({}, settings, {
                                        variables: variableStore.job,
                                        onWarning: handleWarning
                                    }));
                                    var outCss = stringifyCss(node.__cssVars.tree);
                                    if (settings.updateDOM) {
                                        var nodeCSS = cssArray[i];
                                        var hasCSSVarFunc = regex.cssVarFunc.test(nodeCSS);
                                        if (!node.getAttribute("data-cssvars")) {
                                            node.setAttribute("data-cssvars", "src");
                                        }
                                        if (outCss.length && hasCSSVarFunc) {
                                            var dataGroup = node.getAttribute("data-cssvars-group") || ++counters.group;
                                            var outCssNoSpaces = outCss.replace(/\s/g, "");
                                            var outNode = settings.rootElement.querySelector('[data-cssvars="out"][data-cssvars-group="'.concat(dataGroup, '"]')) || document.createElement("style");
                                            hasKeyframesWithVars = hasKeyframesWithVars || regex.cssKeyframes.test(outCss);
                                            if (settings.preserveStatic) {
                                                node.sheet && (node.sheet.disabled = true);
                                            }
                                            if (!outNode.hasAttribute("data-cssvars")) {
                                                outNode.setAttribute("data-cssvars", "out");
                                            }
                                            if (outCssNoSpaces === node.textContent.replace(/\s/g, "")) {
                                                isSkip = true;
                                                if (outNode && outNode.parentNode) {
                                                    node.removeAttribute("data-cssvars-group");
                                                    outNode.parentNode.removeChild(outNode);
                                                }
                                            } else if (outCssNoSpaces !== outNode.textContent.replace(/\s/g, "")) {
                                                [ node, outNode ].forEach((function(n) {
                                                    n.setAttribute("data-cssvars-job", counters.job);
                                                    n.setAttribute("data-cssvars-group", dataGroup);
                                                }));
                                                outNode.textContent = outCss;
                                                outCssArray.push(outCss);
                                                outNodeArray.push(outNode);
                                                if (!outNode.parentNode) {
                                                    node.parentNode.insertBefore(outNode, node.nextSibling);
                                                }
                                            }
                                        }
                                    } else {
                                        if (node.textContent.replace(/\s/g, "") !== outCss) {
                                            outCssArray.push(outCss);
                                        }
                                    }
                                } catch (err) {
                                    handleError(err.message, node);
                                }
                            }
                            if (isSkip) {
                                node.setAttribute("data-cssvars", "skip");
                            }
                            if (!node.hasAttribute("data-cssvars-job")) {
                                node.setAttribute("data-cssvars-job", counters.job);
                            }
                        }));
                        cssVarsSrcNodeCount = settings.rootElement.querySelectorAll('[data-cssvars]:not([data-cssvars="out"])').length;
                        if (settings.shadowDOM) {
                            var elms = [].concat(settings.rootElement).concat(Array.apply(null, settings.rootElement.querySelectorAll("*")));
                            for (var i = 0, elm; elm = elms[i]; ++i) {
                                if (elm.shadowRoot && elm.shadowRoot.querySelector("style")) {
                                    var shadowSettings = _extends({}, settings, {
                                        rootElement: elm.shadowRoot
                                    });
                                    cssVars(shadowSettings);
                                }
                            }
                        }
                        if (settings.updateDOM && hasKeyframesWithVars) {
                            fixKeyframes(settings.rootElement);
                        }
                        cssVarsIsRunning = false;
                        settings.onComplete(outCssArray.join(""), outNodeArray, JSON.parse(JSON.stringify(variableStore.job)), getTimeStamp() - settings.__benchmark);
                        handleFinally(outNodeArray.length);
                    }
                }
            });
        }
    } else {
        document.addEventListener("DOMContentLoaded", (function init(evt) {
            cssVars(options);
            document.removeEventListener("DOMContentLoaded", init);
        }));
    }
}

cssVars.reset = function() {
    counters.job = 0;
    counters.group = 0;
    cssVarsIsRunning = false;
    if (cssVarsObserver) {
        cssVarsObserver.disconnect();
        cssVarsObserver = null;
    }
    cssVarsSrcNodeCount = 0;
    debounceTimer = null;
    isShadowDOMReady = false;
    for (var prop in variableStore) {
        variableStore[prop] = {};
    }
};

function addMutationObserver(settings) {
    function isDisabled(node) {
        var isDisabledAttr = isLink(node) && node.hasAttribute("disabled");
        var isDisabledSheet = (node.sheet || {}).disabled;
        return isDisabledAttr || isDisabledSheet;
    }
    function isLink(node) {
        var isStylesheet = node.nodeName.toLowerCase() === "link" && (node.getAttribute("rel") || "").indexOf("stylesheet") !== -1;
        return isStylesheet;
    }
    function isStyle(node) {
        return node.nodeName.toLowerCase() === "style";
    }
    function isValidAttributeMutation(mutation) {
        var isValid = false;
        if (mutation.type === "attributes" && isLink(mutation.target) && !isDisabled(mutation.target)) {
            var isEnabledMutation = mutation.attributeName === "disabled";
            var isHrefMutation = mutation.attributeName === "href";
            var isSkipNode = mutation.target.getAttribute("data-cssvars") === "skip";
            var isSrcNode = mutation.target.getAttribute("data-cssvars") === "src";
            if (isEnabledMutation) {
                isValid = !isSkipNode && !isSrcNode;
            } else if (isHrefMutation) {
                if (isSkipNode) {
                    mutation.target.setAttribute("data-cssvars", "");
                } else if (isSrcNode) {
                    resetCssNodes(settings.rootElement, true);
                }
                isValid = true;
            }
        }
        return isValid;
    }
    function isValidStyleTextMutation(mutation) {
        var isValid = false;
        if (mutation.type === "childList") {
            var isStyleElm = isStyle(mutation.target);
            var isOutNode = mutation.target.getAttribute("data-cssvars") === "out";
            isValid = isStyleElm && !isOutNode;
        }
        return isValid;
    }
    function isValidAddMutation(mutation) {
        var isValid = false;
        if (mutation.type === "childList") {
            isValid = Array.apply(null, mutation.addedNodes).some((function(node) {
                var isElm = node.nodeType === 1;
                var hasAttr = isElm && node.hasAttribute("data-cssvars");
                var isStyleWithVars = isStyle(node) && regex.cssVars.test(node.textContent);
                var isValid = !hasAttr && (isLink(node) || isStyleWithVars);
                return isValid && !isDisabled(node);
            }));
        }
        return isValid;
    }
    function isValidRemoveMutation(mutation) {
        var isValid = false;
        if (mutation.type === "childList") {
            isValid = Array.apply(null, mutation.removedNodes).some((function(node) {
                var isElm = node.nodeType === 1;
                var isOutNode = isElm && node.getAttribute("data-cssvars") === "out";
                var isSrcNode = isElm && node.getAttribute("data-cssvars") === "src";
                var isValid = isSrcNode;
                if (isSrcNode || isOutNode) {
                    var dataGroup = node.getAttribute("data-cssvars-group");
                    var orphanNode = settings.rootElement.querySelector('[data-cssvars-group="'.concat(dataGroup, '"]'));
                    if (isSrcNode) {
                        resetCssNodes(settings.rootElement, true);
                    }
                    if (orphanNode) {
                        orphanNode.parentNode.removeChild(orphanNode);
                    }
                }
                return isValid;
            }));
        }
        return isValid;
    }
    if (!window.MutationObserver) {
        return;
    }
    if (cssVarsObserver) {
        cssVarsObserver.disconnect();
        cssVarsObserver = null;
    }
    cssVarsObserver = new MutationObserver((function(mutations) {
        var hasValidMutation = mutations.some((function(mutation) {
            return isValidAttributeMutation(mutation) || isValidStyleTextMutation(mutation) || isValidAddMutation(mutation) || isValidRemoveMutation(mutation);
        }));
        if (hasValidMutation) {
            cssVars(settings);
        }
    }));
    cssVarsObserver.observe(document.documentElement, {
        attributes: true,
        attributeFilter: [ "disabled", "href" ],
        childList: true,
        subtree: true
    });
}

function cssVarsDebounced(settings) {
    var delay = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 100;
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout((function() {
        settings.__benchmark = null;
        cssVars(settings);
    }), delay);
}

function fixKeyframes(rootElement) {
    var animationNameProp = [ "animation-name", "-moz-animation-name", "-webkit-animation-name" ].filter((function(prop) {
        return getComputedStyle(document.body)[prop];
    }))[0];
    if (animationNameProp) {
        var allNodes = rootElement.getElementsByTagName("*");
        var keyframeNodes = [];
        var nameMarker = "__CSSVARSPONYFILL-KEYFRAMES__";
        for (var i = 0, len = allNodes.length; i < len; i++) {
            var node = allNodes[i];
            var animationName = getComputedStyle(node)[animationNameProp];
            if (animationName !== "none") {
                node.style[animationNameProp] += nameMarker;
                keyframeNodes.push(node);
            }
        }
        void document.body.offsetHeight;
        for (var _i = 0, _len = keyframeNodes.length; _i < _len; _i++) {
            var nodeStyle = keyframeNodes[_i].style;
            nodeStyle[animationNameProp] = nodeStyle[animationNameProp].replace(nameMarker, "");
        }
    }
}

function fixRelativeCssUrls(cssText, baseUrl) {
    var cssUrls = cssText.replace(regex.cssComments, "").match(regex.cssUrls) || [];
    cssUrls.forEach((function(cssUrl) {
        var oldUrl = cssUrl.replace(regex.cssUrls, "$1");
        var newUrl = getFullUrl$1(oldUrl, baseUrl);
        cssText = cssText.replace(cssUrl, cssUrl.replace(oldUrl, newUrl));
    }));
    return cssText;
}

function fixVarNames() {
    var varObj = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
    var reLeadingHyphens = /^-{2}/;
    return Object.keys(varObj).reduce((function(obj, value) {
        var key = reLeadingHyphens.test(value) ? value : "--".concat(value.replace(/^-+/, ""));
        obj[key] = varObj[value];
        return obj;
    }), {});
}

function getFullUrl$1(url) {
    var base = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : location.href;
    var d = document.implementation.createHTMLDocument("");
    var b = d.createElement("base");
    var a = d.createElement("a");
    d.head.appendChild(b);
    d.body.appendChild(a);
    b.href = base;
    a.href = url;
    return a.href;
}

function getTimeStamp() {
    return isBrowser && (window.performance || {}).now ? window.performance.now() : (new Date).getTime();
}

function resetCssNodes(rootElement) {
    var resetDOMVariableStore = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    var resetNodes = Array.apply(null, rootElement.querySelectorAll('[data-cssvars="skip"],[data-cssvars="src"]'));
    resetNodes.forEach((function(node) {
        return node.setAttribute("data-cssvars", "");
    }));
    if (resetDOMVariableStore) {
        variableStore.dom = {};
    }
}

/* harmony default export */ __webpack_exports__["default"] = (cssVars);
//# sourceMappingURL=css-vars-ponyfill.esm.js.map


/***/ }),

/***/ "./node_modules/lodash/_Symbol.js":
/*!****************************************!*\
  !*** ./node_modules/lodash/_Symbol.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var root = __webpack_require__(/*! ./_root */ "./node_modules/lodash/_root.js");

/** Built-in value references. */
var Symbol = root.Symbol;

module.exports = Symbol;


/***/ }),

/***/ "./node_modules/lodash/_baseGetTag.js":
/*!********************************************!*\
  !*** ./node_modules/lodash/_baseGetTag.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var Symbol = __webpack_require__(/*! ./_Symbol */ "./node_modules/lodash/_Symbol.js"),
    getRawTag = __webpack_require__(/*! ./_getRawTag */ "./node_modules/lodash/_getRawTag.js"),
    objectToString = __webpack_require__(/*! ./_objectToString */ "./node_modules/lodash/_objectToString.js");

/** `Object#toString` result references. */
var nullTag = '[object Null]',
    undefinedTag = '[object Undefined]';

/** Built-in value references. */
var symToStringTag = Symbol ? Symbol.toStringTag : undefined;

/**
 * The base implementation of `getTag` without fallbacks for buggy environments.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the `toStringTag`.
 */
function baseGetTag(value) {
  if (value == null) {
    return value === undefined ? undefinedTag : nullTag;
  }
  return (symToStringTag && symToStringTag in Object(value))
    ? getRawTag(value)
    : objectToString(value);
}

module.exports = baseGetTag;


/***/ }),

/***/ "./node_modules/lodash/_freeGlobal.js":
/*!********************************************!*\
  !*** ./node_modules/lodash/_freeGlobal.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {/** Detect free variable `global` from Node.js. */
var freeGlobal = typeof global == 'object' && global && global.Object === Object && global;

module.exports = freeGlobal;

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ "./node_modules/lodash/_getRawTag.js":
/*!*******************************************!*\
  !*** ./node_modules/lodash/_getRawTag.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var Symbol = __webpack_require__(/*! ./_Symbol */ "./node_modules/lodash/_Symbol.js");

/** Used for built-in method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var nativeObjectToString = objectProto.toString;

/** Built-in value references. */
var symToStringTag = Symbol ? Symbol.toStringTag : undefined;

/**
 * A specialized version of `baseGetTag` which ignores `Symbol.toStringTag` values.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the raw `toStringTag`.
 */
function getRawTag(value) {
  var isOwn = hasOwnProperty.call(value, symToStringTag),
      tag = value[symToStringTag];

  try {
    value[symToStringTag] = undefined;
    var unmasked = true;
  } catch (e) {}

  var result = nativeObjectToString.call(value);
  if (unmasked) {
    if (isOwn) {
      value[symToStringTag] = tag;
    } else {
      delete value[symToStringTag];
    }
  }
  return result;
}

module.exports = getRawTag;


/***/ }),

/***/ "./node_modules/lodash/_objectToString.js":
/*!************************************************!*\
  !*** ./node_modules/lodash/_objectToString.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/** Used for built-in method references. */
var objectProto = Object.prototype;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var nativeObjectToString = objectProto.toString;

/**
 * Converts `value` to a string using `Object.prototype.toString`.
 *
 * @private
 * @param {*} value The value to convert.
 * @returns {string} Returns the converted string.
 */
function objectToString(value) {
  return nativeObjectToString.call(value);
}

module.exports = objectToString;


/***/ }),

/***/ "./node_modules/lodash/_root.js":
/*!**************************************!*\
  !*** ./node_modules/lodash/_root.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var freeGlobal = __webpack_require__(/*! ./_freeGlobal */ "./node_modules/lodash/_freeGlobal.js");

/** Detect free variable `self`. */
var freeSelf = typeof self == 'object' && self && self.Object === Object && self;

/** Used as a reference to the global object. */
var root = freeGlobal || freeSelf || Function('return this')();

module.exports = root;


/***/ }),

/***/ "./node_modules/lodash/debounce.js":
/*!*****************************************!*\
  !*** ./node_modules/lodash/debounce.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(/*! ./isObject */ "./node_modules/lodash/isObject.js"),
    now = __webpack_require__(/*! ./now */ "./node_modules/lodash/now.js"),
    toNumber = __webpack_require__(/*! ./toNumber */ "./node_modules/lodash/toNumber.js");

/** Error message constants. */
var FUNC_ERROR_TEXT = 'Expected a function';

/* Built-in method references for those with the same name as other `lodash` methods. */
var nativeMax = Math.max,
    nativeMin = Math.min;

/**
 * Creates a debounced function that delays invoking `func` until after `wait`
 * milliseconds have elapsed since the last time the debounced function was
 * invoked. The debounced function comes with a `cancel` method to cancel
 * delayed `func` invocations and a `flush` method to immediately invoke them.
 * Provide `options` to indicate whether `func` should be invoked on the
 * leading and/or trailing edge of the `wait` timeout. The `func` is invoked
 * with the last arguments provided to the debounced function. Subsequent
 * calls to the debounced function return the result of the last `func`
 * invocation.
 *
 * **Note:** If `leading` and `trailing` options are `true`, `func` is
 * invoked on the trailing edge of the timeout only if the debounced function
 * is invoked more than once during the `wait` timeout.
 *
 * If `wait` is `0` and `leading` is `false`, `func` invocation is deferred
 * until to the next tick, similar to `setTimeout` with a timeout of `0`.
 *
 * See [David Corbacho's article](https://css-tricks.com/debouncing-throttling-explained-examples/)
 * for details over the differences between `_.debounce` and `_.throttle`.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Function
 * @param {Function} func The function to debounce.
 * @param {number} [wait=0] The number of milliseconds to delay.
 * @param {Object} [options={}] The options object.
 * @param {boolean} [options.leading=false]
 *  Specify invoking on the leading edge of the timeout.
 * @param {number} [options.maxWait]
 *  The maximum time `func` is allowed to be delayed before it's invoked.
 * @param {boolean} [options.trailing=true]
 *  Specify invoking on the trailing edge of the timeout.
 * @returns {Function} Returns the new debounced function.
 * @example
 *
 * // Avoid costly calculations while the window size is in flux.
 * jQuery(window).on('resize', _.debounce(calculateLayout, 150));
 *
 * // Invoke `sendMail` when clicked, debouncing subsequent calls.
 * jQuery(element).on('click', _.debounce(sendMail, 300, {
 *   'leading': true,
 *   'trailing': false
 * }));
 *
 * // Ensure `batchLog` is invoked once after 1 second of debounced calls.
 * var debounced = _.debounce(batchLog, 250, { 'maxWait': 1000 });
 * var source = new EventSource('/stream');
 * jQuery(source).on('message', debounced);
 *
 * // Cancel the trailing debounced invocation.
 * jQuery(window).on('popstate', debounced.cancel);
 */
function debounce(func, wait, options) {
  var lastArgs,
      lastThis,
      maxWait,
      result,
      timerId,
      lastCallTime,
      lastInvokeTime = 0,
      leading = false,
      maxing = false,
      trailing = true;

  if (typeof func != 'function') {
    throw new TypeError(FUNC_ERROR_TEXT);
  }
  wait = toNumber(wait) || 0;
  if (isObject(options)) {
    leading = !!options.leading;
    maxing = 'maxWait' in options;
    maxWait = maxing ? nativeMax(toNumber(options.maxWait) || 0, wait) : maxWait;
    trailing = 'trailing' in options ? !!options.trailing : trailing;
  }

  function invokeFunc(time) {
    var args = lastArgs,
        thisArg = lastThis;

    lastArgs = lastThis = undefined;
    lastInvokeTime = time;
    result = func.apply(thisArg, args);
    return result;
  }

  function leadingEdge(time) {
    // Reset any `maxWait` timer.
    lastInvokeTime = time;
    // Start the timer for the trailing edge.
    timerId = setTimeout(timerExpired, wait);
    // Invoke the leading edge.
    return leading ? invokeFunc(time) : result;
  }

  function remainingWait(time) {
    var timeSinceLastCall = time - lastCallTime,
        timeSinceLastInvoke = time - lastInvokeTime,
        timeWaiting = wait - timeSinceLastCall;

    return maxing
      ? nativeMin(timeWaiting, maxWait - timeSinceLastInvoke)
      : timeWaiting;
  }

  function shouldInvoke(time) {
    var timeSinceLastCall = time - lastCallTime,
        timeSinceLastInvoke = time - lastInvokeTime;

    // Either this is the first call, activity has stopped and we're at the
    // trailing edge, the system time has gone backwards and we're treating
    // it as the trailing edge, or we've hit the `maxWait` limit.
    return (lastCallTime === undefined || (timeSinceLastCall >= wait) ||
      (timeSinceLastCall < 0) || (maxing && timeSinceLastInvoke >= maxWait));
  }

  function timerExpired() {
    var time = now();
    if (shouldInvoke(time)) {
      return trailingEdge(time);
    }
    // Restart the timer.
    timerId = setTimeout(timerExpired, remainingWait(time));
  }

  function trailingEdge(time) {
    timerId = undefined;

    // Only invoke if we have `lastArgs` which means `func` has been
    // debounced at least once.
    if (trailing && lastArgs) {
      return invokeFunc(time);
    }
    lastArgs = lastThis = undefined;
    return result;
  }

  function cancel() {
    if (timerId !== undefined) {
      clearTimeout(timerId);
    }
    lastInvokeTime = 0;
    lastArgs = lastCallTime = lastThis = timerId = undefined;
  }

  function flush() {
    return timerId === undefined ? result : trailingEdge(now());
  }

  function debounced() {
    var time = now(),
        isInvoking = shouldInvoke(time);

    lastArgs = arguments;
    lastThis = this;
    lastCallTime = time;

    if (isInvoking) {
      if (timerId === undefined) {
        return leadingEdge(lastCallTime);
      }
      if (maxing) {
        // Handle invocations in a tight loop.
        clearTimeout(timerId);
        timerId = setTimeout(timerExpired, wait);
        return invokeFunc(lastCallTime);
      }
    }
    if (timerId === undefined) {
      timerId = setTimeout(timerExpired, wait);
    }
    return result;
  }
  debounced.cancel = cancel;
  debounced.flush = flush;
  return debounced;
}

module.exports = debounce;


/***/ }),

/***/ "./node_modules/lodash/isObject.js":
/*!*****************************************!*\
  !*** ./node_modules/lodash/isObject.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * Checks if `value` is the
 * [language type](http://www.ecma-international.org/ecma-262/7.0/#sec-ecmascript-language-types)
 * of `Object`. (e.g. arrays, functions, objects, regexes, `new Number(0)`, and `new String('')`)
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an object, else `false`.
 * @example
 *
 * _.isObject({});
 * // => true
 *
 * _.isObject([1, 2, 3]);
 * // => true
 *
 * _.isObject(_.noop);
 * // => true
 *
 * _.isObject(null);
 * // => false
 */
function isObject(value) {
  var type = typeof value;
  return value != null && (type == 'object' || type == 'function');
}

module.exports = isObject;


/***/ }),

/***/ "./node_modules/lodash/isObjectLike.js":
/*!*********************************************!*\
  !*** ./node_modules/lodash/isObjectLike.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * Checks if `value` is object-like. A value is object-like if it's not `null`
 * and has a `typeof` result of "object".
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
 * @example
 *
 * _.isObjectLike({});
 * // => true
 *
 * _.isObjectLike([1, 2, 3]);
 * // => true
 *
 * _.isObjectLike(_.noop);
 * // => false
 *
 * _.isObjectLike(null);
 * // => false
 */
function isObjectLike(value) {
  return value != null && typeof value == 'object';
}

module.exports = isObjectLike;


/***/ }),

/***/ "./node_modules/lodash/isSymbol.js":
/*!*****************************************!*\
  !*** ./node_modules/lodash/isSymbol.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var baseGetTag = __webpack_require__(/*! ./_baseGetTag */ "./node_modules/lodash/_baseGetTag.js"),
    isObjectLike = __webpack_require__(/*! ./isObjectLike */ "./node_modules/lodash/isObjectLike.js");

/** `Object#toString` result references. */
var symbolTag = '[object Symbol]';

/**
 * Checks if `value` is classified as a `Symbol` primitive or object.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a symbol, else `false`.
 * @example
 *
 * _.isSymbol(Symbol.iterator);
 * // => true
 *
 * _.isSymbol('abc');
 * // => false
 */
function isSymbol(value) {
  return typeof value == 'symbol' ||
    (isObjectLike(value) && baseGetTag(value) == symbolTag);
}

module.exports = isSymbol;


/***/ }),

/***/ "./node_modules/lodash/now.js":
/*!************************************!*\
  !*** ./node_modules/lodash/now.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var root = __webpack_require__(/*! ./_root */ "./node_modules/lodash/_root.js");

/**
 * Gets the timestamp of the number of milliseconds that have elapsed since
 * the Unix epoch (1 January 1970 00:00:00 UTC).
 *
 * @static
 * @memberOf _
 * @since 2.4.0
 * @category Date
 * @returns {number} Returns the timestamp.
 * @example
 *
 * _.defer(function(stamp) {
 *   console.log(_.now() - stamp);
 * }, _.now());
 * // => Logs the number of milliseconds it took for the deferred invocation.
 */
var now = function() {
  return root.Date.now();
};

module.exports = now;


/***/ }),

/***/ "./node_modules/lodash/toNumber.js":
/*!*****************************************!*\
  !*** ./node_modules/lodash/toNumber.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(/*! ./isObject */ "./node_modules/lodash/isObject.js"),
    isSymbol = __webpack_require__(/*! ./isSymbol */ "./node_modules/lodash/isSymbol.js");

/** Used as references for various `Number` constants. */
var NAN = 0 / 0;

/** Used to match leading and trailing whitespace. */
var reTrim = /^\s+|\s+$/g;

/** Used to detect bad signed hexadecimal string values. */
var reIsBadHex = /^[-+]0x[0-9a-f]+$/i;

/** Used to detect binary string values. */
var reIsBinary = /^0b[01]+$/i;

/** Used to detect octal string values. */
var reIsOctal = /^0o[0-7]+$/i;

/** Built-in method references without a dependency on `root`. */
var freeParseInt = parseInt;

/**
 * Converts `value` to a number.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to process.
 * @returns {number} Returns the number.
 * @example
 *
 * _.toNumber(3.2);
 * // => 3.2
 *
 * _.toNumber(Number.MIN_VALUE);
 * // => 5e-324
 *
 * _.toNumber(Infinity);
 * // => Infinity
 *
 * _.toNumber('3.2');
 * // => 3.2
 */
function toNumber(value) {
  if (typeof value == 'number') {
    return value;
  }
  if (isSymbol(value)) {
    return NAN;
  }
  if (isObject(value)) {
    var other = typeof value.valueOf == 'function' ? value.valueOf() : value;
    value = isObject(other) ? (other + '') : other;
  }
  if (typeof value != 'string') {
    return value === 0 ? value : +value;
  }
  value = value.replace(reTrim, '');
  var isBinary = reIsBinary.test(value);
  return (isBinary || reIsOctal.test(value))
    ? freeParseInt(value.slice(2), isBinary ? 2 : 8)
    : (reIsBadHex.test(value) ? NAN : +value);
}

module.exports = toNumber;


/***/ }),

/***/ "./node_modules/webpack/buildin/global.js":
/*!***********************************!*\
  !*** (webpack)/buildin/global.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || new Function("return this")();
} catch (e) {
	// This works if the window reference is available
	if (typeof window === "object") g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoianMvZnJvbnRlbmQuanMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vLmRldi9hc3NldHMvc2hhcmVkL2pzL2Zyb250ZW5kL2NvbXBvbmVudHMvcHJpbWFyeS1tZW51LmpzIiwid2VicGFjazovLy8uLy5kZXYvYXNzZXRzL3NoYXJlZC9qcy9mcm9udGVuZC9jb21wb25lbnRzL3NlYXJjaC10b2dnbGUuanMiLCJ3ZWJwYWNrOi8vLy4vLmRldi9hc3NldHMvc2hhcmVkL2pzL2Zyb250ZW5kL2NvbXBvbmVudHMvd29vLW1lbnUtY2FydC5qcyIsIndlYnBhY2s6Ly8vLi8uZGV2L2Fzc2V0cy9zaGFyZWQvanMvZnJvbnRlbmQvZnJvbnRlbmQuanMiLCJ3ZWJwYWNrOi8vLy4vLmRldi9hc3NldHMvc2hhcmVkL2pzL2Zyb250ZW5kL3ZlbmRvci9yZXNwb25zaXZlLW5hdi5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY3NzLXZhcnMtcG9ueWZpbGwvZGlzdC9jc3MtdmFycy1wb255ZmlsbC5lc20uanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2xvZGFzaC9fU3ltYm9sLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9sb2Rhc2gvX2Jhc2VHZXRUYWcuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2xvZGFzaC9fZnJlZUdsb2JhbC5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvbG9kYXNoL19nZXRSYXdUYWcuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2xvZGFzaC9fb2JqZWN0VG9TdHJpbmcuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2xvZGFzaC9fcm9vdC5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvbG9kYXNoL2RlYm91bmNlLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9sb2Rhc2gvaXNPYmplY3QuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2xvZGFzaC9pc09iamVjdExpa2UuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2xvZGFzaC9pc1N5bWJvbC5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvbG9kYXNoL25vdy5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvbG9kYXNoL3RvTnVtYmVyLmpzIiwid2VicGFjazovLy8od2VicGFjaykvYnVpbGRpbi9nbG9iYWwuanMiXSwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IFwiLi8uZGV2L2Fzc2V0cy9zaGFyZWQvanMvZnJvbnRlbmQvZnJvbnRlbmQuanNcIik7XG4iLCIvKiBnbG9iYWwgVGVuVXAgKi9cbmltcG9ydCAnLi4vdmVuZG9yL3Jlc3BvbnNpdmUtbmF2JztcblxuLyoqXG4gKiBIb29rIHVwIG5hdmlnYXRpb24uXG4gKi9cbmNvbnN0IGluaXQgPSAoKSA9PiB7XG5cdGlmICggVGVuVXAgKSB7XG5cdFx0VGVuVXAubmF2aWdhdGlvbigge1xuXHRcdFx0dGFyZ2V0OiAnI2hlYWRlcl9fbmF2aWdhdGlvbicsXG5cdFx0XHR0b2dnbGU6ICcjbmF2LXRvZ2dsZScsXG5cdFx0XHQvLyBlc2xpbnQtZGlzYWJsZS1uZXh0LWxpbmVcblx0XHRcdHN1Yl9tZW51X29wZW46IGdvRnJvbnRlbmQub3Blbk1lbnVPbkhvdmVyID8gJ2hvdmVyJyA6ICdjbGljaydcblx0XHR9ICk7XG5cdH1cblxuXHRkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCAna2V5ZG93bicsIGxvY2tNZW51Rm9jdXMgKTtcbn07XG5cbi8qKlxuICogTG9jayB0YWJiaW5nIHRvIHRoZSBtYWluIG5hdmlnYXRpb24gb25seS5cbiAqL1xuZnVuY3Rpb24gbG9ja01lbnVGb2N1cyggZXZ0ICkge1xuXHR2YXIgZSA9IGV2ZW50IHx8IGV2dDsgLy8gZm9yIGNyb3NzLWJyb3dzZXIgY29tcGF0aWJpbGl0eVxuXHR2YXIgY2hhckNvZGUgPSBlLndoaWNoIHx8IGUua2V5Q29kZTtcblxuXHRpZiAoIGNoYXJDb2RlICE9PSA5IHx8ICEgalF1ZXJ5KCAnYm9keScgKS5oYXNDbGFzcyggJ21lbnUtaXMtb3BlbicgKSApIHtcblx0XHRyZXR1cm47XG5cdH1cblxuXHR2YXIgJGVsZW1lbnQgICAgICAgPSBqUXVlcnkoICc6Zm9jdXMnICksXG5cdCAgICBtYWluTWVudUxlbmd0aCA9IGpRdWVyeSggJ3VsLnByaW1hcnktbWVudScgKS5jaGlsZHJlbigpLmxlbmd0aCxcblx0ICAgIGN1cnJlbnRJbmRleCAgID0galF1ZXJ5KCAkZWxlbWVudCApLmNsb3Nlc3QoICdsaScgKS5pbmRleCgpLFxuXHQgICAgaXNTaGlmdFRhYiAgICAgPSAoIGV2ZW50LnNoaWZ0S2V5ICYmIGV2ZW50LmtleUNvZGUgPT0gOSApO1xuXG5cdGlmICggJGVsZW1lbnQuY2xvc2VzdCggJ3VsJyApLmhhc0NsYXNzKCAnc3ViLW1lbnUnICkgKSB7XG5cdFx0cmV0dXJuO1xuXHR9XG5cblx0Y3VycmVudEluZGV4ID0gaXNTaGlmdFRhYiA/IGN1cnJlbnRJbmRleCAtIDEgOiBjdXJyZW50SW5kZXggKyAxO1xuXG5cdGlmICggJGVsZW1lbnQuYXR0ciggJ2lkJyApID09PSAnbmF2LXRvZ2dsZScgKSB7XG5cdFx0aWYgKCBpc1NoaWZ0VGFiICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblx0XHRzZXRUaW1lb3V0KCBmdW5jdGlvbigpIHtcblx0XHRcdGpRdWVyeSggJ3VsLnByaW1hcnktbWVudSBsaTpmaXJzdC1jaGlsZCBhJyApWzBdLmZvY3VzKCk7XG5cdFx0fSwgMTAgKTtcblx0fVxuXG5cdC8vIE1lbnUgbGlua1xuXHRpZiAoICRlbGVtZW50LnBhcmVudHMoICd1bC5wcmltYXJ5LW1lbnUnICkubGVuZ3RoID4gMCApIHtcblx0XHRpZiAoICggY3VycmVudEluZGV4IDwgMCAmJiBpc1NoaWZ0VGFiICkgfHwgKCBjdXJyZW50SW5kZXggPT09IG1haW5NZW51TGVuZ3RoICkgKSB7XG5cdFx0XHRzZXRUaW1lb3V0KCBmdW5jdGlvbigpIHtcblx0XHRcdFx0alF1ZXJ5KCAnI25hdi10b2dnbGUnICkuZm9jdXMoKTtcblx0XHRcdH0sIDEwICk7XG5cdFx0fVxuXHR9XG59O1xuXG5leHBvcnQgZGVmYXVsdCBpbml0O1xuIiwiY29uc3Qgc2VhcmNoVG9nZ2xlID0gKCkgPT4ge1xuXHRjb25zdCBzZWFyY2hUb2dnbGUgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCggJ2hlYWRlcl9fc2VhcmNoLXRvZ2dsZScgKTtcblxuXHRpZiAoICEgc2VhcmNoVG9nZ2xlICkge1xuXHRcdHJldHVybjtcblx0fVxuXG5cdGNvbnN0IHBlcmZvcm1Ub2dnbGUgPSAoIGVsZW1lbnQgKSA9PiB7XG5cdFx0Y29uc3QgdG9nZ2xlID0gZWxlbWVudDtcblx0XHRjb25zdCB0YXJnZXQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCB0b2dnbGUuZGF0YXNldC50b2dnbGVUYXJnZXQgKTtcblxuXHRcdGlmICggdGFyZ2V0LmNsYXNzTGlzdC5jb250YWlucyggJ3Nob3ctbW9kYWwnICkgKSB7XG5cdFx0XHQvLyBIaWRlIHRoZSBtb2RhbC5cblx0XHRcdHRhcmdldC5jbGFzc0xpc3QucmVtb3ZlKCAnYWN0aXZlJyApO1xuXG5cdFx0XHRzZXRUaW1lb3V0KCAoKSA9PiB7XG5cdFx0XHRcdHRhcmdldC5jbGFzc0xpc3QucmVtb3ZlKCAnc2hvdy1tb2RhbCcgKTtcblx0XHRcdFx0dG9nZ2xlLmZvY3VzKCk7XG5cdFx0XHR9LCAyNTAgKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0Ly8gU2hvdyB0aGUgbW9kYWwuXG5cdFx0XHR0YXJnZXQuY2xhc3NMaXN0LmFkZCggJ3Nob3ctbW9kYWwnICk7XG5cblx0XHRcdHNldFRpbWVvdXQoICgpID0+IHtcblx0XHRcdFx0dGFyZ2V0LmNsYXNzTGlzdC5hZGQoICdhY3RpdmUnICk7XG5cblx0XHRcdFx0aWYgKCB0b2dnbGUuZGF0YXNldC5zZXRGb2N1cyApIHtcblx0XHRcdFx0XHRjb25zdCBmb2N1c0VsZW1lbnQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCB0b2dnbGUuZGF0YXNldC5zZXRGb2N1cyApO1xuXG5cdFx0XHRcdFx0aWYgKCBmb2N1c0VsZW1lbnQgKSB7XG5cdFx0XHRcdFx0XHR2YXIgc2VhcmNoVGVybSA9IGZvY3VzRWxlbWVudC52YWx1ZTtcblx0XHRcdFx0XHRcdGZvY3VzRWxlbWVudC52YWx1ZSA9ICcnO1xuXHRcdFx0XHRcdFx0Zm9jdXNFbGVtZW50LmZvY3VzKCk7XG5cdFx0XHRcdFx0XHRmb2N1c0VsZW1lbnQudmFsdWUgPSBzZWFyY2hUZXJtO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fSwgMTAgKTtcblx0XHR9XG5cdH07XG5cblx0ZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCggJypbZGF0YS10b2dnbGUtdGFyZ2V0XScgKS5mb3JFYWNoKCBlbGVtZW50ID0+IHtcblx0XHRlbGVtZW50LmFkZEV2ZW50TGlzdGVuZXIoICdjbGljaycsIGV2ZW50ID0+IHtcblx0XHRcdGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cdFx0XHRwZXJmb3JtVG9nZ2xlKCBlbGVtZW50ICk7XG5cdFx0fSApO1xuXHR9ICk7XG5cblx0Ly8gQ2xvc2UgbW9kYWwgb24gZXNjYXBlIGtleSBwcmVzcy5cblx0ZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lciggJ2tleXVwJywgZXZlbnQgPT4ge1xuXHRcdGlmICggZXZlbnQua2V5Q29kZSA9PT0gMjcgKSB7XG5cdFx0XHRldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuXHRcdFx0ZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCggJy5zZWFyY2gtbW9kYWwuYWN0aXZlJyApLmZvckVhY2goIGVsZW1lbnQgPT4ge1xuXHRcdFx0XHRwZXJmb3JtVG9nZ2xlKFxuXHRcdFx0XHRcdGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoICcqW2RhdGEtdG9nZ2xlLXRhcmdldD1cIicgKyBlbGVtZW50LmRhdGFzZXQubW9kYWxUYXJnZXRTdHJpbmcgKyAnXCJdJyApXG5cdFx0XHRcdCk7XG5cdFx0XHR9ICk7XG5cdFx0fVxuXHR9ICk7XG5cblx0Ly8gQ2xvc2UgbW9kYWwgb24gb3V0c2lkZSBjbGljay5cblx0ZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lciggJ2NsaWNrJywgZXZlbnQgPT4ge1xuXHRcdGNvbnN0IHRhcmdldCA9IGV2ZW50LnRhcmdldDtcblx0XHRjb25zdCBtb2RhbCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoICcuc2VhcmNoLW1vZGFsLmFjdGl2ZScgKTtcblxuXHRcdGlmICggdGFyZ2V0ID09PSBtb2RhbCApIHtcblx0XHRcdHBlcmZvcm1Ub2dnbGUoXG5cdFx0XHRcdGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoICcqW2RhdGEtdG9nZ2xlLXRhcmdldD1cIicgKyBtb2RhbC5kYXRhc2V0Lm1vZGFsVGFyZ2V0U3RyaW5nICsgJ1wiXScgKVxuXHRcdFx0KTtcblx0XHR9XG5cdH0gKTtcblxuXHRkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCAna2V5ZG93bicsIGxvY2tTZWFyY2hGb2N1cyApO1xufTtcblxuLyoqXG4gKiBMb2NrIHRhYmJpbmcgdG8gdGhlIHNlYXJjaCBmb3JtIG9ubHkuXG4gKi9cbmZ1bmN0aW9uIGxvY2tTZWFyY2hGb2N1cyggZXZ0ICkge1xuXHR2YXIgZSA9IGV2ZW50IHx8IGV2dDsgLy8gZm9yIGNyb3NzLWJyb3dzZXIgY29tcGF0aWJpbGl0eVxuXHR2YXIgY2hhckNvZGUgPSBlLndoaWNoIHx8IGUua2V5Q29kZTtcblxuXHRpZiAoIGNoYXJDb2RlICE9PSA5IHx8ICEgalF1ZXJ5KCAnZGl2LnNlYXJjaC1tb2RhbCcgKS5oYXNDbGFzcyggJ2FjdGl2ZScgKSApIHtcblx0XHRyZXR1cm47XG5cdH1cblxuXHR2YXIgJGVsZW1lbnQgICAgICAgPSBqUXVlcnkoICc6Zm9jdXMnICksXG5cdCAgICBpc1NoaWZ0VGFiICAgICA9ICggZXZlbnQuc2hpZnRLZXkgJiYgZXZlbnQua2V5Q29kZSA9PSA5ICk7XG5cblx0aWYgKCAkZWxlbWVudC5oYXNDbGFzcyggJ3NlYXJjaC1mb3JtX19pbnB1dCcgKSAmJiBpc1NoaWZ0VGFiICkge1xuXHRcdHNldFRpbWVvdXQoIGZ1bmN0aW9uKCkge1xuXHRcdFx0alF1ZXJ5KCAnLnNlYXJjaC1pbnB1dF9fYnV0dG9uJyApLmZvY3VzKCk7XG5cdFx0fSwgMTAgKTtcblx0fVxuXG5cdGlmICggJGVsZW1lbnQuaGFzQ2xhc3MoICdzZWFyY2gtaW5wdXRfX2J1dHRvbicgKSAmJiAhIGlzU2hpZnRUYWIgKSB7XG5cdFx0c2V0VGltZW91dCggZnVuY3Rpb24oKSB7XG5cdFx0XHRqUXVlcnkoICdpbnB1dC5zZWFyY2gtZm9ybV9faW5wdXQnICkuZm9jdXMoKTtcblx0XHR9LCAxMCApO1xuXHR9XG59O1xuXG5cbmV4cG9ydCBkZWZhdWx0IHNlYXJjaFRvZ2dsZTtcbiIsImxldCBtZW51T2JqZWN0ICAgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCggJ2hlYWRlcl9fY2FydC10b2dnbGUnICk7XG5sZXQgc2l0ZU92ZXJsYXkgID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoICdzaXRlLW92ZXJsYXknICk7XG5sZXQgc2lkZU5hdiAgICAgID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoICdzaXRlLW5hdi0tY2FydCcgKTtcbmxldCBzaWRlTmF2Q2xvc2UgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCggJ3NpdGUtY2xvc2UtaGFuZGxlJyApO1xuXG5jb25zdCB3b29NZW51Q2FydCA9ICgpID0+IHtcblx0aWYgKFxuXHRcdG51bGwgPT09IG1lbnVPYmplY3QgfHxcblx0XHRudWxsID09PSBzaXRlT3ZlcmxheSB8fFxuXHRcdG51bGwgPT09IHNpZGVOYXZDbG9zZVxuXHQpIHtcblx0XHRyZXR1cm47XG5cdH1cblxuXHRkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5hZGQoICdoYXMtd29vLWNhcnQtc2xpZGVvdXQnICk7XG5cblx0bWVudU9iamVjdC5hZGRFdmVudExpc3RlbmVyKCAnY2xpY2snLCAgZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cdFx0dG9nZ2xlU2lkZU5hdlZpc2liaWxpdHkoKTtcblx0fSApO1xuXG5cdHNpdGVPdmVybGF5LmFkZEV2ZW50TGlzdGVuZXIoICdjbGljaycsIHRvZ2dsZVNpZGVOYXZWaXNpYmlsaXR5ICk7XG5cdHNpZGVOYXZDbG9zZS5hZGRFdmVudExpc3RlbmVyKCAnY2xpY2snLCB0b2dnbGVTaWRlTmF2VmlzaWJpbGl0eSApO1xufTtcblxuY29uc3QgdG9nZ2xlU2lkZU5hdlZpc2liaWxpdHkgPSAoIGV2ZW50ICkgPT4ge1xuXHRzaWRlTmF2LmNsYXNzTGlzdC50b2dnbGUoICdhY3RpdmUnICk7XG5cdHNpdGVPdmVybGF5LmNsYXNzTGlzdC50b2dnbGUoICdhY3RpdmUnICk7XG5cdGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LnRvZ2dsZSggJ3NpZGViYXItbW92ZScgKTtcbn07XG5cbmV4cG9ydCBkZWZhdWx0IHdvb01lbnVDYXJ0O1xuIiwiaW1wb3J0IGNzc1ZhcnMgZnJvbSAnY3NzLXZhcnMtcG9ueWZpbGwnO1xuaW1wb3J0IHByaW1hcnlNZW51IGZyb20gJy4vY29tcG9uZW50cy9wcmltYXJ5LW1lbnUuanMnO1xuaW1wb3J0IHNlYXJjaFRvZ2dsZSBmcm9tICcuL2NvbXBvbmVudHMvc2VhcmNoLXRvZ2dsZS5qcyc7XG5pbXBvcnQgd29vTWVudUNhcnQgZnJvbSAnLi9jb21wb25lbnRzL3dvby1tZW51LWNhcnQuanMnO1xuaW1wb3J0IF9kZWJvdWNlIGZyb20gJ2xvZGFzaC9kZWJvdW5jZSc7IC8vIHdlIG5lZWQgYW4gYWxpYXMgZm9yIGRlYm91bmNlIG90aGVyd2lzZSBpdCBjb25mbGljdHMgd2l0aCBjdXN0b21pemVyXG5cbnByaW1hcnlNZW51KCk7XG5zZWFyY2hUb2dnbGUoKTtcbndvb01lbnVDYXJ0KCk7XG5jc3NWYXJzKCk7XG5cbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoICdET01Db250ZW50TG9hZGVkJywgZnVuY3Rpb24oKSB7XG5cdGNvbnN0IGhhc1NlbGVjdGl2ZVJlZnJlc2ggPSAoXG5cdFx0J3VuZGVmaW5lZCcgIT09IHR5cGVvZiB3cCAmJlxuXHRcdHdwLmN1c3RvbWl6ZSAmJlxuXHRcdHdwLmN1c3RvbWl6ZS5zZWxlY3RpdmVSZWZyZXNoICYmXG5cdFx0d3AuY3VzdG9taXplLm5hdk1lbnVzUHJldmlldy5OYXZNZW51SW5zdGFuY2VQYXJ0aWFsXG5cdCk7XG5cblx0Ly8gcGFydGlhbC1jb250ZW50LXJlbmRlcmVkIG1pZ2h0IHJlbmRlciBtdWx0aXBsZSB0aW1lcyBmb3Igc29tZSByZWFzb24sIGxldCdzIG1ha2Ugc3VyZSB0byBkZWJvdWNlIHRoaXMuXG5cdGNvbnN0IGluaXQgPSBfZGVib3VjZSggKCkgPT4ge1xuXHRcdC8vIHdlIG5lZWQgdG8gcmVtb3ZlIHRoaXMgYmVmb3JlIGNhbGxpbmcgcHJpbWFyeSBtZW51IGFnYWluLlxuXHRcdGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LnJlbW92ZSggJ2hhcy1vZmZzY3JlZW4tbmF2JyApO1xuXG5cdFx0cHJpbWFyeU1lbnUoKTtcblx0XHRzZWFyY2hUb2dnbGUoKTtcblx0fSwgMTAwMCApO1xuXG5cdGlmICggaGFzU2VsZWN0aXZlUmVmcmVzaCApIHtcblx0XHR3cC5jdXN0b21pemUuc2VsZWN0aXZlUmVmcmVzaC5iaW5kKCAncGFydGlhbC1jb250ZW50LXJlbmRlcmVkJywgZnVuY3Rpb24gKCBwbGFjZW1lbnQgKSB7XG5cdFx0XHRjb25zdCBjaGFuZ2VkSGVhZGVyVmFyaWF0aW9uID0gKFxuXHRcdFx0XHRwbGFjZW1lbnQgJiZcblx0XHRcdFx0J251bGwnICE9PSBwbGFjZW1lbnQuY29udGFpbmVyWzBdLnBhcmVudE5vZGUgJiZcblx0XHRcdFx0J2hlYWRlcl92YXJpYXRpb24nID09PSBwbGFjZW1lbnQucGFydGlhbC5pZFxuXHRcdFx0KTtcblxuXHRcdFx0aWYgKCBjaGFuZ2VkSGVhZGVyVmFyaWF0aW9uICkge1xuXHRcdFx0XHRpbml0KCk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9XG59ICk7XG4iLCIvKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKipcblxuXHROYW1lOiBXb3JkUHJlc3MgQWNjZXNzaWJsZSBSZXNwb25zaXZlIE5hdmlnYXRpb24gTWVudVxuXHRVc2FnZTpcblxuXHRUZW5VcC5idWlsZF9tZW51KHtcblxuXHRcdCd0YXJnZXQnXHRcdDpcdCcjcHJpbWFyeS1uYXYnLCAgICAgIC8vIHRoZSBzZWxlY3RvciBvZiB0aGUgbmF2IG1lbnUgPHVsPlxuXHRcdCd0b2dnbGUnXHRcdDpcdCcjanMtbWVudS10b2dnbGUnLCAgIC8vIHRoZSBJRCBvZiB0aGUgbGluayB5b3UncmUgdXNpbmcgdG8gb3Blbi9jbG9zZSB0aGUgc21hbGwgc2NyZWVuIG1lbnVcblx0XHQnc3ViX21lbnVfb3BlbidcdDpcdCdob3ZlcidcblxuXHR9LCBmdW5jdGlvbigpIHtcblxuXHRcdGNvbnNvbGUubG9nKCdBbWF6aW5nIGNhbGxiYWNrIGZ1bmN0aW9uIScpO1xuXG5cdH0pO1xuXG4qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKi9cbi8qIGVzbGludC1kaXNhYmxlICovXG4oIGZ1bmN0aW9uKCkge1xuXG5cdCd1c2Ugc3RyaWN0JztcblxuXHQvLyBEZWZpbmUgZ2xvYmFsIFRlblVwIG9iamVjdCBpZiBpdCBkb2Vzbid0IGV4aXN0XG5cdGlmICggJ29iamVjdCcgIT09IHR5cGVvZiB3aW5kb3cuVGVuVXAgKSB7XG5cdFx0d2luZG93LlRlblVwID0ge307XG5cdH1cblxuXHQvKlxuXHRcdENhY2hlIGFuZCBkZWZpbmUgc29tZSB2YXJpYWJsZXNcblx0Ki9cblxuXHQvLyBpbml0IGZ1bmN0aW9uXG5cdFRlblVwLm5hdmlnYXRpb24gPSBmdW5jdGlvbiggb3B0aW9ucywgY2FsbGJhY2sgKSB7XG5cblx0XHR2YXIgZGVmYXVsdHMgPSB7XG5cdFx0XHQndGFyZ2V0J1x0XHQ6XHQnI3ByaW1hcnktbmF2Jyxcblx0XHRcdCd0b2dnbGUnXHRcdDpcdCcjanMtbWVudS10b2dnbGUnLFxuXHRcdFx0J3N1Yl9tZW51X29wZW4nXHQ6XHQnaG92ZXInXG5cdFx0fTtcblx0XHR2YXIgb3B0O1xuXG5cdFx0Ly8gTWFwIGFsbCBkZWZhdWx0IHNldHRpbmdzIHRvIHVzZXIgZGVmaW5lZCBvcHRpb25zIGlmIHRoZXkgZXhpc3Rcblx0XHRmb3IgKCBvcHQgPSAwOyBvcHQgPCBkZWZhdWx0cy5sZW5ndGg7IG9wdCA9IG9wdCArIDEgKSB7XG5cblx0XHRcdGlmKCB0eXBlb2Ygb3B0aW9uc1tvcHRdID09PSAndW5kZWZpbmVkJyApIHtcblx0XHRcdFx0b3B0aW9uc1tvcHRdID0gZGVmYXVsdHNbb3B0XTtcblx0XHRcdH1cblxuXHRcdH1cblxuXHRcdHZhciBtZW51ID0gZG9jdW1lbnQucXVlcnlTZWxlY3Rvciggb3B0aW9ucy50YXJnZXQgKTtcblxuXHRcdC8vIEJhaWwgb3V0IGlmIHRoZXJlJ3Mgbm8gbWVudVxuXHRcdGlmICggISBtZW51ICkgeyByZXR1cm47IH1cblxuXHRcdHZhciBtZW51X2lkID0gbWVudS5nZXRBdHRyaWJ1dGUoICdpZCcgKTtcblx0XHR2YXIgbWVudV90b2dnbGUgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCBvcHRpb25zLnRvZ2dsZSApO1xuXHRcdHZhciBhcmlhX2NvbnRyb2xzID0gbWVudV90b2dnbGUuZ2V0QXR0cmlidXRlKCAnYXJpYS1jb250cm9scycgKTtcblx0XHR2YXIgc3ViX21lbnVfYWNpb24gPSBvcHRpb25zLnN1Yl9tZW51X29wZW47XG5cdFx0dmFyIGN1cnJlbnRfbWVudV9pdGVtID0gbWVudS5xdWVyeVNlbGVjdG9yKCAnLmN1cnJlbnQtbWVudS1pdGVtJyApO1xuXHRcdHZhciBtZW51X2l0ZW1zX3dpdGhfY2hpbGRyZW4gPSBtZW51LnF1ZXJ5U2VsZWN0b3JBbGwoICcubWVudS1pdGVtLWhhcy1jaGlsZHJlbicgKTtcblx0XHR2YXIgbWVudV9pdGVtc193aXRoX2NoaWxkcmVuX2NvdW50ID0gbWVudV9pdGVtc193aXRoX2NoaWxkcmVuLmxlbmd0aDtcblx0XHR2YXIgY3VycmVudFRhcmdldDtcblx0XHR2YXIgdGFyZ2V0O1xuXHRcdHZhciBpO1xuXG5cdFx0Ly8gTGlzdGVuZXIgZm9yIHRoZSBtZW51IG9wZW4vY2xvc2UgYWN0aW9uXG5cdFx0ZnVuY3Rpb24gbGlzdGVuZXJfbWVudSggZSApIHtcblxuXHRcdFx0Ly8gU3RvcCBsaW5rcyBmcm9tIGZpcmluZ1xuXHRcdFx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG5cdFx0XHRpZiAoIGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LmNvbnRhaW5zKCAnbWVudS1pcy1vcGVuJyApICkge1xuXHRcdFx0XHQvLyBDbG9zZSB0aGUgbWVudVxuXHRcdFx0XHRtZW51LnNldEF0dHJpYnV0ZSggJ2FyaWEtaGlkZGVuJywgJ3RydWUnICk7XG5cdFx0XHRcdG1lbnVfdG9nZ2xlLnNldEF0dHJpYnV0ZSggJ2FyaWEtZXhwYW5kZWQnLCAnZmFsc2UnICk7XG5cblx0XHRcdFx0Ly8gQnViYmxlIHRvIHRoZSBkb2N1bWVudFxuXHRcdFx0XHRkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5yZW1vdmUoICdtZW51LWlzLW9wZW4nICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHQvLyBPcGVuIHRoZSBtZW51XG5cdFx0XHRcdG1lbnUuc2V0QXR0cmlidXRlKCAnYXJpYS1oaWRkZW4nLCAnZmFsc2UnICk7XG5cdFx0XHRcdG1lbnVfdG9nZ2xlLnNldEF0dHJpYnV0ZSggJ2FyaWEtZXhwYW5kZWQnLCAndHJ1ZScgKTtcblxuXHRcdFx0XHQvLyBTZXQgZm9jdXMgdG8gdGhlIGZpcnN0IGxpbmtcblx0XHRcdFx0bWVudS5xdWVyeVNlbGVjdG9yQWxsKCAnYScgKVswXS5mb2N1cygpO1xuXG5cdFx0XHRcdC8vIEJ1YmJsZSB0byB0aGUgZG9jdW1lbnRcblx0XHRcdFx0ZG9jdW1lbnQuYm9keS5jbGFzc0xpc3QuYWRkKCAnbWVudS1pcy1vcGVuJyApO1xuXHRcdFx0fVxuXG5cdFx0fTsgLy8gbGlzdGVuZXJfbWVudSgpXG5cblx0XHQvLyBMaXN0ZW5lciBmb3Igc3VibWVudSBvbiBjbGlja1xuXHRcdGZ1bmN0aW9uIGxpc3RlbmVyX3N1Ym1lbnVfY2xpY2soIGUgKSB7XG5cblx0XHRcdGN1cnJlbnRUYXJnZXQgPSBlLmN1cnJlbnRUYXJnZXQ7XG5cdFx0XHR0YXJnZXQgPSBlLnRhcmdldDtcblxuXHRcdFx0aWYgKCB0YXJnZXQudGFnTmFtZSA9PT0gJ3N2ZycgfHwgdGFyZ2V0LnRhZ05hbWUgPT09ICdwYXRoJyApIHtcblx0XHRcdFx0dGFyZ2V0ID0gY3VycmVudFRhcmdldC5jbG9zZXN0KCAnLm1lbnUtaXRlbSA+IGEnICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRjb25zb2xlLmxvZyggdGFyZ2V0LnByZXZpb3VzU2libGluZy5wcmV2aW91c1NpYmxpbmcuaHJlZiApO1xuXHRcdFx0XHRpZiAoIGdvRnJvbnRlbmQuaXNNb2JpbGUgKSB7XG5cdFx0XHRcdFx0aWYgKCB0YXJnZXQudGFnTmFtZSA9PT0gJ0EnICkge1xuXHRcdFx0XHRcdFx0cmV0dXJuO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0XHRpZiAoIHRhcmdldC50YWdOYW1lID09PSAnVUwnICkge1xuXHRcdFx0XHRcdFx0bGV0IHRlbXBVUkwgPSB0YXJnZXQucHJldmlvdXNTaWJsaW5nLnByZXZpb3VzU2libGluZy5ocmVmO1xuXHRcdFx0XHRcdFx0aWYgKCBudWxsICE9PSB0ZW1wVVJMICkge1xuXHRcdFx0XHRcdFx0XHR3aW5kb3cubG9jYXRpb24uaHJlZiA9IHRlbXBVUkw7XG5cdFx0XHRcdFx0XHRcdHJldHVybjtcblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0aWYgKCB0YXJnZXQuZ2V0QXR0cmlidXRlKCAnYXJpYS1oYXNwb3B1cCcgKSApIHtcblx0XHRcdFx0Ly8gU3RvcCBsaW5rcyBmcm9tIGZpcmluZ1xuXHRcdFx0XHRlLnByZXZlbnREZWZhdWx0KCk7XG5cblx0XHRcdFx0Ly8gU3RvcCBldmVudHMgZnJvbSBidWJibGluZyB1cCB0byBwYXJlbnQgZWxlbWVudHNcblx0XHRcdFx0ZS5zdG9wUHJvcGFnYXRpb24oKTtcblxuXHRcdFx0XHR2YXIgcGFyZW50X21lbnUgPSB0YXJnZXQucGFyZW50Tm9kZTtcblx0XHRcdFx0dmFyIHN1Yl9tZW51ID0gcGFyZW50X21lbnUucXVlcnlTZWxlY3RvciggJy5zdWItbWVudScgKTtcblx0XHRcdFx0dmFyIGFsbF9vcGVuX21lbnVzID0gbWVudS5xdWVyeVNlbGVjdG9yQWxsKCAnLmNoaWxkLWhhcy1mb2N1cycgKTtcblx0XHRcdFx0dmFyIGFsbF9vcGVuX21lbnVzX2NvdW50ID0gYWxsX29wZW5fbWVudXMubGVuZ3RoO1xuXHRcdFx0XHR2YXIgYWxsX29wZW5fbWVudV90cmlnZ2VycyA9IG1lbnUucXVlcnlTZWxlY3RvckFsbCggJy5jaGlsZC1oYXMtZm9jdXMgPiBhLnN1Ym1lbnUtaXMtb3BlbicgKTtcblx0XHRcdFx0dmFyIGFsbF9vcGVuX21lbnVfdHJpZ2dlcnNfY291bnQgPSBhbGxfb3Blbl9tZW51X3RyaWdnZXJzLmxlbmd0aDtcblx0XHRcdFx0dmFyIHQ7XG5cblx0XHRcdFx0aWYgKCBnZXRfc2NyZWVuX3NpemUoICdoYXMtZnVsbC1uYXYnICkgKSB7XG5cdFx0XHRcdFx0aWYgKCBhbGxfb3Blbl9tZW51X3RyaWdnZXJzX2NvdW50ID4gMCApIHtcblx0XHRcdFx0XHRcdC8vIE1ha2Ugc3VyZSBvbmx5IDEgbWVudSBpdGVtIGNhbiBiZSBvcGVuZWQgYXQgYSB0aW1lXG5cdFx0XHRcdFx0XHRmb3IgKCB0ID0gMDsgdCA8IGFsbF9vcGVuX21lbnVfdHJpZ2dlcnNfY291bnQ7IHQgPSB0ICsgMSApIHtcblxuXHRcdFx0XHRcdFx0XHQvLyBDaGVjayBpZiB0aGUgb3BlbiBtZW51IGlzIHRvcC1sZXZlbCwgaWYgc28sIGNsb3NlIGl0XG5cdFx0XHRcdFx0XHRcdGlmICggcGFyZW50X21lbnUucGFyZW50Tm9kZSA9PT0gbWVudSApIHtcblx0XHRcdFx0XHRcdFx0XHRtZW51X3N1Yl9jbG9zZSggYWxsX29wZW5fbWVudV90cmlnZ2Vyc1t0XSApO1xuXHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHR9IC8vIGZvclxuXHRcdFx0XHRcdH0gLy8gaWZcblx0XHRcdFx0fSAvLyBpZlxuXG5cdFx0XHRcdGlmICggKCBlLnRhcmdldC5ub2RlTmFtZSA9PT0gJ0EnIHx8IHRhcmdldC50YWdOYW1lID09PSAnQScgKSAmJiB0YXJnZXQuY2xhc3NMaXN0LmNvbnRhaW5zKCAnc3VibWVudS1pcy1vcGVuJyApICkge1xuXHRcdFx0XHRcdC8vIFRoZSBtZW51IGlzIGFscmVhZHkgb3Blbiwgc28gdGhpcyBzaG91bGQgYmUgYSBjbG9zZSBhY3Rpb25cblx0XHRcdFx0XHRtZW51X3N1Yl9jbG9zZSggdGFyZ2V0ICk7XG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0bWVudV9zdWJfY2xvc2VfYWxsKCk7XG5cdFx0XHRcdFx0Ly8gVGhlIG1lbnUgaXMgY2xvc2VkLCBzbyB0aGlzIGNsaWNrIHNob3VsZCBvcGVuIGl0XG5cdFx0XHRcdFx0bWVudV9zdWJfb3BlbiggdGFyZ2V0ICk7XG5cblx0XHRcdFx0XHQvLyBSZXNldCB0aGUgZm9jdXNcblx0XHRcdFx0XHRzdWJfbWVudS5xdWVyeVNlbGVjdG9yQWxsKCdhJylbMF0uZm9jdXMoKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH07IC8vIGxpc3RlbmVyX3N1Ym1lbnVfY2xpY2soKVxuXG5cdFx0Ly8gV2hlbiBcImhvdmVyXCIsIHRoaXMgaXMgaG93IGZvY3VzIHNob3VsZCBhY3Rcblx0XHRmdW5jdGlvbiBsaXN0ZW5lcl9zdWJtZW51X2ZvY3VzKCBlICkge1xuXG5cdFx0XHR2YXIgY3VycmVudFRhcmdldCA9IGUuY3VycmVudFRhcmdldDtcblx0XHRcdHZhciB0YXJnZXQgPSBlLnRhcmdldDtcblx0XHRcdHZhciBwYXJlbnRfbWVudSA9IHRhcmdldC5wYXJlbnROb2RlO1xuXHRcdFx0dmFyIHN1Yl9tZW51ID0gcGFyZW50X21lbnUucXVlcnlTZWxlY3RvciggJy5zdWItbWVudScgKTtcblx0XHRcdHZhciBhbGxfb3Blbl9tZW51X3RyaWdnZXJzID0gbWVudS5xdWVyeVNlbGVjdG9yQWxsKCAnLmNoaWxkLWhhcy1mb2N1cyA+IGEuc3VibWVudS1pcy1vcGVuJyApO1xuXHRcdFx0dmFyIGFsbF9vcGVuX21lbnVfdHJpZ2dlcnNfY291bnQgPSBhbGxfb3Blbl9tZW51X3RyaWdnZXJzLmxlbmd0aDtcblx0XHRcdHZhciB0O1xuXG5cdFx0XHRpZiAoIGdldF9zY3JlZW5fc2l6ZSggJ2hhcy1mdWxsLW5hdicgKSApIHtcblx0XHRcdFx0aWYgKCBhbGxfb3Blbl9tZW51X3RyaWdnZXJzX2NvdW50ID4gMCApIHtcblx0XHRcdFx0XHQvLyBNYWtlIHN1cmUgb25seSAxIG1lbnUgaXRlbSBjYW4gYmUgb3BlbmVkIGF0IGEgdGltZVxuXHRcdFx0XHRcdGZvciAoIHQgPSAwOyB0IDwgYWxsX29wZW5fbWVudV90cmlnZ2Vyc19jb3VudDsgdCA9IHQgKyAxICkge1xuXHRcdFx0XHRcdFx0Ly8gQ2hlY2sgaWYgdGhlIG9wZW4gbWVudSBpcyB0b3AtbGV2ZWwsIGlmIHNvLCBjbG9zZSBpdFxuXHRcdFx0XHRcdFx0aWYgKCBwYXJlbnRfbWVudS5wYXJlbnROb2RlID09PSBtZW51ICkge1xuXHRcdFx0XHRcdFx0XHRtZW51X3N1Yl9jbG9zZSggYWxsX29wZW5fbWVudV90cmlnZ2Vyc1t0XSApO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdFx0bWVudV9zdWJfb3BlbiggdGFyZ2V0ICk7XG5cdFx0fTtcblxuXHRcdC8vIExpc3RlbmVyIGZvciB0aGUgd2luZG93IHJlc2l6ZVxuXHRcdHZhciBsaXN0ZW5lcl93aW5kb3cgPSBkZWJvdW5jZSggZnVuY3Rpb24oIGUgKSB7XG5cdFx0XHRpZiggZ2V0X3NjcmVlbl9zaXplKCAnaGFzLW9mZnNjcmVlbi1uYXYnICkgKSB7XG5cdFx0XHRcdG1lbnVfY3JlYXRlKCk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRtZW51X2Rlc3Ryb3koKTtcblx0XHRcdH1cblx0XHR9LCAxMDAgKTsgLy8gbGlzdGVuZXJfd2luZG93KClcblxuXHRcdC8vIENsb3NlIHRoZSBtZW51IGlmIHlvdSBjbGljayBzb21ld2hlcmUgZWxzZVxuXHRcdGZ1bmN0aW9uIGxpc3RlbmVyX2Nsb3NlX29wZW5fbWVudXMoIGUgKSB7XG5cblx0XHRcdHZhciBvcGVuX21lbnVzID0gbWVudS5xdWVyeVNlbGVjdG9yQWxsKCcuc3VibWVudS1pcy1vcGVuJyk7XG5cdFx0XHR2YXIgb3Blbl9tZW51c19jb3VudCA9IG9wZW5fbWVudXMubGVuZ3RoO1xuXHRcdFx0dmFyIG9wbjtcblxuXHRcdFx0Ly8gaWYgdGhlIGV2ZW50IGlzIGtleXVwIGFuZCBpdCB3YXMgdGhlIEVTQyBrZXlcblx0XHRcdGlmICggZS50eXBlID09PSAna2V5dXAnICYmIGUua2V5Q29kZSA9PSAyNyApIHtcblxuXHRcdFx0XHQvLyBXZSB3ZXJlIGdldHRpbmcgc29tZSBlcnJvcnMsIHNvIGxldCdzIGFkZCBpbiBhIGNoZWNrcG9pbnRcblx0XHRcdFx0aWYgKCBvcGVuX21lbnVzX2NvdW50ICkge1xuXG5cdFx0XHRcdFx0Ly8gTG9vcCB0aHJvdWdoIGFsbCB0aGUgb3BlbiBtZW51cyBhbmQgY2xvc2UgdGhlbVxuXHRcdFx0XHRcdGZvciAoIG9wbiA9IDA7IG9wbiA8IG9wZW5fbWVudXMubGVuZ3RoOyBvcG4gPSBvcG4gKyAxICkge1xuXG5cdFx0XHRcdFx0XHRtZW51X3N1Yl9jbG9zZSggb3Blbl9tZW51c1tvcG5dICk7XG5cblx0XHRcdFx0XHR9IC8vIGZvclxuXG5cdFx0XHRcdFx0Ly8gUmV0dXJuIGZvY3VzIHRvIHRoZSBmaXJzdCBvcGVuIG1lbnVcblx0XHRcdFx0XHRpZiAoIHN1Yl9tZW51X2FjaW9uID09PSAnY2xpY2snICkge1xuXHRcdFx0XHRcdFx0b3Blbl9tZW51c1swXS5mb2N1cygpO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHR9IC8vIGlmXG5cblx0XHRcdC8vIElmIHRoZSBldmVudCB3YXMgYSBtb3VzZXVwXG5cdFx0XHR9IGVsc2UgaWYgKCBlLnR5cGUgPT09ICdtb3VzZXVwJyApIHtcblxuXHRcdFx0XHRpZiAoICEgbWVudS5jb250YWlucyggZS50YXJnZXQgKSAmJiBtZW51LnF1ZXJ5U2VsZWN0b3IoICcuc3VibWVudS1pcy1vcGVuJyApICkge1xuXHRcdFx0XHRcdC8vIFdlIHdlcmUgZ2V0dGluZyBzb21lIGVycm9yLCBzbyBsZXQncyBhZGQgaW4gYSBzZWNvbmQgY2hlY2twb2ludFxuXHRcdFx0XHRcdGlmICggb3Blbl9tZW51c19jb3VudCApIHtcblx0XHRcdFx0XHRcdGZvciggb3BuID0gMDsgb3BuIDwgb3Blbl9tZW51cy5sZW5ndGg7IG9wbiA9IG9wbiArIDEgKSB7XG5cdFx0XHRcdFx0XHRcdG1lbnVfc3ViX2Nsb3NlKCBvcGVuX21lbnVzW29wbl0gKTtcblx0XHRcdFx0XHRcdH0gLy8gZm9yXG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9IC8vIGlmXG5cdFx0XHR9XG5cdFx0fTsgLy8gbGlzdGVuZXJfY2xvc2Vfb3Blbl9tZW51cygpXG5cblx0XHRmdW5jdGlvbiBtZW51X3N1Yl9jbG9zZSggb3Blbl9pdGVtICkge1xuXHRcdFx0aWYgKCBvcGVuX2l0ZW0gJiYgb3Blbl9pdGVtLmNsYXNzTGlzdCApIHtcblx0XHRcdFx0b3Blbl9pdGVtLmNsYXNzTGlzdC5yZW1vdmUoJ3N1Ym1lbnUtaXMtb3BlbicpO1xuXHRcdFx0XHRvcGVuX2l0ZW0ucGFyZW50Tm9kZS5jbGFzc0xpc3QucmVtb3ZlKCdjaGlsZC1oYXMtZm9jdXMnKTtcblx0XHRcdH1cblxuXHRcdFx0aWYgKCBvcGVuX2l0ZW0gJiYgb3Blbl9pdGVtLnBhcmVudE5vZGUgJiYgb3Blbl9pdGVtLnBhcmVudE5vZGUucXVlcnlTZWxlY3RvciggJy5zdWItbWVudScgKSApIHtcblx0XHRcdFx0b3Blbl9pdGVtLnBhcmVudE5vZGUucXVlcnlTZWxlY3RvciggJy5zdWItbWVudScgKS5zZXRBdHRyaWJ1dGUoICdhcmlhLWhpZGRlbicsICd0cnVlJyApO1xuXHRcdFx0fVxuXHRcdH07IC8vIG1lbnVfc3ViX2Nsb3NlKClcblxuXHRcdGZ1bmN0aW9uIG1lbnVfc3ViX2Nsb3NlX2FsbCgpIHtcblx0XHRcdHZhciBvcGVuX21lbnVzID0gbWVudS5xdWVyeVNlbGVjdG9yQWxsKCAnLnN1Ym1lbnUtaXMtb3BlbicgKTtcblx0XHRcdHZhciBvcGVuX21lbnVzX2NvdW50ID0gb3Blbl9tZW51cy5sZW5ndGg7XG5cdFx0XHR2YXIgb3BuO1xuXHRcdFx0Ly8gV2Ugd2VyZSBnZXR0aW5nIHNvbWUgZXJyb3JzLCBzbyBsZXQncyBhZGQgaW4gYSBjaGVja3BvaW50XG5cdFx0XHRpZiAoIG9wZW5fbWVudXNfY291bnQgKSB7XG5cdFx0XHRcdC8vIExvb3AgdGhyb3VnaCBhbGwgdGhlIG9wZW4gbWVudXMgYW5kIGNsb3NlIHRoZW1cblx0XHRcdFx0Zm9yICggb3BuID0gMDsgb3BuIDwgb3Blbl9tZW51cy5sZW5ndGg7IG9wbiA9IG9wbiArIDEgKSB7XG5cdFx0XHRcdFx0bWVudV9zdWJfY2xvc2UoIG9wZW5fbWVudXNbb3BuXSApO1xuXHRcdFx0XHR9IC8vIGZvclxuXHRcdFx0fSAvLyBpZlxuXHRcdH07IC8vIG1lbnVfc3ViX2Nsb3NlKClcblxuXHRcdGZ1bmN0aW9uIG1lbnVfc3ViX29wZW4oIGNsb3NlZF9pdGVtICkge1xuXHRcdFx0Y2xvc2VkX2l0ZW0uY2xhc3NMaXN0LmFkZCggJ3N1Ym1lbnUtaXMtb3BlbicgKTtcblx0XHRcdGNsb3NlZF9pdGVtLnBhcmVudE5vZGUuY2xhc3NMaXN0LmFkZCggJ2NoaWxkLWhhcy1mb2N1cycgKTtcblxuXHRcdFx0aWYgKCBjbG9zZWRfaXRlbS5wYXJlbnROb2RlLnF1ZXJ5U2VsZWN0b3IoICcuc3ViLW1lbnUnICkgKSB7XG5cdFx0XHRcdGNsb3NlZF9pdGVtLnBhcmVudE5vZGUucXVlcnlTZWxlY3RvciggJy5zdWItbWVudScgKS5zZXRBdHRyaWJ1dGUoICdhcmlhLWhpZGRlbicsICdmYWxzZScgKTtcblx0XHRcdH1cblx0XHR9OyAvLyBtZW51X3N1Yl9vcGVuKClcblxuXHRcdC8vIE1ldGhvZCB0byBjcmVhdGUgdGhlIHNtYWxsIHNjcmVlbiBtZW51XG5cdFx0ZnVuY3Rpb24gbWVudV9jcmVhdGUoKSB7XG5cblx0XHRcdGlmICggISBkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5jb250YWlucyggJ2hhcy1vZmZzY3JlZW4tbmF2JyApICkge1xuXG5cdFx0XHRcdGlmICggISBkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5jb250YWlucyggJ21lbnUtaXMtb3BlbicgKSApIHtcblx0XHRcdFx0XHRtZW51LnNldEF0dHJpYnV0ZSggJ2FyaWEtaGlkZGVuJywgJ3RydWUnICk7XG5cdFx0XHRcdFx0bWVudV90b2dnbGUuc2V0QXR0cmlidXRlKCAnYXJpYS1leHBhbmRlZCcsICdmYWxzZScgKTtcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRtZW51LnNldEF0dHJpYnV0ZSggJ2FyaWEtaGlkZGVuJywgJ2ZhbHNlJyApO1xuXHRcdFx0XHRcdG1lbnVfdG9nZ2xlLnNldEF0dHJpYnV0ZSggJ2FyaWEtZXhwYW5kZWQnLCAndHJ1ZScgKTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIExvb3AgdGhyb3VnaCBhbGwgc3VibWVudXMgYW5kIGJpbmQgZXZlbnRzIHdoZW4gbmVlZGVkXG5cdFx0XHRcdGZvciAoIGkgPSAwOyBpIDwgbWVudV9pdGVtc193aXRoX2NoaWxkcmVuX2NvdW50OyBpID0gaSArIDEgKSB7XG5cdFx0XHRcdFx0dmFyIHN2Z0VsZW1lbnRzID0gbWVudV9pdGVtc193aXRoX2NoaWxkcmVuW2ldLnF1ZXJ5U2VsZWN0b3JBbGwoICdzdmcnICk7XG5cdFx0XHRcdFx0Zm9yICggdmFyIHEgPSAwOyBxIDwgc3ZnRWxlbWVudHMubGVuZ3RoOyBxID0gcSArIDEgKSB7XG5cdFx0XHRcdFx0XHRzdmdFbGVtZW50c1txXS5hZGRFdmVudExpc3RlbmVyKCAnY2xpY2snLCBsaXN0ZW5lcl9zdWJtZW51X2NsaWNrICk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHRcdG1lbnVfaXRlbXNfd2l0aF9jaGlsZHJlbltpXS5yZW1vdmVFdmVudExpc3RlbmVyKCAnZm9jdXNpbicsIGxpc3RlbmVyX3N1Ym1lbnVfZm9jdXMgKTtcblx0XHRcdFx0fSAvLyBmb3JcblxuXHRcdFx0XHQvLyBCaW5kIHRoZSBldmVudFxuXHRcdFx0XHRtZW51X3RvZ2dsZS5hZGRFdmVudExpc3RlbmVyKCAnY2xpY2snLCBsaXN0ZW5lcl9tZW51ICk7XG5cblx0XHRcdFx0Ly8gQWRkIHRoZSBib2R5IGNsYXNzIHRvIHByZXZlbnQgdGhpcyBmcm9tIHJ1bm5pbmcgYWdhaW5cblx0XHRcdFx0ZG9jdW1lbnQuYm9keS5jbGFzc0xpc3QuYWRkKCAnaGFzLW9mZnNjcmVlbi1uYXYnICk7XG5cdFx0XHRcdGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LnJlbW92ZSggJ2hhcy1mdWxsLW5hdicgKTtcblx0XHRcdH1cblx0XHR9OyAvLyBtZW51X2NyZWF0ZSgpXG5cblx0XHQvLyBNZXRob2QgdG8gZGVzdHJveSB0aGUgc21hbGwgc2NyZWVuIG1lbnVcblx0XHRmdW5jdGlvbiBtZW51X2Rlc3Ryb3koKSB7XG5cblx0XHRcdHZhciB0bXBfb3BlblxuXHRcdFx0dmFyIHRtcF9vcGVuX2NvdW50XG5cdFx0XHR2YXIgdDtcblxuXHRcdFx0aWYgKCAhIGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LmNvbnRhaW5zKCAnaGFzLWZ1bGwtbmF2JyApICkge1xuXHRcdFx0XHQvLyBSZW1vdmUgYXJpYS1oaWRkZW4sIGJlY2F1c2Ugd2UgZG9uJ3QgbmVlZCBpdC5cblx0XHRcdFx0bWVudS5yZW1vdmVBdHRyaWJ1dGUoICdhcmlhLWhpZGRlbicgKTtcblxuXHRcdFx0XHQvLyBMb29wIHRocm91Z2ggYWxsIHN1Ym1lbnVzIGFuZCBiaW5kIGV2ZW50cyB3aGVuIG5lZWRlZFxuXHRcdFx0XHRmb3IgKCBpID0gMDsgaSA8IG1lbnVfaXRlbXNfd2l0aF9jaGlsZHJlbl9jb3VudDsgaSA9IGkgKyAxICkge1xuXHRcdFx0XHRcdGlmICggc3ViX21lbnVfYWNpb24gIT09ICdjbGljaycgKSB7XG5cdFx0XHRcdFx0XHRtZW51X2l0ZW1zX3dpdGhfY2hpbGRyZW5baV0ucmVtb3ZlRXZlbnRMaXN0ZW5lciggJ2NsaWNrJywgbGlzdGVuZXJfc3VibWVudV9jbGljayApO1xuXHRcdFx0XHRcdFx0bWVudV9pdGVtc193aXRoX2NoaWxkcmVuW2ldLmFkZEV2ZW50TGlzdGVuZXIoICdmb2N1c2luJywgbGlzdGVuZXJfc3VibWVudV9mb2N1cyApO1xuXHRcdFx0XHRcdFx0bWVudS5jbGFzc0xpc3QucmVtb3ZlKCd1c2VzLWNsaWNrJyk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cblx0XHRcdFx0Ly8gSWYgd2UncmUgbm90IHVzaW5nIGNsaWNrLCB0aGUgb3BlbiBtZW51cyBuZWVkIHRvIGJlIHJlc2V0XG5cdFx0XHRcdGlmICggc3ViX21lbnVfYWNpb24gIT09ICdjbGljaycgKSB7XG5cdFx0XHRcdFx0dG1wX29wZW4gPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuY2hpbGQtaGFzLWZvY3VzJyk7XG5cdFx0XHRcdFx0dG1wX29wZW5fY291bnQgPSB0bXBfb3Blbi5sZW5ndGg7XG5cblx0XHRcdFx0XHRmb3IgKCB0ID0gMDsgdCA8IHRtcF9vcGVuX2NvdW50OyB0ID0gdCArIDEgKSB7XG5cdFx0XHRcdFx0XHR0bXBfb3Blblt0XS5jbGFzc0xpc3QucmVtb3ZlKCAnY2hpbGQtaGFzLWZvY3VzJyApO1xuXHRcdFx0XHRcdFx0dG1wX29wZW5bdF0ucXVlcnlTZWxlY3RvciggJy5zdWJtZW51LWlzLW9wZW4nICkuY2xhc3NMaXN0LnJlbW92ZSggJ3N1Ym1lbnUtaXMtb3BlbicgKTtcblx0XHRcdFx0XHRcdHRtcF9vcGVuW3RdLnF1ZXJ5U2VsZWN0b3IoICcuc3ViLW1lbnUnICkuc2V0QXR0cmlidXRlKCAnYXJpYS1oaWRkZW4nLCAndHJ1ZScgKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblxuXHRcdFx0XHQvLyBVbmJpbmQgdGhlIGV2ZW50XG5cdFx0XHRcdG1lbnVfdG9nZ2xlLnJlbW92ZUV2ZW50TGlzdGVuZXIoICdjbGljaycsIGxpc3RlbmVyX21lbnUgKTtcblxuXHRcdFx0XHQvLyBBZGQgdGhlIGJvZHkgY2xhc3MgdG8gcHJldmVudCB0aGlzIGZyb20gcnVubmluZyBhZ2FpblxuXHRcdFx0XHRkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5hZGQoICdoYXMtZnVsbC1uYXYnICk7XG5cdFx0XHRcdGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LnJlbW92ZSggJ2hhcy1vZmZzY3JlZW4tbmF2JyApO1xuXHRcdFx0fVxuXHRcdH07XG5cblx0XHQvLyBDaGVjayBpbml0IG1lbnUgc3RhdGVcblx0XHRpZiAoIGdldF9zY3JlZW5fc2l6ZSggJ2hhcy1vZmZzY3JlZW4tbmF2JyApICkge1xuXHRcdFx0bWVudV9jcmVhdGUoKTtcblx0XHR9XG5cblx0XHQvLyBJZiBhcmlhLWNvbnRyb2xzIGlzbid0IHNldCwgc2V0IGl0XG5cdFx0aWYgKCAhIGFyaWFfY29udHJvbHMgKSB7XG5cdFx0XHRtZW51X3RvZ2dsZS5zZXRBdHRyaWJ1dGUoICdhcmlhLWNvbnRyb2xzJywgbWVudV9pZCApO1xuXHRcdH1cblxuXHRcdGlmICggY3VycmVudF9tZW51X2l0ZW0gKSB7XG5cdFx0XHRjdXJyZW50X21lbnVfaXRlbS5xdWVyeVNlbGVjdG9yKCAnYScgKS5zZXRBdHRyaWJ1dGUoICdhcmlhLWN1cnJlbnQnLCAncGFnZScgKTtcblx0XHR9XG5cblx0XHQvKlxuXHRcdFx0RXZlbnRzXG5cdFx0Ki9cblxuXHRcdC8vIERlYm91bmNlZCByZXNpemUgZXZlbnQgdG8gY3JlYXRlIGFuZCBkZXN0cm95IHRoZSBzbWFsbCBzY3JlZW4gbWVudSBvcHRpb25zXG5cdFx0d2luZG93LmFkZEV2ZW50TGlzdGVuZXIoICdyZXNpemUnLCBsaXN0ZW5lcl93aW5kb3cgKTtcblxuXHRcdC8vIENsb3NlIHRoZSBzdWJtZW51cyBieSBjbGlja2luZyBvZmYgb2YgdGhlbSBvciBoaXR0aW5nIEVTQ1xuXHRcdGRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoICdtb3VzZXVwJywgbGlzdGVuZXJfY2xvc2Vfb3Blbl9tZW51cyApO1xuXHRcdGRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoICdrZXl1cCcsIGxpc3RlbmVyX2Nsb3NlX29wZW5fbWVudXMgKTtcblxuXHRcdC8qXG5cdFx0XHRIaWRpbmcgYW5kIHNob3dpbmcgc3VibWVudXMgKGNsaWNrLCBmb2N1cywgaG92ZXIpXG5cdFx0Ki9cblxuXHRcdC8vIExvb3AgdGhyb3VnaCBhbGwgaXRlbXMgd2l0aCBzdWIgbWVudXMgYW5kIGJpbmQgZm9jdXMgdG8gdGhlbSBmb3IgdGFiYmluZ1xuXHRcdGZvciAoIGkgPSAwOyBpIDwgbWVudV9pdGVtc193aXRoX2NoaWxkcmVuX2NvdW50OyBpID0gaSArIDEgKSB7XG5cblx0XHRcdC8vIExldCBhIHNjcmVlbiByZWFkZXIga25vdyB0aGlzIG1lbnUgaGFzIGEgc3VibWVudSBieSBob29raW5nIGludG8gdGhlIGZpcnN0IGxpbmtcblx0XHRcdG1lbnVfaXRlbXNfd2l0aF9jaGlsZHJlbltpXS5xdWVyeVNlbGVjdG9yKCAnYScgKS5zZXRBdHRyaWJ1dGUoICdhcmlhLWhhc3BvcHVwJywgJ3RydWUnICk7XG5cblx0XHRcdC8vIEhpZGUgYW5kIGxhYmVsIGVhY2ggc3ViIG1lbnVcblx0XHRcdG1lbnVfaXRlbXNfd2l0aF9jaGlsZHJlbltpXS5xdWVyeVNlbGVjdG9yKCAnLnN1Yi1tZW51JyApLnNldEF0dHJpYnV0ZSggJ2FyaWEtaGlkZGVuJywgJ3RydWUnICk7XG5cdFx0XHRtZW51X2l0ZW1zX3dpdGhfY2hpbGRyZW5baV0ucXVlcnlTZWxlY3RvciggJy5zdWItbWVudScgKS5zZXRBdHRyaWJ1dGUoICdhcmlhLWxhYmVsJywgJ1N1Ym1lbnUnICk7XG5cblx0XHRcdC8vIElmIHRoZSBzY3JlZW4gaXMgc21hbGwgb3IgdGhlIGFjdGlvbiBpcyBzZXQgdG8gY2xpY2tcblx0XHRcdGlmICggZ2V0X3NjcmVlbl9zaXplKCAnaGFzLW9mZnNjcmVlbi1uYXYnICkgfHwgc3ViX21lbnVfYWNpb24gPT09ICdjbGljaycgKSB7XG5cdFx0XHRcdG1lbnVfaXRlbXNfd2l0aF9jaGlsZHJlbltpXS5hZGRFdmVudExpc3RlbmVyKCAnY2xpY2snLCBsaXN0ZW5lcl9zdWJtZW51X2NsaWNrICk7XG5cblx0XHRcdFx0dmFyIHN2Z0VsZW1lbnRzID0gbWVudV9pdGVtc193aXRoX2NoaWxkcmVuW2ldLnF1ZXJ5U2VsZWN0b3JBbGwoICdzdmcnICk7XG5cblx0XHRcdFx0Zm9yICggdmFyIHogPSAwOyB6IDwgc3ZnRWxlbWVudHMubGVuZ3RoOyB6ID0geiArIDEgKSB7XG5cblx0XHRcdFx0XHRzdmdFbGVtZW50c1t6XS5hZGRFdmVudExpc3RlbmVyKCAnY2xpY2snLCBsaXN0ZW5lcl9zdWJtZW51X2NsaWNrICk7XG5cblx0XHRcdFx0fVxuXG5cdFx0XHRcdG1lbnUuY2xhc3NMaXN0LmFkZCggc3ViX21lbnVfYWNpb24gPT09ICdjbGljaycgPyAndXNlcy1jbGljaycgOiAndXNlcy1ob3ZlcicgKTtcblx0XHRcdH0gZWxzZSBpZiAoIHN1Yl9tZW51X2FjaW9uICE9PSAnY2xpY2snICkge1xuXHRcdFx0XHRpZiAoIGdldF9zY3JlZW5fc2l6ZSggJ2hhcy1mdWxsLW5hdicgKSApIHtcblx0XHRcdFx0XHRtZW51X2l0ZW1zX3dpdGhfY2hpbGRyZW5baV0uYWRkRXZlbnRMaXN0ZW5lciggJ21vdXNlb3ZlcicsIGxpc3RlbmVyX3N1Ym1lbnVfZm9jdXMgKTtcblx0XHRcdFx0XHRtZW51X2l0ZW1zX3dpdGhfY2hpbGRyZW5baV0uYWRkRXZlbnRMaXN0ZW5lciggJ21vdXNlb3V0JywgZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0XHR2YXIgb3Blbl9tZW51cyA9IG1lbnUucXVlcnlTZWxlY3RvckFsbCggJy5zdWJtZW51LWlzLW9wZW4nICk7XG5cdFx0XHRcdFx0XHR2YXIgb3Blbl9tZW51c19jb3VudCA9IG9wZW5fbWVudXMubGVuZ3RoO1xuXHRcdFx0XHRcdFx0dmFyIG9wbjtcblxuXHRcdFx0XHRcdFx0Ly8gV2Ugd2VyZSBnZXR0aW5nIHNvbWUgZXJyb3JzLCBzbyBsZXQncyBhZGQgaW4gYSBjaGVja3BvaW50XG5cdFx0XHRcdFx0XHRpZiAoIG9wZW5fbWVudXNfY291bnQgKSB7XG5cblx0XHRcdFx0XHRcdFx0Ly8gTG9vcCB0aHJvdWdoIGFsbCB0aGUgb3BlbiBtZW51cyBhbmQgY2xvc2UgdGhlbVxuXHRcdFx0XHRcdFx0XHRmb3IgKCBvcG4gPSAwOyBvcG4gPCBvcGVuX21lbnVzX2NvdW50OyBvcG4gPSBvcG4gKyAxICkge1xuXG5cdFx0XHRcdFx0XHRcdFx0bWVudV9zdWJfY2xvc2UoIG9wZW5fbWVudXNbb3BuXSApO1xuXG5cdFx0XHRcdFx0XHRcdH0gLy8gZm9yXG5cblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9ICk7XG5cdFx0XHRcdFx0bWVudV9pdGVtc193aXRoX2NoaWxkcmVuW2ldLmFkZEV2ZW50TGlzdGVuZXIoICdmb2N1c2luJywgbGlzdGVuZXJfc3VibWVudV9mb2N1cyApO1xuXHRcdFx0XHRcdG1lbnVfaXRlbXNfd2l0aF9jaGlsZHJlbltpXS5xdWVyeVNlbGVjdG9yQWxsKCAnLnN1Yi1tZW51JyApLmZvckVhY2goIHN1Ym1lbnUgPT4ge1xuXHRcdFx0XHRcdFx0c3VibWVudS5hZGRFdmVudExpc3RlbmVyKCAnbW91c2VvdmVyJywgZXZlbnQgPT4ge1xuXHRcdFx0XHRcdFx0XHRzdWJtZW51LnBhcmVudEVsZW1lbnQuY2xhc3NMaXN0LmFkZCggJ2NoaWxkLWhhcy1mb2N1cycgKTtcblx0XHRcdFx0XHRcdFx0c3VibWVudS5wcmV2aW91c0VsZW1lbnRTaWJsaW5nLmNsYXNzTGlzdC5hZGQoICdzdWJtZW51LWlzLW9wZW4nICk7XG5cdFx0XHRcdFx0XHR9LCBmYWxzZSApO1xuXHRcdFx0XHRcdH0gKTtcblx0XHRcdFx0fSAvLyBpZlxuXHRcdFx0fSAvLyBpZlxuXHRcdH0gLy8gZm9yXG5cblx0XHQvLyBFeGVjdXRlIHRoZSBjYWxsYmFjayBmdW5jdGlvblxuXHRcdGlmICggdHlwZW9mIGNhbGxiYWNrID09PSAnZnVuY3Rpb24nICkge1xuXHRcdFx0Y2FsbGJhY2suY2FsbCgpO1xuXHRcdH1cblx0fTsgLy8gYnVpbGRfbWVudSgpXG5cblx0Lypcblx0XHRIZWxwZXIgZnVuY3Rpb25zXG5cdCovXG5cblx0Ly8gR2V0IHNjcmVlbiBzaXplIGZyb20gZ2V0Q29tcHV0ZWRTdHlsZSAoc28gd2UgZG9uJ3QgaGF2ZSB0byBkZWZpbmUgZWFjaCBicmVha3BvaW50IHR3aWNlKSAtLSBWYWx1ZXMgYXJlIHNldCBpbiBDU1MgLS1cblx0ZnVuY3Rpb24gZ2V0X3NjcmVlbl9zaXplKCBzaXplU3RyaW5nICkge1xuXHRcdHZhciBzaXplID0gd2luZG93LmdldENvbXB1dGVkU3R5bGUoIGRvY3VtZW50LmJvZHksJzpiZWZvcmUnICkuZ2V0UHJvcGVydHlWYWx1ZSggJ2NvbnRlbnQnICk7XG5cblx0XHRpZiAoIHNpemUgJiYgc2l6ZS5pbmRleE9mKCBzaXplU3RyaW5nICkgIT09IC0xICkge1xuXHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0fVxuXHR9O1xuXG5cdC8vIERlYm91bmNlXG5cdGZ1bmN0aW9uIGRlYm91bmNlKCBmdW5jLCB3YWl0LCBpbW1lZGlhdGUgKSB7XG5cdFx0dmFyIHRpbWVvdXQ7XG5cblx0XHRyZXR1cm4gZnVuY3Rpb24oKSB7XG5cdFx0XHR2YXIgY29udGV4dCA9IHRoaXMsIGFyZ3MgPSBhcmd1bWVudHM7XG5cblx0XHRcdHZhciBsYXRlciA9IGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR0aW1lb3V0ID0gbnVsbDtcblx0XHRcdFx0aWYgKCAhIGltbWVkaWF0ZSApIGZ1bmMuYXBwbHkoIGNvbnRleHQsIGFyZ3MgKTtcblx0XHRcdH07XG5cblx0XHRcdHZhciBjYWxsTm93ID0gaW1tZWRpYXRlICYmICF0aW1lb3V0O1xuXG5cdFx0XHRjbGVhclRpbWVvdXQoIHRpbWVvdXQgKTtcblx0XHRcdHRpbWVvdXQgPSBzZXRUaW1lb3V0KCBsYXRlciwgd2FpdCApO1xuXHRcdFx0aWYgKCBjYWxsTm93ICkgZnVuYy5hcHBseSggY29udGV4dCwgYXJncyApO1xuXHRcdH07XG5cdH07XG5cbn0gKSgpO1xuIiwiLyohXG4gKiBjc3MtdmFycy1wb255ZmlsbFxuICogdjIuNC4zXG4gKiBodHRwczovL2poaWxkZW5iaWRkbGUuZ2l0aHViLmlvL2Nzcy12YXJzLXBvbnlmaWxsL1xuICogKGMpIDIwMTgtMjAyMSBKb2huIEhpbGRlbmJpZGRsZSA8aHR0cDovL2hpbGRlbmJpZGRsZS5jb20+XG4gKiBNSVQgbGljZW5zZVxuICovXG5mdW5jdGlvbiBfZXh0ZW5kcygpIHtcbiAgICBfZXh0ZW5kcyA9IE9iamVjdC5hc3NpZ24gfHwgZnVuY3Rpb24odGFyZ2V0KSB7XG4gICAgICAgIGZvciAodmFyIGkgPSAxOyBpIDwgYXJndW1lbnRzLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgICAgICB2YXIgc291cmNlID0gYXJndW1lbnRzW2ldO1xuICAgICAgICAgICAgZm9yICh2YXIga2V5IGluIHNvdXJjZSkge1xuICAgICAgICAgICAgICAgIGlmIChPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwoc291cmNlLCBrZXkpKSB7XG4gICAgICAgICAgICAgICAgICAgIHRhcmdldFtrZXldID0gc291cmNlW2tleV07XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICAgIHJldHVybiB0YXJnZXQ7XG4gICAgfTtcbiAgICByZXR1cm4gX2V4dGVuZHMuYXBwbHkodGhpcywgYXJndW1lbnRzKTtcbn1cblxuLyohXG4gKiBnZXQtY3NzLWRhdGFcbiAqIHYyLjAuMFxuICogaHR0cHM6Ly9naXRodWIuY29tL2poaWxkZW5iaWRkbGUvZ2V0LWNzcy1kYXRhXG4gKiAoYykgMjAxOC0yMDIxIEpvaG4gSGlsZGVuYmlkZGxlIDxodHRwOi8vaGlsZGVuYmlkZGxlLmNvbT5cbiAqIE1JVCBsaWNlbnNlXG4gKi8gZnVuY3Rpb24gZ2V0VXJscyh1cmxzKSB7XG4gICAgdmFyIG9wdGlvbnMgPSBhcmd1bWVudHMubGVuZ3RoID4gMSAmJiBhcmd1bWVudHNbMV0gIT09IHVuZGVmaW5lZCA/IGFyZ3VtZW50c1sxXSA6IHt9O1xuICAgIHZhciBzZXR0aW5ncyA9IHtcbiAgICAgICAgbWltZVR5cGU6IG9wdGlvbnMubWltZVR5cGUgfHwgbnVsbCxcbiAgICAgICAgb25CZWZvcmVTZW5kOiBvcHRpb25zLm9uQmVmb3JlU2VuZCB8fCBGdW5jdGlvbi5wcm90b3R5cGUsXG4gICAgICAgIG9uU3VjY2Vzczogb3B0aW9ucy5vblN1Y2Nlc3MgfHwgRnVuY3Rpb24ucHJvdG90eXBlLFxuICAgICAgICBvbkVycm9yOiBvcHRpb25zLm9uRXJyb3IgfHwgRnVuY3Rpb24ucHJvdG90eXBlLFxuICAgICAgICBvbkNvbXBsZXRlOiBvcHRpb25zLm9uQ29tcGxldGUgfHwgRnVuY3Rpb24ucHJvdG90eXBlXG4gICAgfTtcbiAgICB2YXIgdXJsQXJyYXkgPSBBcnJheS5pc0FycmF5KHVybHMpID8gdXJscyA6IFsgdXJscyBdO1xuICAgIHZhciB1cmxRdWV1ZSA9IEFycmF5LmFwcGx5KG51bGwsIEFycmF5KHVybEFycmF5Lmxlbmd0aCkpLm1hcCgoZnVuY3Rpb24oeCkge1xuICAgICAgICByZXR1cm4gbnVsbDtcbiAgICB9KSk7XG4gICAgZnVuY3Rpb24gaXNWYWxpZENzcyhjc3NUZXh0KSB7XG4gICAgICAgIHZhciBpc0hUTUwgPSBjc3NUZXh0ICYmIGNzc1RleHQudHJpbSgpLmNoYXJBdCgwKSA9PT0gXCI8XCI7XG4gICAgICAgIHJldHVybiBjc3NUZXh0ICYmICFpc0hUTUw7XG4gICAgfVxuICAgIGZ1bmN0aW9uIG9uRXJyb3IoeGhyLCB1cmxJbmRleCkge1xuICAgICAgICBzZXR0aW5ncy5vbkVycm9yKHhociwgdXJsQXJyYXlbdXJsSW5kZXhdLCB1cmxJbmRleCk7XG4gICAgfVxuICAgIGZ1bmN0aW9uIG9uU3VjY2VzcyhyZXNwb25zZVRleHQsIHVybEluZGV4KSB7XG4gICAgICAgIHZhciByZXR1cm5WYWwgPSBzZXR0aW5ncy5vblN1Y2Nlc3MocmVzcG9uc2VUZXh0LCB1cmxBcnJheVt1cmxJbmRleF0sIHVybEluZGV4KTtcbiAgICAgICAgcmVzcG9uc2VUZXh0ID0gcmV0dXJuVmFsID09PSBmYWxzZSA/IFwiXCIgOiByZXR1cm5WYWwgfHwgcmVzcG9uc2VUZXh0O1xuICAgICAgICB1cmxRdWV1ZVt1cmxJbmRleF0gPSByZXNwb25zZVRleHQ7XG4gICAgICAgIGlmICh1cmxRdWV1ZS5pbmRleE9mKG51bGwpID09PSAtMSkge1xuICAgICAgICAgICAgc2V0dGluZ3Mub25Db21wbGV0ZSh1cmxRdWV1ZSk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgdmFyIHBhcnNlciA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJhXCIpO1xuICAgIHVybEFycmF5LmZvckVhY2goKGZ1bmN0aW9uKHVybCwgaSkge1xuICAgICAgICBwYXJzZXIuc2V0QXR0cmlidXRlKFwiaHJlZlwiLCB1cmwpO1xuICAgICAgICBwYXJzZXIuaHJlZiA9IFN0cmluZyhwYXJzZXIuaHJlZik7XG4gICAgICAgIHZhciBpc0lFbHRlOSA9IEJvb2xlYW4oZG9jdW1lbnQuYWxsICYmICF3aW5kb3cuYXRvYik7XG4gICAgICAgIHZhciBpc0lFbHRlOUNPUlMgPSBpc0lFbHRlOSAmJiBwYXJzZXIuaG9zdC5zcGxpdChcIjpcIilbMF0gIT09IGxvY2F0aW9uLmhvc3Quc3BsaXQoXCI6XCIpWzBdO1xuICAgICAgICBpZiAoaXNJRWx0ZTlDT1JTKSB7XG4gICAgICAgICAgICB2YXIgaXNTYW1lUHJvdG9jb2wgPSBwYXJzZXIucHJvdG9jb2wgPT09IGxvY2F0aW9uLnByb3RvY29sO1xuICAgICAgICAgICAgaWYgKGlzU2FtZVByb3RvY29sKSB7XG4gICAgICAgICAgICAgICAgdmFyIHhkciA9IG5ldyBYRG9tYWluUmVxdWVzdDtcbiAgICAgICAgICAgICAgICB4ZHIub3BlbihcIkdFVFwiLCB1cmwpO1xuICAgICAgICAgICAgICAgIHhkci50aW1lb3V0ID0gMDtcbiAgICAgICAgICAgICAgICB4ZHIub25wcm9ncmVzcyA9IEZ1bmN0aW9uLnByb3RvdHlwZTtcbiAgICAgICAgICAgICAgICB4ZHIub250aW1lb3V0ID0gRnVuY3Rpb24ucHJvdG90eXBlO1xuICAgICAgICAgICAgICAgIHhkci5vbmxvYWQgPSBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKGlzVmFsaWRDc3MoeGRyLnJlc3BvbnNlVGV4dCkpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIG9uU3VjY2Vzcyh4ZHIucmVzcG9uc2VUZXh0LCBpKTtcbiAgICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIG9uRXJyb3IoeGRyLCBpKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH07XG4gICAgICAgICAgICAgICAgeGRyLm9uZXJyb3IgPSBmdW5jdGlvbihlcnIpIHtcbiAgICAgICAgICAgICAgICAgICAgb25FcnJvcih4ZHIsIGkpO1xuICAgICAgICAgICAgICAgIH07XG4gICAgICAgICAgICAgICAgc2V0VGltZW91dCgoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIHhkci5zZW5kKCk7XG4gICAgICAgICAgICAgICAgfSksIDApO1xuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICBjb25zb2xlLndhcm4oXCJJbnRlcm5ldCBFeHBsb3JlciA5IENyb3NzLU9yaWdpbiAoQ09SUykgcmVxdWVzdHMgbXVzdCB1c2UgdGhlIHNhbWUgcHJvdG9jb2wgKFwiLmNvbmNhdCh1cmwsIFwiKVwiKSk7XG4gICAgICAgICAgICAgICAgb25FcnJvcihudWxsLCBpKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIHZhciB4aHIgPSBuZXcgWE1MSHR0cFJlcXVlc3Q7XG4gICAgICAgICAgICB4aHIub3BlbihcIkdFVFwiLCB1cmwpO1xuICAgICAgICAgICAgaWYgKHNldHRpbmdzLm1pbWVUeXBlICYmIHhoci5vdmVycmlkZU1pbWVUeXBlKSB7XG4gICAgICAgICAgICAgICAgeGhyLm92ZXJyaWRlTWltZVR5cGUoc2V0dGluZ3MubWltZVR5cGUpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgc2V0dGluZ3Mub25CZWZvcmVTZW5kKHhociwgdXJsLCBpKTtcbiAgICAgICAgICAgIHhoci5vbnJlYWR5c3RhdGVjaGFuZ2UgPSBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICBpZiAoeGhyLnJlYWR5U3RhdGUgPT09IDQpIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKHhoci5zdGF0dXMgPCA0MDAgJiYgaXNWYWxpZENzcyh4aHIucmVzcG9uc2VUZXh0KSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgb25TdWNjZXNzKHhoci5yZXNwb25zZVRleHQsIGkpO1xuICAgICAgICAgICAgICAgICAgICB9IGVsc2UgaWYgKHhoci5zdGF0dXMgPT09IDAgJiYgaXNWYWxpZENzcyh4aHIucmVzcG9uc2VUZXh0KSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgb25TdWNjZXNzKHhoci5yZXNwb25zZVRleHQsIGkpO1xuICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgb25FcnJvcih4aHIsIGkpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfTtcbiAgICAgICAgICAgIHhoci5zZW5kKCk7XG4gICAgICAgIH1cbiAgICB9KSk7XG59XG5cbi8qKlxuICogR2V0cyBDU1MgZGF0YSBmcm9tIDxzdHlsZT4gYW5kIDxsaW5rPiBub2RlcyAoaW5jbHVkaW5nIEBpbXBvcnRzKSwgdGhlblxuICogcmV0dXJucyBkYXRhIGluIG9yZGVyIHByb2Nlc3NlZCBieSBET00uIEFsbG93cyBzcGVjaWZ5aW5nIG5vZGVzIHRvXG4gKiBpbmNsdWRlL2V4Y2x1ZGUgYW5kIGZpbHRlcmluZyBDU1MgZGF0YSB1c2luZyBSZWdFeC5cbiAqXG4gKiBAcHJlc2VydmVcbiAqIEBwYXJhbSB7b2JqZWN0fSAgIFtvcHRpb25zXSBUaGUgb3B0aW9ucyBvYmplY3RcbiAqIEBwYXJhbSB7b2JqZWN0fSAgIFtvcHRpb25zLnJvb3RFbGVtZW50PWRvY3VtZW50XSBSb290IGVsZW1lbnQgdG8gdHJhdmVyc2UgZm9yXG4gKiAgICAgICAgICAgICAgICAgICA8bGluaz4gYW5kIDxzdHlsZT4gbm9kZXMuXG4gKiBAcGFyYW0ge3N0cmluZ30gICBbb3B0aW9ucy5pbmNsdWRlXSBDU1Mgc2VsZWN0b3IgbWF0Y2hpbmcgPGxpbms+IGFuZCA8c3R5bGU+XG4gKiAgICAgICAgICAgICAgICAgICBub2RlcyB0byBpbmNsdWRlXG4gKiBAcGFyYW0ge3N0cmluZ30gICBbb3B0aW9ucy5leGNsdWRlXSBDU1Mgc2VsZWN0b3IgbWF0Y2hpbmcgPGxpbms+IGFuZCA8c3R5bGU+XG4gKiAgICAgICAgICAgICAgICAgICBub2RlcyB0byBleGNsdWRlXG4gKiBAcGFyYW0ge29iamVjdH0gICBbb3B0aW9ucy5maWx0ZXJdIFJlZ3VsYXIgZXhwcmVzc2lvbiB1c2VkIHRvIGZpbHRlciBub2RlIENTU1xuICogICAgICAgICAgICAgICAgICAgZGF0YS4gRWFjaCBibG9jayBvZiBDU1MgZGF0YSBpcyB0ZXN0ZWQgYWdhaW5zdCB0aGUgZmlsdGVyLFxuICogICAgICAgICAgICAgICAgICAgYW5kIG9ubHkgbWF0Y2hpbmcgZGF0YSBpcyBpbmNsdWRlZC5cbiAqIEBwYXJhbSB7Ym9vbGVhbn0gIFtvcHRpb25zLnNraXBEaXNhYmxlZD10cnVlXSBEZXRlcm1pbmVzIGlmIGRpc2FibGVkXG4gKiAgICAgICAgICAgICAgICAgICBzdHlsZXNoZWV0cyB3aWxsIGJlIHNraXBwZWQgd2hpbGUgY29sbGVjdGluZyBDU1MgZGF0YS5cbiAqIEBwYXJhbSB7Ym9vbGVhbn0gIFtvcHRpb25zLnVzZUNTU09NPWZhbHNlXSBEZXRlcm1pbmVzIGlmIENTUyBkYXRhIHdpbGwgYmVcbiAqICAgICAgICAgICAgICAgICAgIGNvbGxlY3RlZCBmcm9tIGEgc3R5bGVzaGVldCdzIHJ1bnRpbWUgdmFsdWVzIGluc3RlYWQgb2YgaXRzXG4gKiAgICAgICAgICAgICAgICAgICB0ZXh0IGNvbnRlbnQuIFRoaXMgaXMgcmVxdWlyZWQgdG8gZ2V0IGFjY3VyYXRlIENTUyBkYXRhXG4gKiAgICAgICAgICAgICAgICAgICB3aGVuIGEgc3R5bGVzaGVldCBoYXMgYmVlbiBtb2RpZmllZCB1c2luZyB0aGUgZGVsZXRlUnVsZSgpXG4gKiAgICAgICAgICAgICAgICAgICBvciBpbnNlcnRSdWxlKCkgbWV0aG9kcyBiZWNhdXNlIHRoZXNlIG1vZGlmaWNhdGlvbnMgd2lsbFxuICogICAgICAgICAgICAgICAgICAgbm90IGJlIHJlZmxlY3RlZCBpbiB0aGUgc3R5bGVzaGVldCdzIHRleHQgY29udGVudC5cbiAqIEBwYXJhbSB7ZnVuY3Rpb259IFtvcHRpb25zLm9uQmVmb3JlU2VuZF0gQ2FsbGJhY2sgYmVmb3JlIFhIUiBpcyBzZW50LiBQYXNzZXNcbiAqICAgICAgICAgICAgICAgICAgIDEpIHRoZSBYSFIgb2JqZWN0LCAyKSBzb3VyY2Ugbm9kZSByZWZlcmVuY2UsIGFuZCAzKSB0aGVcbiAqICAgICAgICAgICAgICAgICAgIHNvdXJjZSBVUkwgYXMgYXJndW1lbnRzLlxuICogQHBhcmFtIHtmdW5jdGlvbn0gW29wdGlvbnMub25TdWNjZXNzXSBDYWxsYmFjayBvbiBlYWNoIENTUyBub2RlIHJlYWQuIFBhc3Nlc1xuICogICAgICAgICAgICAgICAgICAgMSkgQ1NTIHRleHQsIDIpIHNvdXJjZSBub2RlIHJlZmVyZW5jZSwgYW5kIDMpIHRoZSBzb3VyY2VcbiAqICAgICAgICAgICAgICAgICAgIFVSTCBhcyBhcmd1bWVudHMuXG4gKiBAcGFyYW0ge2Z1bmN0aW9ufSBbb3B0aW9ucy5vbkVycm9yXSBDYWxsYmFjayBvbiBlYWNoIGVycm9yLiBQYXNzZXMgMSkgdGhlIFhIUlxuICogICAgICAgICAgICAgICAgICAgb2JqZWN0IGZvciBpbnNwZWN0aW9uLCAyKSBzb3VyZSBub2RlIHJlZmVyZW5jZSwgYW5kIDMpIHRoZVxuICogICAgICAgICAgICAgICAgICAgc291cmNlIFVSTCB0aGF0IGZhaWxlZCAoZWl0aGVyIGEgPGxpbms+IGhyZWYgb3IgYW4gQGltcG9ydClcbiAqICAgICAgICAgICAgICAgICAgIGFzIGFyZ3VtZW50c1xuICogQHBhcmFtIHtmdW5jdGlvbn0gW29wdGlvbnMub25Db21wbGV0ZV0gQ2FsbGJhY2sgYWZ0ZXIgYWxsIG5vZGVzIGhhdmUgYmVlblxuICogICAgICAgICAgICAgICAgICAgcHJvY2Vzc2VkLiBQYXNzZXMgMSkgY29uY2F0ZW5hdGVkIENTUyB0ZXh0LCAyKSBhbiBhcnJheSBvZlxuICogICAgICAgICAgICAgICAgICAgQ1NTIHRleHQgaW4gRE9NIG9yZGVyLCBhbmQgMykgYW4gYXJyYXkgb2Ygbm9kZXMgaW4gRE9NXG4gKiAgICAgICAgICAgICAgICAgICBvcmRlciBhcyBhcmd1bWVudHMuXG4gKlxuICogQGV4YW1wbGVcbiAqXG4gKiAgIGdldENzc0RhdGEoe1xuICogICAgIHJvb3RFbGVtZW50IDogZG9jdW1lbnQsXG4gKiAgICAgaW5jbHVkZSAgICAgOiAnc3R5bGUsbGlua1tyZWw9XCJzdHlsZXNoZWV0XCJdJyxcbiAqICAgICBleGNsdWRlICAgICA6ICdbaHJlZj1cInNraXAuY3NzXCJdJyxcbiAqICAgICBmaWx0ZXIgICAgICA6IC9yZWQvLFxuICogICAgIHNraXBEaXNhYmxlZDogdHJ1ZSxcbiAqICAgICB1c2VDU1NPTSAgICA6IGZhbHNlLFxuICogICAgIG9uQmVmb3JlU2VuZCh4aHIsIG5vZGUsIHVybCkge1xuICogICAgICAgLy8gLi4uXG4gKiAgICAgfVxuICogICAgIG9uU3VjY2Vzcyhjc3NUZXh0LCBub2RlLCB1cmwpIHtcbiAqICAgICAgIC8vIC4uLlxuICogICAgIH1cbiAqICAgICBvbkVycm9yKHhociwgbm9kZSwgdXJsKSB7XG4gKiAgICAgICAvLyAuLi5cbiAqICAgICB9LFxuICogICAgIG9uQ29tcGxldGUoY3NzVGV4dCwgY3NzQXJyYXksIG5vZGVBcnJheSkge1xuICogICAgICAgLy8gLi4uXG4gKiAgICAgfVxuICogICB9KTtcbiAqLyBmdW5jdGlvbiBnZXRDc3NEYXRhKG9wdGlvbnMpIHtcbiAgICB2YXIgcmVnZXggPSB7XG4gICAgICAgIGNzc0NvbW1lbnRzOiAvXFwvXFwqW1xcc1xcU10rP1xcKlxcLy9nLFxuICAgICAgICBjc3NJbXBvcnRzOiAvKD86QGltcG9ydFxccyopKD86dXJsXFwoXFxzKik/KD86WydcIl0pKFteJ1wiXSopKD86WydcIl0pKD86XFxzKlxcKSk/KD86W147XSo7KS9nXG4gICAgfTtcbiAgICB2YXIgc2V0dGluZ3MgPSB7XG4gICAgICAgIHJvb3RFbGVtZW50OiBvcHRpb25zLnJvb3RFbGVtZW50IHx8IGRvY3VtZW50LFxuICAgICAgICBpbmNsdWRlOiBvcHRpb25zLmluY2x1ZGUgfHwgJ3N0eWxlLGxpbmtbcmVsPVwic3R5bGVzaGVldFwiXScsXG4gICAgICAgIGV4Y2x1ZGU6IG9wdGlvbnMuZXhjbHVkZSB8fCBudWxsLFxuICAgICAgICBmaWx0ZXI6IG9wdGlvbnMuZmlsdGVyIHx8IG51bGwsXG4gICAgICAgIHNraXBEaXNhYmxlZDogb3B0aW9ucy5za2lwRGlzYWJsZWQgIT09IGZhbHNlLFxuICAgICAgICB1c2VDU1NPTTogb3B0aW9ucy51c2VDU1NPTSB8fCBmYWxzZSxcbiAgICAgICAgb25CZWZvcmVTZW5kOiBvcHRpb25zLm9uQmVmb3JlU2VuZCB8fCBGdW5jdGlvbi5wcm90b3R5cGUsXG4gICAgICAgIG9uU3VjY2Vzczogb3B0aW9ucy5vblN1Y2Nlc3MgfHwgRnVuY3Rpb24ucHJvdG90eXBlLFxuICAgICAgICBvbkVycm9yOiBvcHRpb25zLm9uRXJyb3IgfHwgRnVuY3Rpb24ucHJvdG90eXBlLFxuICAgICAgICBvbkNvbXBsZXRlOiBvcHRpb25zLm9uQ29tcGxldGUgfHwgRnVuY3Rpb24ucHJvdG90eXBlXG4gICAgfTtcbiAgICB2YXIgc291cmNlTm9kZXMgPSBBcnJheS5hcHBseShudWxsLCBzZXR0aW5ncy5yb290RWxlbWVudC5xdWVyeVNlbGVjdG9yQWxsKHNldHRpbmdzLmluY2x1ZGUpKS5maWx0ZXIoKGZ1bmN0aW9uKG5vZGUpIHtcbiAgICAgICAgcmV0dXJuICFtYXRjaGVzU2VsZWN0b3Iobm9kZSwgc2V0dGluZ3MuZXhjbHVkZSk7XG4gICAgfSkpO1xuICAgIHZhciBjc3NBcnJheSA9IEFycmF5LmFwcGx5KG51bGwsIEFycmF5KHNvdXJjZU5vZGVzLmxlbmd0aCkpLm1hcCgoZnVuY3Rpb24oeCkge1xuICAgICAgICByZXR1cm4gbnVsbDtcbiAgICB9KSk7XG4gICAgZnVuY3Rpb24gaGFuZGxlQ29tcGxldGUoKSB7XG4gICAgICAgIHZhciBpc0NvbXBsZXRlID0gY3NzQXJyYXkuaW5kZXhPZihudWxsKSA9PT0gLTE7XG4gICAgICAgIGlmIChpc0NvbXBsZXRlKSB7XG4gICAgICAgICAgICBjc3NBcnJheS5yZWR1Y2UoKGZ1bmN0aW9uKHNraXBJbmRpY2VzLCB2YWx1ZSwgaSkge1xuICAgICAgICAgICAgICAgIGlmICh2YWx1ZSA9PT0gXCJcIikge1xuICAgICAgICAgICAgICAgICAgICBza2lwSW5kaWNlcy5wdXNoKGkpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICByZXR1cm4gc2tpcEluZGljZXM7XG4gICAgICAgICAgICB9KSwgW10pLnJldmVyc2UoKS5mb3JFYWNoKChmdW5jdGlvbihza2lwSW5kZXgpIHtcbiAgICAgICAgICAgICAgICByZXR1cm4gWyBzb3VyY2VOb2RlcywgY3NzQXJyYXkgXS5mb3JFYWNoKChmdW5jdGlvbihhcnIpIHtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGFyci5zcGxpY2Uoc2tpcEluZGV4LCAxKTtcbiAgICAgICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICB2YXIgY3NzVGV4dCA9IGNzc0FycmF5LmpvaW4oXCJcIik7XG4gICAgICAgICAgICBzZXR0aW5ncy5vbkNvbXBsZXRlKGNzc1RleHQsIGNzc0FycmF5LCBzb3VyY2VOb2Rlcyk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgZnVuY3Rpb24gaGFuZGxlU3VjY2Vzcyhjc3NUZXh0LCBjc3NJbmRleCwgbm9kZSwgc291cmNlVXJsKSB7XG4gICAgICAgIHZhciByZXR1cm5WYWwgPSBzZXR0aW5ncy5vblN1Y2Nlc3MoY3NzVGV4dCwgbm9kZSwgc291cmNlVXJsKTtcbiAgICAgICAgY3NzVGV4dCA9IHJldHVyblZhbCAhPT0gdW5kZWZpbmVkICYmIEJvb2xlYW4ocmV0dXJuVmFsKSA9PT0gZmFsc2UgPyBcIlwiIDogcmV0dXJuVmFsIHx8IGNzc1RleHQ7XG4gICAgICAgIHJlc29sdmVJbXBvcnRzKGNzc1RleHQsIG5vZGUsIHNvdXJjZVVybCwgKGZ1bmN0aW9uKHJlc29sdmVkQ3NzVGV4dCwgZXJyb3JEYXRhKSB7XG4gICAgICAgICAgICBpZiAoY3NzQXJyYXlbY3NzSW5kZXhdID09PSBudWxsKSB7XG4gICAgICAgICAgICAgICAgZXJyb3JEYXRhLmZvckVhY2goKGZ1bmN0aW9uKGRhdGEpIHtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIHNldHRpbmdzLm9uRXJyb3IoZGF0YS54aHIsIG5vZGUsIGRhdGEudXJsKTtcbiAgICAgICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICAgICAgaWYgKCFzZXR0aW5ncy5maWx0ZXIgfHwgc2V0dGluZ3MuZmlsdGVyLnRlc3QocmVzb2x2ZWRDc3NUZXh0KSkge1xuICAgICAgICAgICAgICAgICAgICBjc3NBcnJheVtjc3NJbmRleF0gPSByZXNvbHZlZENzc1RleHQ7XG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgY3NzQXJyYXlbY3NzSW5kZXhdID0gXCJcIjtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgaGFuZGxlQ29tcGxldGUoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSkpO1xuICAgIH1cbiAgICBmdW5jdGlvbiBwYXJzZUltcG9ydERhdGEoY3NzVGV4dCwgYmFzZVVybCkge1xuICAgICAgICB2YXIgaWdub3JlUnVsZXMgPSBhcmd1bWVudHMubGVuZ3RoID4gMiAmJiBhcmd1bWVudHNbMl0gIT09IHVuZGVmaW5lZCA/IGFyZ3VtZW50c1syXSA6IFtdO1xuICAgICAgICB2YXIgaW1wb3J0RGF0YSA9IHt9O1xuICAgICAgICBpbXBvcnREYXRhLnJ1bGVzID0gKGNzc1RleHQucmVwbGFjZShyZWdleC5jc3NDb21tZW50cywgXCJcIikubWF0Y2gocmVnZXguY3NzSW1wb3J0cykgfHwgW10pLmZpbHRlcigoZnVuY3Rpb24ocnVsZSkge1xuICAgICAgICAgICAgcmV0dXJuIGlnbm9yZVJ1bGVzLmluZGV4T2YocnVsZSkgPT09IC0xO1xuICAgICAgICB9KSk7XG4gICAgICAgIGltcG9ydERhdGEudXJscyA9IGltcG9ydERhdGEucnVsZXMubWFwKChmdW5jdGlvbihydWxlKSB7XG4gICAgICAgICAgICByZXR1cm4gcnVsZS5yZXBsYWNlKHJlZ2V4LmNzc0ltcG9ydHMsIFwiJDFcIik7XG4gICAgICAgIH0pKTtcbiAgICAgICAgaW1wb3J0RGF0YS5hYnNvbHV0ZVVybHMgPSBpbXBvcnREYXRhLnVybHMubWFwKChmdW5jdGlvbih1cmwpIHtcbiAgICAgICAgICAgIHJldHVybiBnZXRGdWxsVXJsKHVybCwgYmFzZVVybCk7XG4gICAgICAgIH0pKTtcbiAgICAgICAgaW1wb3J0RGF0YS5hYnNvbHV0ZVJ1bGVzID0gaW1wb3J0RGF0YS5ydWxlcy5tYXAoKGZ1bmN0aW9uKHJ1bGUsIGkpIHtcbiAgICAgICAgICAgIHZhciBvbGRVcmwgPSBpbXBvcnREYXRhLnVybHNbaV07XG4gICAgICAgICAgICB2YXIgbmV3VXJsID0gZ2V0RnVsbFVybChpbXBvcnREYXRhLmFic29sdXRlVXJsc1tpXSwgYmFzZVVybCk7XG4gICAgICAgICAgICByZXR1cm4gcnVsZS5yZXBsYWNlKG9sZFVybCwgbmV3VXJsKTtcbiAgICAgICAgfSkpO1xuICAgICAgICByZXR1cm4gaW1wb3J0RGF0YTtcbiAgICB9XG4gICAgZnVuY3Rpb24gcmVzb2x2ZUltcG9ydHMoY3NzVGV4dCwgbm9kZSwgYmFzZVVybCwgY2FsbGJhY2tGbikge1xuICAgICAgICB2YXIgX19lcnJvckRhdGEgPSBhcmd1bWVudHMubGVuZ3RoID4gNCAmJiBhcmd1bWVudHNbNF0gIT09IHVuZGVmaW5lZCA/IGFyZ3VtZW50c1s0XSA6IFtdO1xuICAgICAgICB2YXIgX19lcnJvclJ1bGVzID0gYXJndW1lbnRzLmxlbmd0aCA+IDUgJiYgYXJndW1lbnRzWzVdICE9PSB1bmRlZmluZWQgPyBhcmd1bWVudHNbNV0gOiBbXTtcbiAgICAgICAgdmFyIGltcG9ydERhdGEgPSBwYXJzZUltcG9ydERhdGEoY3NzVGV4dCwgYmFzZVVybCwgX19lcnJvclJ1bGVzKTtcbiAgICAgICAgaWYgKGltcG9ydERhdGEucnVsZXMubGVuZ3RoKSB7XG4gICAgICAgICAgICBnZXRVcmxzKGltcG9ydERhdGEuYWJzb2x1dGVVcmxzLCB7XG4gICAgICAgICAgICAgICAgb25CZWZvcmVTZW5kOiBmdW5jdGlvbiBvbkJlZm9yZVNlbmQoeGhyLCB1cmwsIHVybEluZGV4KSB7XG4gICAgICAgICAgICAgICAgICAgIHNldHRpbmdzLm9uQmVmb3JlU2VuZCh4aHIsIG5vZGUsIHVybCk7XG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBvblN1Y2Nlc3M6IGZ1bmN0aW9uIG9uU3VjY2Vzcyhjc3NUZXh0LCB1cmwsIHVybEluZGV4KSB7XG4gICAgICAgICAgICAgICAgICAgIHZhciByZXR1cm5WYWwgPSBzZXR0aW5ncy5vblN1Y2Nlc3MoY3NzVGV4dCwgbm9kZSwgdXJsKTtcbiAgICAgICAgICAgICAgICAgICAgY3NzVGV4dCA9IHJldHVyblZhbCA9PT0gZmFsc2UgPyBcIlwiIDogcmV0dXJuVmFsIHx8IGNzc1RleHQ7XG4gICAgICAgICAgICAgICAgICAgIHZhciByZXNwb25zZUltcG9ydERhdGEgPSBwYXJzZUltcG9ydERhdGEoY3NzVGV4dCwgdXJsLCBfX2Vycm9yUnVsZXMpO1xuICAgICAgICAgICAgICAgICAgICByZXNwb25zZUltcG9ydERhdGEucnVsZXMuZm9yRWFjaCgoZnVuY3Rpb24ocnVsZSwgaSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgY3NzVGV4dCA9IGNzc1RleHQucmVwbGFjZShydWxlLCByZXNwb25zZUltcG9ydERhdGEuYWJzb2x1dGVSdWxlc1tpXSk7XG4gICAgICAgICAgICAgICAgICAgIH0pKTtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGNzc1RleHQ7XG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBvbkVycm9yOiBmdW5jdGlvbiBvbkVycm9yKHhociwgdXJsLCB1cmxJbmRleCkge1xuICAgICAgICAgICAgICAgICAgICBfX2Vycm9yRGF0YS5wdXNoKHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHhocjogeGhyLFxuICAgICAgICAgICAgICAgICAgICAgICAgdXJsOiB1cmxcbiAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgIF9fZXJyb3JSdWxlcy5wdXNoKGltcG9ydERhdGEucnVsZXNbdXJsSW5kZXhdKTtcbiAgICAgICAgICAgICAgICAgICAgcmVzb2x2ZUltcG9ydHMoY3NzVGV4dCwgbm9kZSwgYmFzZVVybCwgY2FsbGJhY2tGbiwgX19lcnJvckRhdGEsIF9fZXJyb3JSdWxlcyk7XG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBvbkNvbXBsZXRlOiBmdW5jdGlvbiBvbkNvbXBsZXRlKHJlc3BvbnNlQXJyYXkpIHtcbiAgICAgICAgICAgICAgICAgICAgcmVzcG9uc2VBcnJheS5mb3JFYWNoKChmdW5jdGlvbihpbXBvcnRUZXh0LCBpKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBjc3NUZXh0ID0gY3NzVGV4dC5yZXBsYWNlKGltcG9ydERhdGEucnVsZXNbaV0sIGltcG9ydFRleHQpO1xuICAgICAgICAgICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICAgICAgICAgIHJlc29sdmVJbXBvcnRzKGNzc1RleHQsIG5vZGUsIGJhc2VVcmwsIGNhbGxiYWNrRm4sIF9fZXJyb3JEYXRhLCBfX2Vycm9yUnVsZXMpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgY2FsbGJhY2tGbihjc3NUZXh0LCBfX2Vycm9yRGF0YSk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgaWYgKHNvdXJjZU5vZGVzLmxlbmd0aCkge1xuICAgICAgICBzb3VyY2VOb2Rlcy5mb3JFYWNoKChmdW5jdGlvbihub2RlLCBpKSB7XG4gICAgICAgICAgICB2YXIgbGlua0hyZWYgPSBub2RlLmdldEF0dHJpYnV0ZShcImhyZWZcIik7XG4gICAgICAgICAgICB2YXIgbGlua1JlbCA9IG5vZGUuZ2V0QXR0cmlidXRlKFwicmVsXCIpO1xuICAgICAgICAgICAgdmFyIGlzTGluayA9IG5vZGUubm9kZU5hbWUudG9Mb3dlckNhc2UoKSA9PT0gXCJsaW5rXCIgJiYgbGlua0hyZWYgJiYgbGlua1JlbCAmJiBsaW5rUmVsLnRvTG93ZXJDYXNlKCkuaW5kZXhPZihcInN0eWxlc2hlZXRcIikgIT09IC0xO1xuICAgICAgICAgICAgdmFyIGlzU2tpcCA9IHNldHRpbmdzLnNraXBEaXNhYmxlZCA9PT0gZmFsc2UgPyBmYWxzZSA6IG5vZGUuZGlzYWJsZWQ7XG4gICAgICAgICAgICB2YXIgaXNTdHlsZSA9IG5vZGUubm9kZU5hbWUudG9Mb3dlckNhc2UoKSA9PT0gXCJzdHlsZVwiO1xuICAgICAgICAgICAgaWYgKGlzTGluayAmJiAhaXNTa2lwKSB7XG4gICAgICAgICAgICAgICAgZ2V0VXJscyhsaW5rSHJlZiwge1xuICAgICAgICAgICAgICAgICAgICBtaW1lVHlwZTogXCJ0ZXh0L2Nzc1wiLFxuICAgICAgICAgICAgICAgICAgICBvbkJlZm9yZVNlbmQ6IGZ1bmN0aW9uIG9uQmVmb3JlU2VuZCh4aHIsIHVybCwgdXJsSW5kZXgpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHNldHRpbmdzLm9uQmVmb3JlU2VuZCh4aHIsIG5vZGUsIHVybCk7XG4gICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgIG9uU3VjY2VzczogZnVuY3Rpb24gb25TdWNjZXNzKGNzc1RleHQsIHVybCwgdXJsSW5kZXgpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzb3VyY2VVcmwgPSBnZXRGdWxsVXJsKGxpbmtIcmVmKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIGhhbmRsZVN1Y2Nlc3MoY3NzVGV4dCwgaSwgbm9kZSwgc291cmNlVXJsKTtcbiAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgb25FcnJvcjogZnVuY3Rpb24gb25FcnJvcih4aHIsIHVybCwgdXJsSW5kZXgpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGNzc0FycmF5W2ldID0gXCJcIjtcbiAgICAgICAgICAgICAgICAgICAgICAgIHNldHRpbmdzLm9uRXJyb3IoeGhyLCBub2RlLCB1cmwpO1xuICAgICAgICAgICAgICAgICAgICAgICAgaGFuZGxlQ29tcGxldGUoKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgfSBlbHNlIGlmIChpc1N0eWxlICYmICFpc1NraXApIHtcbiAgICAgICAgICAgICAgICB2YXIgY3NzVGV4dCA9IG5vZGUudGV4dENvbnRlbnQ7XG4gICAgICAgICAgICAgICAgaWYgKHNldHRpbmdzLnVzZUNTU09NKSB7XG4gICAgICAgICAgICAgICAgICAgIGNzc1RleHQgPSBBcnJheS5hcHBseShudWxsLCBub2RlLnNoZWV0LmNzc1J1bGVzKS5tYXAoKGZ1bmN0aW9uKHJ1bGUpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBydWxlLmNzc1RleHQ7XG4gICAgICAgICAgICAgICAgICAgIH0pKS5qb2luKFwiXCIpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBoYW5kbGVTdWNjZXNzKGNzc1RleHQsIGksIG5vZGUsIGxvY2F0aW9uLmhyZWYpO1xuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICBjc3NBcnJheVtpXSA9IFwiXCI7XG4gICAgICAgICAgICAgICAgaGFuZGxlQ29tcGxldGUoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSkpO1xuICAgIH0gZWxzZSB7XG4gICAgICAgIHNldHRpbmdzLm9uQ29tcGxldGUoXCJcIiwgW10pO1xuICAgIH1cbn1cblxuZnVuY3Rpb24gZ2V0RnVsbFVybCh1cmwsIGJhc2UpIHtcbiAgICB2YXIgZCA9IGRvY3VtZW50LmltcGxlbWVudGF0aW9uLmNyZWF0ZUhUTUxEb2N1bWVudChcIlwiKTtcbiAgICB2YXIgYiA9IGQuY3JlYXRlRWxlbWVudChcImJhc2VcIik7XG4gICAgdmFyIGEgPSBkLmNyZWF0ZUVsZW1lbnQoXCJhXCIpO1xuICAgIGQuaGVhZC5hcHBlbmRDaGlsZChiKTtcbiAgICBkLmJvZHkuYXBwZW5kQ2hpbGQoYSk7XG4gICAgYi5ocmVmID0gYmFzZSB8fCBkb2N1bWVudC5iYXNlVVJJIHx8IChkb2N1bWVudC5xdWVyeVNlbGVjdG9yKFwiYmFzZVwiKSB8fCB7fSkuaHJlZiB8fCBsb2NhdGlvbi5ocmVmO1xuICAgIGEuaHJlZiA9IHVybDtcbiAgICByZXR1cm4gYS5ocmVmO1xufVxuXG5mdW5jdGlvbiBtYXRjaGVzU2VsZWN0b3IoZWxtLCBzZWxlY3Rvcikge1xuICAgIHZhciBtYXRjaGVzID0gZWxtLm1hdGNoZXMgfHwgZWxtLm1hdGNoZXNTZWxlY3RvciB8fCBlbG0ud2Via2l0TWF0Y2hlc1NlbGVjdG9yIHx8IGVsbS5tb3pNYXRjaGVzU2VsZWN0b3IgfHwgZWxtLm1zTWF0Y2hlc1NlbGVjdG9yIHx8IGVsbS5vTWF0Y2hlc1NlbGVjdG9yO1xuICAgIHJldHVybiBtYXRjaGVzLmNhbGwoZWxtLCBzZWxlY3Rvcik7XG59XG5cbnZhciBiYWxhbmNlZE1hdGNoID0gYmFsYW5jZWQ7XG5cbmZ1bmN0aW9uIGJhbGFuY2VkKGEsIGIsIHN0cikge1xuICAgIGlmIChhIGluc3RhbmNlb2YgUmVnRXhwKSBhID0gbWF5YmVNYXRjaChhLCBzdHIpO1xuICAgIGlmIChiIGluc3RhbmNlb2YgUmVnRXhwKSBiID0gbWF5YmVNYXRjaChiLCBzdHIpO1xuICAgIHZhciByID0gcmFuZ2UoYSwgYiwgc3RyKTtcbiAgICByZXR1cm4gciAmJiB7XG4gICAgICAgIHN0YXJ0OiByWzBdLFxuICAgICAgICBlbmQ6IHJbMV0sXG4gICAgICAgIHByZTogc3RyLnNsaWNlKDAsIHJbMF0pLFxuICAgICAgICBib2R5OiBzdHIuc2xpY2UoclswXSArIGEubGVuZ3RoLCByWzFdKSxcbiAgICAgICAgcG9zdDogc3RyLnNsaWNlKHJbMV0gKyBiLmxlbmd0aClcbiAgICB9O1xufVxuXG5mdW5jdGlvbiBtYXliZU1hdGNoKHJlZywgc3RyKSB7XG4gICAgdmFyIG0gPSBzdHIubWF0Y2gocmVnKTtcbiAgICByZXR1cm4gbSA/IG1bMF0gOiBudWxsO1xufVxuXG5iYWxhbmNlZC5yYW5nZSA9IHJhbmdlO1xuXG5mdW5jdGlvbiByYW5nZShhLCBiLCBzdHIpIHtcbiAgICB2YXIgYmVncywgYmVnLCBsZWZ0LCByaWdodCwgcmVzdWx0O1xuICAgIHZhciBhaSA9IHN0ci5pbmRleE9mKGEpO1xuICAgIHZhciBiaSA9IHN0ci5pbmRleE9mKGIsIGFpICsgMSk7XG4gICAgdmFyIGkgPSBhaTtcbiAgICBpZiAoYWkgPj0gMCAmJiBiaSA+IDApIHtcbiAgICAgICAgYmVncyA9IFtdO1xuICAgICAgICBsZWZ0ID0gc3RyLmxlbmd0aDtcbiAgICAgICAgd2hpbGUgKGkgPj0gMCAmJiAhcmVzdWx0KSB7XG4gICAgICAgICAgICBpZiAoaSA9PSBhaSkge1xuICAgICAgICAgICAgICAgIGJlZ3MucHVzaChpKTtcbiAgICAgICAgICAgICAgICBhaSA9IHN0ci5pbmRleE9mKGEsIGkgKyAxKTtcbiAgICAgICAgICAgIH0gZWxzZSBpZiAoYmVncy5sZW5ndGggPT0gMSkge1xuICAgICAgICAgICAgICAgIHJlc3VsdCA9IFsgYmVncy5wb3AoKSwgYmkgXTtcbiAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgYmVnID0gYmVncy5wb3AoKTtcbiAgICAgICAgICAgICAgICBpZiAoYmVnIDwgbGVmdCkge1xuICAgICAgICAgICAgICAgICAgICBsZWZ0ID0gYmVnO1xuICAgICAgICAgICAgICAgICAgICByaWdodCA9IGJpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBiaSA9IHN0ci5pbmRleE9mKGIsIGkgKyAxKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGkgPSBhaSA8IGJpICYmIGFpID49IDAgPyBhaSA6IGJpO1xuICAgICAgICB9XG4gICAgICAgIGlmIChiZWdzLmxlbmd0aCkge1xuICAgICAgICAgICAgcmVzdWx0ID0gWyBsZWZ0LCByaWdodCBdO1xuICAgICAgICB9XG4gICAgfVxuICAgIHJldHVybiByZXN1bHQ7XG59XG5cbmZ1bmN0aW9uIHBhcnNlQ3NzKGNzcykge1xuICAgIHZhciBvcHRpb25zID0gYXJndW1lbnRzLmxlbmd0aCA+IDEgJiYgYXJndW1lbnRzWzFdICE9PSB1bmRlZmluZWQgPyBhcmd1bWVudHNbMV0gOiB7fTtcbiAgICB2YXIgZGVmYXVsdHMgPSB7XG4gICAgICAgIHByZXNlcnZlU3RhdGljOiB0cnVlLFxuICAgICAgICByZW1vdmVDb21tZW50czogZmFsc2VcbiAgICB9O1xuICAgIHZhciBzZXR0aW5ncyA9IF9leHRlbmRzKHt9LCBkZWZhdWx0cywgb3B0aW9ucyk7XG4gICAgdmFyIGVycm9ycyA9IFtdO1xuICAgIGZ1bmN0aW9uIGVycm9yKG1zZykge1xuICAgICAgICB0aHJvdyBuZXcgRXJyb3IoXCJDU1MgcGFyc2UgZXJyb3I6IFwiLmNvbmNhdChtc2cpKTtcbiAgICB9XG4gICAgZnVuY3Rpb24gbWF0Y2gocmUpIHtcbiAgICAgICAgdmFyIG0gPSByZS5leGVjKGNzcyk7XG4gICAgICAgIGlmIChtKSB7XG4gICAgICAgICAgICBjc3MgPSBjc3Muc2xpY2UobVswXS5sZW5ndGgpO1xuICAgICAgICAgICAgcmV0dXJuIG07XG4gICAgICAgIH1cbiAgICB9XG4gICAgZnVuY3Rpb24gb3BlbigpIHtcbiAgICAgICAgcmV0dXJuIG1hdGNoKC9ee1xccyovKTtcbiAgICB9XG4gICAgZnVuY3Rpb24gY2xvc2UoKSB7XG4gICAgICAgIHJldHVybiBtYXRjaCgvXn0vKTtcbiAgICB9XG4gICAgZnVuY3Rpb24gd2hpdGVzcGFjZSgpIHtcbiAgICAgICAgbWF0Y2goL15cXHMqLyk7XG4gICAgfVxuICAgIGZ1bmN0aW9uIGNvbW1lbnQoKSB7XG4gICAgICAgIHdoaXRlc3BhY2UoKTtcbiAgICAgICAgaWYgKGNzc1swXSAhPT0gXCIvXCIgfHwgY3NzWzFdICE9PSBcIipcIikge1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG4gICAgICAgIHZhciBpID0gMjtcbiAgICAgICAgd2hpbGUgKGNzc1tpXSAmJiAoY3NzW2ldICE9PSBcIipcIiB8fCBjc3NbaSArIDFdICE9PSBcIi9cIikpIHtcbiAgICAgICAgICAgIGkrKztcbiAgICAgICAgfVxuICAgICAgICBpZiAoIWNzc1tpXSkge1xuICAgICAgICAgICAgcmV0dXJuIGVycm9yKFwiZW5kIG9mIGNvbW1lbnQgaXMgbWlzc2luZ1wiKTtcbiAgICAgICAgfVxuICAgICAgICB2YXIgc3RyID0gY3NzLnNsaWNlKDIsIGkpO1xuICAgICAgICBjc3MgPSBjc3Muc2xpY2UoaSArIDIpO1xuICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgdHlwZTogXCJjb21tZW50XCIsXG4gICAgICAgICAgICBjb21tZW50OiBzdHJcbiAgICAgICAgfTtcbiAgICB9XG4gICAgZnVuY3Rpb24gY29tbWVudHMoKSB7XG4gICAgICAgIHZhciBjbW50cyA9IFtdO1xuICAgICAgICB2YXIgYztcbiAgICAgICAgd2hpbGUgKGMgPSBjb21tZW50KCkpIHtcbiAgICAgICAgICAgIGNtbnRzLnB1c2goYyk7XG4gICAgICAgIH1cbiAgICAgICAgcmV0dXJuIHNldHRpbmdzLnJlbW92ZUNvbW1lbnRzID8gW10gOiBjbW50cztcbiAgICB9XG4gICAgZnVuY3Rpb24gc2VsZWN0b3IoKSB7XG4gICAgICAgIHdoaXRlc3BhY2UoKTtcbiAgICAgICAgd2hpbGUgKGNzc1swXSA9PT0gXCJ9XCIpIHtcbiAgICAgICAgICAgIGVycm9yKFwiZXh0cmEgY2xvc2luZyBicmFja2V0XCIpO1xuICAgICAgICB9XG4gICAgICAgIHZhciBtID0gbWF0Y2goL14oKFwiKD86XFxcXFwifFteXCJdKSpcInwnKD86XFxcXCd8W14nXSkqJ3xbXntdKSspLyk7XG4gICAgICAgIGlmIChtKSB7XG4gICAgICAgICAgICByZXR1cm4gbVswXS50cmltKCkucmVwbGFjZSgvXFwvXFwqKFteKl18W1xcclxcbl18KFxcKisoW14qL118W1xcclxcbl0pKSkqXFwqXFwvKy9nLCBcIlwiKS5yZXBsYWNlKC9cIig/OlxcXFxcInxbXlwiXSkqXCJ8Jyg/OlxcXFwnfFteJ10pKicvZywgKGZ1bmN0aW9uKG0pIHtcbiAgICAgICAgICAgICAgICByZXR1cm4gbS5yZXBsYWNlKC8sL2csIFwi4oCMXCIpO1xuICAgICAgICAgICAgfSkpLnNwbGl0KC9cXHMqKD8hW14oXSpcXCkpLFxccyovKS5tYXAoKGZ1bmN0aW9uKHMpIHtcbiAgICAgICAgICAgICAgICByZXR1cm4gcy5yZXBsYWNlKC9cXHUyMDBDL2csIFwiLFwiKTtcbiAgICAgICAgICAgIH0pKTtcbiAgICAgICAgfVxuICAgIH1cbiAgICBmdW5jdGlvbiBkZWNsYXJhdGlvbigpIHtcbiAgICAgICAgaWYgKGNzc1swXSA9PT0gXCJAXCIpIHtcbiAgICAgICAgICAgIHJldHVybiBhdF9ydWxlKCk7XG4gICAgICAgIH1cbiAgICAgICAgbWF0Y2goL14oWztcXHNdKikrLyk7XG4gICAgICAgIHZhciBjb21tZW50X3JlZ2V4cCA9IC9cXC9cXCpbXipdKlxcKisoW14vKl1bXipdKlxcKispKlxcLy9nO1xuICAgICAgICB2YXIgcHJvcCA9IG1hdGNoKC9eKFxcKj9bLSMvKlxcXFxcXHddKyhcXFtbMC05YS16Xy1dK1xcXSk/KVxccyovKTtcbiAgICAgICAgaWYgKCFwcm9wKSB7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cbiAgICAgICAgcHJvcCA9IHByb3BbMF0udHJpbSgpO1xuICAgICAgICBpZiAoIW1hdGNoKC9eOlxccyovKSkge1xuICAgICAgICAgICAgcmV0dXJuIGVycm9yKFwicHJvcGVydHkgbWlzc2luZyAnOidcIik7XG4gICAgICAgIH1cbiAgICAgICAgdmFyIHZhbCA9IG1hdGNoKC9eKCg/OlxcL1xcKi4qP1xcKlxcL3wnKD86XFxcXCd8LikqPyd8XCIoPzpcXFxcXCJ8LikqP1wifFxcKChcXHMqJyg/OlxcXFwnfC4pKj8nfFwiKD86XFxcXFwifC4pKj9cInxbXildKj8pXFxzKlxcKXxbXn07XSkrKS8pO1xuICAgICAgICB2YXIgcmV0ID0ge1xuICAgICAgICAgICAgdHlwZTogXCJkZWNsYXJhdGlvblwiLFxuICAgICAgICAgICAgcHJvcGVydHk6IHByb3AucmVwbGFjZShjb21tZW50X3JlZ2V4cCwgXCJcIiksXG4gICAgICAgICAgICB2YWx1ZTogdmFsID8gdmFsWzBdLnJlcGxhY2UoY29tbWVudF9yZWdleHAsIFwiXCIpLnRyaW0oKSA6IFwiXCJcbiAgICAgICAgfTtcbiAgICAgICAgbWF0Y2goL15bO1xcc10qLyk7XG4gICAgICAgIHJldHVybiByZXQ7XG4gICAgfVxuICAgIGZ1bmN0aW9uIGRlY2xhcmF0aW9ucygpIHtcbiAgICAgICAgaWYgKCFvcGVuKCkpIHtcbiAgICAgICAgICAgIHJldHVybiBlcnJvcihcIm1pc3NpbmcgJ3snXCIpO1xuICAgICAgICB9XG4gICAgICAgIHZhciBkO1xuICAgICAgICB2YXIgZGVjbHMgPSBjb21tZW50cygpO1xuICAgICAgICB3aGlsZSAoZCA9IGRlY2xhcmF0aW9uKCkpIHtcbiAgICAgICAgICAgIGRlY2xzLnB1c2goZCk7XG4gICAgICAgICAgICBkZWNscyA9IGRlY2xzLmNvbmNhdChjb21tZW50cygpKTtcbiAgICAgICAgfVxuICAgICAgICBpZiAoIWNsb3NlKCkpIHtcbiAgICAgICAgICAgIHJldHVybiBlcnJvcihcIm1pc3NpbmcgJ30nXCIpO1xuICAgICAgICB9XG4gICAgICAgIHJldHVybiBkZWNscztcbiAgICB9XG4gICAgZnVuY3Rpb24ga2V5ZnJhbWUoKSB7XG4gICAgICAgIHdoaXRlc3BhY2UoKTtcbiAgICAgICAgdmFyIHZhbHMgPSBbXTtcbiAgICAgICAgdmFyIG07XG4gICAgICAgIHdoaWxlIChtID0gbWF0Y2goL14oKFxcZCtcXC5cXGQrfFxcLlxcZCt8XFxkKyklP3xbYS16XSspXFxzKi8pKSB7XG4gICAgICAgICAgICB2YWxzLnB1c2gobVsxXSk7XG4gICAgICAgICAgICBtYXRjaCgvXixcXHMqLyk7XG4gICAgICAgIH1cbiAgICAgICAgaWYgKHZhbHMubGVuZ3RoKSB7XG4gICAgICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgICAgIHR5cGU6IFwia2V5ZnJhbWVcIixcbiAgICAgICAgICAgICAgICB2YWx1ZXM6IHZhbHMsXG4gICAgICAgICAgICAgICAgZGVjbGFyYXRpb25zOiBkZWNsYXJhdGlvbnMoKVxuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cbiAgICBmdW5jdGlvbiBhdF9rZXlmcmFtZXMoKSB7XG4gICAgICAgIHZhciBtID0gbWF0Y2goL15AKFstXFx3XSspP2tleWZyYW1lc1xccyovKTtcbiAgICAgICAgaWYgKCFtKSB7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cbiAgICAgICAgdmFyIHZlbmRvciA9IG1bMV07XG4gICAgICAgIG0gPSBtYXRjaCgvXihbLVxcd10rKVxccyovKTtcbiAgICAgICAgaWYgKCFtKSB7XG4gICAgICAgICAgICByZXR1cm4gZXJyb3IoXCJAa2V5ZnJhbWVzIG1pc3NpbmcgbmFtZVwiKTtcbiAgICAgICAgfVxuICAgICAgICB2YXIgbmFtZSA9IG1bMV07XG4gICAgICAgIGlmICghb3BlbigpKSB7XG4gICAgICAgICAgICByZXR1cm4gZXJyb3IoXCJAa2V5ZnJhbWVzIG1pc3NpbmcgJ3snXCIpO1xuICAgICAgICB9XG4gICAgICAgIHZhciBmcmFtZTtcbiAgICAgICAgdmFyIGZyYW1lcyA9IGNvbW1lbnRzKCk7XG4gICAgICAgIHdoaWxlIChmcmFtZSA9IGtleWZyYW1lKCkpIHtcbiAgICAgICAgICAgIGZyYW1lcy5wdXNoKGZyYW1lKTtcbiAgICAgICAgICAgIGZyYW1lcyA9IGZyYW1lcy5jb25jYXQoY29tbWVudHMoKSk7XG4gICAgICAgIH1cbiAgICAgICAgaWYgKCFjbG9zZSgpKSB7XG4gICAgICAgICAgICByZXR1cm4gZXJyb3IoXCJAa2V5ZnJhbWVzIG1pc3NpbmcgJ30nXCIpO1xuICAgICAgICB9XG4gICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICB0eXBlOiBcImtleWZyYW1lc1wiLFxuICAgICAgICAgICAgbmFtZTogbmFtZSxcbiAgICAgICAgICAgIHZlbmRvcjogdmVuZG9yLFxuICAgICAgICAgICAga2V5ZnJhbWVzOiBmcmFtZXNcbiAgICAgICAgfTtcbiAgICB9XG4gICAgZnVuY3Rpb24gYXRfcGFnZSgpIHtcbiAgICAgICAgdmFyIG0gPSBtYXRjaCgvXkBwYWdlICovKTtcbiAgICAgICAgaWYgKG0pIHtcbiAgICAgICAgICAgIHZhciBzZWwgPSBzZWxlY3RvcigpIHx8IFtdO1xuICAgICAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgICAgICB0eXBlOiBcInBhZ2VcIixcbiAgICAgICAgICAgICAgICBzZWxlY3RvcnM6IHNlbCxcbiAgICAgICAgICAgICAgICBkZWNsYXJhdGlvbnM6IGRlY2xhcmF0aW9ucygpXG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuICAgIGZ1bmN0aW9uIGF0X3BhZ2VfbWFyZ2luX2JveCgpIHtcbiAgICAgICAgdmFyIG0gPSBtYXRjaCgvQCh0b3B8Ym90dG9tfGxlZnR8cmlnaHQpLShsZWZ0fGNlbnRlcnxyaWdodHx0b3B8bWlkZGxlfGJvdHRvbSktPyhjb3JuZXIpP1xccyovKTtcbiAgICAgICAgaWYgKG0pIHtcbiAgICAgICAgICAgIHZhciBuYW1lID0gXCJcIi5jb25jYXQobVsxXSwgXCItXCIpLmNvbmNhdChtWzJdKSArIChtWzNdID8gXCItXCIuY29uY2F0KG1bM10pIDogXCJcIik7XG4gICAgICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgICAgIHR5cGU6IFwicGFnZS1tYXJnaW4tYm94XCIsXG4gICAgICAgICAgICAgICAgbmFtZTogbmFtZSxcbiAgICAgICAgICAgICAgICBkZWNsYXJhdGlvbnM6IGRlY2xhcmF0aW9ucygpXG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuICAgIGZ1bmN0aW9uIGF0X2ZvbnRmYWNlKCkge1xuICAgICAgICB2YXIgbSA9IG1hdGNoKC9eQGZvbnQtZmFjZVxccyovKTtcbiAgICAgICAgaWYgKG0pIHtcbiAgICAgICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICAgICAgdHlwZTogXCJmb250LWZhY2VcIixcbiAgICAgICAgICAgICAgICBkZWNsYXJhdGlvbnM6IGRlY2xhcmF0aW9ucygpXG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuICAgIGZ1bmN0aW9uIGF0X3N1cHBvcnRzKCkge1xuICAgICAgICB2YXIgbSA9IG1hdGNoKC9eQHN1cHBvcnRzICooW157XSspLyk7XG4gICAgICAgIGlmIChtKSB7XG4gICAgICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgICAgIHR5cGU6IFwic3VwcG9ydHNcIixcbiAgICAgICAgICAgICAgICBzdXBwb3J0czogbVsxXS50cmltKCksXG4gICAgICAgICAgICAgICAgcnVsZXM6IHJ1bGVzKClcbiAgICAgICAgICAgIH07XG4gICAgICAgIH1cbiAgICB9XG4gICAgZnVuY3Rpb24gYXRfaG9zdCgpIHtcbiAgICAgICAgdmFyIG0gPSBtYXRjaCgvXkBob3N0XFxzKi8pO1xuICAgICAgICBpZiAobSkge1xuICAgICAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgICAgICB0eXBlOiBcImhvc3RcIixcbiAgICAgICAgICAgICAgICBydWxlczogcnVsZXMoKVxuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cbiAgICBmdW5jdGlvbiBhdF9tZWRpYSgpIHtcbiAgICAgICAgdmFyIG0gPSBtYXRjaCgvXkBtZWRpYShbXntdKykqLyk7XG4gICAgICAgIGlmIChtKSB7XG4gICAgICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgICAgIHR5cGU6IFwibWVkaWFcIixcbiAgICAgICAgICAgICAgICBtZWRpYTogKG1bMV0gfHwgXCJcIikudHJpbSgpLFxuICAgICAgICAgICAgICAgIHJ1bGVzOiBydWxlcygpXG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuICAgIGZ1bmN0aW9uIGF0X2N1c3RvbV9tKCkge1xuICAgICAgICB2YXIgbSA9IG1hdGNoKC9eQGN1c3RvbS1tZWRpYVxccysoLS1bXlxcc10rKVxccyooW157O10rKTsvKTtcbiAgICAgICAgaWYgKG0pIHtcbiAgICAgICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICAgICAgdHlwZTogXCJjdXN0b20tbWVkaWFcIixcbiAgICAgICAgICAgICAgICBuYW1lOiBtWzFdLnRyaW0oKSxcbiAgICAgICAgICAgICAgICBtZWRpYTogbVsyXS50cmltKClcbiAgICAgICAgICAgIH07XG4gICAgICAgIH1cbiAgICB9XG4gICAgZnVuY3Rpb24gYXRfZG9jdW1lbnQoKSB7XG4gICAgICAgIHZhciBtID0gbWF0Y2goL15AKFstXFx3XSspP2RvY3VtZW50ICooW157XSspLyk7XG4gICAgICAgIGlmIChtKSB7XG4gICAgICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgICAgIHR5cGU6IFwiZG9jdW1lbnRcIixcbiAgICAgICAgICAgICAgICBkb2N1bWVudDogbVsyXS50cmltKCksXG4gICAgICAgICAgICAgICAgdmVuZG9yOiBtWzFdID8gbVsxXS50cmltKCkgOiBudWxsLFxuICAgICAgICAgICAgICAgIHJ1bGVzOiBydWxlcygpXG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuICAgIGZ1bmN0aW9uIGF0X3goKSB7XG4gICAgICAgIHZhciBtID0gbWF0Y2goL15AKGltcG9ydHxjaGFyc2V0fG5hbWVzcGFjZSlcXHMqKFteO10rKTsvKTtcbiAgICAgICAgaWYgKG0pIHtcbiAgICAgICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICAgICAgdHlwZTogbVsxXSxcbiAgICAgICAgICAgICAgICBuYW1lOiBtWzJdLnRyaW0oKVxuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cbiAgICBmdW5jdGlvbiBhdF9ydWxlKCkge1xuICAgICAgICB3aGl0ZXNwYWNlKCk7XG4gICAgICAgIGlmIChjc3NbMF0gPT09IFwiQFwiKSB7XG4gICAgICAgICAgICB2YXIgcmV0ID0gYXRfeCgpIHx8IGF0X2ZvbnRmYWNlKCkgfHwgYXRfbWVkaWEoKSB8fCBhdF9rZXlmcmFtZXMoKSB8fCBhdF9zdXBwb3J0cygpIHx8IGF0X2RvY3VtZW50KCkgfHwgYXRfY3VzdG9tX20oKSB8fCBhdF9ob3N0KCkgfHwgYXRfcGFnZSgpIHx8IGF0X3BhZ2VfbWFyZ2luX2JveCgpO1xuICAgICAgICAgICAgaWYgKHJldCAmJiAhc2V0dGluZ3MucHJlc2VydmVTdGF0aWMpIHtcbiAgICAgICAgICAgICAgICB2YXIgaGFzVmFyRnVuYyA9IGZhbHNlO1xuICAgICAgICAgICAgICAgIGlmIChyZXQuZGVjbGFyYXRpb25zKSB7XG4gICAgICAgICAgICAgICAgICAgIGhhc1ZhckZ1bmMgPSByZXQuZGVjbGFyYXRpb25zLnNvbWUoKGZ1bmN0aW9uKGRlY2wpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiAvdmFyXFwoLy50ZXN0KGRlY2wudmFsdWUpO1xuICAgICAgICAgICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgdmFyIGFyciA9IHJldC5rZXlmcmFtZXMgfHwgcmV0LnJ1bGVzIHx8IFtdO1xuICAgICAgICAgICAgICAgICAgICBoYXNWYXJGdW5jID0gYXJyLnNvbWUoKGZ1bmN0aW9uKG9iaikge1xuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIChvYmouZGVjbGFyYXRpb25zIHx8IFtdKS5zb21lKChmdW5jdGlvbihkZWNsKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIC92YXJcXCgvLnRlc3QoZGVjbC52YWx1ZSk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICAgICAgICAgIH0pKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgcmV0dXJuIGhhc1ZhckZ1bmMgPyByZXQgOiB7fTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIHJldHVybiByZXQ7XG4gICAgICAgIH1cbiAgICB9XG4gICAgZnVuY3Rpb24gcnVsZSgpIHtcbiAgICAgICAgaWYgKCFzZXR0aW5ncy5wcmVzZXJ2ZVN0YXRpYykge1xuICAgICAgICAgICAgdmFyIGJhbGFuY2VkTWF0Y2gkMSA9IGJhbGFuY2VkTWF0Y2goXCJ7XCIsIFwifVwiLCBjc3MpO1xuICAgICAgICAgICAgaWYgKGJhbGFuY2VkTWF0Y2gkMSkge1xuICAgICAgICAgICAgICAgIHZhciBoYXNWYXJEZWNsID0gLzooPzpyb290fGhvc3QpKD8hWy46IyhdKS8udGVzdChiYWxhbmNlZE1hdGNoJDEucHJlKSAmJiAvLS1cXFMqXFxzKjovLnRlc3QoYmFsYW5jZWRNYXRjaCQxLmJvZHkpO1xuICAgICAgICAgICAgICAgIHZhciBoYXNWYXJGdW5jID0gL3ZhclxcKC8udGVzdChiYWxhbmNlZE1hdGNoJDEuYm9keSk7XG4gICAgICAgICAgICAgICAgaWYgKCFoYXNWYXJEZWNsICYmICFoYXNWYXJGdW5jKSB7XG4gICAgICAgICAgICAgICAgICAgIGNzcyA9IGNzcy5zbGljZShiYWxhbmNlZE1hdGNoJDEuZW5kICsgMSk7XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiB7fTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgICAgdmFyIHNlbCA9IHNlbGVjdG9yKCkgfHwgW107XG4gICAgICAgIHZhciBkZWNscyA9IHNldHRpbmdzLnByZXNlcnZlU3RhdGljID8gZGVjbGFyYXRpb25zKCkgOiBkZWNsYXJhdGlvbnMoKS5maWx0ZXIoKGZ1bmN0aW9uKGRlY2wpIHtcbiAgICAgICAgICAgIHZhciBoYXNWYXJEZWNsID0gc2VsLnNvbWUoKGZ1bmN0aW9uKHMpIHtcbiAgICAgICAgICAgICAgICByZXR1cm4gLzooPzpyb290fGhvc3QpKD8hWy46IyhdKS8udGVzdChzKTtcbiAgICAgICAgICAgIH0pKSAmJiAvXi0tXFxTLy50ZXN0KGRlY2wucHJvcGVydHkpO1xuICAgICAgICAgICAgdmFyIGhhc1ZhckZ1bmMgPSAvdmFyXFwoLy50ZXN0KGRlY2wudmFsdWUpO1xuICAgICAgICAgICAgcmV0dXJuIGhhc1ZhckRlY2wgfHwgaGFzVmFyRnVuYztcbiAgICAgICAgfSkpO1xuICAgICAgICBpZiAoIXNlbC5sZW5ndGgpIHtcbiAgICAgICAgICAgIGVycm9yKFwic2VsZWN0b3IgbWlzc2luZ1wiKTtcbiAgICAgICAgfVxuICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgdHlwZTogXCJydWxlXCIsXG4gICAgICAgICAgICBzZWxlY3RvcnM6IHNlbCxcbiAgICAgICAgICAgIGRlY2xhcmF0aW9uczogZGVjbHNcbiAgICAgICAgfTtcbiAgICB9XG4gICAgZnVuY3Rpb24gcnVsZXMoY29yZSkge1xuICAgICAgICBpZiAoIWNvcmUgJiYgIW9wZW4oKSkge1xuICAgICAgICAgICAgcmV0dXJuIGVycm9yKFwibWlzc2luZyAneydcIik7XG4gICAgICAgIH1cbiAgICAgICAgdmFyIG5vZGU7XG4gICAgICAgIHZhciBydWxlcyA9IGNvbW1lbnRzKCk7XG4gICAgICAgIHdoaWxlIChjc3MubGVuZ3RoICYmIChjb3JlIHx8IGNzc1swXSAhPT0gXCJ9XCIpICYmIChub2RlID0gYXRfcnVsZSgpIHx8IHJ1bGUoKSkpIHtcbiAgICAgICAgICAgIGlmIChub2RlLnR5cGUpIHtcbiAgICAgICAgICAgICAgICBydWxlcy5wdXNoKG5vZGUpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgcnVsZXMgPSBydWxlcy5jb25jYXQoY29tbWVudHMoKSk7XG4gICAgICAgIH1cbiAgICAgICAgaWYgKCFjb3JlICYmICFjbG9zZSgpKSB7XG4gICAgICAgICAgICByZXR1cm4gZXJyb3IoXCJtaXNzaW5nICd9J1wiKTtcbiAgICAgICAgfVxuICAgICAgICByZXR1cm4gcnVsZXM7XG4gICAgfVxuICAgIHJldHVybiB7XG4gICAgICAgIHR5cGU6IFwic3R5bGVzaGVldFwiLFxuICAgICAgICBzdHlsZXNoZWV0OiB7XG4gICAgICAgICAgICBydWxlczogcnVsZXModHJ1ZSksXG4gICAgICAgICAgICBlcnJvcnM6IGVycm9yc1xuICAgICAgICB9XG4gICAgfTtcbn1cblxuZnVuY3Rpb24gcGFyc2VWYXJzKGNzc0RhdGEpIHtcbiAgICB2YXIgb3B0aW9ucyA9IGFyZ3VtZW50cy5sZW5ndGggPiAxICYmIGFyZ3VtZW50c1sxXSAhPT0gdW5kZWZpbmVkID8gYXJndW1lbnRzWzFdIDoge307XG4gICAgdmFyIGRlZmF1bHRzID0ge1xuICAgICAgICBwYXJzZUhvc3Q6IGZhbHNlLFxuICAgICAgICBzdG9yZToge30sXG4gICAgICAgIG9uV2FybmluZzogZnVuY3Rpb24gb25XYXJuaW5nKCkge31cbiAgICB9O1xuICAgIHZhciBzZXR0aW5ncyA9IF9leHRlbmRzKHt9LCBkZWZhdWx0cywgb3B0aW9ucyk7XG4gICAgdmFyIHJlVmFyRGVjbFNlbGVjdG9ycyA9IG5ldyBSZWdFeHAoXCI6XCIuY29uY2F0KHNldHRpbmdzLnBhcnNlSG9zdCA/IFwiaG9zdFwiIDogXCJyb290XCIsIFwiJFwiKSk7XG4gICAgaWYgKHR5cGVvZiBjc3NEYXRhID09PSBcInN0cmluZ1wiKSB7XG4gICAgICAgIGNzc0RhdGEgPSBwYXJzZUNzcyhjc3NEYXRhLCBzZXR0aW5ncyk7XG4gICAgfVxuICAgIGNzc0RhdGEuc3R5bGVzaGVldC5ydWxlcy5mb3JFYWNoKChmdW5jdGlvbihydWxlKSB7XG4gICAgICAgIGlmIChydWxlLnR5cGUgIT09IFwicnVsZVwiIHx8ICFydWxlLnNlbGVjdG9ycy5zb21lKChmdW5jdGlvbihzKSB7XG4gICAgICAgICAgICByZXR1cm4gcmVWYXJEZWNsU2VsZWN0b3JzLnRlc3Qocyk7XG4gICAgICAgIH0pKSkge1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG4gICAgICAgIHJ1bGUuZGVjbGFyYXRpb25zLmZvckVhY2goKGZ1bmN0aW9uKGRlY2wsIGkpIHtcbiAgICAgICAgICAgIHZhciBwcm9wID0gZGVjbC5wcm9wZXJ0eTtcbiAgICAgICAgICAgIHZhciB2YWx1ZSA9IGRlY2wudmFsdWU7XG4gICAgICAgICAgICBpZiAocHJvcCAmJiBwcm9wLmluZGV4T2YoXCItLVwiKSA9PT0gMCkge1xuICAgICAgICAgICAgICAgIHNldHRpbmdzLnN0b3JlW3Byb3BdID0gdmFsdWU7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pKTtcbiAgICB9KSk7XG4gICAgcmV0dXJuIHNldHRpbmdzLnN0b3JlO1xufVxuXG5mdW5jdGlvbiBzdHJpbmdpZnlDc3ModHJlZSkge1xuICAgIHZhciBkZWxpbSA9IGFyZ3VtZW50cy5sZW5ndGggPiAxICYmIGFyZ3VtZW50c1sxXSAhPT0gdW5kZWZpbmVkID8gYXJndW1lbnRzWzFdIDogXCJcIjtcbiAgICB2YXIgY2IgPSBhcmd1bWVudHMubGVuZ3RoID4gMiA/IGFyZ3VtZW50c1syXSA6IHVuZGVmaW5lZDtcbiAgICB2YXIgcmVuZGVyTWV0aG9kcyA9IHtcbiAgICAgICAgY2hhcnNldDogZnVuY3Rpb24gY2hhcnNldChub2RlKSB7XG4gICAgICAgICAgICByZXR1cm4gXCJAY2hhcnNldCBcIiArIG5vZGUubmFtZSArIFwiO1wiO1xuICAgICAgICB9LFxuICAgICAgICBjb21tZW50OiBmdW5jdGlvbiBjb21tZW50KG5vZGUpIHtcbiAgICAgICAgICAgIHJldHVybiBub2RlLmNvbW1lbnQuaW5kZXhPZihcIl9fQ1NTVkFSU1BPTllGSUxMXCIpID09PSAwID8gXCIvKlwiICsgbm9kZS5jb21tZW50ICsgXCIqL1wiIDogXCJcIjtcbiAgICAgICAgfSxcbiAgICAgICAgXCJjdXN0b20tbWVkaWFcIjogZnVuY3Rpb24gY3VzdG9tTWVkaWEobm9kZSkge1xuICAgICAgICAgICAgcmV0dXJuIFwiQGN1c3RvbS1tZWRpYSBcIiArIG5vZGUubmFtZSArIFwiIFwiICsgbm9kZS5tZWRpYSArIFwiO1wiO1xuICAgICAgICB9LFxuICAgICAgICBkZWNsYXJhdGlvbjogZnVuY3Rpb24gZGVjbGFyYXRpb24obm9kZSkge1xuICAgICAgICAgICAgcmV0dXJuIG5vZGUucHJvcGVydHkgKyBcIjpcIiArIG5vZGUudmFsdWUgKyBcIjtcIjtcbiAgICAgICAgfSxcbiAgICAgICAgZG9jdW1lbnQ6IGZ1bmN0aW9uIGRvY3VtZW50KG5vZGUpIHtcbiAgICAgICAgICAgIHJldHVybiBcIkBcIiArIChub2RlLnZlbmRvciB8fCBcIlwiKSArIFwiZG9jdW1lbnQgXCIgKyBub2RlLmRvY3VtZW50ICsgXCJ7XCIgKyB2aXNpdChub2RlLnJ1bGVzKSArIFwifVwiO1xuICAgICAgICB9LFxuICAgICAgICBcImZvbnQtZmFjZVwiOiBmdW5jdGlvbiBmb250RmFjZShub2RlKSB7XG4gICAgICAgICAgICByZXR1cm4gXCJAZm9udC1mYWNlXCIgKyBcIntcIiArIHZpc2l0KG5vZGUuZGVjbGFyYXRpb25zKSArIFwifVwiO1xuICAgICAgICB9LFxuICAgICAgICBob3N0OiBmdW5jdGlvbiBob3N0KG5vZGUpIHtcbiAgICAgICAgICAgIHJldHVybiBcIkBob3N0XCIgKyBcIntcIiArIHZpc2l0KG5vZGUucnVsZXMpICsgXCJ9XCI7XG4gICAgICAgIH0sXG4gICAgICAgIGltcG9ydDogZnVuY3Rpb24gX2ltcG9ydChub2RlKSB7XG4gICAgICAgICAgICByZXR1cm4gXCJAaW1wb3J0IFwiICsgbm9kZS5uYW1lICsgXCI7XCI7XG4gICAgICAgIH0sXG4gICAgICAgIGtleWZyYW1lOiBmdW5jdGlvbiBrZXlmcmFtZShub2RlKSB7XG4gICAgICAgICAgICByZXR1cm4gbm9kZS52YWx1ZXMuam9pbihcIixcIikgKyBcIntcIiArIHZpc2l0KG5vZGUuZGVjbGFyYXRpb25zKSArIFwifVwiO1xuICAgICAgICB9LFxuICAgICAgICBrZXlmcmFtZXM6IGZ1bmN0aW9uIGtleWZyYW1lcyhub2RlKSB7XG4gICAgICAgICAgICByZXR1cm4gXCJAXCIgKyAobm9kZS52ZW5kb3IgfHwgXCJcIikgKyBcImtleWZyYW1lcyBcIiArIG5vZGUubmFtZSArIFwie1wiICsgdmlzaXQobm9kZS5rZXlmcmFtZXMpICsgXCJ9XCI7XG4gICAgICAgIH0sXG4gICAgICAgIG1lZGlhOiBmdW5jdGlvbiBtZWRpYShub2RlKSB7XG4gICAgICAgICAgICByZXR1cm4gXCJAbWVkaWEgXCIgKyBub2RlLm1lZGlhICsgXCJ7XCIgKyB2aXNpdChub2RlLnJ1bGVzKSArIFwifVwiO1xuICAgICAgICB9LFxuICAgICAgICBuYW1lc3BhY2U6IGZ1bmN0aW9uIG5hbWVzcGFjZShub2RlKSB7XG4gICAgICAgICAgICByZXR1cm4gXCJAbmFtZXNwYWNlIFwiICsgbm9kZS5uYW1lICsgXCI7XCI7XG4gICAgICAgIH0sXG4gICAgICAgIHBhZ2U6IGZ1bmN0aW9uIHBhZ2Uobm9kZSkge1xuICAgICAgICAgICAgcmV0dXJuIFwiQHBhZ2UgXCIgKyAobm9kZS5zZWxlY3RvcnMubGVuZ3RoID8gbm9kZS5zZWxlY3RvcnMuam9pbihcIiwgXCIpIDogXCJcIikgKyBcIntcIiArIHZpc2l0KG5vZGUuZGVjbGFyYXRpb25zKSArIFwifVwiO1xuICAgICAgICB9LFxuICAgICAgICBcInBhZ2UtbWFyZ2luLWJveFwiOiBmdW5jdGlvbiBwYWdlTWFyZ2luQm94KG5vZGUpIHtcbiAgICAgICAgICAgIHJldHVybiBcIkBcIiArIG5vZGUubmFtZSArIFwie1wiICsgdmlzaXQobm9kZS5kZWNsYXJhdGlvbnMpICsgXCJ9XCI7XG4gICAgICAgIH0sXG4gICAgICAgIHJ1bGU6IGZ1bmN0aW9uIHJ1bGUobm9kZSkge1xuICAgICAgICAgICAgdmFyIGRlY2xzID0gbm9kZS5kZWNsYXJhdGlvbnM7XG4gICAgICAgICAgICBpZiAoZGVjbHMubGVuZ3RoKSB7XG4gICAgICAgICAgICAgICAgcmV0dXJuIG5vZGUuc2VsZWN0b3JzLmpvaW4oXCIsXCIpICsgXCJ7XCIgKyB2aXNpdChkZWNscykgKyBcIn1cIjtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSxcbiAgICAgICAgc3VwcG9ydHM6IGZ1bmN0aW9uIHN1cHBvcnRzKG5vZGUpIHtcbiAgICAgICAgICAgIHJldHVybiBcIkBzdXBwb3J0cyBcIiArIG5vZGUuc3VwcG9ydHMgKyBcIntcIiArIHZpc2l0KG5vZGUucnVsZXMpICsgXCJ9XCI7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIGZ1bmN0aW9uIHZpc2l0KG5vZGVzKSB7XG4gICAgICAgIHZhciBidWYgPSBcIlwiO1xuICAgICAgICBmb3IgKHZhciBpID0gMDsgaSA8IG5vZGVzLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgICAgICB2YXIgbiA9IG5vZGVzW2ldO1xuICAgICAgICAgICAgaWYgKGNiKSB7XG4gICAgICAgICAgICAgICAgY2Iobik7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICB2YXIgdHh0ID0gcmVuZGVyTWV0aG9kc1tuLnR5cGVdKG4pO1xuICAgICAgICAgICAgaWYgKHR4dCkge1xuICAgICAgICAgICAgICAgIGJ1ZiArPSB0eHQ7XG4gICAgICAgICAgICAgICAgaWYgKHR4dC5sZW5ndGggJiYgbi5zZWxlY3RvcnMpIHtcbiAgICAgICAgICAgICAgICAgICAgYnVmICs9IGRlbGltO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgICByZXR1cm4gYnVmO1xuICAgIH1cbiAgICByZXR1cm4gdmlzaXQodHJlZS5zdHlsZXNoZWV0LnJ1bGVzKTtcbn1cblxuZnVuY3Rpb24gd2Fsa0Nzcyhub2RlLCBmbikge1xuICAgIG5vZGUucnVsZXMuZm9yRWFjaCgoZnVuY3Rpb24ocnVsZSkge1xuICAgICAgICBpZiAocnVsZS5ydWxlcykge1xuICAgICAgICAgICAgd2Fsa0NzcyhydWxlLCBmbik7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cbiAgICAgICAgaWYgKHJ1bGUua2V5ZnJhbWVzKSB7XG4gICAgICAgICAgICBydWxlLmtleWZyYW1lcy5mb3JFYWNoKChmdW5jdGlvbihrZXlmcmFtZSkge1xuICAgICAgICAgICAgICAgIGlmIChrZXlmcmFtZS50eXBlID09PSBcImtleWZyYW1lXCIpIHtcbiAgICAgICAgICAgICAgICAgICAgZm4oa2V5ZnJhbWUuZGVjbGFyYXRpb25zLCBydWxlKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cbiAgICAgICAgaWYgKCFydWxlLmRlY2xhcmF0aW9ucykge1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG4gICAgICAgIGZuKHJ1bGUuZGVjbGFyYXRpb25zLCBub2RlKTtcbiAgICB9KSk7XG59XG5cbnZhciBWQVJfUFJPUF9JREVOVElGSUVSID0gXCItLVwiO1xuXG52YXIgVkFSX0ZVTkNfSURFTlRJRklFUiA9IFwidmFyXCI7XG5cbmZ1bmN0aW9uIHRyYW5zZm9ybUNzcyhjc3NEYXRhKSB7XG4gICAgdmFyIG9wdGlvbnMgPSBhcmd1bWVudHMubGVuZ3RoID4gMSAmJiBhcmd1bWVudHNbMV0gIT09IHVuZGVmaW5lZCA/IGFyZ3VtZW50c1sxXSA6IHt9O1xuICAgIHZhciBkZWZhdWx0cyA9IHtcbiAgICAgICAgcHJlc2VydmVTdGF0aWM6IHRydWUsXG4gICAgICAgIHByZXNlcnZlVmFyczogZmFsc2UsXG4gICAgICAgIHZhcmlhYmxlczoge30sXG4gICAgICAgIG9uV2FybmluZzogZnVuY3Rpb24gb25XYXJuaW5nKCkge31cbiAgICB9O1xuICAgIHZhciBzZXR0aW5ncyA9IF9leHRlbmRzKHt9LCBkZWZhdWx0cywgb3B0aW9ucyk7XG4gICAgaWYgKHR5cGVvZiBjc3NEYXRhID09PSBcInN0cmluZ1wiKSB7XG4gICAgICAgIGNzc0RhdGEgPSBwYXJzZUNzcyhjc3NEYXRhLCBzZXR0aW5ncyk7XG4gICAgfVxuICAgIHdhbGtDc3MoY3NzRGF0YS5zdHlsZXNoZWV0LCAoZnVuY3Rpb24oZGVjbGFyYXRpb25zLCBub2RlKSB7XG4gICAgICAgIGZvciAodmFyIGkgPSAwOyBpIDwgZGVjbGFyYXRpb25zLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgICAgICB2YXIgZGVjbCA9IGRlY2xhcmF0aW9uc1tpXTtcbiAgICAgICAgICAgIHZhciB0eXBlID0gZGVjbC50eXBlO1xuICAgICAgICAgICAgdmFyIHByb3AgPSBkZWNsLnByb3BlcnR5O1xuICAgICAgICAgICAgdmFyIHZhbHVlID0gZGVjbC52YWx1ZTtcbiAgICAgICAgICAgIGlmICh0eXBlICE9PSBcImRlY2xhcmF0aW9uXCIpIHtcbiAgICAgICAgICAgICAgICBjb250aW51ZTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGlmICghc2V0dGluZ3MucHJlc2VydmVWYXJzICYmIHByb3AgJiYgcHJvcC5pbmRleE9mKFZBUl9QUk9QX0lERU5USUZJRVIpID09PSAwKSB7XG4gICAgICAgICAgICAgICAgZGVjbGFyYXRpb25zLnNwbGljZShpLCAxKTtcbiAgICAgICAgICAgICAgICBpLS07XG4gICAgICAgICAgICAgICAgY29udGludWU7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBpZiAodmFsdWUuaW5kZXhPZihWQVJfRlVOQ19JREVOVElGSUVSICsgXCIoXCIpICE9PSAtMSkge1xuICAgICAgICAgICAgICAgIHZhciByZXNvbHZlZFZhbHVlID0gcmVzb2x2ZVZhbHVlKHZhbHVlLCBzZXR0aW5ncyk7XG4gICAgICAgICAgICAgICAgaWYgKHJlc29sdmVkVmFsdWUgIT09IGRlY2wudmFsdWUpIHtcbiAgICAgICAgICAgICAgICAgICAgcmVzb2x2ZWRWYWx1ZSA9IGZpeE5lc3RlZENhbGMocmVzb2x2ZWRWYWx1ZSk7XG4gICAgICAgICAgICAgICAgICAgIGlmICghc2V0dGluZ3MucHJlc2VydmVWYXJzKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBkZWNsLnZhbHVlID0gcmVzb2x2ZWRWYWx1ZTtcbiAgICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGRlY2xhcmF0aW9ucy5zcGxpY2UoaSwgMCwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU6IHR5cGUsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgcHJvcGVydHk6IHByb3AsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU6IHJlc29sdmVkVmFsdWVcbiAgICAgICAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgICAgICAgICAgaSsrO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgfSkpO1xuICAgIHJldHVybiBzdHJpbmdpZnlDc3MoY3NzRGF0YSk7XG59XG5cbmZ1bmN0aW9uIGZpeE5lc3RlZENhbGModmFsdWUpIHtcbiAgICB2YXIgcmVDYWxjVmFsID0gL2NhbGNcXCgoW14pXSspXFwpL2c7XG4gICAgKHZhbHVlLm1hdGNoKHJlQ2FsY1ZhbCkgfHwgW10pLmZvckVhY2goKGZ1bmN0aW9uKG1hdGNoKSB7XG4gICAgICAgIHZhciBuZXdWYWwgPSBcImNhbGNcIi5jb25jYXQobWF0Y2guc3BsaXQoXCJjYWxjXCIpLmpvaW4oXCJcIikpO1xuICAgICAgICB2YWx1ZSA9IHZhbHVlLnJlcGxhY2UobWF0Y2gsIG5ld1ZhbCk7XG4gICAgfSkpO1xuICAgIHJldHVybiB2YWx1ZTtcbn1cblxuZnVuY3Rpb24gcmVzb2x2ZVZhbHVlKHZhbHVlKSB7XG4gICAgdmFyIHNldHRpbmdzID0gYXJndW1lbnRzLmxlbmd0aCA+IDEgJiYgYXJndW1lbnRzWzFdICE9PSB1bmRlZmluZWQgPyBhcmd1bWVudHNbMV0gOiB7fTtcbiAgICB2YXIgX19yZWN1cnNpdmVGYWxsYmFjayA9IGFyZ3VtZW50cy5sZW5ndGggPiAyID8gYXJndW1lbnRzWzJdIDogdW5kZWZpbmVkO1xuICAgIGlmICh2YWx1ZS5pbmRleE9mKFwidmFyKFwiKSA9PT0gLTEpIHtcbiAgICAgICAgcmV0dXJuIHZhbHVlO1xuICAgIH1cbiAgICB2YXIgdmFsdWVEYXRhID0gYmFsYW5jZWRNYXRjaChcIihcIiwgXCIpXCIsIHZhbHVlKTtcbiAgICBmdW5jdGlvbiByZXNvbHZlRnVuYyh2YWx1ZSkge1xuICAgICAgICB2YXIgbmFtZSA9IHZhbHVlLnNwbGl0KFwiLFwiKVswXS5yZXBsYWNlKC9bXFxzXFxuXFx0XS9nLCBcIlwiKTtcbiAgICAgICAgdmFyIGZhbGxiYWNrID0gKHZhbHVlLm1hdGNoKC8oPzpcXHMqLFxccyopezF9KC4qKT8vKSB8fCBbXSlbMV07XG4gICAgICAgIHZhciBtYXRjaCA9IE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChzZXR0aW5ncy52YXJpYWJsZXMsIG5hbWUpID8gU3RyaW5nKHNldHRpbmdzLnZhcmlhYmxlc1tuYW1lXSkgOiB1bmRlZmluZWQ7XG4gICAgICAgIHZhciByZXBsYWNlbWVudCA9IG1hdGNoIHx8IChmYWxsYmFjayA/IFN0cmluZyhmYWxsYmFjaykgOiB1bmRlZmluZWQpO1xuICAgICAgICB2YXIgdW5yZXNvbHZlZEZhbGxiYWNrID0gX19yZWN1cnNpdmVGYWxsYmFjayB8fCB2YWx1ZTtcbiAgICAgICAgaWYgKCFtYXRjaCkge1xuICAgICAgICAgICAgc2V0dGluZ3Mub25XYXJuaW5nKCd2YXJpYWJsZSBcIicuY29uY2F0KG5hbWUsICdcIiBpcyB1bmRlZmluZWQnKSk7XG4gICAgICAgIH1cbiAgICAgICAgaWYgKHJlcGxhY2VtZW50ICYmIHJlcGxhY2VtZW50ICE9PSBcInVuZGVmaW5lZFwiICYmIHJlcGxhY2VtZW50Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIHJldHVybiByZXNvbHZlVmFsdWUocmVwbGFjZW1lbnQsIHNldHRpbmdzLCB1bnJlc29sdmVkRmFsbGJhY2spO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgcmV0dXJuIFwidmFyKFwiLmNvbmNhdCh1bnJlc29sdmVkRmFsbGJhY2ssIFwiKVwiKTtcbiAgICAgICAgfVxuICAgIH1cbiAgICBpZiAoIXZhbHVlRGF0YSkge1xuICAgICAgICBpZiAodmFsdWUuaW5kZXhPZihcInZhcihcIikgIT09IC0xKSB7XG4gICAgICAgICAgICBzZXR0aW5ncy5vbldhcm5pbmcoJ21pc3NpbmcgY2xvc2luZyBcIilcIiBpbiB0aGUgdmFsdWUgXCInLmNvbmNhdCh2YWx1ZSwgJ1wiJykpO1xuICAgICAgICB9XG4gICAgICAgIHJldHVybiB2YWx1ZTtcbiAgICB9IGVsc2UgaWYgKHZhbHVlRGF0YS5wcmUuc2xpY2UoLTMpID09PSBcInZhclwiKSB7XG4gICAgICAgIHZhciBpc0VtcHR5VmFyRnVuYyA9IHZhbHVlRGF0YS5ib2R5LnRyaW0oKS5sZW5ndGggPT09IDA7XG4gICAgICAgIGlmIChpc0VtcHR5VmFyRnVuYykge1xuICAgICAgICAgICAgc2V0dGluZ3Mub25XYXJuaW5nKFwidmFyKCkgbXVzdCBjb250YWluIGEgbm9uLXdoaXRlc3BhY2Ugc3RyaW5nXCIpO1xuICAgICAgICAgICAgcmV0dXJuIHZhbHVlO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgcmV0dXJuIHZhbHVlRGF0YS5wcmUuc2xpY2UoMCwgLTMpICsgcmVzb2x2ZUZ1bmModmFsdWVEYXRhLmJvZHkpICsgcmVzb2x2ZVZhbHVlKHZhbHVlRGF0YS5wb3N0LCBzZXR0aW5ncyk7XG4gICAgICAgIH1cbiAgICB9IGVsc2Uge1xuICAgICAgICByZXR1cm4gdmFsdWVEYXRhLnByZSArIFwiKFwiLmNvbmNhdChyZXNvbHZlVmFsdWUodmFsdWVEYXRhLmJvZHksIHNldHRpbmdzKSwgXCIpXCIpICsgcmVzb2x2ZVZhbHVlKHZhbHVlRGF0YS5wb3N0LCBzZXR0aW5ncyk7XG4gICAgfVxufVxuXG52YXIgaXNCcm93c2VyID0gdHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIjtcblxudmFyIGlzTmF0aXZlU3VwcG9ydCA9IGlzQnJvd3NlciAmJiB3aW5kb3cuQ1NTICYmIHdpbmRvdy5DU1Muc3VwcG9ydHMgJiYgd2luZG93LkNTUy5zdXBwb3J0cyhcIigtLWE6IDApXCIpO1xuXG52YXIgY291bnRlcnMgPSB7XG4gICAgZ3JvdXA6IDAsXG4gICAgam9iOiAwXG59O1xuXG52YXIgZGVmYXVsdHMgPSB7XG4gICAgcm9vdEVsZW1lbnQ6IGlzQnJvd3NlciA/IGRvY3VtZW50IDogbnVsbCxcbiAgICBzaGFkb3dET006IGZhbHNlLFxuICAgIGluY2x1ZGU6IFwic3R5bGUsbGlua1tyZWw9c3R5bGVzaGVldF1cIixcbiAgICBleGNsdWRlOiBcIlwiLFxuICAgIHZhcmlhYmxlczoge30sXG4gICAgb25seUxlZ2FjeTogdHJ1ZSxcbiAgICBwcmVzZXJ2ZVN0YXRpYzogdHJ1ZSxcbiAgICBwcmVzZXJ2ZVZhcnM6IGZhbHNlLFxuICAgIHNpbGVudDogZmFsc2UsXG4gICAgdXBkYXRlRE9NOiB0cnVlLFxuICAgIHVwZGF0ZVVSTHM6IHRydWUsXG4gICAgd2F0Y2g6IG51bGwsXG4gICAgb25CZWZvcmVTZW5kOiBmdW5jdGlvbiBvbkJlZm9yZVNlbmQoKSB7fSxcbiAgICBvbkVycm9yOiBmdW5jdGlvbiBvbkVycm9yKCkge30sXG4gICAgb25XYXJuaW5nOiBmdW5jdGlvbiBvbldhcm5pbmcoKSB7fSxcbiAgICBvblN1Y2Nlc3M6IGZ1bmN0aW9uIG9uU3VjY2VzcygpIHt9LFxuICAgIG9uQ29tcGxldGU6IGZ1bmN0aW9uIG9uQ29tcGxldGUoKSB7fSxcbiAgICBvbkZpbmFsbHk6IGZ1bmN0aW9uIG9uRmluYWxseSgpIHt9XG59O1xuXG52YXIgcmVnZXggPSB7XG4gICAgY3NzQ29tbWVudHM6IC9cXC9cXCpbXFxzXFxTXSs/XFwqXFwvL2csXG4gICAgY3NzS2V5ZnJhbWVzOiAvQCg/Oi1cXHcqLSk/a2V5ZnJhbWVzLyxcbiAgICBjc3NNZWRpYVF1ZXJpZXM6IC9AbWVkaWFbXntdK1xceyhbXFxzXFxTXSs/fSlcXHMqfS9nLFxuICAgIGNzc1VybHM6IC91cmxcXCgoPyFbJ1wiXT8oPzpkYXRhfGh0dHB8XFwvXFwvKTopWydcIl0/KFteJ1wiKV0qKVsnXCJdP1xcKS9nLFxuICAgIGNzc1ZhckRlY2xSdWxlczogLyg/OjooPzpyb290fGhvc3QpKD8hWy46IyhdKVtcXHMsXSpbXntdKntcXHMqW159XSp9KS9nLFxuICAgIGNzc1ZhckRlY2xzOiAvKD86W1xccztdKikoLXsyfVxcd1tcXHctXSopKD86XFxzKjpcXHMqKShbXjtdKik7L2csXG4gICAgY3NzVmFyRnVuYzogL3ZhclxcKFxccyotLVtcXHctXS8sXG4gICAgY3NzVmFyczogLyg/Oig/OjooPzpyb290fGhvc3QpKD8hWy46IyhdKVtcXHMsXSpbXntdKntcXHMqW147XSo7KlxccyopfCg/OnZhclxcKFxccyopKSgtLVteOildKykoPzpcXHMqWzopXSkvXG59O1xuXG52YXIgdmFyaWFibGVTdG9yZSA9IHtcbiAgICBkb206IHt9LFxuICAgIGpvYjoge30sXG4gICAgdXNlcjoge31cbn07XG5cbnZhciBjc3NWYXJzSXNSdW5uaW5nID0gZmFsc2U7XG5cbnZhciBjc3NWYXJzT2JzZXJ2ZXIgPSBudWxsO1xuXG52YXIgY3NzVmFyc1NyY05vZGVDb3VudCA9IDA7XG5cbnZhciBkZWJvdW5jZVRpbWVyID0gbnVsbDtcblxudmFyIGlzU2hhZG93RE9NUmVhZHkgPSBmYWxzZTtcblxuLyoqXG4gKiBGZXRjaGVzLCBwYXJzZXMsIGFuZCB0cmFuc2Zvcm1zIENTUyBjdXN0b20gcHJvcGVydGllcyBmcm9tIHNwZWNpZmllZFxuICogPHN0eWxlPiBhbmQgPGxpbms+IGVsZW1lbnRzIGludG8gc3RhdGljIHZhbHVlcywgdGhlbiBhcHBlbmRzIGEgbmV3IDxzdHlsZT5cbiAqIGVsZW1lbnQgd2l0aCBzdGF0aWMgdmFsdWVzIHRvIHRoZSBET00gdG8gcHJvdmlkZSBDU1MgY3VzdG9tIHByb3BlcnR5XG4gKiBjb21wYXRpYmlsaXR5IGZvciBsZWdhY3kgYnJvd3NlcnMuIEFsc28gcHJvdmlkZXMgYSBzaW5nbGUgaW50ZXJmYWNlIGZvclxuICogbGl2ZSB1cGRhdGVzIG9mIHJ1bnRpbWUgdmFsdWVzIGluIGJvdGggbW9kZXJuIGFuZCBsZWdhY3kgYnJvd3NlcnMuXG4gKlxuICogQHByZXNlcnZlXG4gKiBAcGFyYW0ge29iamVjdH0gICBbb3B0aW9uc10gT3B0aW9ucyBvYmplY3RcbiAqIEBwYXJhbSB7b2JqZWN0fSAgIFtvcHRpb25zLnJvb3RFbGVtZW50PWRvY3VtZW50XSBSb290IGVsZW1lbnQgdG8gdHJhdmVyc2UgZm9yXG4gKiAgICAgICAgICAgICAgICAgICA8bGluaz4gYW5kIDxzdHlsZT4gbm9kZXNcbiAqIEBwYXJhbSB7Ym9vbGVhbn0gIFtvcHRpb25zLnNoYWRvd0RPTT1mYWxzZV0gRGV0ZXJtaW5lcyBpZiBzaGFkb3cgRE9NIDxsaW5rPlxuICogICAgICAgICAgICAgICAgICAgYW5kIDxzdHlsZT4gbm9kZXMgd2lsbCBiZSBwcm9jZXNzZWQuXG4gKiBAcGFyYW0ge3N0cmluZ30gICBbb3B0aW9ucy5pbmNsdWRlPVwic3R5bGUsbGlua1tyZWw9c3R5bGVzaGVldF1cIl0gQ1NTIHNlbGVjdG9yXG4gKiAgICAgICAgICAgICAgICAgICBtYXRjaGluZyA8bGluayByZT1cInN0eWxlc2hlZXRcIj4gYW5kIDxzdHlsZT4gbm9kZXMgdG9cbiAqICAgICAgICAgICAgICAgICAgIHByb2Nlc3NcbiAqIEBwYXJhbSB7c3RyaW5nfSAgIFtvcHRpb25zLmV4Y2x1ZGVdIENTUyBzZWxlY3RvciBtYXRjaGluZyA8bGlua1xuICogICAgICAgICAgICAgICAgICAgcmVsPVwic3R5bGVoc2VldFwiPiBhbmQgPHN0eWxlPiBub2RlcyB0byBleGNsdWRlIGZyb20gdGhvc2VcbiAqICAgICAgICAgICAgICAgICAgIG1hdGNoZXMgYnkgb3B0aW9ucy5pbmNsdWRlXG4gKiBAcGFyYW0ge29iamVjdH0gICBbb3B0aW9ucy52YXJpYWJsZXNdIEEgbWFwIG9mIGN1c3RvbSBwcm9wZXJ0eSBuYW1lL3ZhbHVlXG4gKiAgICAgICAgICAgICAgICAgICBwYWlycy4gUHJvcGVydHkgbmFtZXMgY2FuIG9taXQgb3IgaW5jbHVkZSB0aGUgbGVhZGluZ1xuICogICAgICAgICAgICAgICAgICAgZG91YmxlLWh5cGhlbiAo4oCUKSwgYW5kIHZhbHVlcyBzcGVjaWZpZWQgd2lsbCBvdmVycmlkZVxuICogICAgICAgICAgICAgICAgICAgcHJldmlvdXMgdmFsdWVzXG4gKiBAcGFyYW0ge2Jvb2xlYW59ICBbb3B0aW9ucy5vbmx5TGVnYWN5PXRydWVdIERldGVybWluZXMgaWYgdGhlIHBvbnlmaWxsIHdpbGxcbiAqICAgICAgICAgICAgICAgICAgIG9ubHkgZ2VuZXJhdGUgbGVnYWN5LWNvbXBhdGlibGUgQ1NTIGluIGJyb3dzZXJzIHRoYXQgbGFja1xuICogICAgICAgICAgICAgICAgICAgbmF0aXZlIHN1cHBvcnQgKGkuZS4sIGxlZ2FjeSBicm93c2VycylcbiAqIEBwYXJhbSB7Ym9vbGVhbn0gIFtvcHRpb25zLnByZXNlcnZlU3RhdGljPXRydWVdIERldGVybWluZXMgaWYgQ1NTXG4gKiAgICAgICAgICAgICAgICAgICBkZWNsYXJhdGlvbnMgdGhhdCBkbyBub3QgcmVmZXJlbmNlIGEgY3VzdG9tIHByb3BlcnR5IHdpbGxcbiAqICAgICAgICAgICAgICAgICAgIGJlIHByZXNlcnZlZCBpbiB0aGUgdHJhbnNmb3JtZWQgQ1NTXG4gKiBAcGFyYW0ge2Jvb2xlYW59ICBbb3B0aW9ucy5wcmVzZXJ2ZVZhcnM9ZmFsc2VdIERldGVybWluZXMgaWYgQ1NTIGN1c3RvbVxuICogICAgICAgICAgICAgICAgICAgcHJvcGVydHkgZGVjbGFyYXRpb25zIHdpbGwgYmUgcHJlc2VydmVkIGluIHRoZSB0cmFuc2Zvcm1lZFxuICogICAgICAgICAgICAgICAgICAgQ1NTXG4gKiBAcGFyYW0ge2Jvb2xlYW59ICBbb3B0aW9ucy5zaWxlbnQ9ZmFsc2VdIERldGVybWluZXMgaWYgd2FybmluZyBhbmQgZXJyb3JcbiAqICAgICAgICAgICAgICAgICAgIG1lc3NhZ2VzIHdpbGwgYmUgZGlzcGxheWVkIG9uIHRoZSBjb25zb2xlXG4gKiBAcGFyYW0ge2Jvb2xlYW59ICBbb3B0aW9ucy51cGRhdGVET009dHJ1ZV0gRGV0ZXJtaW5lcyBpZiB0aGUgcG9ueWZpbGwgd2lsbFxuICogICAgICAgICAgICAgICAgICAgdXBkYXRlIHRoZSBET00gYWZ0ZXIgcHJvY2Vzc2luZyBDU1MgY3VzdG9tIHByb3BlcnRpZXNcbiAqIEBwYXJhbSB7Ym9vbGVhbn0gIFtvcHRpb25zLnVwZGF0ZVVSTHM9dHJ1ZV0gRGV0ZXJtaW5lcyBpZiByZWxhdGl2ZSB1cmwoKVxuICogICAgICAgICAgICAgICAgICAgcGF0aHMgd2lsbCBiZSBjb252ZXJ0ZWQgdG8gYWJzb2x1dGUgdXJscyBpbiBleHRlcm5hbCBDU1NcbiAqIEBwYXJhbSB7Ym9vbGVhbn0gIFtvcHRpb25zLndhdGNoPWZhbHNlXSBEZXRlcm1pbmVzIGlmIGEgTXV0YXRpb25PYnNlcnZlciB3aWxsXG4gKiAgICAgICAgICAgICAgICAgICBiZSBjcmVhdGVkIHRoYXQgd2lsbCBleGVjdXRlIHRoZSBwb255ZmlsbCB3aGVuIGEgPGxpbms+IG9yXG4gKiAgICAgICAgICAgICAgICAgICA8c3R5bGU+IERPTSBtdXRhdGlvbiBpcyBvYnNlcnZlZFxuICogQHBhcmFtIHtmdW5jdGlvbn0gW29wdGlvbnMub25CZWZvcmVTZW5kXSBDYWxsYmFjayBiZWZvcmUgWEhSIGlzIHNlbnQuIFBhc3Nlc1xuICogICAgICAgICAgICAgICAgICAgMSkgdGhlIFhIUiBvYmplY3QsIDIpIHNvdXJjZSBub2RlIHJlZmVyZW5jZSwgYW5kIDMpIHRoZVxuICogICAgICAgICAgICAgICAgICAgc291cmNlIFVSTCBhcyBhcmd1bWVudHNcbiAqIEBwYXJhbSB7ZnVuY3Rpb259IFtvcHRpb25zLm9uRXJyb3JdIENhbGxiYWNrIGFmdGVyIGEgQ1NTIHBhcnNpbmcgZXJyb3IgaGFzXG4gKiAgICAgICAgICAgICAgICAgICBvY2N1cnJlZCBvciBhbiBYSFIgcmVxdWVzdCBoYXMgZmFpbGVkLiBQYXNzZXMgMSkgYW4gZXJyb3JcbiAqICAgICAgICAgICAgICAgICAgIG1lc3NhZ2UsIGFuZCAyKSBzb3VyY2Ugbm9kZSByZWZlcmVuY2UsIDMpIHhociwgYW5kIDQgdXJsIGFzXG4gKiAgICAgICAgICAgICAgICAgICBhcmd1bWVudHMuXG4gKiBAcGFyYW0ge2Z1bmN0aW9ufSBbb3B0aW9ucy5vbldhcm5pbmddIENhbGxiYWNrIGFmdGVyIGVhY2ggQ1NTIHBhcnNpbmcgd2FybmluZ1xuICogICAgICAgICAgICAgICAgICAgaGFzIG9jY3VycmVkLiBQYXNzZXMgMSkgYSB3YXJuaW5nIG1lc3NhZ2UgYXMgYW4gYXJndW1lbnQuXG4gKiBAcGFyYW0ge2Z1bmN0aW9ufSBbb3B0aW9ucy5vblN1Y2Nlc3NdIENhbGxiYWNrIGFmdGVyIENTUyBkYXRhIGhhcyBiZWVuXG4gKiAgICAgICAgICAgICAgICAgICBjb2xsZWN0ZWQgZnJvbSBlYWNoIG5vZGUgYW5kIGJlZm9yZSBDU1MgY3VzdG9tIHByb3BlcnRpZXNcbiAqICAgICAgICAgICAgICAgICAgIGhhdmUgYmVlbiB0cmFuc2Zvcm1lZC4gQWxsb3dzIG1vZGlmeWluZyB0aGUgQ1NTIGRhdGEgYmVmb3JlXG4gKiAgICAgICAgICAgICAgICAgICBpdCBpcyB0cmFuc2Zvcm1lZCBieSByZXR1cm5pbmcgYW55IHN0cmluZyB2YWx1ZSAob3IgZmFsc2VcbiAqICAgICAgICAgICAgICAgICAgIHRvIHNraXApLiBQYXNzZXMgMSkgQ1NTIHRleHQsIDIpIHNvdXJjZSBub2RlIHJlZmVyZW5jZSwgYW5kXG4gKiAgICAgICAgICAgICAgICAgICAzKSB0aGUgc291cmNlIFVSTCBhcyBhcmd1bWVudHMuXG4gKiBAcGFyYW0ge2Z1bmN0aW9ufSBbb3B0aW9ucy5vbkNvbXBsZXRlXSBDYWxsYmFjayBhZnRlciBhbGwgQ1NTIGhhcyBiZWVuXG4gKiAgICAgICAgICAgICAgICAgICBwcm9jZXNzZWQsIGxlZ2FjeS1jb21wYXRpYmxlIENTUyBoYXMgYmVlbiBnZW5lcmF0ZWQsIGFuZFxuICogICAgICAgICAgICAgICAgICAgKG9wdGlvbmFsbHkpIHRoZSBET00gaGFzIGJlZW4gdXBkYXRlZC4gUGFzc2VzIDEpIGEgQ1NTXG4gKiAgICAgICAgICAgICAgICAgICBzdHJpbmcgd2l0aCBDU1MgdmFyaWFibGUgdmFsdWVzIHJlc29sdmVkLCAyKSBhbiBhcnJheSBvZlxuICogICAgICAgICAgICAgICAgICAgb3V0cHV0IDxzdHlsZT4gbm9kZSByZWZlcmVuY2VzIHRoYXQgaGF2ZSBiZWVuIGFwcGVuZGVkIHRvXG4gKiAgICAgICAgICAgICAgICAgICB0aGUgRE9NLCAzKSBhbiBvYmplY3QgY29udGFpbmluZyBhbGwgY3VzdG9tIHByb3BlcmllcyBuYW1lc1xuICogICAgICAgICAgICAgICAgICAgYW5kIHZhbHVlcywgYW5kIDQpIHRoZSBwb255ZmlsbCBleGVjdXRpb24gdGltZSBpblxuICogICAgICAgICAgICAgICAgICAgbWlsbGlzZWNvbmRzLlxuICogQHBhcmFtIHtmdW5jdGlvbn0gW29wdGlvbnMub25GaW5hbGx5XSBDYWxsYmFjayBpbiBtb2Rlcm4gYW5kIGxlZ2FjeSBicm93c2Vyc1xuICogICAgICAgICAgICAgICAgICAgYWZ0ZXIgdGhlIHBvbnlmaWxsIGhhcyBmaW5pc2hlZCBhbGwgdGFza3MuIFBhc3NlcyAxKSBhXG4gKiAgICAgICAgICAgICAgICAgICBib29sZWFuIGluZGljYXRpbmcgaWYgdGhlIGxhc3QgcG9ueWZpbGwgY2FsbCByZXN1bHRlZCBpbiBhXG4gKiAgICAgICAgICAgICAgICAgICBzdHlsZSBjaGFuZ2UsIDIpIGEgYm9vbGVhbiBpbmRpY2F0aW5nIGlmIHRoZSBjdXJyZW50XG4gKiAgICAgICAgICAgICAgICAgICBicm93c2VyIHByb3ZpZGVzIG5hdGl2ZSBzdXBwb3J0IGZvciBDU1MgY3VzdG9tIHByb3BlcnRpZXMsXG4gKiAgICAgICAgICAgICAgICAgICBhbmQgMykgdGhlIHBvbnlmaWxsIGV4ZWN1dGlvbiB0aW1lIGluIG1pbGxpc2Vjb25kcy5cbiAqIEBleGFtcGxlXG4gKlxuICogICBjc3NWYXJzKHtcbiAqICAgICByb290RWxlbWVudCAgIDogZG9jdW1lbnQsXG4gKiAgICAgc2hhZG93RE9NICAgICA6IGZhbHNlLFxuICogICAgIGluY2x1ZGUgICAgICAgOiAnc3R5bGUsbGlua1tyZWw9XCJzdHlsZXNoZWV0XCJdJyxcbiAqICAgICBleGNsdWRlICAgICAgIDogJycsXG4gKiAgICAgdmFyaWFibGVzICAgICA6IHt9LFxuICogICAgIG9ubHlMZWdhY3kgICAgOiB0cnVlLFxuICogICAgIHByZXNlcnZlU3RhdGljOiB0cnVlLFxuICogICAgIHByZXNlcnZlVmFycyAgOiBmYWxzZSxcbiAqICAgICBzaWxlbnQgICAgICAgIDogZmFsc2UsXG4gKiAgICAgdXBkYXRlRE9NICAgICA6IHRydWUsXG4gKiAgICAgdXBkYXRlVVJMcyAgICA6IHRydWUsXG4gKiAgICAgd2F0Y2ggICAgICAgICA6IGZhbHNlLFxuICogICAgIG9uQmVmb3JlU2VuZCh4aHIsIG5vZGUsIHVybCkge30sXG4gKiAgICAgb25FcnJvcihtZXNzYWdlLCBub2RlLCB4aHIsIHVybCkge30sXG4gKiAgICAgb25XYXJuaW5nKG1lc3NhZ2UpIHt9LFxuICogICAgIG9uU3VjY2Vzcyhjc3NUZXh0LCBub2RlLCB1cmwpIHt9LFxuICogICAgIG9uQ29tcGxldGUoY3NzVGV4dCwgc3R5bGVOb2RlLCBjc3NWYXJpYWJsZXMsIGJlbmNobWFyaykge30sXG4gKiAgICAgb25GaW5hbGx5KGhhc0NoYW5nZWQsIGhhc05hdGl2ZVN1cHBvcnQsIGJlbmNobWFyaylcbiAqICAgfSk7XG4gKi8gZnVuY3Rpb24gY3NzVmFycygpIHtcbiAgICB2YXIgb3B0aW9ucyA9IGFyZ3VtZW50cy5sZW5ndGggPiAwICYmIGFyZ3VtZW50c1swXSAhPT0gdW5kZWZpbmVkID8gYXJndW1lbnRzWzBdIDoge307XG4gICAgdmFyIG1zZ1ByZWZpeCA9IFwiY3NzVmFycygpOiBcIjtcbiAgICB2YXIgc2V0dGluZ3MgPSBfZXh0ZW5kcyh7fSwgZGVmYXVsdHMsIG9wdGlvbnMpO1xuICAgIGZ1bmN0aW9uIGhhbmRsZUVycm9yKG1lc3NhZ2UsIHNvdXJjZU5vZGUsIHhociwgdXJsKSB7XG4gICAgICAgIGlmICghc2V0dGluZ3Muc2lsZW50ICYmIHdpbmRvdy5jb25zb2xlKSB7XG4gICAgICAgICAgICBjb25zb2xlLmVycm9yKFwiXCIuY29uY2F0KG1zZ1ByZWZpeCkuY29uY2F0KG1lc3NhZ2UsIFwiXFxuXCIpLCBzb3VyY2VOb2RlKTtcbiAgICAgICAgfVxuICAgICAgICBzZXR0aW5ncy5vbkVycm9yKG1lc3NhZ2UsIHNvdXJjZU5vZGUsIHhociwgdXJsKTtcbiAgICB9XG4gICAgZnVuY3Rpb24gaGFuZGxlV2FybmluZyhtZXNzYWdlKSB7XG4gICAgICAgIGlmICghc2V0dGluZ3Muc2lsZW50ICYmIHdpbmRvdy5jb25zb2xlKSB7XG4gICAgICAgICAgICBjb25zb2xlLndhcm4oXCJcIi5jb25jYXQobXNnUHJlZml4KS5jb25jYXQobWVzc2FnZSkpO1xuICAgICAgICB9XG4gICAgICAgIHNldHRpbmdzLm9uV2FybmluZyhtZXNzYWdlKTtcbiAgICB9XG4gICAgZnVuY3Rpb24gaGFuZGxlRmluYWxseShoYXNDaGFuZ2VkKSB7XG4gICAgICAgIHNldHRpbmdzLm9uRmluYWxseShCb29sZWFuKGhhc0NoYW5nZWQpLCBpc05hdGl2ZVN1cHBvcnQsIGdldFRpbWVTdGFtcCgpIC0gc2V0dGluZ3MuX19iZW5jaG1hcmspO1xuICAgIH1cbiAgICBpZiAoIWlzQnJvd3Nlcikge1xuICAgICAgICByZXR1cm47XG4gICAgfVxuICAgIGlmIChzZXR0aW5ncy53YXRjaCkge1xuICAgICAgICBzZXR0aW5ncy53YXRjaCA9IGRlZmF1bHRzLndhdGNoO1xuICAgICAgICBhZGRNdXRhdGlvbk9ic2VydmVyKHNldHRpbmdzKTtcbiAgICAgICAgY3NzVmFycyhzZXR0aW5ncyk7XG4gICAgICAgIHJldHVybjtcbiAgICB9IGVsc2UgaWYgKHNldHRpbmdzLndhdGNoID09PSBmYWxzZSAmJiBjc3NWYXJzT2JzZXJ2ZXIpIHtcbiAgICAgICAgY3NzVmFyc09ic2VydmVyLmRpc2Nvbm5lY3QoKTtcbiAgICAgICAgY3NzVmFyc09ic2VydmVyID0gbnVsbDtcbiAgICB9XG4gICAgaWYgKCFzZXR0aW5ncy5fX2JlbmNobWFyaykge1xuICAgICAgICBpZiAoY3NzVmFyc0lzUnVubmluZyA9PT0gc2V0dGluZ3Mucm9vdEVsZW1lbnQpIHtcbiAgICAgICAgICAgIGNzc1ZhcnNEZWJvdW5jZWQob3B0aW9ucyk7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cbiAgICAgICAgdmFyIHNyY05vZGVzID0gQXJyYXkuYXBwbHkobnVsbCwgc2V0dGluZ3Mucm9vdEVsZW1lbnQucXVlcnlTZWxlY3RvckFsbCgnW2RhdGEtY3NzdmFyc106bm90KFtkYXRhLWNzc3ZhcnM9XCJvdXRcIl0pJykpO1xuICAgICAgICBzZXR0aW5ncy5fX2JlbmNobWFyayA9IGdldFRpbWVTdGFtcCgpO1xuICAgICAgICBzZXR0aW5ncy5leGNsdWRlID0gWyBjc3NWYXJzT2JzZXJ2ZXIgPyAnW2RhdGEtY3NzdmFyc106bm90KFtkYXRhLWNzc3ZhcnM9XCJcIl0pJyA6ICdbZGF0YS1jc3N2YXJzPVwib3V0XCJdJywgXCJsaW5rW2Rpc2FibGVkXTpub3QoW2RhdGEtY3NzdmFyc10pXCIsIHNldHRpbmdzLmV4Y2x1ZGUgXS5maWx0ZXIoKGZ1bmN0aW9uKHNlbGVjdG9yKSB7XG4gICAgICAgICAgICByZXR1cm4gc2VsZWN0b3I7XG4gICAgICAgIH0pKS5qb2luKFwiLFwiKTtcbiAgICAgICAgc2V0dGluZ3MudmFyaWFibGVzID0gZml4VmFyTmFtZXMoc2V0dGluZ3MudmFyaWFibGVzKTtcbiAgICAgICAgc3JjTm9kZXMuZm9yRWFjaCgoZnVuY3Rpb24oc3JjTm9kZSkge1xuICAgICAgICAgICAgdmFyIGhhc1N0eWxlQ2FjaGUgPSBzcmNOb2RlLm5vZGVOYW1lLnRvTG93ZXJDYXNlKCkgPT09IFwic3R5bGVcIiAmJiBzcmNOb2RlLl9fY3NzVmFycy50ZXh0O1xuICAgICAgICAgICAgdmFyIGhhc1N0eWxlQ2hhbmdlZCA9IGhhc1N0eWxlQ2FjaGUgJiYgc3JjTm9kZS50ZXh0Q29udGVudCAhPT0gc3JjTm9kZS5fX2Nzc1ZhcnMudGV4dDtcbiAgICAgICAgICAgIGlmIChoYXNTdHlsZUNhY2hlICYmIGhhc1N0eWxlQ2hhbmdlZCkge1xuICAgICAgICAgICAgICAgIHNyY05vZGUuc2hlZXQgJiYgKHNyY05vZGUuc2hlZXQuZGlzYWJsZWQgPSBmYWxzZSk7XG4gICAgICAgICAgICAgICAgc3JjTm9kZS5zZXRBdHRyaWJ1dGUoXCJkYXRhLWNzc3ZhcnNcIiwgXCJcIik7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pKTtcbiAgICAgICAgaWYgKCFjc3NWYXJzT2JzZXJ2ZXIpIHtcbiAgICAgICAgICAgIHZhciBvdXROb2RlcyA9IEFycmF5LmFwcGx5KG51bGwsIHNldHRpbmdzLnJvb3RFbGVtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJ1tkYXRhLWNzc3ZhcnM9XCJvdXRcIl0nKSk7XG4gICAgICAgICAgICBvdXROb2Rlcy5mb3JFYWNoKChmdW5jdGlvbihvdXROb2RlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGFHcm91cCA9IG91dE5vZGUuZ2V0QXR0cmlidXRlKFwiZGF0YS1jc3N2YXJzLWdyb3VwXCIpO1xuICAgICAgICAgICAgICAgIHZhciBzcmNOb2RlID0gZGF0YUdyb3VwID8gc2V0dGluZ3Mucm9vdEVsZW1lbnQucXVlcnlTZWxlY3RvcignW2RhdGEtY3NzdmFycz1cInNyY1wiXVtkYXRhLWNzc3ZhcnMtZ3JvdXA9XCInLmNvbmNhdChkYXRhR3JvdXAsICdcIl0nKSkgOiBudWxsO1xuICAgICAgICAgICAgICAgIGlmICghc3JjTm9kZSkge1xuICAgICAgICAgICAgICAgICAgICBvdXROb2RlLnBhcmVudE5vZGUucmVtb3ZlQ2hpbGQob3V0Tm9kZSk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSkpO1xuICAgICAgICAgICAgaWYgKGNzc1ZhcnNTcmNOb2RlQ291bnQgJiYgc3JjTm9kZXMubGVuZ3RoIDwgY3NzVmFyc1NyY05vZGVDb3VudCkge1xuICAgICAgICAgICAgICAgIGNzc1ZhcnNTcmNOb2RlQ291bnQgPSBzcmNOb2Rlcy5sZW5ndGg7XG4gICAgICAgICAgICAgICAgdmFyaWFibGVTdG9yZS5kb20gPSB7fTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgIH1cbiAgICBpZiAoZG9jdW1lbnQucmVhZHlTdGF0ZSAhPT0gXCJsb2FkaW5nXCIpIHtcbiAgICAgICAgaWYgKGlzTmF0aXZlU3VwcG9ydCAmJiBzZXR0aW5ncy5vbmx5TGVnYWN5KSB7XG4gICAgICAgICAgICB2YXIgaGFzVmFyQ2hhbmdlID0gZmFsc2U7XG4gICAgICAgICAgICBpZiAoc2V0dGluZ3MudXBkYXRlRE9NKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldEVsbSA9IHNldHRpbmdzLnJvb3RFbGVtZW50Lmhvc3QgfHwgKHNldHRpbmdzLnJvb3RFbGVtZW50ID09PSBkb2N1bWVudCA/IGRvY3VtZW50LmRvY3VtZW50RWxlbWVudCA6IHNldHRpbmdzLnJvb3RFbGVtZW50KTtcbiAgICAgICAgICAgICAgICBPYmplY3Qua2V5cyhzZXR0aW5ncy52YXJpYWJsZXMpLmZvckVhY2goKGZ1bmN0aW9uKGtleSkge1xuICAgICAgICAgICAgICAgICAgICB2YXIgdmFyVmFsdWUgPSBzZXR0aW5ncy52YXJpYWJsZXNba2V5XTtcbiAgICAgICAgICAgICAgICAgICAgaGFzVmFyQ2hhbmdlID0gaGFzVmFyQ2hhbmdlIHx8IHZhclZhbHVlICE9PSBnZXRDb21wdXRlZFN0eWxlKHRhcmdldEVsbSkuZ2V0UHJvcGVydHlWYWx1ZShrZXkpO1xuICAgICAgICAgICAgICAgICAgICB0YXJnZXRFbG0uc3R5bGUuc2V0UHJvcGVydHkoa2V5LCB2YXJWYWx1ZSk7XG4gICAgICAgICAgICAgICAgfSkpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgaGFuZGxlRmluYWxseShoYXNWYXJDaGFuZ2UpO1xuICAgICAgICB9IGVsc2UgaWYgKCFpc1NoYWRvd0RPTVJlYWR5ICYmIChzZXR0aW5ncy5zaGFkb3dET00gfHwgc2V0dGluZ3Mucm9vdEVsZW1lbnQuc2hhZG93Um9vdCB8fCBzZXR0aW5ncy5yb290RWxlbWVudC5ob3N0KSkge1xuICAgICAgICAgICAgZ2V0Q3NzRGF0YSh7XG4gICAgICAgICAgICAgICAgcm9vdEVsZW1lbnQ6IGRlZmF1bHRzLnJvb3RFbGVtZW50LFxuICAgICAgICAgICAgICAgIGluY2x1ZGU6IGRlZmF1bHRzLmluY2x1ZGUsXG4gICAgICAgICAgICAgICAgZXhjbHVkZTogc2V0dGluZ3MuZXhjbHVkZSxcbiAgICAgICAgICAgICAgICBza2lwRGlzYWJsZWQ6IGZhbHNlLFxuICAgICAgICAgICAgICAgIG9uU3VjY2VzczogZnVuY3Rpb24gb25TdWNjZXNzKGNzc1RleHQsIG5vZGUsIHVybCkge1xuICAgICAgICAgICAgICAgICAgICB2YXIgaXNVc2VyRGlzYWJsZWQgPSAobm9kZS5zaGVldCB8fCB7fSkuZGlzYWJsZWQgJiYgIW5vZGUuX19jc3NWYXJzO1xuICAgICAgICAgICAgICAgICAgICBpZiAoaXNVc2VyRGlzYWJsZWQpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBjc3NUZXh0ID0gY3NzVGV4dC5yZXBsYWNlKHJlZ2V4LmNzc0NvbW1lbnRzLCBcIlwiKS5yZXBsYWNlKHJlZ2V4LmNzc01lZGlhUXVlcmllcywgXCJcIik7XG4gICAgICAgICAgICAgICAgICAgIGNzc1RleHQgPSAoY3NzVGV4dC5tYXRjaChyZWdleC5jc3NWYXJEZWNsUnVsZXMpIHx8IFtdKS5qb2luKFwiXCIpO1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gY3NzVGV4dCB8fCBmYWxzZTtcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIG9uQ29tcGxldGU6IGZ1bmN0aW9uIG9uQ29tcGxldGUoY3NzVGV4dCwgY3NzQXJyYXksIG5vZGVBcnJheSkge1xuICAgICAgICAgICAgICAgICAgICBwYXJzZVZhcnMoY3NzVGV4dCwge1xuICAgICAgICAgICAgICAgICAgICAgICAgc3RvcmU6IHZhcmlhYmxlU3RvcmUuZG9tLFxuICAgICAgICAgICAgICAgICAgICAgICAgb25XYXJuaW5nOiBoYW5kbGVXYXJuaW5nXG4gICAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgICAgICBpc1NoYWRvd0RPTVJlYWR5ID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICAgICAgY3NzVmFycyhzZXR0aW5ncyk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICBjc3NWYXJzSXNSdW5uaW5nID0gc2V0dGluZ3Mucm9vdEVsZW1lbnQ7XG4gICAgICAgICAgICBnZXRDc3NEYXRhKHtcbiAgICAgICAgICAgICAgICByb290RWxlbWVudDogc2V0dGluZ3Mucm9vdEVsZW1lbnQsXG4gICAgICAgICAgICAgICAgaW5jbHVkZTogc2V0dGluZ3MuaW5jbHVkZSxcbiAgICAgICAgICAgICAgICBleGNsdWRlOiBzZXR0aW5ncy5leGNsdWRlLFxuICAgICAgICAgICAgICAgIHNraXBEaXNhYmxlZDogZmFsc2UsXG4gICAgICAgICAgICAgICAgb25CZWZvcmVTZW5kOiBzZXR0aW5ncy5vbkJlZm9yZVNlbmQsXG4gICAgICAgICAgICAgICAgb25FcnJvcjogZnVuY3Rpb24gb25FcnJvcih4aHIsIG5vZGUsIHVybCkge1xuICAgICAgICAgICAgICAgICAgICB2YXIgcmVzcG9uc2VVcmwgPSB4aHIucmVzcG9uc2VVUkwgfHwgZ2V0RnVsbFVybCQxKHVybCwgbG9jYXRpb24uaHJlZik7XG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGF0dXNUZXh0ID0geGhyLnN0YXR1c1RleHQgPyBcIihcIi5jb25jYXQoeGhyLnN0YXR1c1RleHQsIFwiKVwiKSA6IFwiVW5zcGVjaWZpZWQgRXJyb3JcIiArICh4aHIuc3RhdHVzID09PSAwID8gXCIgKHBvc3NpYmx5IENPUlMgcmVsYXRlZClcIiA6IFwiXCIpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgZXJyb3JNc2cgPSBcIkNTUyBYSFIgRXJyb3I6IFwiLmNvbmNhdChyZXNwb25zZVVybCwgXCIgXCIpLmNvbmNhdCh4aHIuc3RhdHVzLCBcIiBcIikuY29uY2F0KHN0YXR1c1RleHQpO1xuICAgICAgICAgICAgICAgICAgICBoYW5kbGVFcnJvcihlcnJvck1zZywgbm9kZSwgeGhyLCByZXNwb25zZVVybCk7XG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBvblN1Y2Nlc3M6IGZ1bmN0aW9uIG9uU3VjY2Vzcyhjc3NUZXh0LCBub2RlLCB1cmwpIHtcbiAgICAgICAgICAgICAgICAgICAgdmFyIGlzVXNlckRpc2FibGVkID0gKG5vZGUuc2hlZXQgfHwge30pLmRpc2FibGVkICYmICFub2RlLl9fY3NzVmFycztcbiAgICAgICAgICAgICAgICAgICAgaWYgKGlzVXNlckRpc2FibGVkKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgdmFyIGlzTGluayA9IG5vZGUubm9kZU5hbWUudG9Mb3dlckNhc2UoKSA9PT0gXCJsaW5rXCI7XG4gICAgICAgICAgICAgICAgICAgIHZhciBpc1N0eWxlSW1wb3J0ID0gbm9kZS5ub2RlTmFtZS50b0xvd2VyQ2FzZSgpID09PSBcInN0eWxlXCIgJiYgY3NzVGV4dCAhPT0gbm9kZS50ZXh0Q29udGVudDtcbiAgICAgICAgICAgICAgICAgICAgdmFyIHJldHVyblZhbCA9IHNldHRpbmdzLm9uU3VjY2Vzcyhjc3NUZXh0LCBub2RlLCB1cmwpO1xuICAgICAgICAgICAgICAgICAgICBjc3NUZXh0ID0gcmV0dXJuVmFsICE9PSB1bmRlZmluZWQgJiYgQm9vbGVhbihyZXR1cm5WYWwpID09PSBmYWxzZSA/IFwiXCIgOiByZXR1cm5WYWwgfHwgY3NzVGV4dDtcbiAgICAgICAgICAgICAgICAgICAgaWYgKHNldHRpbmdzLnVwZGF0ZVVSTHMgJiYgKGlzTGluayB8fCBpc1N0eWxlSW1wb3J0KSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgY3NzVGV4dCA9IGZpeFJlbGF0aXZlQ3NzVXJscyhjc3NUZXh0LCB1cmwpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiBjc3NUZXh0O1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgb25Db21wbGV0ZTogZnVuY3Rpb24gb25Db21wbGV0ZShjc3NUZXh0LCBjc3NBcnJheSkge1xuICAgICAgICAgICAgICAgICAgICB2YXIgbm9kZUFycmF5ID0gYXJndW1lbnRzLmxlbmd0aCA+IDIgJiYgYXJndW1lbnRzWzJdICE9PSB1bmRlZmluZWQgPyBhcmd1bWVudHNbMl0gOiBbXTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIGN1cnJlbnRWYXJzID0gX2V4dGVuZHMoe30sIHZhcmlhYmxlU3RvcmUuZG9tLCB2YXJpYWJsZVN0b3JlLnVzZXIpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgaGFzVmFyQ2hhbmdlID0gZmFsc2U7XG4gICAgICAgICAgICAgICAgICAgIHZhcmlhYmxlU3RvcmUuam9iID0ge307XG4gICAgICAgICAgICAgICAgICAgIG5vZGVBcnJheS5mb3JFYWNoKChmdW5jdGlvbihub2RlLCBpKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgbm9kZUNTUyA9IGNzc0FycmF5W2ldO1xuICAgICAgICAgICAgICAgICAgICAgICAgbm9kZS5fX2Nzc1ZhcnMgPSBub2RlLl9fY3NzVmFycyB8fCB7fTtcbiAgICAgICAgICAgICAgICAgICAgICAgIG5vZGUuX19jc3NWYXJzLnRleHQgPSBub2RlQ1NTO1xuICAgICAgICAgICAgICAgICAgICAgICAgaWYgKHJlZ2V4LmNzc1ZhcnMudGVzdChub2RlQ1NTKSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRyeSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBjc3NUcmVlID0gcGFyc2VDc3Mobm9kZUNTUywge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcHJlc2VydmVTdGF0aWM6IHNldHRpbmdzLnByZXNlcnZlU3RhdGljLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcmVtb3ZlQ29tbWVudHM6IHRydWVcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHBhcnNlVmFycyhjc3NUcmVlLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBwYXJzZUhvc3Q6IEJvb2xlYW4oc2V0dGluZ3Mucm9vdEVsZW1lbnQuaG9zdCksXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdG9yZTogdmFyaWFibGVTdG9yZS5kb20sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBvbldhcm5pbmc6IGhhbmRsZVdhcm5pbmdcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5vZGUuX19jc3NWYXJzLnRyZWUgPSBjc3NUcmVlO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0gY2F0Y2ggKGVycikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBoYW5kbGVFcnJvcihlcnIubWVzc2FnZSwgbm9kZSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICAgICAgICAgIF9leHRlbmRzKHZhcmlhYmxlU3RvcmUuam9iLCB2YXJpYWJsZVN0b3JlLmRvbSk7XG4gICAgICAgICAgICAgICAgICAgIGlmIChzZXR0aW5ncy51cGRhdGVET00pIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIF9leHRlbmRzKHZhcmlhYmxlU3RvcmUudXNlciwgc2V0dGluZ3MudmFyaWFibGVzKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIF9leHRlbmRzKHZhcmlhYmxlU3RvcmUuam9iLCB2YXJpYWJsZVN0b3JlLnVzZXIpO1xuICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgX2V4dGVuZHModmFyaWFibGVTdG9yZS5qb2IsIHZhcmlhYmxlU3RvcmUudXNlciwgc2V0dGluZ3MudmFyaWFibGVzKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIF9leHRlbmRzKGN1cnJlbnRWYXJzLCBzZXR0aW5ncy52YXJpYWJsZXMpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIGhhc1ZhckNoYW5nZSA9IGNvdW50ZXJzLmpvYiA+IDAgJiYgQm9vbGVhbihPYmplY3Qua2V5cyh2YXJpYWJsZVN0b3JlLmpvYikubGVuZ3RoID4gT2JqZWN0LmtleXMoY3VycmVudFZhcnMpLmxlbmd0aCB8fCBCb29sZWFuKE9iamVjdC5rZXlzKGN1cnJlbnRWYXJzKS5sZW5ndGggJiYgT2JqZWN0LmtleXModmFyaWFibGVTdG9yZS5qb2IpLnNvbWUoKGZ1bmN0aW9uKGtleSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIHZhcmlhYmxlU3RvcmUuam9iW2tleV0gIT09IGN1cnJlbnRWYXJzW2tleV07XG4gICAgICAgICAgICAgICAgICAgIH0pKSkpO1xuICAgICAgICAgICAgICAgICAgICBpZiAoaGFzVmFyQ2hhbmdlKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICByZXNldENzc05vZGVzKHNldHRpbmdzLnJvb3RFbGVtZW50KTtcbiAgICAgICAgICAgICAgICAgICAgICAgIGNzc1ZhcnMoc2V0dGluZ3MpO1xuICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIG91dENzc0FycmF5ID0gW107XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgb3V0Tm9kZUFycmF5ID0gW107XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgaGFzS2V5ZnJhbWVzV2l0aFZhcnMgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmIChzZXR0aW5ncy51cGRhdGVET00pIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb3VudGVycy5qb2IrKztcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIG5vZGVBcnJheS5mb3JFYWNoKChmdW5jdGlvbihub2RlLCBpKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGlzU2tpcCA9ICFub2RlLl9fY3NzVmFycy50cmVlO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChub2RlLl9fY3NzVmFycy50cmVlKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRyeSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0cmFuc2Zvcm1Dc3Mobm9kZS5fX2Nzc1ZhcnMudHJlZSwgX2V4dGVuZHMoe30sIHNldHRpbmdzLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyaWFibGVzOiB2YXJpYWJsZVN0b3JlLmpvYixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBvbldhcm5pbmc6IGhhbmRsZVdhcm5pbmdcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBvdXRDc3MgPSBzdHJpbmdpZnlDc3Mobm9kZS5fX2Nzc1ZhcnMudHJlZSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoc2V0dGluZ3MudXBkYXRlRE9NKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIG5vZGVDU1MgPSBjc3NBcnJheVtpXTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgaGFzQ1NTVmFyRnVuYyA9IHJlZ2V4LmNzc1ZhckZ1bmMudGVzdChub2RlQ1NTKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoIW5vZGUuZ2V0QXR0cmlidXRlKFwiZGF0YS1jc3N2YXJzXCIpKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5vZGUuc2V0QXR0cmlidXRlKFwiZGF0YS1jc3N2YXJzXCIsIFwic3JjXCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAob3V0Q3NzLmxlbmd0aCAmJiBoYXNDU1NWYXJGdW5jKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBkYXRhR3JvdXAgPSBub2RlLmdldEF0dHJpYnV0ZShcImRhdGEtY3NzdmFycy1ncm91cFwiKSB8fCArK2NvdW50ZXJzLmdyb3VwO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgb3V0Q3NzTm9TcGFjZXMgPSBvdXRDc3MucmVwbGFjZSgvXFxzL2csIFwiXCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgb3V0Tm9kZSA9IHNldHRpbmdzLnJvb3RFbGVtZW50LnF1ZXJ5U2VsZWN0b3IoJ1tkYXRhLWNzc3ZhcnM9XCJvdXRcIl1bZGF0YS1jc3N2YXJzLWdyb3VwPVwiJy5jb25jYXQoZGF0YUdyb3VwLCAnXCJdJykpIHx8IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJzdHlsZVwiKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaGFzS2V5ZnJhbWVzV2l0aFZhcnMgPSBoYXNLZXlmcmFtZXNXaXRoVmFycyB8fCByZWdleC5jc3NLZXlmcmFtZXMudGVzdChvdXRDc3MpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoc2V0dGluZ3MucHJlc2VydmVTdGF0aWMpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5vZGUuc2hlZXQgJiYgKG5vZGUuc2hlZXQuZGlzYWJsZWQgPSB0cnVlKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoIW91dE5vZGUuaGFzQXR0cmlidXRlKFwiZGF0YS1jc3N2YXJzXCIpKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBvdXROb2RlLnNldEF0dHJpYnV0ZShcImRhdGEtY3NzdmFyc1wiLCBcIm91dFwiKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAob3V0Q3NzTm9TcGFjZXMgPT09IG5vZGUudGV4dENvbnRlbnQucmVwbGFjZSgvXFxzL2csIFwiXCIpKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpc1NraXAgPSB0cnVlO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKG91dE5vZGUgJiYgb3V0Tm9kZS5wYXJlbnROb2RlKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbm9kZS5yZW1vdmVBdHRyaWJ1dGUoXCJkYXRhLWNzc3ZhcnMtZ3JvdXBcIik7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgb3V0Tm9kZS5wYXJlbnROb2RlLnJlbW92ZUNoaWxkKG91dE5vZGUpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9IGVsc2UgaWYgKG91dENzc05vU3BhY2VzICE9PSBvdXROb2RlLnRleHRDb250ZW50LnJlcGxhY2UoL1xccy9nLCBcIlwiKSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgWyBub2RlLCBvdXROb2RlIF0uZm9yRWFjaCgoZnVuY3Rpb24obikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG4uc2V0QXR0cmlidXRlKFwiZGF0YS1jc3N2YXJzLWpvYlwiLCBjb3VudGVycy5qb2IpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG4uc2V0QXR0cmlidXRlKFwiZGF0YS1jc3N2YXJzLWdyb3VwXCIsIGRhdGFHcm91cCk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBvdXROb2RlLnRleHRDb250ZW50ID0gb3V0Q3NzO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgb3V0Q3NzQXJyYXkucHVzaChvdXRDc3MpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgb3V0Tm9kZUFycmF5LnB1c2gob3V0Tm9kZSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoIW91dE5vZGUucGFyZW50Tm9kZSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5vZGUucGFyZW50Tm9kZS5pbnNlcnRCZWZvcmUob3V0Tm9kZSwgbm9kZS5uZXh0U2libGluZyk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChub2RlLnRleHRDb250ZW50LnJlcGxhY2UoL1xccy9nLCBcIlwiKSAhPT0gb3V0Q3NzKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG91dENzc0FycmF5LnB1c2gob3V0Q3NzKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0gY2F0Y2ggKGVycikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaGFuZGxlRXJyb3IoZXJyLm1lc3NhZ2UsIG5vZGUpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChpc1NraXApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbm9kZS5zZXRBdHRyaWJ1dGUoXCJkYXRhLWNzc3ZhcnNcIiwgXCJza2lwXCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoIW5vZGUuaGFzQXR0cmlidXRlKFwiZGF0YS1jc3N2YXJzLWpvYlwiKSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBub2RlLnNldEF0dHJpYnV0ZShcImRhdGEtY3NzdmFycy1qb2JcIiwgY291bnRlcnMuam9iKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICAgICAgICAgICAgICBjc3NWYXJzU3JjTm9kZUNvdW50ID0gc2V0dGluZ3Mucm9vdEVsZW1lbnQucXVlcnlTZWxlY3RvckFsbCgnW2RhdGEtY3NzdmFyc106bm90KFtkYXRhLWNzc3ZhcnM9XCJvdXRcIl0pJykubGVuZ3RoO1xuICAgICAgICAgICAgICAgICAgICAgICAgaWYgKHNldHRpbmdzLnNoYWRvd0RPTSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBlbG1zID0gW10uY29uY2F0KHNldHRpbmdzLnJvb3RFbGVtZW50KS5jb25jYXQoQXJyYXkuYXBwbHkobnVsbCwgc2V0dGluZ3Mucm9vdEVsZW1lbnQucXVlcnlTZWxlY3RvckFsbChcIipcIikpKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmb3IgKHZhciBpID0gMCwgZWxtOyBlbG0gPSBlbG1zW2ldOyArK2kpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKGVsbS5zaGFkb3dSb290ICYmIGVsbS5zaGFkb3dSb290LnF1ZXJ5U2VsZWN0b3IoXCJzdHlsZVwiKSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHNoYWRvd1NldHRpbmdzID0gX2V4dGVuZHMoe30sIHNldHRpbmdzLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcm9vdEVsZW1lbnQ6IGVsbS5zaGFkb3dSb290XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNzc1ZhcnMoc2hhZG93U2V0dGluZ3MpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgaWYgKHNldHRpbmdzLnVwZGF0ZURPTSAmJiBoYXNLZXlmcmFtZXNXaXRoVmFycykge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZpeEtleWZyYW1lcyhzZXR0aW5ncy5yb290RWxlbWVudCk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICBjc3NWYXJzSXNSdW5uaW5nID0gZmFsc2U7XG4gICAgICAgICAgICAgICAgICAgICAgICBzZXR0aW5ncy5vbkNvbXBsZXRlKG91dENzc0FycmF5LmpvaW4oXCJcIiksIG91dE5vZGVBcnJheSwgSlNPTi5wYXJzZShKU09OLnN0cmluZ2lmeSh2YXJpYWJsZVN0b3JlLmpvYikpLCBnZXRUaW1lU3RhbXAoKSAtIHNldHRpbmdzLl9fYmVuY2htYXJrKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIGhhbmRsZUZpbmFsbHkob3V0Tm9kZUFycmF5Lmxlbmd0aCk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH0gZWxzZSB7XG4gICAgICAgIGRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoXCJET01Db250ZW50TG9hZGVkXCIsIChmdW5jdGlvbiBpbml0KGV2dCkge1xuICAgICAgICAgICAgY3NzVmFycyhvcHRpb25zKTtcbiAgICAgICAgICAgIGRvY3VtZW50LnJlbW92ZUV2ZW50TGlzdGVuZXIoXCJET01Db250ZW50TG9hZGVkXCIsIGluaXQpO1xuICAgICAgICB9KSk7XG4gICAgfVxufVxuXG5jc3NWYXJzLnJlc2V0ID0gZnVuY3Rpb24oKSB7XG4gICAgY291bnRlcnMuam9iID0gMDtcbiAgICBjb3VudGVycy5ncm91cCA9IDA7XG4gICAgY3NzVmFyc0lzUnVubmluZyA9IGZhbHNlO1xuICAgIGlmIChjc3NWYXJzT2JzZXJ2ZXIpIHtcbiAgICAgICAgY3NzVmFyc09ic2VydmVyLmRpc2Nvbm5lY3QoKTtcbiAgICAgICAgY3NzVmFyc09ic2VydmVyID0gbnVsbDtcbiAgICB9XG4gICAgY3NzVmFyc1NyY05vZGVDb3VudCA9IDA7XG4gICAgZGVib3VuY2VUaW1lciA9IG51bGw7XG4gICAgaXNTaGFkb3dET01SZWFkeSA9IGZhbHNlO1xuICAgIGZvciAodmFyIHByb3AgaW4gdmFyaWFibGVTdG9yZSkge1xuICAgICAgICB2YXJpYWJsZVN0b3JlW3Byb3BdID0ge307XG4gICAgfVxufTtcblxuZnVuY3Rpb24gYWRkTXV0YXRpb25PYnNlcnZlcihzZXR0aW5ncykge1xuICAgIGZ1bmN0aW9uIGlzRGlzYWJsZWQobm9kZSkge1xuICAgICAgICB2YXIgaXNEaXNhYmxlZEF0dHIgPSBpc0xpbmsobm9kZSkgJiYgbm9kZS5oYXNBdHRyaWJ1dGUoXCJkaXNhYmxlZFwiKTtcbiAgICAgICAgdmFyIGlzRGlzYWJsZWRTaGVldCA9IChub2RlLnNoZWV0IHx8IHt9KS5kaXNhYmxlZDtcbiAgICAgICAgcmV0dXJuIGlzRGlzYWJsZWRBdHRyIHx8IGlzRGlzYWJsZWRTaGVldDtcbiAgICB9XG4gICAgZnVuY3Rpb24gaXNMaW5rKG5vZGUpIHtcbiAgICAgICAgdmFyIGlzU3R5bGVzaGVldCA9IG5vZGUubm9kZU5hbWUudG9Mb3dlckNhc2UoKSA9PT0gXCJsaW5rXCIgJiYgKG5vZGUuZ2V0QXR0cmlidXRlKFwicmVsXCIpIHx8IFwiXCIpLmluZGV4T2YoXCJzdHlsZXNoZWV0XCIpICE9PSAtMTtcbiAgICAgICAgcmV0dXJuIGlzU3R5bGVzaGVldDtcbiAgICB9XG4gICAgZnVuY3Rpb24gaXNTdHlsZShub2RlKSB7XG4gICAgICAgIHJldHVybiBub2RlLm5vZGVOYW1lLnRvTG93ZXJDYXNlKCkgPT09IFwic3R5bGVcIjtcbiAgICB9XG4gICAgZnVuY3Rpb24gaXNWYWxpZEF0dHJpYnV0ZU11dGF0aW9uKG11dGF0aW9uKSB7XG4gICAgICAgIHZhciBpc1ZhbGlkID0gZmFsc2U7XG4gICAgICAgIGlmIChtdXRhdGlvbi50eXBlID09PSBcImF0dHJpYnV0ZXNcIiAmJiBpc0xpbmsobXV0YXRpb24udGFyZ2V0KSAmJiAhaXNEaXNhYmxlZChtdXRhdGlvbi50YXJnZXQpKSB7XG4gICAgICAgICAgICB2YXIgaXNFbmFibGVkTXV0YXRpb24gPSBtdXRhdGlvbi5hdHRyaWJ1dGVOYW1lID09PSBcImRpc2FibGVkXCI7XG4gICAgICAgICAgICB2YXIgaXNIcmVmTXV0YXRpb24gPSBtdXRhdGlvbi5hdHRyaWJ1dGVOYW1lID09PSBcImhyZWZcIjtcbiAgICAgICAgICAgIHZhciBpc1NraXBOb2RlID0gbXV0YXRpb24udGFyZ2V0LmdldEF0dHJpYnV0ZShcImRhdGEtY3NzdmFyc1wiKSA9PT0gXCJza2lwXCI7XG4gICAgICAgICAgICB2YXIgaXNTcmNOb2RlID0gbXV0YXRpb24udGFyZ2V0LmdldEF0dHJpYnV0ZShcImRhdGEtY3NzdmFyc1wiKSA9PT0gXCJzcmNcIjtcbiAgICAgICAgICAgIGlmIChpc0VuYWJsZWRNdXRhdGlvbikge1xuICAgICAgICAgICAgICAgIGlzVmFsaWQgPSAhaXNTa2lwTm9kZSAmJiAhaXNTcmNOb2RlO1xuICAgICAgICAgICAgfSBlbHNlIGlmIChpc0hyZWZNdXRhdGlvbikge1xuICAgICAgICAgICAgICAgIGlmIChpc1NraXBOb2RlKSB7XG4gICAgICAgICAgICAgICAgICAgIG11dGF0aW9uLnRhcmdldC5zZXRBdHRyaWJ1dGUoXCJkYXRhLWNzc3ZhcnNcIiwgXCJcIik7XG4gICAgICAgICAgICAgICAgfSBlbHNlIGlmIChpc1NyY05vZGUpIHtcbiAgICAgICAgICAgICAgICAgICAgcmVzZXRDc3NOb2RlcyhzZXR0aW5ncy5yb290RWxlbWVudCwgdHJ1ZSk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGlzVmFsaWQgPSB0cnVlO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICAgIHJldHVybiBpc1ZhbGlkO1xuICAgIH1cbiAgICBmdW5jdGlvbiBpc1ZhbGlkU3R5bGVUZXh0TXV0YXRpb24obXV0YXRpb24pIHtcbiAgICAgICAgdmFyIGlzVmFsaWQgPSBmYWxzZTtcbiAgICAgICAgaWYgKG11dGF0aW9uLnR5cGUgPT09IFwiY2hpbGRMaXN0XCIpIHtcbiAgICAgICAgICAgIHZhciBpc1N0eWxlRWxtID0gaXNTdHlsZShtdXRhdGlvbi50YXJnZXQpO1xuICAgICAgICAgICAgdmFyIGlzT3V0Tm9kZSA9IG11dGF0aW9uLnRhcmdldC5nZXRBdHRyaWJ1dGUoXCJkYXRhLWNzc3ZhcnNcIikgPT09IFwib3V0XCI7XG4gICAgICAgICAgICBpc1ZhbGlkID0gaXNTdHlsZUVsbSAmJiAhaXNPdXROb2RlO1xuICAgICAgICB9XG4gICAgICAgIHJldHVybiBpc1ZhbGlkO1xuICAgIH1cbiAgICBmdW5jdGlvbiBpc1ZhbGlkQWRkTXV0YXRpb24obXV0YXRpb24pIHtcbiAgICAgICAgdmFyIGlzVmFsaWQgPSBmYWxzZTtcbiAgICAgICAgaWYgKG11dGF0aW9uLnR5cGUgPT09IFwiY2hpbGRMaXN0XCIpIHtcbiAgICAgICAgICAgIGlzVmFsaWQgPSBBcnJheS5hcHBseShudWxsLCBtdXRhdGlvbi5hZGRlZE5vZGVzKS5zb21lKChmdW5jdGlvbihub2RlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGlzRWxtID0gbm9kZS5ub2RlVHlwZSA9PT0gMTtcbiAgICAgICAgICAgICAgICB2YXIgaGFzQXR0ciA9IGlzRWxtICYmIG5vZGUuaGFzQXR0cmlidXRlKFwiZGF0YS1jc3N2YXJzXCIpO1xuICAgICAgICAgICAgICAgIHZhciBpc1N0eWxlV2l0aFZhcnMgPSBpc1N0eWxlKG5vZGUpICYmIHJlZ2V4LmNzc1ZhcnMudGVzdChub2RlLnRleHRDb250ZW50KTtcbiAgICAgICAgICAgICAgICB2YXIgaXNWYWxpZCA9ICFoYXNBdHRyICYmIChpc0xpbmsobm9kZSkgfHwgaXNTdHlsZVdpdGhWYXJzKTtcbiAgICAgICAgICAgICAgICByZXR1cm4gaXNWYWxpZCAmJiAhaXNEaXNhYmxlZChub2RlKTtcbiAgICAgICAgICAgIH0pKTtcbiAgICAgICAgfVxuICAgICAgICByZXR1cm4gaXNWYWxpZDtcbiAgICB9XG4gICAgZnVuY3Rpb24gaXNWYWxpZFJlbW92ZU11dGF0aW9uKG11dGF0aW9uKSB7XG4gICAgICAgIHZhciBpc1ZhbGlkID0gZmFsc2U7XG4gICAgICAgIGlmIChtdXRhdGlvbi50eXBlID09PSBcImNoaWxkTGlzdFwiKSB7XG4gICAgICAgICAgICBpc1ZhbGlkID0gQXJyYXkuYXBwbHkobnVsbCwgbXV0YXRpb24ucmVtb3ZlZE5vZGVzKS5zb21lKChmdW5jdGlvbihub2RlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGlzRWxtID0gbm9kZS5ub2RlVHlwZSA9PT0gMTtcbiAgICAgICAgICAgICAgICB2YXIgaXNPdXROb2RlID0gaXNFbG0gJiYgbm9kZS5nZXRBdHRyaWJ1dGUoXCJkYXRhLWNzc3ZhcnNcIikgPT09IFwib3V0XCI7XG4gICAgICAgICAgICAgICAgdmFyIGlzU3JjTm9kZSA9IGlzRWxtICYmIG5vZGUuZ2V0QXR0cmlidXRlKFwiZGF0YS1jc3N2YXJzXCIpID09PSBcInNyY1wiO1xuICAgICAgICAgICAgICAgIHZhciBpc1ZhbGlkID0gaXNTcmNOb2RlO1xuICAgICAgICAgICAgICAgIGlmIChpc1NyY05vZGUgfHwgaXNPdXROb2RlKSB7XG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRhR3JvdXAgPSBub2RlLmdldEF0dHJpYnV0ZShcImRhdGEtY3NzdmFycy1ncm91cFwiKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIG9ycGhhbk5vZGUgPSBzZXR0aW5ncy5yb290RWxlbWVudC5xdWVyeVNlbGVjdG9yKCdbZGF0YS1jc3N2YXJzLWdyb3VwPVwiJy5jb25jYXQoZGF0YUdyb3VwLCAnXCJdJykpO1xuICAgICAgICAgICAgICAgICAgICBpZiAoaXNTcmNOb2RlKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICByZXNldENzc05vZGVzKHNldHRpbmdzLnJvb3RFbGVtZW50LCB0cnVlKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBpZiAob3JwaGFuTm9kZSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgb3JwaGFuTm9kZS5wYXJlbnROb2RlLnJlbW92ZUNoaWxkKG9ycGhhbk5vZGUpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIHJldHVybiBpc1ZhbGlkO1xuICAgICAgICAgICAgfSkpO1xuICAgICAgICB9XG4gICAgICAgIHJldHVybiBpc1ZhbGlkO1xuICAgIH1cbiAgICBpZiAoIXdpbmRvdy5NdXRhdGlvbk9ic2VydmVyKSB7XG4gICAgICAgIHJldHVybjtcbiAgICB9XG4gICAgaWYgKGNzc1ZhcnNPYnNlcnZlcikge1xuICAgICAgICBjc3NWYXJzT2JzZXJ2ZXIuZGlzY29ubmVjdCgpO1xuICAgICAgICBjc3NWYXJzT2JzZXJ2ZXIgPSBudWxsO1xuICAgIH1cbiAgICBjc3NWYXJzT2JzZXJ2ZXIgPSBuZXcgTXV0YXRpb25PYnNlcnZlcigoZnVuY3Rpb24obXV0YXRpb25zKSB7XG4gICAgICAgIHZhciBoYXNWYWxpZE11dGF0aW9uID0gbXV0YXRpb25zLnNvbWUoKGZ1bmN0aW9uKG11dGF0aW9uKSB7XG4gICAgICAgICAgICByZXR1cm4gaXNWYWxpZEF0dHJpYnV0ZU11dGF0aW9uKG11dGF0aW9uKSB8fCBpc1ZhbGlkU3R5bGVUZXh0TXV0YXRpb24obXV0YXRpb24pIHx8IGlzVmFsaWRBZGRNdXRhdGlvbihtdXRhdGlvbikgfHwgaXNWYWxpZFJlbW92ZU11dGF0aW9uKG11dGF0aW9uKTtcbiAgICAgICAgfSkpO1xuICAgICAgICBpZiAoaGFzVmFsaWRNdXRhdGlvbikge1xuICAgICAgICAgICAgY3NzVmFycyhzZXR0aW5ncyk7XG4gICAgICAgIH1cbiAgICB9KSk7XG4gICAgY3NzVmFyc09ic2VydmVyLm9ic2VydmUoZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LCB7XG4gICAgICAgIGF0dHJpYnV0ZXM6IHRydWUsXG4gICAgICAgIGF0dHJpYnV0ZUZpbHRlcjogWyBcImRpc2FibGVkXCIsIFwiaHJlZlwiIF0sXG4gICAgICAgIGNoaWxkTGlzdDogdHJ1ZSxcbiAgICAgICAgc3VidHJlZTogdHJ1ZVxuICAgIH0pO1xufVxuXG5mdW5jdGlvbiBjc3NWYXJzRGVib3VuY2VkKHNldHRpbmdzKSB7XG4gICAgdmFyIGRlbGF5ID0gYXJndW1lbnRzLmxlbmd0aCA+IDEgJiYgYXJndW1lbnRzWzFdICE9PSB1bmRlZmluZWQgPyBhcmd1bWVudHNbMV0gOiAxMDA7XG4gICAgY2xlYXJUaW1lb3V0KGRlYm91bmNlVGltZXIpO1xuICAgIGRlYm91bmNlVGltZXIgPSBzZXRUaW1lb3V0KChmdW5jdGlvbigpIHtcbiAgICAgICAgc2V0dGluZ3MuX19iZW5jaG1hcmsgPSBudWxsO1xuICAgICAgICBjc3NWYXJzKHNldHRpbmdzKTtcbiAgICB9KSwgZGVsYXkpO1xufVxuXG5mdW5jdGlvbiBmaXhLZXlmcmFtZXMocm9vdEVsZW1lbnQpIHtcbiAgICB2YXIgYW5pbWF0aW9uTmFtZVByb3AgPSBbIFwiYW5pbWF0aW9uLW5hbWVcIiwgXCItbW96LWFuaW1hdGlvbi1uYW1lXCIsIFwiLXdlYmtpdC1hbmltYXRpb24tbmFtZVwiIF0uZmlsdGVyKChmdW5jdGlvbihwcm9wKSB7XG4gICAgICAgIHJldHVybiBnZXRDb21wdXRlZFN0eWxlKGRvY3VtZW50LmJvZHkpW3Byb3BdO1xuICAgIH0pKVswXTtcbiAgICBpZiAoYW5pbWF0aW9uTmFtZVByb3ApIHtcbiAgICAgICAgdmFyIGFsbE5vZGVzID0gcm9vdEVsZW1lbnQuZ2V0RWxlbWVudHNCeVRhZ05hbWUoXCIqXCIpO1xuICAgICAgICB2YXIga2V5ZnJhbWVOb2RlcyA9IFtdO1xuICAgICAgICB2YXIgbmFtZU1hcmtlciA9IFwiX19DU1NWQVJTUE9OWUZJTEwtS0VZRlJBTUVTX19cIjtcbiAgICAgICAgZm9yICh2YXIgaSA9IDAsIGxlbiA9IGFsbE5vZGVzLmxlbmd0aDsgaSA8IGxlbjsgaSsrKSB7XG4gICAgICAgICAgICB2YXIgbm9kZSA9IGFsbE5vZGVzW2ldO1xuICAgICAgICAgICAgdmFyIGFuaW1hdGlvbk5hbWUgPSBnZXRDb21wdXRlZFN0eWxlKG5vZGUpW2FuaW1hdGlvbk5hbWVQcm9wXTtcbiAgICAgICAgICAgIGlmIChhbmltYXRpb25OYW1lICE9PSBcIm5vbmVcIikge1xuICAgICAgICAgICAgICAgIG5vZGUuc3R5bGVbYW5pbWF0aW9uTmFtZVByb3BdICs9IG5hbWVNYXJrZXI7XG4gICAgICAgICAgICAgICAga2V5ZnJhbWVOb2Rlcy5wdXNoKG5vZGUpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICAgIHZvaWQgZG9jdW1lbnQuYm9keS5vZmZzZXRIZWlnaHQ7XG4gICAgICAgIGZvciAodmFyIF9pID0gMCwgX2xlbiA9IGtleWZyYW1lTm9kZXMubGVuZ3RoOyBfaSA8IF9sZW47IF9pKyspIHtcbiAgICAgICAgICAgIHZhciBub2RlU3R5bGUgPSBrZXlmcmFtZU5vZGVzW19pXS5zdHlsZTtcbiAgICAgICAgICAgIG5vZGVTdHlsZVthbmltYXRpb25OYW1lUHJvcF0gPSBub2RlU3R5bGVbYW5pbWF0aW9uTmFtZVByb3BdLnJlcGxhY2UobmFtZU1hcmtlciwgXCJcIik7XG4gICAgICAgIH1cbiAgICB9XG59XG5cbmZ1bmN0aW9uIGZpeFJlbGF0aXZlQ3NzVXJscyhjc3NUZXh0LCBiYXNlVXJsKSB7XG4gICAgdmFyIGNzc1VybHMgPSBjc3NUZXh0LnJlcGxhY2UocmVnZXguY3NzQ29tbWVudHMsIFwiXCIpLm1hdGNoKHJlZ2V4LmNzc1VybHMpIHx8IFtdO1xuICAgIGNzc1VybHMuZm9yRWFjaCgoZnVuY3Rpb24oY3NzVXJsKSB7XG4gICAgICAgIHZhciBvbGRVcmwgPSBjc3NVcmwucmVwbGFjZShyZWdleC5jc3NVcmxzLCBcIiQxXCIpO1xuICAgICAgICB2YXIgbmV3VXJsID0gZ2V0RnVsbFVybCQxKG9sZFVybCwgYmFzZVVybCk7XG4gICAgICAgIGNzc1RleHQgPSBjc3NUZXh0LnJlcGxhY2UoY3NzVXJsLCBjc3NVcmwucmVwbGFjZShvbGRVcmwsIG5ld1VybCkpO1xuICAgIH0pKTtcbiAgICByZXR1cm4gY3NzVGV4dDtcbn1cblxuZnVuY3Rpb24gZml4VmFyTmFtZXMoKSB7XG4gICAgdmFyIHZhck9iaiA9IGFyZ3VtZW50cy5sZW5ndGggPiAwICYmIGFyZ3VtZW50c1swXSAhPT0gdW5kZWZpbmVkID8gYXJndW1lbnRzWzBdIDoge307XG4gICAgdmFyIHJlTGVhZGluZ0h5cGhlbnMgPSAvXi17Mn0vO1xuICAgIHJldHVybiBPYmplY3Qua2V5cyh2YXJPYmopLnJlZHVjZSgoZnVuY3Rpb24ob2JqLCB2YWx1ZSkge1xuICAgICAgICB2YXIga2V5ID0gcmVMZWFkaW5nSHlwaGVucy50ZXN0KHZhbHVlKSA/IHZhbHVlIDogXCItLVwiLmNvbmNhdCh2YWx1ZS5yZXBsYWNlKC9eLSsvLCBcIlwiKSk7XG4gICAgICAgIG9ialtrZXldID0gdmFyT2JqW3ZhbHVlXTtcbiAgICAgICAgcmV0dXJuIG9iajtcbiAgICB9KSwge30pO1xufVxuXG5mdW5jdGlvbiBnZXRGdWxsVXJsJDEodXJsKSB7XG4gICAgdmFyIGJhc2UgPSBhcmd1bWVudHMubGVuZ3RoID4gMSAmJiBhcmd1bWVudHNbMV0gIT09IHVuZGVmaW5lZCA/IGFyZ3VtZW50c1sxXSA6IGxvY2F0aW9uLmhyZWY7XG4gICAgdmFyIGQgPSBkb2N1bWVudC5pbXBsZW1lbnRhdGlvbi5jcmVhdGVIVE1MRG9jdW1lbnQoXCJcIik7XG4gICAgdmFyIGIgPSBkLmNyZWF0ZUVsZW1lbnQoXCJiYXNlXCIpO1xuICAgIHZhciBhID0gZC5jcmVhdGVFbGVtZW50KFwiYVwiKTtcbiAgICBkLmhlYWQuYXBwZW5kQ2hpbGQoYik7XG4gICAgZC5ib2R5LmFwcGVuZENoaWxkKGEpO1xuICAgIGIuaHJlZiA9IGJhc2U7XG4gICAgYS5ocmVmID0gdXJsO1xuICAgIHJldHVybiBhLmhyZWY7XG59XG5cbmZ1bmN0aW9uIGdldFRpbWVTdGFtcCgpIHtcbiAgICByZXR1cm4gaXNCcm93c2VyICYmICh3aW5kb3cucGVyZm9ybWFuY2UgfHwge30pLm5vdyA/IHdpbmRvdy5wZXJmb3JtYW5jZS5ub3coKSA6IChuZXcgRGF0ZSkuZ2V0VGltZSgpO1xufVxuXG5mdW5jdGlvbiByZXNldENzc05vZGVzKHJvb3RFbGVtZW50KSB7XG4gICAgdmFyIHJlc2V0RE9NVmFyaWFibGVTdG9yZSA9IGFyZ3VtZW50cy5sZW5ndGggPiAxICYmIGFyZ3VtZW50c1sxXSAhPT0gdW5kZWZpbmVkID8gYXJndW1lbnRzWzFdIDogZmFsc2U7XG4gICAgdmFyIHJlc2V0Tm9kZXMgPSBBcnJheS5hcHBseShudWxsLCByb290RWxlbWVudC5xdWVyeVNlbGVjdG9yQWxsKCdbZGF0YS1jc3N2YXJzPVwic2tpcFwiXSxbZGF0YS1jc3N2YXJzPVwic3JjXCJdJykpO1xuICAgIHJlc2V0Tm9kZXMuZm9yRWFjaCgoZnVuY3Rpb24obm9kZSkge1xuICAgICAgICByZXR1cm4gbm9kZS5zZXRBdHRyaWJ1dGUoXCJkYXRhLWNzc3ZhcnNcIiwgXCJcIik7XG4gICAgfSkpO1xuICAgIGlmIChyZXNldERPTVZhcmlhYmxlU3RvcmUpIHtcbiAgICAgICAgdmFyaWFibGVTdG9yZS5kb20gPSB7fTtcbiAgICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IGNzc1ZhcnM7XG4vLyMgc291cmNlTWFwcGluZ1VSTD1jc3MtdmFycy1wb255ZmlsbC5lc20uanMubWFwXG4iLCJ2YXIgcm9vdCA9IHJlcXVpcmUoJy4vX3Jvb3QnKTtcblxuLyoqIEJ1aWx0LWluIHZhbHVlIHJlZmVyZW5jZXMuICovXG52YXIgU3ltYm9sID0gcm9vdC5TeW1ib2w7XG5cbm1vZHVsZS5leHBvcnRzID0gU3ltYm9sO1xuIiwidmFyIFN5bWJvbCA9IHJlcXVpcmUoJy4vX1N5bWJvbCcpLFxuICAgIGdldFJhd1RhZyA9IHJlcXVpcmUoJy4vX2dldFJhd1RhZycpLFxuICAgIG9iamVjdFRvU3RyaW5nID0gcmVxdWlyZSgnLi9fb2JqZWN0VG9TdHJpbmcnKTtcblxuLyoqIGBPYmplY3QjdG9TdHJpbmdgIHJlc3VsdCByZWZlcmVuY2VzLiAqL1xudmFyIG51bGxUYWcgPSAnW29iamVjdCBOdWxsXScsXG4gICAgdW5kZWZpbmVkVGFnID0gJ1tvYmplY3QgVW5kZWZpbmVkXSc7XG5cbi8qKiBCdWlsdC1pbiB2YWx1ZSByZWZlcmVuY2VzLiAqL1xudmFyIHN5bVRvU3RyaW5nVGFnID0gU3ltYm9sID8gU3ltYm9sLnRvU3RyaW5nVGFnIDogdW5kZWZpbmVkO1xuXG4vKipcbiAqIFRoZSBiYXNlIGltcGxlbWVudGF0aW9uIG9mIGBnZXRUYWdgIHdpdGhvdXQgZmFsbGJhY2tzIGZvciBidWdneSBlbnZpcm9ubWVudHMuXG4gKlxuICogQHByaXZhdGVcbiAqIEBwYXJhbSB7Kn0gdmFsdWUgVGhlIHZhbHVlIHRvIHF1ZXJ5LlxuICogQHJldHVybnMge3N0cmluZ30gUmV0dXJucyB0aGUgYHRvU3RyaW5nVGFnYC5cbiAqL1xuZnVuY3Rpb24gYmFzZUdldFRhZyh2YWx1ZSkge1xuICBpZiAodmFsdWUgPT0gbnVsbCkge1xuICAgIHJldHVybiB2YWx1ZSA9PT0gdW5kZWZpbmVkID8gdW5kZWZpbmVkVGFnIDogbnVsbFRhZztcbiAgfVxuICByZXR1cm4gKHN5bVRvU3RyaW5nVGFnICYmIHN5bVRvU3RyaW5nVGFnIGluIE9iamVjdCh2YWx1ZSkpXG4gICAgPyBnZXRSYXdUYWcodmFsdWUpXG4gICAgOiBvYmplY3RUb1N0cmluZyh2YWx1ZSk7XG59XG5cbm1vZHVsZS5leHBvcnRzID0gYmFzZUdldFRhZztcbiIsIi8qKiBEZXRlY3QgZnJlZSB2YXJpYWJsZSBgZ2xvYmFsYCBmcm9tIE5vZGUuanMuICovXG52YXIgZnJlZUdsb2JhbCA9IHR5cGVvZiBnbG9iYWwgPT0gJ29iamVjdCcgJiYgZ2xvYmFsICYmIGdsb2JhbC5PYmplY3QgPT09IE9iamVjdCAmJiBnbG9iYWw7XG5cbm1vZHVsZS5leHBvcnRzID0gZnJlZUdsb2JhbDtcbiIsInZhciBTeW1ib2wgPSByZXF1aXJlKCcuL19TeW1ib2wnKTtcblxuLyoqIFVzZWQgZm9yIGJ1aWx0LWluIG1ldGhvZCByZWZlcmVuY2VzLiAqL1xudmFyIG9iamVjdFByb3RvID0gT2JqZWN0LnByb3RvdHlwZTtcblxuLyoqIFVzZWQgdG8gY2hlY2sgb2JqZWN0cyBmb3Igb3duIHByb3BlcnRpZXMuICovXG52YXIgaGFzT3duUHJvcGVydHkgPSBvYmplY3RQcm90by5oYXNPd25Qcm9wZXJ0eTtcblxuLyoqXG4gKiBVc2VkIHRvIHJlc29sdmUgdGhlXG4gKiBbYHRvU3RyaW5nVGFnYF0oaHR0cDovL2VjbWEtaW50ZXJuYXRpb25hbC5vcmcvZWNtYS0yNjIvNy4wLyNzZWMtb2JqZWN0LnByb3RvdHlwZS50b3N0cmluZylcbiAqIG9mIHZhbHVlcy5cbiAqL1xudmFyIG5hdGl2ZU9iamVjdFRvU3RyaW5nID0gb2JqZWN0UHJvdG8udG9TdHJpbmc7XG5cbi8qKiBCdWlsdC1pbiB2YWx1ZSByZWZlcmVuY2VzLiAqL1xudmFyIHN5bVRvU3RyaW5nVGFnID0gU3ltYm9sID8gU3ltYm9sLnRvU3RyaW5nVGFnIDogdW5kZWZpbmVkO1xuXG4vKipcbiAqIEEgc3BlY2lhbGl6ZWQgdmVyc2lvbiBvZiBgYmFzZUdldFRhZ2Agd2hpY2ggaWdub3JlcyBgU3ltYm9sLnRvU3RyaW5nVGFnYCB2YWx1ZXMuXG4gKlxuICogQHByaXZhdGVcbiAqIEBwYXJhbSB7Kn0gdmFsdWUgVGhlIHZhbHVlIHRvIHF1ZXJ5LlxuICogQHJldHVybnMge3N0cmluZ30gUmV0dXJucyB0aGUgcmF3IGB0b1N0cmluZ1RhZ2AuXG4gKi9cbmZ1bmN0aW9uIGdldFJhd1RhZyh2YWx1ZSkge1xuICB2YXIgaXNPd24gPSBoYXNPd25Qcm9wZXJ0eS5jYWxsKHZhbHVlLCBzeW1Ub1N0cmluZ1RhZyksXG4gICAgICB0YWcgPSB2YWx1ZVtzeW1Ub1N0cmluZ1RhZ107XG5cbiAgdHJ5IHtcbiAgICB2YWx1ZVtzeW1Ub1N0cmluZ1RhZ10gPSB1bmRlZmluZWQ7XG4gICAgdmFyIHVubWFza2VkID0gdHJ1ZTtcbiAgfSBjYXRjaCAoZSkge31cblxuICB2YXIgcmVzdWx0ID0gbmF0aXZlT2JqZWN0VG9TdHJpbmcuY2FsbCh2YWx1ZSk7XG4gIGlmICh1bm1hc2tlZCkge1xuICAgIGlmIChpc093bikge1xuICAgICAgdmFsdWVbc3ltVG9TdHJpbmdUYWddID0gdGFnO1xuICAgIH0gZWxzZSB7XG4gICAgICBkZWxldGUgdmFsdWVbc3ltVG9TdHJpbmdUYWddO1xuICAgIH1cbiAgfVxuICByZXR1cm4gcmVzdWx0O1xufVxuXG5tb2R1bGUuZXhwb3J0cyA9IGdldFJhd1RhZztcbiIsIi8qKiBVc2VkIGZvciBidWlsdC1pbiBtZXRob2QgcmVmZXJlbmNlcy4gKi9cbnZhciBvYmplY3RQcm90byA9IE9iamVjdC5wcm90b3R5cGU7XG5cbi8qKlxuICogVXNlZCB0byByZXNvbHZlIHRoZVxuICogW2B0b1N0cmluZ1RhZ2BdKGh0dHA6Ly9lY21hLWludGVybmF0aW9uYWwub3JnL2VjbWEtMjYyLzcuMC8jc2VjLW9iamVjdC5wcm90b3R5cGUudG9zdHJpbmcpXG4gKiBvZiB2YWx1ZXMuXG4gKi9cbnZhciBuYXRpdmVPYmplY3RUb1N0cmluZyA9IG9iamVjdFByb3RvLnRvU3RyaW5nO1xuXG4vKipcbiAqIENvbnZlcnRzIGB2YWx1ZWAgdG8gYSBzdHJpbmcgdXNpbmcgYE9iamVjdC5wcm90b3R5cGUudG9TdHJpbmdgLlxuICpcbiAqIEBwcml2YXRlXG4gKiBAcGFyYW0geyp9IHZhbHVlIFRoZSB2YWx1ZSB0byBjb252ZXJ0LlxuICogQHJldHVybnMge3N0cmluZ30gUmV0dXJucyB0aGUgY29udmVydGVkIHN0cmluZy5cbiAqL1xuZnVuY3Rpb24gb2JqZWN0VG9TdHJpbmcodmFsdWUpIHtcbiAgcmV0dXJuIG5hdGl2ZU9iamVjdFRvU3RyaW5nLmNhbGwodmFsdWUpO1xufVxuXG5tb2R1bGUuZXhwb3J0cyA9IG9iamVjdFRvU3RyaW5nO1xuIiwidmFyIGZyZWVHbG9iYWwgPSByZXF1aXJlKCcuL19mcmVlR2xvYmFsJyk7XG5cbi8qKiBEZXRlY3QgZnJlZSB2YXJpYWJsZSBgc2VsZmAuICovXG52YXIgZnJlZVNlbGYgPSB0eXBlb2Ygc2VsZiA9PSAnb2JqZWN0JyAmJiBzZWxmICYmIHNlbGYuT2JqZWN0ID09PSBPYmplY3QgJiYgc2VsZjtcblxuLyoqIFVzZWQgYXMgYSByZWZlcmVuY2UgdG8gdGhlIGdsb2JhbCBvYmplY3QuICovXG52YXIgcm9vdCA9IGZyZWVHbG9iYWwgfHwgZnJlZVNlbGYgfHwgRnVuY3Rpb24oJ3JldHVybiB0aGlzJykoKTtcblxubW9kdWxlLmV4cG9ydHMgPSByb290O1xuIiwidmFyIGlzT2JqZWN0ID0gcmVxdWlyZSgnLi9pc09iamVjdCcpLFxuICAgIG5vdyA9IHJlcXVpcmUoJy4vbm93JyksXG4gICAgdG9OdW1iZXIgPSByZXF1aXJlKCcuL3RvTnVtYmVyJyk7XG5cbi8qKiBFcnJvciBtZXNzYWdlIGNvbnN0YW50cy4gKi9cbnZhciBGVU5DX0VSUk9SX1RFWFQgPSAnRXhwZWN0ZWQgYSBmdW5jdGlvbic7XG5cbi8qIEJ1aWx0LWluIG1ldGhvZCByZWZlcmVuY2VzIGZvciB0aG9zZSB3aXRoIHRoZSBzYW1lIG5hbWUgYXMgb3RoZXIgYGxvZGFzaGAgbWV0aG9kcy4gKi9cbnZhciBuYXRpdmVNYXggPSBNYXRoLm1heCxcbiAgICBuYXRpdmVNaW4gPSBNYXRoLm1pbjtcblxuLyoqXG4gKiBDcmVhdGVzIGEgZGVib3VuY2VkIGZ1bmN0aW9uIHRoYXQgZGVsYXlzIGludm9raW5nIGBmdW5jYCB1bnRpbCBhZnRlciBgd2FpdGBcbiAqIG1pbGxpc2Vjb25kcyBoYXZlIGVsYXBzZWQgc2luY2UgdGhlIGxhc3QgdGltZSB0aGUgZGVib3VuY2VkIGZ1bmN0aW9uIHdhc1xuICogaW52b2tlZC4gVGhlIGRlYm91bmNlZCBmdW5jdGlvbiBjb21lcyB3aXRoIGEgYGNhbmNlbGAgbWV0aG9kIHRvIGNhbmNlbFxuICogZGVsYXllZCBgZnVuY2AgaW52b2NhdGlvbnMgYW5kIGEgYGZsdXNoYCBtZXRob2QgdG8gaW1tZWRpYXRlbHkgaW52b2tlIHRoZW0uXG4gKiBQcm92aWRlIGBvcHRpb25zYCB0byBpbmRpY2F0ZSB3aGV0aGVyIGBmdW5jYCBzaG91bGQgYmUgaW52b2tlZCBvbiB0aGVcbiAqIGxlYWRpbmcgYW5kL29yIHRyYWlsaW5nIGVkZ2Ugb2YgdGhlIGB3YWl0YCB0aW1lb3V0LiBUaGUgYGZ1bmNgIGlzIGludm9rZWRcbiAqIHdpdGggdGhlIGxhc3QgYXJndW1lbnRzIHByb3ZpZGVkIHRvIHRoZSBkZWJvdW5jZWQgZnVuY3Rpb24uIFN1YnNlcXVlbnRcbiAqIGNhbGxzIHRvIHRoZSBkZWJvdW5jZWQgZnVuY3Rpb24gcmV0dXJuIHRoZSByZXN1bHQgb2YgdGhlIGxhc3QgYGZ1bmNgXG4gKiBpbnZvY2F0aW9uLlxuICpcbiAqICoqTm90ZToqKiBJZiBgbGVhZGluZ2AgYW5kIGB0cmFpbGluZ2Agb3B0aW9ucyBhcmUgYHRydWVgLCBgZnVuY2AgaXNcbiAqIGludm9rZWQgb24gdGhlIHRyYWlsaW5nIGVkZ2Ugb2YgdGhlIHRpbWVvdXQgb25seSBpZiB0aGUgZGVib3VuY2VkIGZ1bmN0aW9uXG4gKiBpcyBpbnZva2VkIG1vcmUgdGhhbiBvbmNlIGR1cmluZyB0aGUgYHdhaXRgIHRpbWVvdXQuXG4gKlxuICogSWYgYHdhaXRgIGlzIGAwYCBhbmQgYGxlYWRpbmdgIGlzIGBmYWxzZWAsIGBmdW5jYCBpbnZvY2F0aW9uIGlzIGRlZmVycmVkXG4gKiB1bnRpbCB0byB0aGUgbmV4dCB0aWNrLCBzaW1pbGFyIHRvIGBzZXRUaW1lb3V0YCB3aXRoIGEgdGltZW91dCBvZiBgMGAuXG4gKlxuICogU2VlIFtEYXZpZCBDb3JiYWNobydzIGFydGljbGVdKGh0dHBzOi8vY3NzLXRyaWNrcy5jb20vZGVib3VuY2luZy10aHJvdHRsaW5nLWV4cGxhaW5lZC1leGFtcGxlcy8pXG4gKiBmb3IgZGV0YWlscyBvdmVyIHRoZSBkaWZmZXJlbmNlcyBiZXR3ZWVuIGBfLmRlYm91bmNlYCBhbmQgYF8udGhyb3R0bGVgLlxuICpcbiAqIEBzdGF0aWNcbiAqIEBtZW1iZXJPZiBfXG4gKiBAc2luY2UgMC4xLjBcbiAqIEBjYXRlZ29yeSBGdW5jdGlvblxuICogQHBhcmFtIHtGdW5jdGlvbn0gZnVuYyBUaGUgZnVuY3Rpb24gdG8gZGVib3VuY2UuXG4gKiBAcGFyYW0ge251bWJlcn0gW3dhaXQ9MF0gVGhlIG51bWJlciBvZiBtaWxsaXNlY29uZHMgdG8gZGVsYXkuXG4gKiBAcGFyYW0ge09iamVjdH0gW29wdGlvbnM9e31dIFRoZSBvcHRpb25zIG9iamVjdC5cbiAqIEBwYXJhbSB7Ym9vbGVhbn0gW29wdGlvbnMubGVhZGluZz1mYWxzZV1cbiAqICBTcGVjaWZ5IGludm9raW5nIG9uIHRoZSBsZWFkaW5nIGVkZ2Ugb2YgdGhlIHRpbWVvdXQuXG4gKiBAcGFyYW0ge251bWJlcn0gW29wdGlvbnMubWF4V2FpdF1cbiAqICBUaGUgbWF4aW11bSB0aW1lIGBmdW5jYCBpcyBhbGxvd2VkIHRvIGJlIGRlbGF5ZWQgYmVmb3JlIGl0J3MgaW52b2tlZC5cbiAqIEBwYXJhbSB7Ym9vbGVhbn0gW29wdGlvbnMudHJhaWxpbmc9dHJ1ZV1cbiAqICBTcGVjaWZ5IGludm9raW5nIG9uIHRoZSB0cmFpbGluZyBlZGdlIG9mIHRoZSB0aW1lb3V0LlxuICogQHJldHVybnMge0Z1bmN0aW9ufSBSZXR1cm5zIHRoZSBuZXcgZGVib3VuY2VkIGZ1bmN0aW9uLlxuICogQGV4YW1wbGVcbiAqXG4gKiAvLyBBdm9pZCBjb3N0bHkgY2FsY3VsYXRpb25zIHdoaWxlIHRoZSB3aW5kb3cgc2l6ZSBpcyBpbiBmbHV4LlxuICogalF1ZXJ5KHdpbmRvdykub24oJ3Jlc2l6ZScsIF8uZGVib3VuY2UoY2FsY3VsYXRlTGF5b3V0LCAxNTApKTtcbiAqXG4gKiAvLyBJbnZva2UgYHNlbmRNYWlsYCB3aGVuIGNsaWNrZWQsIGRlYm91bmNpbmcgc3Vic2VxdWVudCBjYWxscy5cbiAqIGpRdWVyeShlbGVtZW50KS5vbignY2xpY2snLCBfLmRlYm91bmNlKHNlbmRNYWlsLCAzMDAsIHtcbiAqICAgJ2xlYWRpbmcnOiB0cnVlLFxuICogICAndHJhaWxpbmcnOiBmYWxzZVxuICogfSkpO1xuICpcbiAqIC8vIEVuc3VyZSBgYmF0Y2hMb2dgIGlzIGludm9rZWQgb25jZSBhZnRlciAxIHNlY29uZCBvZiBkZWJvdW5jZWQgY2FsbHMuXG4gKiB2YXIgZGVib3VuY2VkID0gXy5kZWJvdW5jZShiYXRjaExvZywgMjUwLCB7ICdtYXhXYWl0JzogMTAwMCB9KTtcbiAqIHZhciBzb3VyY2UgPSBuZXcgRXZlbnRTb3VyY2UoJy9zdHJlYW0nKTtcbiAqIGpRdWVyeShzb3VyY2UpLm9uKCdtZXNzYWdlJywgZGVib3VuY2VkKTtcbiAqXG4gKiAvLyBDYW5jZWwgdGhlIHRyYWlsaW5nIGRlYm91bmNlZCBpbnZvY2F0aW9uLlxuICogalF1ZXJ5KHdpbmRvdykub24oJ3BvcHN0YXRlJywgZGVib3VuY2VkLmNhbmNlbCk7XG4gKi9cbmZ1bmN0aW9uIGRlYm91bmNlKGZ1bmMsIHdhaXQsIG9wdGlvbnMpIHtcbiAgdmFyIGxhc3RBcmdzLFxuICAgICAgbGFzdFRoaXMsXG4gICAgICBtYXhXYWl0LFxuICAgICAgcmVzdWx0LFxuICAgICAgdGltZXJJZCxcbiAgICAgIGxhc3RDYWxsVGltZSxcbiAgICAgIGxhc3RJbnZva2VUaW1lID0gMCxcbiAgICAgIGxlYWRpbmcgPSBmYWxzZSxcbiAgICAgIG1heGluZyA9IGZhbHNlLFxuICAgICAgdHJhaWxpbmcgPSB0cnVlO1xuXG4gIGlmICh0eXBlb2YgZnVuYyAhPSAnZnVuY3Rpb24nKSB7XG4gICAgdGhyb3cgbmV3IFR5cGVFcnJvcihGVU5DX0VSUk9SX1RFWFQpO1xuICB9XG4gIHdhaXQgPSB0b051bWJlcih3YWl0KSB8fCAwO1xuICBpZiAoaXNPYmplY3Qob3B0aW9ucykpIHtcbiAgICBsZWFkaW5nID0gISFvcHRpb25zLmxlYWRpbmc7XG4gICAgbWF4aW5nID0gJ21heFdhaXQnIGluIG9wdGlvbnM7XG4gICAgbWF4V2FpdCA9IG1heGluZyA/IG5hdGl2ZU1heCh0b051bWJlcihvcHRpb25zLm1heFdhaXQpIHx8IDAsIHdhaXQpIDogbWF4V2FpdDtcbiAgICB0cmFpbGluZyA9ICd0cmFpbGluZycgaW4gb3B0aW9ucyA/ICEhb3B0aW9ucy50cmFpbGluZyA6IHRyYWlsaW5nO1xuICB9XG5cbiAgZnVuY3Rpb24gaW52b2tlRnVuYyh0aW1lKSB7XG4gICAgdmFyIGFyZ3MgPSBsYXN0QXJncyxcbiAgICAgICAgdGhpc0FyZyA9IGxhc3RUaGlzO1xuXG4gICAgbGFzdEFyZ3MgPSBsYXN0VGhpcyA9IHVuZGVmaW5lZDtcbiAgICBsYXN0SW52b2tlVGltZSA9IHRpbWU7XG4gICAgcmVzdWx0ID0gZnVuYy5hcHBseSh0aGlzQXJnLCBhcmdzKTtcbiAgICByZXR1cm4gcmVzdWx0O1xuICB9XG5cbiAgZnVuY3Rpb24gbGVhZGluZ0VkZ2UodGltZSkge1xuICAgIC8vIFJlc2V0IGFueSBgbWF4V2FpdGAgdGltZXIuXG4gICAgbGFzdEludm9rZVRpbWUgPSB0aW1lO1xuICAgIC8vIFN0YXJ0IHRoZSB0aW1lciBmb3IgdGhlIHRyYWlsaW5nIGVkZ2UuXG4gICAgdGltZXJJZCA9IHNldFRpbWVvdXQodGltZXJFeHBpcmVkLCB3YWl0KTtcbiAgICAvLyBJbnZva2UgdGhlIGxlYWRpbmcgZWRnZS5cbiAgICByZXR1cm4gbGVhZGluZyA/IGludm9rZUZ1bmModGltZSkgOiByZXN1bHQ7XG4gIH1cblxuICBmdW5jdGlvbiByZW1haW5pbmdXYWl0KHRpbWUpIHtcbiAgICB2YXIgdGltZVNpbmNlTGFzdENhbGwgPSB0aW1lIC0gbGFzdENhbGxUaW1lLFxuICAgICAgICB0aW1lU2luY2VMYXN0SW52b2tlID0gdGltZSAtIGxhc3RJbnZva2VUaW1lLFxuICAgICAgICB0aW1lV2FpdGluZyA9IHdhaXQgLSB0aW1lU2luY2VMYXN0Q2FsbDtcblxuICAgIHJldHVybiBtYXhpbmdcbiAgICAgID8gbmF0aXZlTWluKHRpbWVXYWl0aW5nLCBtYXhXYWl0IC0gdGltZVNpbmNlTGFzdEludm9rZSlcbiAgICAgIDogdGltZVdhaXRpbmc7XG4gIH1cblxuICBmdW5jdGlvbiBzaG91bGRJbnZva2UodGltZSkge1xuICAgIHZhciB0aW1lU2luY2VMYXN0Q2FsbCA9IHRpbWUgLSBsYXN0Q2FsbFRpbWUsXG4gICAgICAgIHRpbWVTaW5jZUxhc3RJbnZva2UgPSB0aW1lIC0gbGFzdEludm9rZVRpbWU7XG5cbiAgICAvLyBFaXRoZXIgdGhpcyBpcyB0aGUgZmlyc3QgY2FsbCwgYWN0aXZpdHkgaGFzIHN0b3BwZWQgYW5kIHdlJ3JlIGF0IHRoZVxuICAgIC8vIHRyYWlsaW5nIGVkZ2UsIHRoZSBzeXN0ZW0gdGltZSBoYXMgZ29uZSBiYWNrd2FyZHMgYW5kIHdlJ3JlIHRyZWF0aW5nXG4gICAgLy8gaXQgYXMgdGhlIHRyYWlsaW5nIGVkZ2UsIG9yIHdlJ3ZlIGhpdCB0aGUgYG1heFdhaXRgIGxpbWl0LlxuICAgIHJldHVybiAobGFzdENhbGxUaW1lID09PSB1bmRlZmluZWQgfHwgKHRpbWVTaW5jZUxhc3RDYWxsID49IHdhaXQpIHx8XG4gICAgICAodGltZVNpbmNlTGFzdENhbGwgPCAwKSB8fCAobWF4aW5nICYmIHRpbWVTaW5jZUxhc3RJbnZva2UgPj0gbWF4V2FpdCkpO1xuICB9XG5cbiAgZnVuY3Rpb24gdGltZXJFeHBpcmVkKCkge1xuICAgIHZhciB0aW1lID0gbm93KCk7XG4gICAgaWYgKHNob3VsZEludm9rZSh0aW1lKSkge1xuICAgICAgcmV0dXJuIHRyYWlsaW5nRWRnZSh0aW1lKTtcbiAgICB9XG4gICAgLy8gUmVzdGFydCB0aGUgdGltZXIuXG4gICAgdGltZXJJZCA9IHNldFRpbWVvdXQodGltZXJFeHBpcmVkLCByZW1haW5pbmdXYWl0KHRpbWUpKTtcbiAgfVxuXG4gIGZ1bmN0aW9uIHRyYWlsaW5nRWRnZSh0aW1lKSB7XG4gICAgdGltZXJJZCA9IHVuZGVmaW5lZDtcblxuICAgIC8vIE9ubHkgaW52b2tlIGlmIHdlIGhhdmUgYGxhc3RBcmdzYCB3aGljaCBtZWFucyBgZnVuY2AgaGFzIGJlZW5cbiAgICAvLyBkZWJvdW5jZWQgYXQgbGVhc3Qgb25jZS5cbiAgICBpZiAodHJhaWxpbmcgJiYgbGFzdEFyZ3MpIHtcbiAgICAgIHJldHVybiBpbnZva2VGdW5jKHRpbWUpO1xuICAgIH1cbiAgICBsYXN0QXJncyA9IGxhc3RUaGlzID0gdW5kZWZpbmVkO1xuICAgIHJldHVybiByZXN1bHQ7XG4gIH1cblxuICBmdW5jdGlvbiBjYW5jZWwoKSB7XG4gICAgaWYgKHRpbWVySWQgIT09IHVuZGVmaW5lZCkge1xuICAgICAgY2xlYXJUaW1lb3V0KHRpbWVySWQpO1xuICAgIH1cbiAgICBsYXN0SW52b2tlVGltZSA9IDA7XG4gICAgbGFzdEFyZ3MgPSBsYXN0Q2FsbFRpbWUgPSBsYXN0VGhpcyA9IHRpbWVySWQgPSB1bmRlZmluZWQ7XG4gIH1cblxuICBmdW5jdGlvbiBmbHVzaCgpIHtcbiAgICByZXR1cm4gdGltZXJJZCA9PT0gdW5kZWZpbmVkID8gcmVzdWx0IDogdHJhaWxpbmdFZGdlKG5vdygpKTtcbiAgfVxuXG4gIGZ1bmN0aW9uIGRlYm91bmNlZCgpIHtcbiAgICB2YXIgdGltZSA9IG5vdygpLFxuICAgICAgICBpc0ludm9raW5nID0gc2hvdWxkSW52b2tlKHRpbWUpO1xuXG4gICAgbGFzdEFyZ3MgPSBhcmd1bWVudHM7XG4gICAgbGFzdFRoaXMgPSB0aGlzO1xuICAgIGxhc3RDYWxsVGltZSA9IHRpbWU7XG5cbiAgICBpZiAoaXNJbnZva2luZykge1xuICAgICAgaWYgKHRpbWVySWQgPT09IHVuZGVmaW5lZCkge1xuICAgICAgICByZXR1cm4gbGVhZGluZ0VkZ2UobGFzdENhbGxUaW1lKTtcbiAgICAgIH1cbiAgICAgIGlmIChtYXhpbmcpIHtcbiAgICAgICAgLy8gSGFuZGxlIGludm9jYXRpb25zIGluIGEgdGlnaHQgbG9vcC5cbiAgICAgICAgY2xlYXJUaW1lb3V0KHRpbWVySWQpO1xuICAgICAgICB0aW1lcklkID0gc2V0VGltZW91dCh0aW1lckV4cGlyZWQsIHdhaXQpO1xuICAgICAgICByZXR1cm4gaW52b2tlRnVuYyhsYXN0Q2FsbFRpbWUpO1xuICAgICAgfVxuICAgIH1cbiAgICBpZiAodGltZXJJZCA9PT0gdW5kZWZpbmVkKSB7XG4gICAgICB0aW1lcklkID0gc2V0VGltZW91dCh0aW1lckV4cGlyZWQsIHdhaXQpO1xuICAgIH1cbiAgICByZXR1cm4gcmVzdWx0O1xuICB9XG4gIGRlYm91bmNlZC5jYW5jZWwgPSBjYW5jZWw7XG4gIGRlYm91bmNlZC5mbHVzaCA9IGZsdXNoO1xuICByZXR1cm4gZGVib3VuY2VkO1xufVxuXG5tb2R1bGUuZXhwb3J0cyA9IGRlYm91bmNlO1xuIiwiLyoqXG4gKiBDaGVja3MgaWYgYHZhbHVlYCBpcyB0aGVcbiAqIFtsYW5ndWFnZSB0eXBlXShodHRwOi8vd3d3LmVjbWEtaW50ZXJuYXRpb25hbC5vcmcvZWNtYS0yNjIvNy4wLyNzZWMtZWNtYXNjcmlwdC1sYW5ndWFnZS10eXBlcylcbiAqIG9mIGBPYmplY3RgLiAoZS5nLiBhcnJheXMsIGZ1bmN0aW9ucywgb2JqZWN0cywgcmVnZXhlcywgYG5ldyBOdW1iZXIoMClgLCBhbmQgYG5ldyBTdHJpbmcoJycpYClcbiAqXG4gKiBAc3RhdGljXG4gKiBAbWVtYmVyT2YgX1xuICogQHNpbmNlIDAuMS4wXG4gKiBAY2F0ZWdvcnkgTGFuZ1xuICogQHBhcmFtIHsqfSB2YWx1ZSBUaGUgdmFsdWUgdG8gY2hlY2suXG4gKiBAcmV0dXJucyB7Ym9vbGVhbn0gUmV0dXJucyBgdHJ1ZWAgaWYgYHZhbHVlYCBpcyBhbiBvYmplY3QsIGVsc2UgYGZhbHNlYC5cbiAqIEBleGFtcGxlXG4gKlxuICogXy5pc09iamVjdCh7fSk7XG4gKiAvLyA9PiB0cnVlXG4gKlxuICogXy5pc09iamVjdChbMSwgMiwgM10pO1xuICogLy8gPT4gdHJ1ZVxuICpcbiAqIF8uaXNPYmplY3QoXy5ub29wKTtcbiAqIC8vID0+IHRydWVcbiAqXG4gKiBfLmlzT2JqZWN0KG51bGwpO1xuICogLy8gPT4gZmFsc2VcbiAqL1xuZnVuY3Rpb24gaXNPYmplY3QodmFsdWUpIHtcbiAgdmFyIHR5cGUgPSB0eXBlb2YgdmFsdWU7XG4gIHJldHVybiB2YWx1ZSAhPSBudWxsICYmICh0eXBlID09ICdvYmplY3QnIHx8IHR5cGUgPT0gJ2Z1bmN0aW9uJyk7XG59XG5cbm1vZHVsZS5leHBvcnRzID0gaXNPYmplY3Q7XG4iLCIvKipcbiAqIENoZWNrcyBpZiBgdmFsdWVgIGlzIG9iamVjdC1saWtlLiBBIHZhbHVlIGlzIG9iamVjdC1saWtlIGlmIGl0J3Mgbm90IGBudWxsYFxuICogYW5kIGhhcyBhIGB0eXBlb2ZgIHJlc3VsdCBvZiBcIm9iamVjdFwiLlxuICpcbiAqIEBzdGF0aWNcbiAqIEBtZW1iZXJPZiBfXG4gKiBAc2luY2UgNC4wLjBcbiAqIEBjYXRlZ29yeSBMYW5nXG4gKiBAcGFyYW0geyp9IHZhbHVlIFRoZSB2YWx1ZSB0byBjaGVjay5cbiAqIEByZXR1cm5zIHtib29sZWFufSBSZXR1cm5zIGB0cnVlYCBpZiBgdmFsdWVgIGlzIG9iamVjdC1saWtlLCBlbHNlIGBmYWxzZWAuXG4gKiBAZXhhbXBsZVxuICpcbiAqIF8uaXNPYmplY3RMaWtlKHt9KTtcbiAqIC8vID0+IHRydWVcbiAqXG4gKiBfLmlzT2JqZWN0TGlrZShbMSwgMiwgM10pO1xuICogLy8gPT4gdHJ1ZVxuICpcbiAqIF8uaXNPYmplY3RMaWtlKF8ubm9vcCk7XG4gKiAvLyA9PiBmYWxzZVxuICpcbiAqIF8uaXNPYmplY3RMaWtlKG51bGwpO1xuICogLy8gPT4gZmFsc2VcbiAqL1xuZnVuY3Rpb24gaXNPYmplY3RMaWtlKHZhbHVlKSB7XG4gIHJldHVybiB2YWx1ZSAhPSBudWxsICYmIHR5cGVvZiB2YWx1ZSA9PSAnb2JqZWN0Jztcbn1cblxubW9kdWxlLmV4cG9ydHMgPSBpc09iamVjdExpa2U7XG4iLCJ2YXIgYmFzZUdldFRhZyA9IHJlcXVpcmUoJy4vX2Jhc2VHZXRUYWcnKSxcbiAgICBpc09iamVjdExpa2UgPSByZXF1aXJlKCcuL2lzT2JqZWN0TGlrZScpO1xuXG4vKiogYE9iamVjdCN0b1N0cmluZ2AgcmVzdWx0IHJlZmVyZW5jZXMuICovXG52YXIgc3ltYm9sVGFnID0gJ1tvYmplY3QgU3ltYm9sXSc7XG5cbi8qKlxuICogQ2hlY2tzIGlmIGB2YWx1ZWAgaXMgY2xhc3NpZmllZCBhcyBhIGBTeW1ib2xgIHByaW1pdGl2ZSBvciBvYmplY3QuXG4gKlxuICogQHN0YXRpY1xuICogQG1lbWJlck9mIF9cbiAqIEBzaW5jZSA0LjAuMFxuICogQGNhdGVnb3J5IExhbmdcbiAqIEBwYXJhbSB7Kn0gdmFsdWUgVGhlIHZhbHVlIHRvIGNoZWNrLlxuICogQHJldHVybnMge2Jvb2xlYW59IFJldHVybnMgYHRydWVgIGlmIGB2YWx1ZWAgaXMgYSBzeW1ib2wsIGVsc2UgYGZhbHNlYC5cbiAqIEBleGFtcGxlXG4gKlxuICogXy5pc1N5bWJvbChTeW1ib2wuaXRlcmF0b3IpO1xuICogLy8gPT4gdHJ1ZVxuICpcbiAqIF8uaXNTeW1ib2woJ2FiYycpO1xuICogLy8gPT4gZmFsc2VcbiAqL1xuZnVuY3Rpb24gaXNTeW1ib2wodmFsdWUpIHtcbiAgcmV0dXJuIHR5cGVvZiB2YWx1ZSA9PSAnc3ltYm9sJyB8fFxuICAgIChpc09iamVjdExpa2UodmFsdWUpICYmIGJhc2VHZXRUYWcodmFsdWUpID09IHN5bWJvbFRhZyk7XG59XG5cbm1vZHVsZS5leHBvcnRzID0gaXNTeW1ib2w7XG4iLCJ2YXIgcm9vdCA9IHJlcXVpcmUoJy4vX3Jvb3QnKTtcblxuLyoqXG4gKiBHZXRzIHRoZSB0aW1lc3RhbXAgb2YgdGhlIG51bWJlciBvZiBtaWxsaXNlY29uZHMgdGhhdCBoYXZlIGVsYXBzZWQgc2luY2VcbiAqIHRoZSBVbml4IGVwb2NoICgxIEphbnVhcnkgMTk3MCAwMDowMDowMCBVVEMpLlxuICpcbiAqIEBzdGF0aWNcbiAqIEBtZW1iZXJPZiBfXG4gKiBAc2luY2UgMi40LjBcbiAqIEBjYXRlZ29yeSBEYXRlXG4gKiBAcmV0dXJucyB7bnVtYmVyfSBSZXR1cm5zIHRoZSB0aW1lc3RhbXAuXG4gKiBAZXhhbXBsZVxuICpcbiAqIF8uZGVmZXIoZnVuY3Rpb24oc3RhbXApIHtcbiAqICAgY29uc29sZS5sb2coXy5ub3coKSAtIHN0YW1wKTtcbiAqIH0sIF8ubm93KCkpO1xuICogLy8gPT4gTG9ncyB0aGUgbnVtYmVyIG9mIG1pbGxpc2Vjb25kcyBpdCB0b29rIGZvciB0aGUgZGVmZXJyZWQgaW52b2NhdGlvbi5cbiAqL1xudmFyIG5vdyA9IGZ1bmN0aW9uKCkge1xuICByZXR1cm4gcm9vdC5EYXRlLm5vdygpO1xufTtcblxubW9kdWxlLmV4cG9ydHMgPSBub3c7XG4iLCJ2YXIgaXNPYmplY3QgPSByZXF1aXJlKCcuL2lzT2JqZWN0JyksXG4gICAgaXNTeW1ib2wgPSByZXF1aXJlKCcuL2lzU3ltYm9sJyk7XG5cbi8qKiBVc2VkIGFzIHJlZmVyZW5jZXMgZm9yIHZhcmlvdXMgYE51bWJlcmAgY29uc3RhbnRzLiAqL1xudmFyIE5BTiA9IDAgLyAwO1xuXG4vKiogVXNlZCB0byBtYXRjaCBsZWFkaW5nIGFuZCB0cmFpbGluZyB3aGl0ZXNwYWNlLiAqL1xudmFyIHJlVHJpbSA9IC9eXFxzK3xcXHMrJC9nO1xuXG4vKiogVXNlZCB0byBkZXRlY3QgYmFkIHNpZ25lZCBoZXhhZGVjaW1hbCBzdHJpbmcgdmFsdWVzLiAqL1xudmFyIHJlSXNCYWRIZXggPSAvXlstK10weFswLTlhLWZdKyQvaTtcblxuLyoqIFVzZWQgdG8gZGV0ZWN0IGJpbmFyeSBzdHJpbmcgdmFsdWVzLiAqL1xudmFyIHJlSXNCaW5hcnkgPSAvXjBiWzAxXSskL2k7XG5cbi8qKiBVc2VkIHRvIGRldGVjdCBvY3RhbCBzdHJpbmcgdmFsdWVzLiAqL1xudmFyIHJlSXNPY3RhbCA9IC9eMG9bMC03XSskL2k7XG5cbi8qKiBCdWlsdC1pbiBtZXRob2QgcmVmZXJlbmNlcyB3aXRob3V0IGEgZGVwZW5kZW5jeSBvbiBgcm9vdGAuICovXG52YXIgZnJlZVBhcnNlSW50ID0gcGFyc2VJbnQ7XG5cbi8qKlxuICogQ29udmVydHMgYHZhbHVlYCB0byBhIG51bWJlci5cbiAqXG4gKiBAc3RhdGljXG4gKiBAbWVtYmVyT2YgX1xuICogQHNpbmNlIDQuMC4wXG4gKiBAY2F0ZWdvcnkgTGFuZ1xuICogQHBhcmFtIHsqfSB2YWx1ZSBUaGUgdmFsdWUgdG8gcHJvY2Vzcy5cbiAqIEByZXR1cm5zIHtudW1iZXJ9IFJldHVybnMgdGhlIG51bWJlci5cbiAqIEBleGFtcGxlXG4gKlxuICogXy50b051bWJlcigzLjIpO1xuICogLy8gPT4gMy4yXG4gKlxuICogXy50b051bWJlcihOdW1iZXIuTUlOX1ZBTFVFKTtcbiAqIC8vID0+IDVlLTMyNFxuICpcbiAqIF8udG9OdW1iZXIoSW5maW5pdHkpO1xuICogLy8gPT4gSW5maW5pdHlcbiAqXG4gKiBfLnRvTnVtYmVyKCczLjInKTtcbiAqIC8vID0+IDMuMlxuICovXG5mdW5jdGlvbiB0b051bWJlcih2YWx1ZSkge1xuICBpZiAodHlwZW9mIHZhbHVlID09ICdudW1iZXInKSB7XG4gICAgcmV0dXJuIHZhbHVlO1xuICB9XG4gIGlmIChpc1N5bWJvbCh2YWx1ZSkpIHtcbiAgICByZXR1cm4gTkFOO1xuICB9XG4gIGlmIChpc09iamVjdCh2YWx1ZSkpIHtcbiAgICB2YXIgb3RoZXIgPSB0eXBlb2YgdmFsdWUudmFsdWVPZiA9PSAnZnVuY3Rpb24nID8gdmFsdWUudmFsdWVPZigpIDogdmFsdWU7XG4gICAgdmFsdWUgPSBpc09iamVjdChvdGhlcikgPyAob3RoZXIgKyAnJykgOiBvdGhlcjtcbiAgfVxuICBpZiAodHlwZW9mIHZhbHVlICE9ICdzdHJpbmcnKSB7XG4gICAgcmV0dXJuIHZhbHVlID09PSAwID8gdmFsdWUgOiArdmFsdWU7XG4gIH1cbiAgdmFsdWUgPSB2YWx1ZS5yZXBsYWNlKHJlVHJpbSwgJycpO1xuICB2YXIgaXNCaW5hcnkgPSByZUlzQmluYXJ5LnRlc3QodmFsdWUpO1xuICByZXR1cm4gKGlzQmluYXJ5IHx8IHJlSXNPY3RhbC50ZXN0KHZhbHVlKSlcbiAgICA/IGZyZWVQYXJzZUludCh2YWx1ZS5zbGljZSgyKSwgaXNCaW5hcnkgPyAyIDogOClcbiAgICA6IChyZUlzQmFkSGV4LnRlc3QodmFsdWUpID8gTkFOIDogK3ZhbHVlKTtcbn1cblxubW9kdWxlLmV4cG9ydHMgPSB0b051bWJlcjtcbiIsInZhciBnO1xuXG4vLyBUaGlzIHdvcmtzIGluIG5vbi1zdHJpY3QgbW9kZVxuZyA9IChmdW5jdGlvbigpIHtcblx0cmV0dXJuIHRoaXM7XG59KSgpO1xuXG50cnkge1xuXHQvLyBUaGlzIHdvcmtzIGlmIGV2YWwgaXMgYWxsb3dlZCAoc2VlIENTUClcblx0ZyA9IGcgfHwgbmV3IEZ1bmN0aW9uKFwicmV0dXJuIHRoaXNcIikoKTtcbn0gY2F0Y2ggKGUpIHtcblx0Ly8gVGhpcyB3b3JrcyBpZiB0aGUgd2luZG93IHJlZmVyZW5jZSBpcyBhdmFpbGFibGVcblx0aWYgKHR5cGVvZiB3aW5kb3cgPT09IFwib2JqZWN0XCIpIGcgPSB3aW5kb3c7XG59XG5cbi8vIGcgY2FuIHN0aWxsIGJlIHVuZGVmaW5lZCwgYnV0IG5vdGhpbmcgdG8gZG8gYWJvdXQgaXQuLi5cbi8vIFdlIHJldHVybiB1bmRlZmluZWQsIGluc3RlYWQgb2Ygbm90aGluZyBoZXJlLCBzbyBpdCdzXG4vLyBlYXNpZXIgdG8gaGFuZGxlIHRoaXMgY2FzZS4gaWYoIWdsb2JhbCkgeyAuLi59XG5cbm1vZHVsZS5leHBvcnRzID0gZztcbiJdLCJtYXBwaW5ncyI6IjtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7Ozs7QUNsRkE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFKQTtBQU1BO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQURBO0FBQ0E7QUFDQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUFBO0FBQ0E7QUFJQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBREE7QUFFQTs7Ozs7Ozs7Ozs7O0FDNURBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUdBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBR0E7QUFDQTtBQUVBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBREE7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFEQTtBQUdBOzs7Ozs7Ozs7Ozs7QUN0R0E7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUtBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7Ozs7Ozs7QUMvQkE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQU9BO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFLQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7Ozs7QUN6Q0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBRUE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQURBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFIQTtBQUtBO0FBQ0E7QUFFQTtBQUVBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFBQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUVBO0FBQ0E7QUFFQTtBQUNBO0FBREE7QUFFQTtBQUNBO0FBQUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUFBO0FBQ0E7QUFDQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUFBO0FBQ0E7QUFDQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBREE7QUFFQTtBQUNBO0FBQUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUNBO0FBREE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUFBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUVBO0FBQ0E7QUFFQTtBQUNBO0FBRUE7QUFFQTtBQUVBO0FBQ0E7QUFDQTtBQURBO0FBQ0E7QUFDQTtBQUVBO0FBRUE7QUFDQTtBQUFBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBQ0E7QUFEQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQURBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUFBO0FBQ0E7QUFEQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBREE7QUFFQTtBQUNBO0FBQUE7QUFFQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQURBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBREE7QUFFQTtBQUNBO0FBQUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFEQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBREE7QUFDQTtBQUVBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQUE7QUFFQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBRUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFFQTtBQUNBO0FBRUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUFBO0FBQ0E7QUFBQTtBQUVBO0FBQ0E7QUFDQTtBQURBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFEQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBREE7QUFDQTtBQUVBO0FBQ0E7QUFFQTtBQUNBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQURBO0FBRUE7Ozs7Ozs7Ozs7OztBQzljQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7Ozs7Ozs7QUNsaERBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDTEE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7OztBQzNCQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7OztBQ0hBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7Ozs7Ozs7QUM3Q0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7OztBQ3JCQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7OztBQ1JBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7OztBQzlMQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDOUJBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7OztBQzVCQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7Ozs7Ozs7QUM1QkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDdEJBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDakVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7O0EiLCJzb3VyY2VSb290IjoiIn0=