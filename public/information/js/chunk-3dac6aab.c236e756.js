(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-3dac6aab"],{"06217":function(e,t,r){"use strict";var a=r("4cee"),o=r.n(a);o.a},2616:function(e,t,r){var a=r("0363"),o=r("7463"),n=a("iterator"),s=Array.prototype;e.exports=function(e){return void 0!==e&&(o.Array===e||s[n]===e)}},"284c":function(e,t,r){"use strict";var a=r("1316"),o=r.n(a);function n(e){if(o()(e)){for(var t=0,r=new Array(e.length);t<e.length;t++)r[t]=e[t];return r}}var s=r("a06f"),i=r.n(s),l=r("2dc0"),c=r.n(l);function u(e){if(c()(Object(e))||"[object Arguments]"===Object.prototype.toString.call(e))return i()(e)}function d(){throw new TypeError("Invalid attempt to spread non-iterable instance")}function m(e){return n(e)||u(e)||d()}r.d(t,"a",(function(){return m}))},"471b":function(e,t,r){"use strict";var a=r("194a"),o=r("4fff"),n=r("faaa"),s=r("2616"),i=r("6725"),l=r("6c15"),c=r("0b7b");e.exports=function(e){var t,r,u,d,m,p=o(e),f="function"==typeof this?this:Array,v=arguments.length,g=v>1?arguments[1]:void 0,h=void 0!==g,b=0,y=c(p);if(h&&(g=a(g,v>2?arguments[2]:void 0,2)),void 0==y||f==Array&&s(y))for(t=i(p.length),r=new f(t);t>b;b++)l(r,b,h?g(p[b],b):p[b]);else for(d=y.call(p),m=d.next,r=new f;!(u=m.call(d)).done;b++)l(r,b,h?n(d,g,[u.value,b],!0):u.value);return r.length=b,r}},"484e":function(e,t,r){var a=r("a5eb"),o=r("471b"),n=r("7de7"),s=!n((function(e){Array.from(e)}));a({target:"Array",stat:!0,forced:s},{from:o})},"4cee":function(e,t,r){},"70d7":function(e,t,r){"use strict";r.r(t);var a=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",[r("a-card",{staticClass:"card",attrs:{title:"仓库管理",bordered:!1}},[r("repository-form",{ref:"repository",attrs:{showSubmit:!1}})],1),r("a-card",{staticClass:"card",attrs:{title:"任务管理",bordered:!1}},[r("task-form",{ref:"task",attrs:{showSubmit:!1}})],1),r("a-card",[r("a-table",{attrs:{columns:e.columns,dataSource:e.data,pagination:!1,loading:e.memberLoading},scopedSlots:e._u([e._l(["name","workId","department"],(function(t,a){return{key:t,fn:function(o,n){return[n.editable?r("a-input",{key:t,staticStyle:{margin:"-5px 0"},attrs:{value:o,placeholder:e.columns[a].title},on:{change:function(r){return e.handleChange(r.target.value,n.key,t)}}}):[e._v(e._s(o))]]}}})),{key:"operation",fn:function(t,a){return[a.editable?[a.isNew?r("span",[r("a",{on:{click:function(t){return e.saveRow(a)}}},[e._v("添加")]),r("a-divider",{attrs:{type:"vertical"}}),r("a-popconfirm",{attrs:{title:"是否要删除此行？"},on:{confirm:function(t){return e.remove(a.key)}}},[r("a",[e._v("删除")])])],1):r("span",[r("a",{on:{click:function(t){return e.saveRow(a)}}},[e._v("保存")]),r("a-divider",{attrs:{type:"vertical"}}),r("a",{on:{click:function(t){return e.cancel(a.key)}}},[e._v("取消")])],1)]:r("span",[r("a",{on:{click:function(t){return e.toggle(a.key)}}},[e._v("编辑")]),r("a-divider",{attrs:{type:"vertical"}}),r("a-popconfirm",{attrs:{title:"是否要删除此行？"},on:{confirm:function(t){return e.remove(a.key)}}},[r("a",[e._v("删除")])])],1)]}}],null,!0)}),r("a-button",{staticStyle:{width:"100%","margin-top":"16px","margin-bottom":"8px"},attrs:{type:"dashed",icon:"plus"},on:{click:e.newMember}},[e._v("新增成员")])],1),r("footer-tool-bar",{style:{width:e.isSideMenu()&&e.isDesktop()?"calc(100% - "+(e.sidebarOpened?256:80)+"px)":"100%"}},[r("span",{staticClass:"popover-wrapper"},[r("a-popover",{attrs:{title:"表单校验信息",overlayClassName:"antd-pro-pages-forms-style-errorPopover",trigger:"click",getPopupContainer:function(e){return e.parentNode}}},[r("template",{slot:"content"},e._l(e.errors,(function(t){return r("li",{key:t.key,staticClass:"antd-pro-pages-forms-style-errorListItem",on:{click:function(r){return e.scrollToField(t.key)}}},[r("a-icon",{staticClass:"antd-pro-pages-forms-style-errorIcon",attrs:{type:"cross-circle-o"}}),r("div",{},[e._v(e._s(t.message))]),r("div",{staticClass:"antd-pro-pages-forms-style-errorField"},[e._v(e._s(t.fieldLabel))])],1)})),0),e.errors.length>0?r("span",{staticClass:"antd-pro-pages-forms-style-errorIcon"},[r("a-icon",{attrs:{type:"exclamation-circle"}}),e._v(e._s(e.errors.length)+" ")],1):e._e()],2)],1),r("a-button",{attrs:{type:"primary",loading:e.loading},on:{click:e.validate}},[e._v("提交")])],1)],1)},o=[],n=(r("a4d3"),r("4de4"),r("7db0"),r("4160"),r("d81d"),r("0d03"),r("b0c0"),r("e439"),r("dbb4"),r("b64b"),r("d3b7"),r("e25e"),r("25f0"),r("3ca3"),r("159b"),r("ddb0"),r("284c")),s=r("2fa7"),i=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("a-form",{staticClass:"form",attrs:{form:e.form},on:{submit:e.handleSubmit}},[r("a-row",{staticClass:"form-row",attrs:{gutter:16}},[r("a-col",{attrs:{lg:6,md:12,sm:24}},[r("a-form-item",{attrs:{label:"仓库名"}},[r("a-input",{directives:[{name:"decorator",rawName:"v-decorator",value:["name",{rules:[{required:!0,message:"请输入仓库名称",whitespace:!0}]}],expression:"[\n            'name',\n            {rules: [{ required: true, message: '请输入仓库名称', whitespace: true}]}\n          ]"}],attrs:{placeholder:"请输入仓库名称"}})],1)],1),r("a-col",{attrs:{xl:{span:7,offset:1},lg:{span:8},md:{span:12},sm:24}},[r("a-form-item",{attrs:{label:"仓库域名"}},[r("a-input",{directives:[{name:"decorator",rawName:"v-decorator",value:["url",{rules:[{required:!0,message:"请输入仓库域名",whitespace:!0},{validator:e.validate}]}],expression:"[\n            'url',\n            {rules: [{ required: true, message: '请输入仓库域名', whitespace: true}, {validator: validate}]}\n          ]"}],attrs:{addonBefore:"http://",addonAfter:".com",placeholder:"请输入"}})],1)],1),r("a-col",{attrs:{xl:{span:9,offset:1},lg:{span:10},md:{span:24},sm:24}},[r("a-form-item",{attrs:{label:"仓库管理员"}},[r("a-select",{directives:[{name:"decorator",rawName:"v-decorator",value:["owner",{rules:[{required:!0,message:"请选择管理员"}]}],expression:"[ 'owner', {rules: [{ required: true, message: '请选择管理员'}]} ]"}],attrs:{placeholder:"请选择管理员"}},[r("a-select-option",{attrs:{value:"王同学"}},[e._v("王同学")]),r("a-select-option",{attrs:{value:"李同学"}},[e._v("李同学")]),r("a-select-option",{attrs:{value:"黄同学"}},[e._v("黄同学")])],1)],1)],1)],1),r("a-row",{staticClass:"form-row",attrs:{gutter:16}},[r("a-col",{attrs:{lg:6,md:12,sm:24}},[r("a-form-item",{attrs:{label:"审批人"}},[r("a-select",{directives:[{name:"decorator",rawName:"v-decorator",value:["approver",{rules:[{required:!0,message:"请选择审批员"}]}],expression:"[ 'approver', {rules: [{ required: true, message: '请选择审批员'}]} ]"}],attrs:{placeholder:"请选择审批员"}},[r("a-select-option",{attrs:{value:"王晓丽"}},[e._v("王晓丽")]),r("a-select-option",{attrs:{value:"李军"}},[e._v("李军")])],1)],1)],1),r("a-col",{attrs:{xl:{span:7,offset:1},lg:{span:8},md:{span:12},sm:24}},[r("a-form-item",{attrs:{label:"生效日期"}},[r("a-range-picker",{directives:[{name:"decorator",rawName:"v-decorator",value:["dateRange",{rules:[{required:!0,message:"请选择生效日期"}]}],expression:"[\n            'dateRange',\n            {rules: [{ required: true, message: '请选择生效日期'}]}\n          ]"}],staticStyle:{width:"100%"}})],1)],1),r("a-col",{attrs:{xl:{span:9,offset:1},lg:{span:10},md:{span:24},sm:24}},[r("a-form-item",{attrs:{label:"仓库类型"}},[r("a-select",{directives:[{name:"decorator",rawName:"v-decorator",value:["type",{rules:[{required:!0,message:"请选择仓库类型"}]}],expression:"[\n            'type',\n            {rules: [{ required: true, message: '请选择仓库类型'}]}\n          ]"}],attrs:{placeholder:"请选择仓库类型"}},[r("a-select-option",{attrs:{value:"公开"}},[e._v("公开")]),r("a-select-option",{attrs:{value:"私密"}},[e._v("私密")])],1)],1)],1)],1),e.showSubmit?r("a-form-item",[r("a-button",{attrs:{htmlType:"submit"}},[e._v("Submit")])],1):e._e()],1)},l=[],c={name:"RepositoryForm",props:{showSubmit:{type:Boolean,default:!1}},data:function(){return{form:this.$form.createForm(this)}},methods:{handleSubmit:function(e){var t=this;e.preventDefault(),this.form.validateFields((function(e,r){e||t.$notification["error"]({message:"Received values of form:",description:r})}))},validate:function(e,t,r){var a=/^user-(.*)$/;a.test(t)||r(new Error("需要以 user- 开头")),r()}}},u=c,d=r("2877"),m=Object(d["a"])(u,i,l,!1,null,"3ae25108",null),p=m.exports,f=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("a-form",{staticClass:"form",attrs:{form:e.form},on:{submit:e.handleSubmit}},[r("a-row",{staticClass:"form-row",attrs:{gutter:16}},[r("a-col",{attrs:{lg:6,md:12,sm:24}},[r("a-form-item",{attrs:{label:"任务名"}},[r("a-input",{directives:[{name:"decorator",rawName:"v-decorator",value:["name2",{rules:[{required:!0,message:"请输入任务名称",whitespace:!0}]}],expression:"[ 'name2', {rules: [{ required: true, message: '请输入任务名称', whitespace: true}]} ]"}],attrs:{placeholder:"请输入任务名称"}})],1)],1),r("a-col",{attrs:{xl:{span:7,offset:1},lg:{span:8},md:{span:12},sm:24}},[r("a-form-item",{attrs:{label:"任务描述"}},[r("a-input",{directives:[{name:"decorator",rawName:"v-decorator",value:["url2",{rules:[{required:!0,message:"请输入任务描述",whitespace:!0}]}],expression:"[ 'url2', {rules: [{ required: true, message: '请输入任务描述', whitespace: true}]} ]"}],attrs:{placeholder:"请输入任务描述"}})],1)],1),r("a-col",{attrs:{xl:{span:9,offset:1},lg:{span:10},md:{span:24},sm:24}},[r("a-form-item",{attrs:{label:"执行人"}},[r("a-select",{directives:[{name:"decorator",rawName:"v-decorator",value:["owner2",{rules:[{required:!0,message:"请选择执行人"}]}],expression:"[\n            'owner2',\n            {rules: [{ required: true, message: '请选择执行人'}]}\n          ]"}],attrs:{placeholder:"请选择执行人"}},[r("a-select-option",{attrs:{value:"黄丽丽"}},[e._v("黄丽丽")]),r("a-select-option",{attrs:{value:"李大刀"}},[e._v("李大刀")])],1)],1)],1)],1),r("a-row",{staticClass:"form-row",attrs:{gutter:16}},[r("a-col",{attrs:{lg:6,md:12,sm:24}},[r("a-form-item",{attrs:{label:"责任人"}},[r("a-select",{directives:[{name:"decorator",rawName:"v-decorator",value:["approver2",{rules:[{required:!0,message:"请选择责任人"}]}],expression:"[\n            'approver2',\n            {rules: [{ required: true, message: '请选择责任人'}]}\n          ]"}],attrs:{placeholder:"请选择责任人"}},[r("a-select-option",{attrs:{value:"王伟"}},[e._v("王伟")]),r("a-select-option",{attrs:{value:"李红军"}},[e._v("李红军")])],1)],1)],1),r("a-col",{attrs:{xl:{span:7,offset:1},lg:{span:8},md:{span:12},sm:24}},[r("a-form-item",{attrs:{label:"提醒时间"}},[r("a-time-picker",{directives:[{name:"decorator",rawName:"v-decorator",value:["dateRange2",{rules:[{required:!0,message:"请选择提醒时间"}]}],expression:"[\n            'dateRange2',\n            {rules: [{ required: true, message: '请选择提醒时间'}]}\n          ]"}],staticStyle:{width:"100%"}})],1)],1),r("a-col",{attrs:{xl:{span:9,offset:1},lg:{span:10},md:{span:24},sm:24}},[r("a-form-item",{attrs:{label:"任务类型"}},[r("a-select",{directives:[{name:"decorator",rawName:"v-decorator",value:["type2",{rules:[{required:!0,message:"请选择任务类型"}]}],expression:"[ 'type2', {rules: [{ required: true, message: '请选择任务类型'}]} ]"}],attrs:{placeholder:"请选择任务类型"}},[r("a-select-option",{attrs:{value:"定时执行"}},[e._v("定时执行")]),r("a-select-option",{attrs:{value:"周期执行"}},[e._v("周期执行")])],1)],1)],1)],1),e.showSubmit?r("a-form-item",[r("a-button",{attrs:{htmlType:"submit"}},[e._v("Submit")])],1):e._e()],1)},v=[],g={name:"TaskForm",props:{showSubmit:{type:Boolean,default:!1}},data:function(){return{form:this.$form.createForm(this)}},methods:{handleSubmit:function(e){var t=this;e.preventDefault(),this.form.validateFields((function(e,r){e||t.$notification["error"]({message:"Received values of form:",description:r})}))}}},h=g,b=Object(d["a"])(h,f,v,!1,null,"1aedc784",null),y=b.exports,w=r("5a70"),k=r("ac0d");function _(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(e);t&&(a=a.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,a)}return r}function x(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?_(r,!0).forEach((function(t){Object(s["a"])(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):_(r).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}var S={name:"仓库名",url:"仓库域名",owner:"仓库管理员",approver:"审批人",dateRange:"生效日期",type:"仓库类型",name2:"任务名",url2:"任务描述",owner2:"执行人",approver2:"责任人",dateRange2:"生效日期",type2:"任务类型"},O={name:"AdvancedForm",mixins:[k["b"],k["c"]],components:{FooterToolBar:w["a"],RepositoryForm:p,TaskForm:y},data:function(){return{description:"高级表单常见于一次性输入和提交大批量数据的场景。",loading:!1,memberLoading:!1,columns:[{title:"成员姓名",dataIndex:"name",key:"name",width:"20%",scopedSlots:{customRender:"name"}},{title:"工号",dataIndex:"workId",key:"workId",width:"20%",scopedSlots:{customRender:"workId"}},{title:"所属部门",dataIndex:"department",key:"department",width:"40%",scopedSlots:{customRender:"department"}},{title:"操作",key:"action",scopedSlots:{customRender:"operation"}}],data:[{key:"1",name:"小明",workId:"001",editable:!1,department:"行政部"},{key:"2",name:"李莉",workId:"002",editable:!1,department:"IT部"},{key:"3",name:"王小帅",workId:"003",editable:!1,department:"财务部"}],errors:[]}},methods:{handleSubmit:function(e){e.preventDefault()},newMember:function(){var e=this.data.length;this.data.push({key:0===e?"1":(parseInt(this.data[e-1].key)+1).toString(),name:"",workId:"",department:"",editable:!0,isNew:!0})},remove:function(e){var t=this.data.filter((function(t){return t.key!==e}));this.data=t},saveRow:function(e){var t=this;this.memberLoading=!0;var r=e.key,a=e.name,o=e.workId,n=e.department;if(!a||!o||!n)return this.memberLoading=!1,void this.$message.error("请填写完整成员信息。");new Promise((function(e){setTimeout((function(){e({loop:!1})}),800)})).then((function(){var e=t.data.find((function(e){return e.key===r}));e.editable=!1,e.isNew=!1,t.memberLoading=!1}))},toggle:function(e){var t=this.data.find((function(t){return t.key===e}));t._originalData=x({},t),t.editable=!t.editable},getRowByKey:function(e,t){var r=this.data;return(t||r).find((function(t){return t.key===e}))},cancel:function(e){var t=this.data.find((function(t){return t.key===e}));Object.keys(t).forEach((function(e){t[e]=t._originalData[e]})),t._originalData=void 0},handleChange:function(e,t,r){var a=Object(n["a"])(this.data),o=a.find((function(e){return t===e.key}));o&&(o[r]=e,this.data=a)},validate:function(){var e=this,t=this.$refs,r=t.repository,a=t.task,o=this.$notification,n=new Promise((function(e,t){r.form.validateFields((function(r,a){r?t(r):e(a)}))})),s=new Promise((function(e,t){a.form.validateFields((function(r,a){r?t(r):e(a)}))}));this.errors=[],Promise.all([n,s]).then((function(e){o["error"]({message:"Received values of form:",description:JSON.stringify(e)})})).catch((function(){var t=Object.assign({},r.form.getFieldsError(),a.form.getFieldsError()),o=x({},t);e.errorList(o)}))},errorList:function(e){e&&0!==e.length&&(this.errors=Object.keys(e).filter((function(t){return e[t]})).map((function(t){return{key:t,message:e[t][0],fieldLabel:S[t]}})))},scrollToField:function(e){var t=document.querySelector('label[for="'.concat(e,'"]'));t&&t.scrollIntoView(!0)}}},q=O,j=(r("06217"),Object(d["a"])(q,a,o,!1,null,"3e3d8762",null));t["default"]=j.exports},"74e7":function(e,t,r){e.exports=r("bc59")},"7de7":function(e,t,r){var a=r("0363"),o=a("iterator"),n=!1;try{var s=0,i={next:function(){return{done:!!s++}},return:function(){n=!0}};i[o]=function(){return this},Array.from(i,(function(){throw 2}))}catch(l){}e.exports=function(e,t){if(!t&&!n)return!1;var r=!1;try{var a={};a[o]=function(){return{next:function(){return{done:r=!0}}}},e(a)}catch(l){}return r}},a06f:function(e,t,r){e.exports=r("74e7")},bc59:function(e,t,r){r("3e47"),r("484e");var a=r("764b");e.exports=a.Array.from},faaa:function(e,t,r){var a=r("6f8d");e.exports=function(e,t,r,o){try{return o?t(a(r)[0],r[1]):t(r)}catch(s){var n=e["return"];throw void 0!==n&&a(n.call(e)),s}}}}]);