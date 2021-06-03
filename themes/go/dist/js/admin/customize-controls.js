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
/******/ 	return __webpack_require__(__webpack_require__.s = "./.dev/assets/admin/js/customize-controls.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./.dev/assets/admin/js/customize-controls.js":
/*!****************************************************!*\
  !*** ./.dev/assets/admin/js/customize-controls.js ***!
  \****************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _customize_controls_range_control__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./customize/controls/range-control */ "./.dev/assets/admin/js/customize/controls/range-control.js");
/* harmony import */ var _customize_controls_range_control__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_customize_controls_range_control__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _customize_controls_set_active_color_schemes__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./customize/controls/set-active-color-schemes */ "./.dev/assets/admin/js/customize/controls/set-active-color-schemes.js");
/* harmony import */ var _customize_controls_set_active_color_schemes__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_customize_controls_set_active_color_schemes__WEBPACK_IMPORTED_MODULE_1__);


/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */

(function () {
  wp.customize.bind('ready', function () {
    /**
     * Function to hide/show Customizer options, based on another control.
     *
     * Parent option, Affected Control, Value which affects the control.
     *
     * @param {String} parentSetting The setting that will toggle the display of the control.
     * @param {String} affectedControl The control that will be toggled.
     * @param {Array} values The values the parentSetting must have for the affectedControl to be displayed.
     * @param {Integer} speed The speed of the toggle animation.
     */
    function customizerOptionDisplay(parentSetting, affectedControl, values) {
      var speed = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 100;
      wp.customize(parentSetting, function (setting) {
        wp.customize.control(affectedControl, function (control) {
          /**
           * Toggle the visibility of a control.
           */
          var visibility = function visibility() {
            if (values.includes(setting.get())) {
              control.container.slideDown(speed);
            } else {
              control.container.slideUp(speed);
            }
          };

          visibility();
          setting.bind(visibility);
        });
      });
    }
    /**
     * Function to hide/show Customizer options, based on another control.
     *
     * Parent option, Affected Control, Value which affects the control.
     *
     * @param {String} parentSetting The setting that will toggle the display of the control.
     * @param {String} affectedControl The control that will be toggled.
     * @param {Integer} speed The speed of the toggle animation.
     */


    function customizerImageOptionDisplay(parentSetting, affectedControl) {
      var speed = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 100;
      wp.customize(parentSetting, function (setting) {
        wp.customize.control(affectedControl, function (control) {
          /**
           * Toggle the visibility of a control.
           */
          var visibility = function visibility() {
            if (setting.get() && 'none' !== setting.get() && '0' !== setting.get()) {
              control.container.slideDown(speed);
            } else {
              control.container.slideUp(speed);
            }
          };

          visibility();
          setting.bind(visibility);
        });
      });
    } // Only show the Footer Header Color selector, if the footer variation is 2 or 4.


    customizerOptionDisplay('footer_variation', 'footer_heading_color', ['footer-3', 'footer-4']);
    customizerOptionDisplay('footer_variation', 'footer_heading_color_alt', ['footer-3', 'footer-4']); // Footer nav locations #2 and #3 are only available on Footer Variation #3 and #4.

    customizerOptionDisplay('footer_variation', 'nav_menu_locations[footer-2]', ['footer-3', 'footer-4']);
    customizerOptionDisplay('footer_variation', 'nav_menu_locations[footer-3]', ['footer-3', 'footer-4']); // Only show the following options, if a logo is uploaded.

    customizerImageOptionDisplay('custom_logo', 'logo_width');
    customizerImageOptionDisplay('custom_logo', 'logo_width_mobile');
  });
})(jQuery);

/***/ }),

/***/ "./.dev/assets/admin/js/customize/controls/range-control.js":
/*!******************************************************************!*\
  !*** ./.dev/assets/admin/js/customize/controls/range-control.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($, api) {
  api.bind('ready', function () {
    $('.range_control__reset').on('click', function () {
      var rangeContainer = $(this).parent();
      var rangeInput = rangeContainer.find('input[data-input-type="range"]');
      var controlValue = rangeContainer.find('.range_control__value');
      var defaultValue = rangeInput.data('default-value');
      rangeInput.val(defaultValue);
      controlValue.find('span').html(defaultValue);
      controlValue.find('input').val(defaultValue);
      var customizeSetting = controlValue.find('input').data('customize-setting-link');
      wp.customize.control(customizeSetting).setting.set(defaultValue);
    });
  });
})(jQuery, wp.customize);

/***/ }),

