import { defineComponent, mergeProps, withCtx, createVNode, createBlock, createTextVNode, openBlock, useSSRContext } from "vue";
import { ssrRenderComponent } from "vue/server-renderer";
import { _ as _sfc_main$1 } from "./AppLayout-CIdlfk5v.js";
import { usePage } from "@inertiajs/vue3";
import "./AppSidebarHeader-B_TpS-cF.js";
import "./AppLogoIcon-DWigOKpl.js";
import "class-variance-authority";
import "clsx";
import "tailwind-merge";
import "reka-ui";
import "lucide-vue-next";
import "@vueuse/core";
import "./Input-CVdQgNF2.js";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Information",
  __ssrInlineRender: true,
  setup(__props) {
    usePage();
    const breadcrumbs = [
      { title: "Informasi", href: "/informasi" }
    ];
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(_sfc_main$1, mergeProps({ breadcrumbs }, _attrs), {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="flex justify-start min-h-screen p-6"${_scopeId}><div class="w-full p-4"${_scopeId}><h1 class="text-3xl font-bold mb-8 text-center"${_scopeId}>Informasi</h1><div class="grid grid-cols-1 md:grid-cols-3 gap-6"${_scopeId}><div class="bg-white p-6 rounded-xl shadow"${_scopeId}><h2 class="text-lg font-semibold flex items-center mb-4"${_scopeId}><svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20"${_scopeId}><path d="M6 2a1 1 0 011 1v1h6V3a1 1 0 112 0v1h1a2 2 0 012 2v2H3V6a2 2 0 012-2h1V3a1 1 0 011-1zM3 9h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"${_scopeId}></path></svg> Libur </h2><p class="text-sm text-gray-500 mb-3"${_scopeId}>Libur di tahun 2025:</p><ul class="space-y-2 text-gray-700 text-sm"${_scopeId}><li${_scopeId}>✅ Hari Buruh Nasional - 1 Mei</li><li${_scopeId}>✅ Hari Raya Waisak - 12, 13 Mei</li><li${_scopeId}>✅ Kenaikan Isa Al Masih - 29, 30 Mei</li></ul></div><div class="bg-white p-6 rounded-xl shadow"${_scopeId}><h2 class="text-lg font-semibold flex items-center mb-4"${_scopeId}><svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20"${_scopeId}><path d="M9.293 9.293a1 1 0 011.414 0L15 13.586V5a1 1 0 112 0v12a1 1 0 01-1 1H5a1 1 0 110-2h8.586l-4.293-4.293a1 1 0 010-1.414z"${_scopeId}></path></svg> Pengumuman Perusahaan </h2><h3 class="font-semibold text-gray-800 mb-2"${_scopeId}>Renovasi Kantor</h3><p class="text-sm text-gray-700"${_scopeId}> Renovasi lantai 3 dimulai minggu depan. Harap ikuti pengaturan sementara. </p></div><div class="bg-white p-6 rounded-xl shadow"${_scopeId}><h2 class="text-lg font-semibold flex items-center mb-4"${_scopeId}><svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20"${_scopeId}><path d="M13 7a3 3 0 100-6 3 3 0 000 6zM3 6a3 3 0 100-6 3 3 0 000 6zm7 8a5 5 0 00-5 5H0a8 8 0 0116 0h-5a5 5 0 00-5-5zM3 14a5 5 0 015-5h4a5 5 0 015 5v1H3v-1z"${_scopeId}></path></svg> Aktivitas Tim </h2><h3 class="font-semibold text-gray-800 mb-2"${_scopeId}>Team Workshop</h3><p class="text-sm text-gray-700"${_scopeId}>10 Juni 2025</p></div></div></div></div>`);
          } else {
            return [
              createVNode("div", { class: "flex justify-start min-h-screen p-6" }, [
                createVNode("div", { class: "w-full p-4" }, [
                  createVNode("h1", { class: "text-3xl font-bold mb-8 text-center" }, "Informasi"),
                  createVNode("div", { class: "grid grid-cols-1 md:grid-cols-3 gap-6" }, [
                    createVNode("div", { class: "bg-white p-6 rounded-xl shadow" }, [
                      createVNode("h2", { class: "text-lg font-semibold flex items-center mb-4" }, [
                        (openBlock(), createBlock("svg", {
                          class: "w-5 h-5 mr-2 text-blue-600",
                          fill: "currentColor",
                          viewBox: "0 0 20 20"
                        }, [
                          createVNode("path", { d: "M6 2a1 1 0 011 1v1h6V3a1 1 0 112 0v1h1a2 2 0 012 2v2H3V6a2 2 0 012-2h1V3a1 1 0 011-1zM3 9h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" })
                        ])),
                        createTextVNode(" Libur ")
                      ]),
                      createVNode("p", { class: "text-sm text-gray-500 mb-3" }, "Libur di tahun 2025:"),
                      createVNode("ul", { class: "space-y-2 text-gray-700 text-sm" }, [
                        createVNode("li", null, "✅ Hari Buruh Nasional - 1 Mei"),
                        createVNode("li", null, "✅ Hari Raya Waisak - 12, 13 Mei"),
                        createVNode("li", null, "✅ Kenaikan Isa Al Masih - 29, 30 Mei")
                      ])
                    ]),
                    createVNode("div", { class: "bg-white p-6 rounded-xl shadow" }, [
                      createVNode("h2", { class: "text-lg font-semibold flex items-center mb-4" }, [
                        (openBlock(), createBlock("svg", {
                          class: "w-5 h-5 mr-2 text-blue-600",
                          fill: "currentColor",
                          viewBox: "0 0 20 20"
                        }, [
                          createVNode("path", { d: "M9.293 9.293a1 1 0 011.414 0L15 13.586V5a1 1 0 112 0v12a1 1 0 01-1 1H5a1 1 0 110-2h8.586l-4.293-4.293a1 1 0 010-1.414z" })
                        ])),
                        createTextVNode(" Pengumuman Perusahaan ")
                      ]),
                      createVNode("h3", { class: "font-semibold text-gray-800 mb-2" }, "Renovasi Kantor"),
                      createVNode("p", { class: "text-sm text-gray-700" }, " Renovasi lantai 3 dimulai minggu depan. Harap ikuti pengaturan sementara. ")
                    ]),
                    createVNode("div", { class: "bg-white p-6 rounded-xl shadow" }, [
                      createVNode("h2", { class: "text-lg font-semibold flex items-center mb-4" }, [
                        (openBlock(), createBlock("svg", {
                          class: "w-5 h-5 mr-2 text-blue-600",
                          fill: "currentColor",
                          viewBox: "0 0 20 20"
                        }, [
                          createVNode("path", { d: "M13 7a3 3 0 100-6 3 3 0 000 6zM3 6a3 3 0 100-6 3 3 0 000 6zm7 8a5 5 0 00-5 5H0a8 8 0 0116 0h-5a5 5 0 00-5-5zM3 14a5 5 0 015-5h4a5 5 0 015 5v1H3v-1z" })
                        ])),
                        createTextVNode(" Aktivitas Tim ")
                      ]),
                      createVNode("h3", { class: "font-semibold text-gray-800 mb-2" }, "Team Workshop"),
                      createVNode("p", { class: "text-sm text-gray-700" }, "10 Juni 2025")
                    ])
                  ])
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/pages/Information.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
