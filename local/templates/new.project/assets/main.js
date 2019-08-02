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
/******/ 	return __webpack_require__(__webpack_require__.s = "./public_html/local/templates/new.project/assets/_source/main.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./public_html/local/templates/new.project/assets/_source/js/_responsiveSlider.js":
/*!****************************************************************************************!*\
  !*** ./public_html/local/templates/new.project/assets/_source/js/_responsiveSlider.js ***!
  \****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var ResponsiveSlider = function ($) {
  var NAME = 'ResponsiveSlider';
  var JQUERY_NO_CONFLICT = $.fn[NAME];
  var __default = {
    maxWidth: 768,
    wrapClass: '',
    rowClass: 'slider-row',
    colClass: 'slider-col',
    onBeforeInit: function onBeforeInit() {},
    init: function init($slider) {},
    destroy: function destroy($slider) {}
  };

  var ResponsiveSlider =
  /*#__PURE__*/
  function () {
    _createClass(ResponsiveSlider, null, [{
      key: "Default",
      get: function get() {
        return Default;
      }
    }]);

    function ResponsiveSlider(target, config) {
      var _this = this;

      _classCallCheck(this, ResponsiveSlider);

      this.config = $.extend({}, __default, config);
      this.config.maxWidth = parseFloat(this.config.maxWidth);
      this.$target = target instanceof jQuery ? target : $(target);
      this.$slider = null;
      if (!this.$target.length) return;
      this.config.onBeforeInit.call(this);
      var $window = $(window);
      $window.on('resize', function (event) {
        if ($window.width() < _this.config.maxWidth) {
          if (!_this.$slider) {
            _this.$slider = _this.$target.clone(true); // remove bootstrap row

            _this.$slider.removeClass('row').addClass(_this.config.rowClass);

            var id = _this.$slider.attr('id');

            if (id) _this.$slider.attr('id', "".concat(id, "--cloned")); // remove column class

            $('> [class*="col"]', _this.$slider).each(function (index, el) {
              $(el).removeAttr('class').addClass(_this.config.colClass);
            });

            _this.$target.after(_this.$slider).hide();

            if (_this.config.wrapClass) {
              _this.$slider.wrap("<div class=\"".concat(_this.config.wrapClass, "\"></div>"));
            }

            _this.config.init.call(_this, _this.$slider);
          }
        } else {
          if (_this.$slider) {
            _this.config.destroy.call(_this, _this.$slider);

            _this.$slider.remove();

            _this.$slider = null;

            _this.$target.show();
          }
        }
      });
      $window.trigger('resize');
    }

    _createClass(ResponsiveSlider, null, [{
      key: "_jQueryInterface",
      value: function _jQueryInterface(config) {
        config = config || {};
        return this.each(function () {
          var $this = $(this);
          config = $.extend({}, ResponsiveSlider.__default, $this.data(), _typeof(config) === 'object' && config);
          new ResponsiveSlider(this, config);
        });
      }
    }]);

    return ResponsiveSlider;
  }();

  $.fn[NAME] = ResponsiveSlider._jQueryInterface;
  $.fn[NAME].Constructor = ResponsiveSlider;

  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return ResponsiveSlider._jQueryInterface;
  };

  return ResponsiveSlider;
}(jQuery);

/* harmony default export */ __webpack_exports__["default"] = (ResponsiveSlider);

/***/ }),

/***/ "./public_html/local/templates/new.project/assets/_source/js/_scrollTo.js":
/*!********************************************************************************!*\
  !*** ./public_html/local/templates/new.project/assets/_source/js/_scrollTo.js ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
window.scrollTo = function (target) {
  var topOffset = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 30;
  var delay = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 400;
  if (!target || target.length <= 1) return false;
  var $target;

  if (target instanceof jQuery) {
    $target = target.first();
  } else {
    $target = $(target).length ? $(target).first() : $('a[name=' + target.slice(1) + ']').first();
  }

  if ($target.offset().top) {
    // for call from dropdown
    setTimeout(function () {
      return $('html, body').animate({
        scrollTop: $target.offset().top - topOffset
      }, delay);
    }, 100);
    return true;
  }

  return console.log('Element not found.');
};

/* harmony default export */ __webpack_exports__["default"] = (scrollTo);

/***/ }),

/***/ "./public_html/local/templates/new.project/assets/_source/main.js":
/*!************************************************************************!*\
  !*** ./public_html/local/templates/new.project/assets/_source/main.js ***!
  \************************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _js_scrollTo_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./js/_scrollTo.js */ "./public_html/local/templates/new.project/assets/_source/js/_scrollTo.js");
/* harmony import */ var _js_responsiveSlider_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./js/_responsiveSlider.js */ "./public_html/local/templates/new.project/assets/_source/js/_responsiveSlider.js");
// for smooth scrool to object
 // init and destroy slider on resize


jQuery(document).ready(function ($) {
  $(document).on('click', '[href^="#"]', function (event) {
    event.preventDefault();
    var isScrolled = Object(_js_scrollTo_js__WEBPACK_IMPORTED_MODULE_0__["default"])(this.getAttribute("href"));
  });
  $('.slider').ResponsiveSlider({
    maxWidth: 992,
    init: function init($slider) {
      $slider.slick({
        infinite: true,
        autoplay: false,
        autoplaySpeed: 4000,
        arrows: true,
        dots: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [{
          breakpoint: 576,
          settings: {
            autoplay: true,
            slidesToShow: 1
          }
        }]
      }); // or this.$slider.owlCarousel( thisconfig..opts );
    }
  });
});

/***/ })

/******/ });
//# sourceMappingURL=main.js.map