/***/ "./.dev/assets/admin/js/customize/controls/set-active-color-schemes.js":
/*!*****************************************************************************!*\
  !*** ./.dev/assets/admin/js/customize/controls/set-active-color-schemes.js ***!
  \*****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  jQuery.wp.wpColorPicker.prototype.options.palettes = goCustomizerControls.activeColorScheme;
  wp.customize('color_scheme', function (value) {
    value.bind(function (to) {
      // 0: design style (eg: modern)
      // 1: color scheme (eg: one, two, three, four etc.)
      var colorSchemeData = to.split('-');

      if (colorSchemeData.legnth < 2 || !goCustomizerControls.availableDesignStyles.hasOwnProperty(colorSchemeData[0]) || !goCustomizerControls.availableDesignStyles[colorSchemeData[0]]['color_schemes'].hasOwnProperty(colorSchemeData[1])) {
        return;
      }

      var colorScheme = goCustomizerControls.availableDesignStyles[colorSchemeData[0]]['color_schemes'][colorSchemeData[1]];

      if (colorScheme.hasOwnProperty('label')) {
        delete colorScheme['label'];
      }

      jQuery.wp.wpColorPicker.prototype.options.palettes = Object.values(colorScheme);
    });
  });
})(jQuery);

/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoianMvYWRtaW4vY3VzdG9taXplLWNvbnRyb2xzLmpzIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vL3dlYnBhY2svYm9vdHN0cmFwIiwid2VicGFjazovLy8uLy5kZXYvYXNzZXRzL2FkbWluL2pzL2N1c3RvbWl6ZS1jb250cm9scy5qcyIsIndlYnBhY2s6Ly8vLi8uZGV2L2Fzc2V0cy9hZG1pbi9qcy9jdXN0b21pemUvY29udHJvbHMvcmFuZ2UtY29udHJvbC5qcyIsIndlYnBhY2s6Ly8vLi8uZGV2L2Fzc2V0cy9hZG1pbi9qcy9jdXN0b21pemUvY29udHJvbHMvc2V0LWFjdGl2ZS1jb2xvci1zY2hlbWVzLmpzIl0sInNvdXJjZXNDb250ZW50IjpbIiBcdC8vIFRoZSBtb2R1bGUgY2FjaGVcbiBcdHZhciBpbnN0YWxsZWRNb2R1bGVzID0ge307XG5cbiBcdC8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG4gXHRmdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cbiBcdFx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG4gXHRcdGlmKGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdKSB7XG4gXHRcdFx0cmV0dXJuIGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdLmV4cG9ydHM7XG4gXHRcdH1cbiBcdFx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcbiBcdFx0dmFyIG1vZHVsZSA9IGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdID0ge1xuIFx0XHRcdGk6IG1vZHVsZUlkLFxuIFx0XHRcdGw6IGZhbHNlLFxuIFx0XHRcdGV4cG9ydHM6IHt9XG4gXHRcdH07XG5cbiBcdFx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG4gXHRcdG1vZHVsZXNbbW9kdWxlSWRdLmNhbGwobW9kdWxlLmV4cG9ydHMsIG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG4gXHRcdC8vIEZsYWcgdGhlIG1vZHVsZSBhcyBsb2FkZWRcbiBcdFx0bW9kdWxlLmwgPSB0cnVlO1xuXG4gXHRcdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG4gXHRcdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbiBcdH1cblxuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZXMgb2JqZWN0IChfX3dlYnBhY2tfbW9kdWxlc19fKVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5tID0gbW9kdWxlcztcblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGUgY2FjaGVcbiBcdF9fd2VicGFja19yZXF1aXJlX18uYyA9IGluc3RhbGxlZE1vZHVsZXM7XG5cbiBcdC8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb24gZm9yIGhhcm1vbnkgZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kID0gZnVuY3Rpb24oZXhwb3J0cywgbmFtZSwgZ2V0dGVyKSB7XG4gXHRcdGlmKCFfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZXhwb3J0cywgbmFtZSkpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgbmFtZSwgeyBlbnVtZXJhYmxlOiB0cnVlLCBnZXQ6IGdldHRlciB9KTtcbiBcdFx0fVxuIFx0fTtcblxuIFx0Ly8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yID0gZnVuY3Rpb24oZXhwb3J0cykge1xuIFx0XHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcbiBcdFx0fVxuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xuIFx0fTtcblxuIFx0Ly8gY3JlYXRlIGEgZmFrZSBuYW1lc3BhY2Ugb2JqZWN0XG4gXHQvLyBtb2RlICYgMTogdmFsdWUgaXMgYSBtb2R1bGUgaWQsIHJlcXVpcmUgaXRcbiBcdC8vIG1vZGUgJiAyOiBtZXJnZSBhbGwgcHJvcGVydGllcyBvZiB2YWx1ZSBpbnRvIHRoZSBuc1xuIFx0Ly8gbW9kZSAmIDQ6IHJldHVybiB2YWx1ZSB3aGVuIGFscmVhZHkgbnMgb2JqZWN0XG4gXHQvLyBtb2RlICYgOHwxOiBiZWhhdmUgbGlrZSByZXF1aXJlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnQgPSBmdW5jdGlvbih2YWx1ZSwgbW9kZSkge1xuIFx0XHRpZihtb2RlICYgMSkgdmFsdWUgPSBfX3dlYnBhY2tfcmVxdWlyZV9fKHZhbHVlKTtcbiBcdFx0aWYobW9kZSAmIDgpIHJldHVybiB2YWx1ZTtcbiBcdFx0aWYoKG1vZGUgJiA0KSAmJiB0eXBlb2YgdmFsdWUgPT09ICdvYmplY3QnICYmIHZhbHVlICYmIHZhbHVlLl9fZXNNb2R1bGUpIHJldHVybiB2YWx1ZTtcbiBcdFx0dmFyIG5zID0gT2JqZWN0LmNyZWF0ZShudWxsKTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yKG5zKTtcbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KG5zLCAnZGVmYXVsdCcsIHsgZW51bWVyYWJsZTogdHJ1ZSwgdmFsdWU6IHZhbHVlIH0pO1xuIFx0XHRpZihtb2RlICYgMiAmJiB0eXBlb2YgdmFsdWUgIT0gJ3N0cmluZycpIGZvcih2YXIga2V5IGluIHZhbHVlKSBfX3dlYnBhY2tfcmVxdWlyZV9fLmQobnMsIGtleSwgZnVuY3Rpb24oa2V5KSB7IHJldHVybiB2YWx1ZVtrZXldOyB9LmJpbmQobnVsbCwga2V5KSk7XG4gXHRcdHJldHVybiBucztcbiBcdH07XG5cbiBcdC8vIGdldERlZmF1bHRFeHBvcnQgZnVuY3Rpb24gZm9yIGNvbXBhdGliaWxpdHkgd2l0aCBub24taGFybW9ueSBtb2R1bGVzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm4gPSBmdW5jdGlvbihtb2R1bGUpIHtcbiBcdFx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0RGVmYXVsdCgpIHsgcmV0dXJuIG1vZHVsZVsnZGVmYXVsdCddOyB9IDpcbiBcdFx0XHRmdW5jdGlvbiBnZXRNb2R1bGVFeHBvcnRzKCkgeyByZXR1cm4gbW9kdWxlOyB9O1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQoZ2V0dGVyLCAnYScsIGdldHRlcik7XG4gXHRcdHJldHVybiBnZXR0ZXI7XG4gXHR9O1xuXG4gXHQvLyBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGxcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubyA9IGZ1bmN0aW9uKG9iamVjdCwgcHJvcGVydHkpIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmplY3QsIHByb3BlcnR5KTsgfTtcblxuIFx0Ly8gX193ZWJwYWNrX3B1YmxpY19wYXRoX19cbiBcdF9fd2VicGFja19yZXF1aXJlX18ucCA9IFwiXCI7XG5cblxuIFx0Ly8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4gXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhfX3dlYnBhY2tfcmVxdWlyZV9fLnMgPSBcIi4vLmRldi9hc3NldHMvYWRtaW4vanMvY3VzdG9taXplLWNvbnRyb2xzLmpzXCIpO1xuIiwiaW1wb3J0ICcuL2N1c3RvbWl6ZS9jb250cm9scy9yYW5nZS1jb250cm9sJztcbmltcG9ydCAnLi9jdXN0b21pemUvY29udHJvbHMvc2V0LWFjdGl2ZS1jb2xvci1zY2hlbWVzJztcblxuLyoqXG4gKiBTY3JpcHRzIHdpdGhpbiB0aGUgY3VzdG9taXplciBjb250cm9scyB3aW5kb3cuXG4gKlxuICogQ29udGV4dHVhbGx5IHNob3dzIHRoZSBjb2xvciBodWUgY29udHJvbCBhbmQgaW5mb3JtcyB0aGUgcHJldmlld1xuICogd2hlbiB1c2VycyBvcGVuIG9yIGNsb3NlIHRoZSBmcm9udCBwYWdlIHNlY3Rpb25zIHNlY3Rpb24uXG4gKi9cblxuKCBmdW5jdGlvbigpIHtcblxuXHR3cC5jdXN0b21pemUuYmluZCggJ3JlYWR5JywgZnVuY3Rpb24gKCkge1xuXG5cdFx0LyoqXG5cdFx0ICogRnVuY3Rpb24gdG8gaGlkZS9zaG93IEN1c3RvbWl6ZXIgb3B0aW9ucywgYmFzZWQgb24gYW5vdGhlciBjb250cm9sLlxuXHRcdCAqXG5cdFx0ICogUGFyZW50IG9wdGlvbiwgQWZmZWN0ZWQgQ29udHJvbCwgVmFsdWUgd2hpY2ggYWZmZWN0cyB0aGUgY29udHJvbC5cblx0XHQgKlxuXHRcdCAqIEBwYXJhbSB7U3RyaW5nfSBwYXJlbnRTZXR0aW5nIFRoZSBzZXR0aW5nIHRoYXQgd2lsbCB0b2dnbGUgdGhlIGRpc3BsYXkgb2YgdGhlIGNvbnRyb2wuXG5cdFx0ICogQHBhcmFtIHtTdHJpbmd9IGFmZmVjdGVkQ29udHJvbCBUaGUgY29udHJvbCB0aGF0IHdpbGwgYmUgdG9nZ2xlZC5cblx0XHQgKiBAcGFyYW0ge0FycmF5fSB2YWx1ZXMgVGhlIHZhbHVlcyB0aGUgcGFyZW50U2V0dGluZyBtdXN0IGhhdmUgZm9yIHRoZSBhZmZlY3RlZENvbnRyb2wgdG8gYmUgZGlzcGxheWVkLlxuXHRcdCAqIEBwYXJhbSB7SW50ZWdlcn0gc3BlZWQgVGhlIHNwZWVkIG9mIHRoZSB0b2dnbGUgYW5pbWF0aW9uLlxuXHRcdCAqL1xuXHRcdGZ1bmN0aW9uIGN1c3RvbWl6ZXJPcHRpb25EaXNwbGF5KCBwYXJlbnRTZXR0aW5nLCBhZmZlY3RlZENvbnRyb2wsIHZhbHVlcywgc3BlZWQgPSAxMDAgKSB7XG5cdFx0XHR3cC5jdXN0b21pemUoIHBhcmVudFNldHRpbmcsIGZ1bmN0aW9uKCBzZXR0aW5nICkge1xuXHRcdFx0XHR3cC5jdXN0b21pemUuY29udHJvbCggYWZmZWN0ZWRDb250cm9sLCBmdW5jdGlvbiAoIGNvbnRyb2wgKSB7XG5cdFx0XHRcdFx0LyoqXG5cdFx0XHRcdFx0ICogVG9nZ2xlIHRoZSB2aXNpYmlsaXR5IG9mIGEgY29udHJvbC5cblx0XHRcdFx0XHQgKi9cblx0XHRcdFx0XHRjb25zdCB2aXNpYmlsaXR5ID0gZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0XHRpZiAoIHZhbHVlcy5pbmNsdWRlcyggc2V0dGluZy5nZXQoKSApICkge1xuXHRcdFx0XHRcdFx0XHRjb250cm9sLmNvbnRhaW5lci5zbGlkZURvd24oIHNwZWVkICk7XG5cdFx0XHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdFx0XHRjb250cm9sLmNvbnRhaW5lci5zbGlkZVVwKCBzcGVlZCApO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH07XG5cblx0XHRcdFx0XHR2aXNpYmlsaXR5KCk7XG5cdFx0XHRcdFx0c2V0dGluZy5iaW5kKCB2aXNpYmlsaXR5ICk7XG5cdFx0XHRcdH0gKTtcblx0XHRcdH0gKTtcblx0XHR9XG5cblx0XHQvKipcblx0XHQgKiBGdW5jdGlvbiB0byBoaWRlL3Nob3cgQ3VzdG9taXplciBvcHRpb25zLCBiYXNlZCBvbiBhbm90aGVyIGNvbnRyb2wuXG5cdFx0ICpcblx0XHQgKiBQYXJlbnQgb3B0aW9uLCBBZmZlY3RlZCBDb250cm9sLCBWYWx1ZSB3aGljaCBhZmZlY3RzIHRoZSBjb250cm9sLlxuXHRcdCAqXG5cdFx0ICogQHBhcmFtIHtTdHJpbmd9IHBhcmVudFNldHRpbmcgVGhlIHNldHRpbmcgdGhhdCB3aWxsIHRvZ2dsZSB0aGUgZGlzcGxheSBvZiB0aGUgY29udHJvbC5cblx0XHQgKiBAcGFyYW0ge1N0cmluZ30gYWZmZWN0ZWRDb250cm9sIFRoZSBjb250cm9sIHRoYXQgd2lsbCBiZSB0b2dnbGVkLlxuXHRcdCAqIEBwYXJhbSB7SW50ZWdlcn0gc3BlZWQgVGhlIHNwZWVkIG9mIHRoZSB0b2dnbGUgYW5pbWF0aW9uLlxuXHRcdCAqL1xuXHRcdGZ1bmN0aW9uIGN1c3RvbWl6ZXJJbWFnZU9wdGlvbkRpc3BsYXkoIHBhcmVudFNldHRpbmcsIGFmZmVjdGVkQ29udHJvbCwgc3BlZWQgPSAxMDAgKSB7XG5cdFx0XHR3cC5jdXN0b21pemUoIHBhcmVudFNldHRpbmcsIGZ1bmN0aW9uKCBzZXR0aW5nICkge1xuXHRcdFx0XHR3cC5jdXN0b21pemUuY29udHJvbCggYWZmZWN0ZWRDb250cm9sLCBmdW5jdGlvbiAoIGNvbnRyb2wgKSB7XG5cdFx0XHRcdFx0LyoqXG5cdFx0XHRcdFx0ICogVG9nZ2xlIHRoZSB2aXNpYmlsaXR5IG9mIGEgY29udHJvbC5cblx0XHRcdFx0XHQgKi9cblx0XHRcdFx0XHRjb25zdCB2aXNpYmlsaXR5ID0gZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0XHRpZiAoIHNldHRpbmcuZ2V0KCkgJiYgJ25vbmUnICE9PSBzZXR0aW5nLmdldCgpICYmICcwJyAhPT0gc2V0dGluZy5nZXQoKSApIHtcblx0XHRcdFx0XHRcdFx0Y29udHJvbC5jb250YWluZXIuc2xpZGVEb3duKCBzcGVlZCApO1xuXHRcdFx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRcdFx0Y29udHJvbC5jb250YWluZXIuc2xpZGVVcCggc3BlZWQgKTtcblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9O1xuXG5cdFx0XHRcdFx0dmlzaWJpbGl0eSgpO1xuXHRcdFx0XHRcdHNldHRpbmcuYmluZCggdmlzaWJpbGl0eSApO1xuXHRcdFx0XHR9ICk7XG5cdFx0XHR9ICk7XG5cdFx0fVxuXG5cdFx0Ly8gT25seSBzaG93IHRoZSBGb290ZXIgSGVhZGVyIENvbG9yIHNlbGVjdG9yLCBpZiB0aGUgZm9vdGVyIHZhcmlhdGlvbiBpcyAyIG9yIDQuXG5cdFx0Y3VzdG9taXplck9wdGlvbkRpc3BsYXkoICdmb290ZXJfdmFyaWF0aW9uJywgJ2Zvb3Rlcl9oZWFkaW5nX2NvbG9yJywgWyAnZm9vdGVyLTMnLCAnZm9vdGVyLTQnIF0gKTtcblx0XHRjdXN0b21pemVyT3B0aW9uRGlzcGxheSggJ2Zvb3Rlcl92YXJpYXRpb24nLCAnZm9vdGVyX2hlYWRpbmdfY29sb3JfYWx0JywgWyAnZm9vdGVyLTMnLCAnZm9vdGVyLTQnIF0gKTtcblxuXHRcdC8vIEZvb3RlciBuYXYgbG9jYXRpb25zICMyIGFuZCAjMyBhcmUgb25seSBhdmFpbGFibGUgb24gRm9vdGVyIFZhcmlhdGlvbiAjMyBhbmQgIzQuXG5cdFx0Y3VzdG9taXplck9wdGlvbkRpc3BsYXkoICdmb290ZXJfdmFyaWF0aW9uJywgJ25hdl9tZW51X2xvY2F0aW9uc1tmb290ZXItMl0nLCBbICdmb290ZXItMycsICdmb290ZXItNCcgXSApO1xuXHRcdGN1c3RvbWl6ZXJPcHRpb25EaXNwbGF5KCAnZm9vdGVyX3ZhcmlhdGlvbicsICduYXZfbWVudV9sb2NhdGlvbnNbZm9vdGVyLTNdJywgWyAnZm9vdGVyLTMnLCAnZm9vdGVyLTQnIF0gKTtcblxuXHRcdC8vIE9ubHkgc2hvdyB0aGUgZm9sbG93aW5nIG9wdGlvbnMsIGlmIGEgbG9nbyBpcyB1cGxvYWRlZC5cblx0XHRjdXN0b21pemVySW1hZ2VPcHRpb25EaXNwbGF5KCAnY3VzdG9tX2xvZ28nLCAnbG9nb193aWR0aCcgKTtcblx0XHRjdXN0b21pemVySW1hZ2VPcHRpb25EaXNwbGF5KCAnY3VzdG9tX2xvZ28nLCAnbG9nb193aWR0aF9tb2JpbGUnICk7XG5cdH0gKTtcblxufSApKCBqUXVlcnkgKTtcbiIsIiggZnVuY3Rpb24gKCAkLCBhcGkgKSB7XG5cblx0YXBpLmJpbmQoICdyZWFkeScsIGZ1bmN0aW9uICgpIHtcblx0XHQkKCAnLnJhbmdlX2NvbnRyb2xfX3Jlc2V0JyApLm9uKCAnY2xpY2snLCBmdW5jdGlvbiAoKSB7XG5cdFx0XHRjb25zdCByYW5nZUNvbnRhaW5lciA9ICQoIHRoaXMgKS5wYXJlbnQoKTtcblxuXHRcdFx0Y29uc3QgcmFuZ2VJbnB1dCAgID0gcmFuZ2VDb250YWluZXIuZmluZCggJ2lucHV0W2RhdGEtaW5wdXQtdHlwZT1cInJhbmdlXCJdJyApO1xuXHRcdFx0Y29uc3QgY29udHJvbFZhbHVlID0gcmFuZ2VDb250YWluZXIuZmluZCggJy5yYW5nZV9jb250cm9sX192YWx1ZScgKTtcblxuXHRcdFx0Y29uc3QgZGVmYXVsdFZhbHVlID0gcmFuZ2VJbnB1dC5kYXRhKCAnZGVmYXVsdC12YWx1ZScgKTtcblxuXHRcdFx0cmFuZ2VJbnB1dC52YWwoIGRlZmF1bHRWYWx1ZSApO1xuXHRcdFx0Y29udHJvbFZhbHVlLmZpbmQoICdzcGFuJyApLmh0bWwoIGRlZmF1bHRWYWx1ZSApO1xuXHRcdFx0Y29udHJvbFZhbHVlLmZpbmQoICdpbnB1dCcgKS52YWwoIGRlZmF1bHRWYWx1ZSApO1xuXG5cdFx0XHRjb25zdCBjdXN0b21pemVTZXR0aW5nID0gY29udHJvbFZhbHVlLmZpbmQoICdpbnB1dCcgKS5kYXRhKCAnY3VzdG9taXplLXNldHRpbmctbGluaycgKTtcblx0XHRcdHdwLmN1c3RvbWl6ZS5jb250cm9sKCBjdXN0b21pemVTZXR0aW5nICkuc2V0dGluZy5zZXQoIGRlZmF1bHRWYWx1ZSApO1xuXHRcdH0gKTtcblx0fSApO1xuXG59ICkoIGpRdWVyeSwgd3AuY3VzdG9taXplICk7XG4iLCIoIGZ1bmN0aW9uICggJCApIHtcblxuXHRqUXVlcnkud3Aud3BDb2xvclBpY2tlci5wcm90b3R5cGUub3B0aW9ucy5wYWxldHRlcyA9IGdvQ3VzdG9taXplckNvbnRyb2xzLmFjdGl2ZUNvbG9yU2NoZW1lO1xuXG5cdHdwLmN1c3RvbWl6ZSggJ2NvbG9yX3NjaGVtZScsICggdmFsdWUgKSA9PiB7XG5cdFx0dmFsdWUuYmluZCggKCB0byApID0+IHtcblx0XHRcdC8vIDA6IGRlc2lnbiBzdHlsZSAoZWc6IG1vZGVybilcblx0XHRcdC8vIDE6IGNvbG9yIHNjaGVtZSAoZWc6IG9uZSwgdHdvLCB0aHJlZSwgZm91ciBldGMuKVxuXHRcdFx0bGV0IGNvbG9yU2NoZW1lRGF0YSA9IHRvLnNwbGl0KCAnLScgKTtcblx0XHRcdGlmICggY29sb3JTY2hlbWVEYXRhLmxlZ250aCA8IDIgfHwgISBnb0N1c3RvbWl6ZXJDb250cm9scy5hdmFpbGFibGVEZXNpZ25TdHlsZXMuaGFzT3duUHJvcGVydHkoIGNvbG9yU2NoZW1lRGF0YVswXSApIHx8ICEgZ29DdXN0b21pemVyQ29udHJvbHMuYXZhaWxhYmxlRGVzaWduU3R5bGVzWyBjb2xvclNjaGVtZURhdGFbMF0gXVsnY29sb3Jfc2NoZW1lcyddLmhhc093blByb3BlcnR5KCBjb2xvclNjaGVtZURhdGFbMV0gKSApIHtcblx0XHRcdFx0cmV0dXJuO1xuXHRcdFx0fVxuXHRcdFx0bGV0IGNvbG9yU2NoZW1lID0gZ29DdXN0b21pemVyQ29udHJvbHMuYXZhaWxhYmxlRGVzaWduU3R5bGVzWyBjb2xvclNjaGVtZURhdGFbMF0gXVsnY29sb3Jfc2NoZW1lcyddWyBjb2xvclNjaGVtZURhdGFbMV0gXTtcblx0XHRcdGlmICggY29sb3JTY2hlbWUuaGFzT3duUHJvcGVydHkoICdsYWJlbCcgKSApIHtcblx0XHRcdFx0ZGVsZXRlKCBjb2xvclNjaGVtZVsnbGFiZWwnXSApO1xuXHRcdFx0fVxuXHRcdFx0alF1ZXJ5LndwLndwQ29sb3JQaWNrZXIucHJvdG90eXBlLm9wdGlvbnMucGFsZXR0ZXMgPSBPYmplY3QudmFsdWVzKCBjb2xvclNjaGVtZSApO1xuXHRcdH0gKTtcblx0fSApO1xuXG59ICkoIGpRdWVyeSApO1xuIl0sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7OztBQ2xGQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFEQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUVBOzs7Ozs7Ozs7OztBQ3RGQTtBQUVBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFFQTtBQUVBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7Ozs7Ozs7Ozs7O0FDcEJBO0FBRUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUFBO0FBQ0E7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUFBO0FBQ0E7QUFDQTtBQUVBOzs7O0EiLCJzb3VyY2VSb290IjoiIn0=