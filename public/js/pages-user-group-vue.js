"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["pages-user-group-vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/user/group.vue?vue&type=script&lang=js":
/*!***********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/user/group.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var element_plus__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! element-plus */ "./node_modules/element-plus/es/components/message/index.mjs");
/* harmony import */ var _api_group__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../api/group */ "./resources/js/api/group.js");
/* harmony import */ var _api_user__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../api/user */ "./resources/js/api/user.js");
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vue-router */ "./node_modules/vue-router/dist/vue-router.mjs");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  setup: function setup() {
    var router = (0,vue_router__WEBPACK_IMPORTED_MODULE_3__.useRouter)();
    var route = (0,vue_router__WEBPACK_IMPORTED_MODULE_3__.useRoute)();
    var state = (0,vue__WEBPACK_IMPORTED_MODULE_0__.reactive)({
      groupList: [],
      userInfo: [],
      multipleSelection: []
    });
    var getLists = function getLists() {
      var params = {
        type: 'all'
      };
      (0,_api_group__WEBPACK_IMPORTED_MODULE_1__.getGroupList)(params).then(function (result) {
        state.groupList = result.Data;
        getUserDetails(route.query.id);
      });
    };
    var handleSelectionChange = function handleSelectionChange(val) {
      state.multipleSelection = val;
    };
    var multipleTable = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(null);
    var toggleSelection = function toggleSelection(row) {
      if (row) {
        multipleTable._value.toggleRowSelection(row);
      }
    };
    var getUserDetails = function getUserDetails(id) {
      var params = {
        type: 'detail',
        id: id
      };
      (0,_api_user__WEBPACK_IMPORTED_MODULE_2__.getUserDetail)(params).then(function (result) {
        state.userInfo = result.Data || [];
        var uGroupIds = state.userInfo.group_ids;
        console.log(uGroupIds);
        state.groupList.every(function (item) {
          if (uGroupIds.indexOf(item.id) > -1) {
            toggleSelection(item);
          }
          return true;
        });
        console.log(state.userInfo);
      });
    };
    var saveAll = function saveAll() {
      console.log(state.multipleSelection);
      var groupData_ids = [];
      state.multipleSelection.every(function (item) {
        groupData_ids.push(item.id);
        return true;
      });
      console.log(groupData_ids);
      state.body_loading = true;
      state.save_loading = true;
      (0,_api_user__WEBPACK_IMPORTED_MODULE_2__.saveUserGroupData)({
        id: route.query.id,
        group_ids: groupData_ids
      }).then(function (res) {
        state.body_loading = false;
        state.save_loading = false;
        (0,element_plus__WEBPACK_IMPORTED_MODULE_4__.ElMessage)({
          type: 'success',
          message: res.Msg,
          duration: 1000
        });
        setTimeout(function () {
          router.push({
            path: '/user/list'
          });
        });
      });
    };
    getLists();
    return _objectSpread(_objectSpread({}, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toRefs)(state)), {}, {
      handleSelectionChange: handleSelectionChange,
      saveAll: saveAll,
      multipleTable: multipleTable,
      getLists: getLists
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/user/group.vue?vue&type=template&id=c9d55838":
/*!***************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/user/group.vue?vue&type=template&id=c9d55838 ***!
  \***************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "card-wrap"
};
var _hoisted_2 = {
  "class": "card-header"
};
var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "card-title"
}, "分配角色", -1 /* HOISTED */);
var _hoisted_4 = {
  "class": "right"
};
var _hoisted_5 = {
  "class": "card-body-blank"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_el_button = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-button");
  var _component_el_table_column = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-table-column");
  var _component_el_tooltip = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-tooltip");
  var _component_el_table = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-table");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [_hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_button, {
    type: "primary",
    onClick: $setup.saveAll,
    disabled: _ctx.isDisabled,
    size: "small",
    "class": "ml-1",
    plain: ""
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("保存")];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onClick", "disabled"])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_table, {
    data: _ctx.groupList,
    border: "",
    "header-row-class-name": "table-header-th",
    size: "small",
    height: "500",
    style: {
      "width": "100%"
    },
    ref: "multipleTable",
    onSelectionChange: $setup.handleSelectionChange
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_table_column, {
        width: "60",
        type: "selection"
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_table_column, {
        width: "60",
        prop: "id",
        align: "center",
        label: "编号"
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_table_column, {
        width: "120",
        align: "center",
        prop: "name",
        label: "角色"
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_table_column, {
        align: "center",
        label: "权限范围"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (scope) {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_tooltip, {
            placement: "top",
            width: "200",
            trigger: "hover"
          }, {
            content: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(scope.row.group_rules), 1 /* TEXT */)];
            }),

            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.stringSub(scope.row.group_rules, 48)), 1 /* TEXT */)];
            }),

            _: 2 /* DYNAMIC */
          }, 1024 /* DYNAMIC_SLOTS */)];
        }),

        _: 1 /* STABLE */
      })];
    }),

    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["data", "onSelectionChange"])])]);
}

