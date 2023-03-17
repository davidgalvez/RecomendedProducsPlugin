/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/relProds/index.js":
/*!*******************************!*\
  !*** ./src/relProds/index.js ***!
  \*******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__);






(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__.registerBlockType)('woorelprods/relprods', {
  apiVersion: 2,
  title: 'Related Productcs List',
  attributes: {
    selListId: {
      type: "number"
    },
    titleBLock: {
      type: "string",
      default: "Related Products"
    }
  },
  edit: (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_2__.withSelect)((select, props) => {
    //extraer valores de atributos
    const {
      attributes: {
        titleBLock,
        selListId
      },
      setAttributes
    } = props;

    const onChangeselListId = newselListId => {
      setAttributes({
        selListId: parseInt(newselListId)
      });
    };

    const onChangetitleBLock = newTitle => {
      setAttributes({
        titleBLock: newTitle
      });
    };

    return {
      relatedList: select("core").getEntityRecords('postType', 'woorelproducts', {
        per_page: 5
      }),
      idSelected: selListId,
      products: [],
      onChangeselListId,
      onChangetitleBLock,
      props
    };
  })(_ref => {
    let {
      relatedList,
      idSelected,
      products,
      onChangeshowQuantity,
      onChangeselListId,
      onChangetitleBLock,
      props
    } = _ref;

    //Validate relatedProductsList
    if (!relatedList) {
      return 'Loading related products...';
    }

    if (relatedList && relatedList.length === 0) {
      return 'Loading related products...';
    }

    if (idSelected !== 0 && typeof relatedList !== 'undefined') {
      relatedList.forEach(relProdList => {
        if (relProdList.id == idSelected) {
          products = relProdList.related_Prods_List;
        }
      });
    } //extract from props


    const {
      attributes: {
        selListId,
        titleBLock
      },
      setAttributes
    } = props; //Generamos los label y values de las relatedList para mostralo en el panel body

    relatedList.forEach(relProdList => {
      relProdList['label'] = relProdList.title_list;
      relProdList['value'] = relProdList.id;
    }); // Arreglo con valores por default

    const opcionDefault = [{
      value: '0',
      label: '--Todos--'
    }];
    const listadorelatedList = [...opcionDefault, ...relatedList];
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
      title: 'Related Products Lists',
      initialOpen: true
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "components-base-control"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "components-base-control__field"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
      className: "components-base-control__label"
    }, "Related Products Lists"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
      options: listadorelatedList,
      onChange: onChangeselListId,
      value: selListId
    })))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
      title: 'Block Title',
      initialOpen: false
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "components-base-control"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "components-base-control__field"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
      className: "components-base-control__label"
    }, "Block Title"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
      onChange: onChangetitleBLock,
      value: titleBLock
    }))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", {
      className: "titulo-menu"
    }, titleBLock), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "container"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      class: "items"
    }, products.map(product => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "entry"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      className: "name"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
      href: product.permalink
    }, product.title)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
      src: product.thubnail_url
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      className: "quote"
    }, (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__.decodeEntities)(product.currency), " ", product.price), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
      className: "link",
      href: product.url
    }, product.urlText))))));
  }),
  save: () => {
    return null;
  }
});

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/html-entities":
/*!**************************************!*\
  !*** external ["wp","htmlEntities"] ***!
  \**************************************/
/***/ (function(module) {

module.exports = window["wp"]["htmlEntities"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _relProds__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./relProds */ "./src/relProds/index.js");

}();
/******/ })()
;
//# sourceMappingURL=index.js.map