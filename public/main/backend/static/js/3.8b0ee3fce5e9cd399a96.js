webpackJsonp([3],{508:function(t,n,e){var s=e(0)(e(530),e(531),null,null,null);t.exports=s.exports},530:function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default={data:function(){return{pages:[],newpage:{url:"",title:"",description:"",keywords:""}}},mounted:function(){this.load()},methods:{load:function(){var t=this;this.$http.get("/admin/meta").then(function(n){t.pages=n.body},function(t){console.log(t)})},add:function(){this.$router.push({name:"Добавить страницу"})},remove:function(t){var n=this;confirm("Удалить?")&&this.$http.delete("/admin/meta/"+t.id).then(function(t){204===t.status?(n.$snackbar.open("Страница удалена!"),n.load()):n.$snackbar.open("Ошибка!")},function(t){n.$snackbar.open("Ошибка!"),console.log(t)})},edit:function(t){this.$router.push({name:"Страница",params:{id:t.id}})},find:function(){var t=this;this.$http.get("/admin/meta/search?q="+this.search).then(function(n){t.articles=n.body},function(n){t.$snackbar.open("Ошибка!"),console.log(n)})}}}},531:function(t,n){t.exports={render:function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("div",[e("div",{staticClass:"tile is-ancestor"},[e("div",{staticClass:"tile is-parent"},[e("article",{staticClass:"tile is-child box"},[e("div",{staticClass:"tile is-parent"},[e("a",{staticClass:"button is-success",on:{click:t.add}},[t._v("Добавить")]),t._v(" "),e("a",{staticClass:"button is-success",on:{click:t.find}},[t._v("Найти")])]),t._v(" "),e("b-table",{attrs:{data:t.pages,paginated:"",narrowed:"",loading:t.loading,"per-page":"10"},scopedSlots:t._u([{key:"default",fn:function(n){return[e("b-table-column",{attrs:{field:"id",label:"ID",width:"40",sortable:"",numeric:""}},[t._v("\n                            "+t._s(n.row.id)+"\n                        ")]),t._v(" "),e("b-table-column",{attrs:{field:"url",label:"url",sortable:""}},[t._v("\n                            "+t._s(n.row.url)+"\n                        ")]),t._v(" "),e("b-table-column",{attrs:{field:"title",label:"title",sortable:""}},[t._v("\n                            "+t._s(n.row.title)+"\n                        ")]),t._v(" "),e("b-table-column",{attrs:{field:"description",label:"description",sortable:""}},[t._v("\n                            "+t._s(n.row.description)+"\n                        ")]),t._v(" "),e("b-table-column",{attrs:{field:"keywords",label:"keywords",sortable:""}},[t._v("\n                            "+t._s(n.row.keywords)+"\n                        ")]),t._v(" "),e("b-table-column",{attrs:{"custom-key":"actions"}},[e("button",{staticClass:"button  is-warning",on:{click:function(e){t.edit(n.row)}}},[e("b-icon",{attrs:{icon:"account-edit",size:"is-small"}})],1),t._v(" "),e("button",{staticClass:"button  is-danger",on:{click:function(e){t.remove(n.row)}}},[e("b-icon",{attrs:{icon:"account-remove",size:"is-small"}})],1)])]}}])})],1)])])])},staticRenderFns:[]}}});
//# sourceMappingURL=3.8b0ee3fce5e9cd399a96.js.map