/***/ }),

/***/ "./resources/js/api/group.js":
/*!***********************************!*\
  !*** ./resources/js/api/group.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "deleteGroupData": () => (/* binding */ deleteGroupData),
/* harmony export */   "getGroupDetail": () => (/* binding */ getGroupDetail),
/* harmony export */   "getGroupList": () => (/* binding */ getGroupList),
/* harmony export */   "saveGroupData": () => (/* binding */ saveGroupData),
/* harmony export */   "saveGroupRulesData": () => (/* binding */ saveGroupRulesData)
/* harmony export */ });
/* harmony import */ var _utils_request__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/request */ "./resources/js/utils/request.js");

var Api = {
  // auth group
  GetList: 'auth/group-list',
  GetDetail: 'auth/group-info',
  SaveGroup: 'auth/save-group',
  SaveGroupRules: 'auth/save-group-rules',
  DeleteGroup: 'auth/delete-group'
};

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
function getGroupList(data) {
  return (0,_utils_request__WEBPACK_IMPORTED_MODULE_0__["default"])({
    url: Api.GetList,
    method: 'GET',
    params: data
  });
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
function getGroupDetail(data) {
  return (0,_utils_request__WEBPACK_IMPORTED_MODULE_0__["default"])({
    url: Api.GetDetail,
    method: 'GET',
    params: data
  });
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
function saveGroupData(data) {
  return (0,_utils_request__WEBPACK_IMPORTED_MODULE_0__["default"])({
    url: Api.SaveGroup,
    method: 'post',
    data: data
  });
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
function saveGroupRulesData(data) {
  return (0,_utils_request__WEBPACK_IMPORTED_MODULE_0__["default"])({
    url: Api.SaveGroupRules,
    method: 'post',
    data: data
  });
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
function deleteGroupData(data) {
  return (0,_utils_request__WEBPACK_IMPORTED_MODULE_0__["default"])({
    url: Api.DeleteGroup,
    method: 'post',
    data: data
  });
}

/***/ }),

/***/ "./resources/js/pages/user/group.vue":
/*!*******************************************!*\
  !*** ./resources/js/pages/user/group.vue ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _group_vue_vue_type_template_id_c9d55838__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./group.vue?vue&type=template&id=c9d55838 */ "./resources/js/pages/user/group.vue?vue&type=template&id=c9d55838");
/* harmony import */ var _group_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./group.vue?vue&type=script&lang=js */ "./resources/js/pages/user/group.vue?vue&type=script&lang=js");
/* harmony import */ var E_webwww_sd_shop_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,E_webwww_sd_shop_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_group_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_group_vue_vue_type_template_id_c9d55838__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/pages/user/group.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/pages/user/group.vue?vue&type=script&lang=js":
/*!*******************************************************************!*\
  !*** ./resources/js/pages/user/group.vue?vue&type=script&lang=js ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_group_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_group_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./group.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/user/group.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/pages/user/group.vue?vue&type=template&id=c9d55838":
/*!*************************************************************************!*\
  !*** ./resources/js/pages/user/group.vue?vue&type=template&id=c9d55838 ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_group_vue_vue_type_template_id_c9d55838__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_group_vue_vue_type_template_id_c9d55838__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./group.vue?vue&type=template&id=c9d55838 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/user/group.vue?vue&type=template&id=c9d55838");


/***/ })

}]);