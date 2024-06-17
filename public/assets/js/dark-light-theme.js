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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./public/theme/assets/sass/login.scss":
/*!*********************************************!*\
  !*** ./public/theme/assets/sass/login.scss ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./public/theme/assets/sass/theme-top-bar-none.scss":
/*!**********************************************************!*\
  !*** ./public/theme/assets/sass/theme-top-bar-none.scss ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/tiger-js/dark-light-theme.js":
/*!************************************************!*\
  !*** ./resources/tiger-js/dark-light-theme.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
var btnChangeThemes = document.getElementById('change-themes');
var txtName = document.getElementById('txt-name');
var container = document.body;
var tigerJs = /*#__PURE__*/function () {
  function tigerJs() {
    _classCallCheck(this, tigerJs);
    var _self = this;
    if (!btnChangeThemes) return console.warn(btnChangeThemes + ' find not found!');
    //check storage if dark mode was on or off
    if (sessionStorage.getItem("mode") == "dark") {
      _self.darkmode(); //if dark mode was on, run this funtion
    } else {
      _self.nodark(); //else run this funtion
    }

    btnChangeThemes.addEventListener("change", function () {
      //check if the checkbox is checked or not
      if (btnChangeThemes.checked) {
        _self.darkmode(); //if the checkbox is checked, run this funtion
      } else {
        _self.nodark(); //else run this funtion
      }
    });
  }
  _createClass(tigerJs, [{
    key: "darkmode",
    value: function darkmode() {
      container.classList.remove('white-sidebar-color', 'logo-white', 'header-white', 'light-theme');
      container.classList.add('dark-sidebar-color', 'logo-dark', 'header-dark', 'dark-theme');
      btnChangeThemes.checked = true; //set checkbox to be checked state
      sessionStorage.setItem("mode", "dark"); //store a name & value to know that dark mode is on
      txtName.innerText = "Giao diện sáng";
    }

    //function for checkbox when checkbox is not checked
  }, {
    key: "nodark",
    value: function nodark() {
      container.classList.remove('dark-sidebar-color', 'logo-dark', 'header-dark', 'dark-theme');
      container.classList.add('white-sidebar-color', 'logo-white', 'header-white', 'light-theme');
      document.body.classList.remove("dark-mode"); //remove added class from body tag
      btnChangeThemes.checked = false; //set checkbox to be unchecked state
      sessionStorage.setItem("mode", "light"); //store a name & value to know that dark mode is off or light mode is on
      txtName.innerText = "Giao diện tối";
    }
  }]);
  return tigerJs;
}();
new tigerJs();

/***/ }),

/***/ 0:
/*!***********************************************************************************************************************************************!*\
  !*** multi ./resources/tiger-js/dark-light-theme.js ./public/theme/assets/sass/login.scss ./public/theme/assets/sass/theme-top-bar-none.scss ***!
  \***********************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! E:\ProjectFrL\Winwin\demosia.e3w.vn\resources\tiger-js\dark-light-theme.js */"./resources/tiger-js/dark-light-theme.js");
__webpack_require__(/*! E:\ProjectFrL\Winwin\demosia.e3w.vn\public\theme\assets\sass\login.scss */"./public/theme/assets/sass/login.scss");
module.exports = __webpack_require__(/*! E:\ProjectFrL\Winwin\demosia.e3w.vn\public\theme\assets\sass\theme-top-bar-none.scss */"./public/theme/assets/sass/theme-top-bar-none.scss");


/***/ })

/******/ });