webpackJsonp([3,6],{526:function(t,e,s){var i=s(0)(s(555),s(556),function(t){s(553)},null,null);t.exports=i.exports},533:function(t,e,s){var i=s(0)(s(569),s(570),null,null,null);t.exports=i.exports},553:function(t,e,s){var i=s(554);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);s(520)("2ec93300",i,!0)},554:function(t,e,s){(t.exports=s(519)(!0)).push([t.i,"\n.modal-card, .modal-content {\n    width: 1100px;\n}\n","",{version:3,sources:["C:/OSPanel/domains/scandinaver/scandinaver/resources/assets/sub/backend/client/views/texts/Modal.vue"],names:[],mappings:";AACA;IACI,cAAc;CACjB",file:"Modal.vue",sourcesContent:["\n.modal-card, .modal-content {\n    width: 1100px;\n}\n"],sourceRoot:""}])},555:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:["visible"],data:function(){return{form:{title:"",origtext:"",translate:""}}},methods:{close:function(){this.$emit("close")}}}},556:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("b-modal",{attrs:{active:t.visible},on:{"update:active":function(e){t.visible=e},close:t.close}},[s("div",{staticClass:"box",staticStyle:{width:"1100px"}},[s("div",{staticClass:"columns"},[s("div",{staticClass:"column"},[s("p",{staticClass:"control"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.form.title,expression:"form.title"}],staticClass:"input",attrs:{type:"text",placeholder:"Название"},domProps:{value:t.form.title},on:{input:function(e){e.target.composing||t.$set(t.form,"title",e.target.value)}}})])])]),t._v(" "),s("div",{staticClass:"columns"},[s("div",{staticClass:"column is-6"},[s("p",{staticClass:"control content"},[s("textarea",{directives:[{name:"model",rawName:"v-model",value:t.form.origtext,expression:"form.origtext"}],staticClass:"textarea",staticStyle:{height:"500px"},attrs:{placeholder:"оригинал"},domProps:{value:t.form.origtext},on:{input:function(e){e.target.composing||t.$set(t.form,"origtext",e.target.value)}}})])]),t._v(" "),s("div",{staticClass:"column is-6"},[s("p",{staticClass:"control content"},[s("textarea",{directives:[{name:"model",rawName:"v-model",value:t.form.translate,expression:"form.translate"}],staticClass:"textarea",staticStyle:{height:"500px"},attrs:{placeholder:"перевод"},domProps:{value:t.form.translate},on:{input:function(e){e.target.composing||t.$set(t.form,"translate",e.target.value)}}})])])]),t._v(" "),s("div",{staticClass:"columns"},[s("div",{staticClass:"column"},[s("button",{staticClass:"button is-succes",on:{click:function(e){t.$emit("save",t.form)}}},[t._v("Сохранить")])])])])])},staticRenderFns:[]}},569:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=function(t){return t&&t.__esModule?t:{default:t}}(s(526));e.default={components:{Modal:i.default},data:function(){return{form:{title:"",origtext:"",translate:""},texts:[],isComponentModalActive:!1}},computed:{},methods:{icon:function(t){return t.published?"eye":"eye-off"},load:function(){var t=this;this.$http.get("/admin/texts").then(function(e){t.texts=e.body},function(t){console.log(t)})},remove:function(t){var e=this;confirm("удалить?")&&this.$http.delete("/admin/text/"+t.id).then(function(t){e.load()},function(t){console.log(t)})},edit:function(t){this.$router.push({name:"textedit",params:{id:t.id}})},add:function(t){var e=this;this.$http.post("/admin/text",this.form).then(function(t){t.body.success?(e.$snackbar.open("Загружено"),e.load(),e.closeSettingsModal()):e.$snackbar.open("Ошибка")},function(t){console.log(t)})},setVisibility:function(t){var e=this;this.$http.post("/admin/text/publish",{id:t.id,published:t.published?"0":"1"}).then(function(t){t.body.success?e.load():e.$snackbar.open("Ошибка")},function(t){console.log(t)})},showSettingsModal:function(){this.isComponentModalActive=!0},closeSettingsModal:function(){this.isComponentModalActive=!1}},mounted:function(){this.load()}}},570:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("div",{staticClass:"tile is-ancestor"},[s("div",{staticClass:"tile is-parent"},[s("article",{staticClass:"tile is-child box"},[s("h4",{staticClass:"title text-center"},[t._v("Тексты")]),t._v(" "),s("button",{staticClass:"button is-small",staticStyle:{margin:"10px 0"},on:{click:t.showSettingsModal}},[t._v("Добавить")]),t._v(" "),s("b-table",{attrs:{data:t.texts,paginated:"",narrowed:"",loading:t.loading,"per-page":"10"},scopedSlots:t._u([{key:"default",fn:function(e){return[s("b-table-column",{attrs:{field:"id",label:"ID",width:"40",sortable:"",numeric:""}},[t._v("\n                            "+t._s(e.row.id)+"\n                        ")]),t._v(" "),s("b-table-column",{attrs:{field:"level",label:"level",sortable:""}},[t._v("\n                            "+t._s(e.row.level)+"\n                        ")]),t._v(" "),s("b-table-column",{attrs:{field:"title",label:"title",sortable:""}},[t._v("\n                            "+t._s(e.row.title)+"\n                        ")]),t._v(" "),s("b-table-column",{attrs:{field:"description",label:"description",sortable:""}},[t._v("\n                            "+t._s(e.row.description)+"\n                        ")]),t._v(" "),s("b-table-column",{attrs:{field:"image",label:"",width:"90"}},[s("img",{class:["avatar-small"],attrs:{src:e.row.image}})]),t._v(" "),s("b-table-column",{attrs:{"custom-key":"actions"}},[s("button",{staticClass:"button  is-warning",on:{click:function(s){t.edit(e.row)}}},[s("b-icon",{attrs:{icon:"account-edit",size:"is-small"}})],1),t._v(" "),s("button",{staticClass:"button  is-warning",on:{click:function(s){t.setVisibility(e.row)}}},[s("b-icon",{attrs:{icon:t.icon(e.row),size:"is-small"}})],1),t._v(" "),s("button",{staticClass:"button  is-danger",on:{click:function(s){t.remove(e.row)}}},[s("b-icon",{attrs:{icon:"account-remove",size:"is-small"}})],1)])]}}])})],1)])]),t._v(" "),s("b-modal",{attrs:{active:t.isComponentModalActive},on:{"update:active":function(e){t.isComponentModalActive=e},close:t.close}},[s("div",{staticClass:"box",staticStyle:{width:"1100px"}},[s("div",{staticClass:"columns"},[s("div",{staticClass:"column"},[s("p",{staticClass:"control"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.form.title,expression:"form.title"}],staticClass:"input",attrs:{type:"text",placeholder:"Название"},domProps:{value:t.form.title},on:{input:function(e){e.target.composing||t.$set(t.form,"title",e.target.value)}}})])])]),t._v(" "),s("div",{staticClass:"columns"},[s("div",{staticClass:"column is-6"},[s("b-field",{attrs:{label:"оригинал"}},[s("b-input",{staticStyle:{height:"500px"},attrs:{type:"textarea"},model:{value:t.form.origtext,callback:function(e){t.$set(t.form,"origtext",e)},expression:"form.origtext"}})],1)],1),t._v(" "),s("div",{staticClass:"column is-6"},[s("b-field",{attrs:{label:"перевод"}},[s("b-input",{staticStyle:{height:"500px"},attrs:{type:"textarea"},model:{value:t.form.translate,callback:function(e){t.$set(t.form,"translate",e)},expression:"form.translate"}})],1)],1)]),t._v(" "),s("div",{staticClass:"columns"},[s("div",{staticClass:"column"},[s("button",{staticClass:"button is-succes",on:{click:t.add}},[t._v("Сохранить")])])])])])],1)},staticRenderFns:[]}}});
//# sourceMappingURL=3.b426609a5cdcc8330ff1.js.map