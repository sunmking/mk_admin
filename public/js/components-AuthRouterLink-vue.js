"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["components-AuthRouterLink-vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/AuthRouterLink.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/AuthRouterLink.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var store2__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! store2 */ "./node_modules/store2/dist/store2.js");
/* harmony import */ var store2__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(store2__WEBPACK_IMPORTED_MODULE_1__);


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "AuthRouterLink",
  props: ['text', 'type', 'size', 'route_name', 'isDisable', 'isLoading'],
  emits: ["handleClick"],
  setup: function setup(props, context) {
    var isShow = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    var is_disable = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    var is_loading = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    var size_data = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)('');
    var type_data = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)('');
    // 其中props是响应式不能随便使用es6解构，context不是响应式可以使用es6解构
    var _toRefs = (0,vue__WEBPACK_IMPORTED_MODULE_0__.toRefs)(props),
      text = _toRefs.text,
      type = _toRefs.type,
      size = _toRefs.size,
      to = _toRefs.to,
      route_name = _toRefs.route_name,
      isDisable = _toRefs.isDisable,
      isLoading = _toRefs.isLoading; // 将props转化为响应式，因为 props 是响应式的，你不能使用 ES6 解构，因为它会消除 prop 的响应性。
    is_disable.value = isDisable === true;
    is_loading.value = isLoading === true;
    size_data.value = size.value || 'mini';
    type_data.value = type.value || 'default';
    var handleClick = function handleClick() {
      //console.log(props, context);
      context.emit("handleClick");
    };
    var isShowButton = function isShowButton() {
      var menuInfo = store2__WEBPACK_IMPORTED_MODULE_1___default().get('menuInfo') || [];
      var menuList = menuInfo.menuList;
      //菜单
      if (menuList.length > 0) {
        for (var i = 0; i < menuList.length; i++) {
          var currentMenu = menuList[i];
          (currentMenu.children || []).every(function (item_c) {
            if (item_c.rule === route_name.value) {
              //eg /unit/index
              isShow.value = true;
              return false;
            } else {
              var data_cc = item_c.children || [];
              data_cc.every(function (item_cc) {
                if (item_cc.rule === route_name.value) {
                  isShow.value = true;
                  return false;
                }
                return true;
              });
            }
            return true;
          });
        }
      }
    };
    isShowButton();
    return {
      isShowButton: isShowButton,
      handleClick: handleClick,
      isShow: isShow,
      text: text,
      to: to,
      type_data: type_data,
      size_data: size_data,
      is_disable: is_disable,
      is_loading: is_loading
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/AuthRouterLink.vue?vue&type=template&id=ae265754":
/*!************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/AuthRouterLink.vue?vue&type=template&id=ae265754 ***!
  \************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_el_button = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-button");
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  return $setup.isShow ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_router_link, {
    key: 0,
    to: $setup.to
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_button, {
        type: $setup.type_data,
        size: $setup.size_data,
        disabled: $setup.is_disable,
        loading: $setup.is_loading,
        onClick: $setup.handleClick
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.text), 1 /* TEXT */)];
        }),

        _: 1 /* STABLE */
      }, 8 /* PROPS */, ["type", "size", "disabled", "loading", "onClick"])];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["to"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true);
}

/***/ }),

/***/ "./resources/js/components/AuthRouterLink.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/AuthRouterLink.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _AuthRouterLink_vue_vue_type_template_id_ae265754__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AuthRouterLink.vue?vue&type=template&id=ae265754 */ "./resources/js/components/AuthRouterLink.vue?vue&type=template&id=ae265754");
/* harmony import */ var _AuthRouterLink_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AuthRouterLink.vue?vue&type=script&lang=js */ "./resources/js/components/AuthRouterLink.vue?vue&type=script&lang=js");
/* harmony import */ var E_webwww_sd_shop_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,E_webwww_sd_shop_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_AuthRouterLink_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_AuthRouterLink_vue_vue_type_template_id_ae265754__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/AuthRouterLink.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/AuthRouterLink.vue?vue&type=script&lang=js":
/*!****************************************************************************!*\
  !*** ./resources/js/components/AuthRouterLink.vue?vue&type=script&lang=js ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AuthRouterLink_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AuthRouterLink_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AuthRouterLink.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/AuthRouterLink.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/AuthRouterLink.vue?vue&type=template&id=ae265754":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/AuthRouterLink.vue?vue&type=template&id=ae265754 ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AuthRouterLink_vue_vue_type_template_id_ae265754__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AuthRouterLink_vue_vue_type_template_id_ae265754__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AuthRouterLink.vue?vue&type=template&id=ae265754 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/AuthRouterLink.vue?vue&type=template&id=ae265754");


/***/ })

}]);