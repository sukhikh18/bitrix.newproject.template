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
/******/ 	return __webpack_require__(__webpack_require__.s = "./public_html/assets/js/main.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./public_html/assets/js/main.js":
/*!***************************************!*\
  !*** ./public_html/assets/js/main.js ***!
  \***************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _parts_lazy_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./parts/_lazy.js */ "./public_html/assets/js/parts/_lazy.js");
/* harmony import */ var _parts_lazy_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_parts_lazy_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _parts_scrollTo_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./parts/_scrollTo.js */ "./public_html/assets/js/parts/_scrollTo.js");
/* harmony import */ var _parts_preloader_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./parts/_preloader.js */ "./public_html/assets/js/parts/_preloader.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

 // for smooth scrool to object



jQuery(document).ready(function ($) {
  $(document).on('click', '[href^="#"]', function (event) {
    event.preventDefault();
    Object(_parts_scrollTo_js__WEBPACK_IMPORTED_MODULE_1__["default"])(this.getAttribute("href"));
  });
  new Cleave('[type="tel"]', {
    phone: true,
    phoneRegionCode: 'RU'
  });
  /**
   * Set event when DOM element in appearance
   * @param  Int (in piexels) | String (in percents) | callable  offset
   */
  // $('.page__header').waypoint({
  //     handler: function(event, direction) {
  //         console.log(direction, this, event);
  //     },
  //     offset: 50
  // });

  /**
   * Example form submit event.
   */

  if (_typeof($.fancybox)) {
    $('.modal form').on('submit', function (event) {
      event.preventDefault();
      _parts_preloader_js__WEBPACK_IMPORTED_MODULE_2__["default"].show(); // Disable retry by 120 seconds

      var $submit = $(this).find('button');
      $submit.attr('disabled', 'disabled');
      setTimeout(function () {
        $submit.removeAttr('disabled');
      }, 120000); // Show success

      setTimeout(function () {
        _parts_preloader_js__WEBPACK_IMPORTED_MODULE_2__["default"].hide();
        $.fancybox.open({
          content: '<h1>Отлично!</h1><p>Ваша заявка принята, ожидайте звонка.</p>',
          type: 'html'
        });
      }, 5000);
    });
  }
});

/***/ }),

/***/ "./public_html/assets/js/parts/_lazy.js":
/*!**********************************************!*\
  !*** ./public_html/assets/js/parts/_lazy.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener('DOMContentLoaded', function () {
  var lazyAttribute = 'data-lazy-src',
      lazySetAttribute = 'data-lazy-srcset',
      lazyBackgroundAttribute = 'data-lazy-bg',
      lazyImages = [].slice.call(document.querySelectorAll('[' + lazyAttribute + ']')),
      lazyBackgrounds = [].slice.call(document.querySelectorAll('[' + lazyBackgroundAttribute + ']'));

  var lazyLoad = function lazyLoad(lazyImage) {
    var srcset = lazyImage.getAttribute(lazySetAttribute);
    lazyImage.setAttribute('src', lazyImage.getAttribute(lazyAttribute));
    if (srcset) lazyImage.setAttribute('srcset', srcset);

    lazyImage.onload = function () {
      lazyImage.removeAttribute(lazyAttribute);
      if (srcset) lazyImage.removeAttribute(lazySetAttribute);
    };
  }; // Usage .element:not([data-lazy-bg]) { background-image: url('lazy.png') } for lazy css background
  // or data-lazy-bg="lazy.png" attribute for set style background on observe.


  var lazyBackground = function lazyBackground(lazyBackgroundElem) {
    var bg = lazyBackgroundElem.getAttribute(lazyBackgroundAttribute);

    if (bg.length > 0 && 'true' !== bg) {
      lazyBackgroundElem.style.backgroundImage = "url(".concat(bg, ")");
    }

    lazyBackgroundElem.removeAttribute(lazyBackgroundAttribute);
  };

  var lazyStyles = function lazyStyles() {
    var css = "\n            img { opacity: 1; transition: opacity .3s }\n            [".concat(lazyAttribute, "] { opacity: 0 }"),
        head = document.head || document.getElementsByTagName('head')[0],
        style = document.createElement('style');
    head.appendChild(style);
    style.type = 'text/css';

    if (style.styleSheet) {
      // This is required for IE8 and below.
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }
  }; // You may use "delete window.IntersectionObserver;" for fallback check.


  if ('IntersectionObserver' in window) {
    lazyStyles();
    var lazyImageObserver = new IntersectionObserver(function (entries, observer) {
      return entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          lazyLoad(entry.target);
          lazyImageObserver.unobserve(entry.target);
        }
      });
    });
    lazyImages.forEach(function (lazyImage) {
      return lazyImageObserver.observe(lazyImage);
    });
    var lazyBackgroundObserver = new IntersectionObserver(function (entries, observer) {
      return entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          lazyBackground(entry.target);
          lazyBackgroundObserver.unobserve(entry.target);
        }
      });
    });
    lazyBackgrounds.forEach(function (lazyBackgroundElem) {
      return lazyBackgroundObserver.observe(lazyBackgroundElem);
    });
  } else {
    lazyImages.forEach(lazyLoad);
    lazyBackgrounds.forEach(lazyBackground);
  }
});

/***/ }),

/***/ "./public_html/assets/js/parts/_preloader.js":
/*!***************************************************!*\
  !*** ./public_html/assets/js/parts/_preloader.js ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var preloadClass = 'fancy-preloading';
var preloader = {
  show: function show() {
    var message = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'Загрузка..';
    var $preload = $('<p>' + message + '</p>').css({
      'margin-top': '50px',
      'margin-bottom': '-40px',
      'padding-bottom': '',
      'color': '#ddd'
    });
    $.fancybox.open({
      closeExisting: true,
      content: $preload,
      type: 'html',
      smallBtn: false,
      afterLoad: function afterLoad(instance, current) {
        current.$content.css('background', 'none');
      },
      afterShow: function afterShow(instance, current) {
        $('body').addClass(preloadClass);
        instance.showLoading(current);
      },
      afterClose: function afterClose(instance, current) {
        $('body').removeClass(preloadClass);
        instance.hideLoading(current);
      }
    });
  },
  hide: function hide() {
    if ($('body').hasClass(preloadClass)) {
      $.fancybox.getInstance().close();
    }
  }
};
/* harmony default export */ __webpack_exports__["default"] = (preloader);

/***/ }),

/***/ "./public_html/assets/js/parts/_scrollTo.js":
/*!**************************************************!*\
  !*** ./public_html/assets/js/parts/_scrollTo.js ***!
  \**************************************************/
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

/***/ })

/******/ });
//# sourceMappingURL=main.js.map