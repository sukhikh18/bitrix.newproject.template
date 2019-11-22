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
/******/ 	return __webpack_require__(__webpack_require__.s = "./public_html/local/templates/new.project/assets/babel/main.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./public_html/local/templates/new.project/assets/babel/main.js":
/*!**********************************************************************!*\
  !*** ./public_html/local/templates/new.project/assets/babel/main.js ***!
  \**********************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _parts_scrollTo_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./parts/_scrollTo.js */ "./public_html/local/templates/new.project/assets/babel/parts/_scrollTo.js");
// for smooth scrool to object
 // init and destroy slider on resize
// import responsiveSlider from "./parts/_responsiveSlider.js";

jQuery(document).ready(function ($) {
  $(document).on('click', '[href^="#"]', function (event) {
    event.preventDefault();
    var isScrolled = Object(_parts_scrollTo_js__WEBPACK_IMPORTED_MODULE_0__["default"])(this.getAttribute("href"));
  }); // $('.slider').ResponsiveSlider({
  //     maxWidth: 992,
  //     init: function($slider) {
  //         $slider.slick({
  //             infinite: true,
  //             autoplay: false,
  //             autoplaySpeed: 4000,
  //             arrows: true,
  //             dots: false,
  //             slidesToShow: 4,
  //             slidesToScroll: 1,
  //             responsive: [{
  //                 breakpoint: 576,
  //                 settings: {
  //                     autoplay: true,
  //                     slidesToShow: 1,
  //                 }
  //             }]
  //         }); // or this.$slider.owlCarousel( thisconfig..opts );
  //     }
  // });

  /**
   * Set event when DOM element in appearance
   * @param  Int (in piexels) | String (in percents) | callable  offset
   */
  // $('.site-header').waypoint({
  //     handler: function(event, direction) {
  //         console.log(direction, this, event);
  //     },
  //     offset: 50
  // });
});

/***/ }),

/***/ "./public_html/local/templates/new.project/assets/babel/parts/_scrollTo.js":
/*!*********************************************************************************!*\
  !*** ./public_html/local/templates/new.project/assets/babel/parts/_scrollTo.js ***!
  \*********************************************************************************/
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