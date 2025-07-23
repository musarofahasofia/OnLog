import { defineComponent, computed, createVNode, resolveDynamicComponent, mergeProps, useSSRContext, ref, onMounted, watch, withCtx, unref, createTextVNode, createBlock, openBlock, Fragment, renderList, toDisplayString } from "vue";
import { ssrRenderVNode, ssrRenderComponent, ssrRenderList, ssrInterpolate, ssrRenderClass } from "vue/server-renderer";
import { _ as _sfc_main$2 } from "./AppLayout-CIdlfk5v.js";
import { c as cn } from "./AppLogoIcon-DWigOKpl.js";
import * as icons from "lucide-vue-next";
import Datepicker from "@vuepic/vue-datepicker";
import axios from "axios";
import "./AppSidebarHeader-B_TpS-cF.js";
import "@inertiajs/vue3";
import "reka-ui";
import "@vueuse/core";
import "class-variance-authority";
import "./Input-CVdQgNF2.js";
import "clsx";
import "tailwind-merge";
const _sfc_main$1 = /* @__PURE__ */ defineComponent({
  __name: "Icon",
  __ssrInlineRender: true,
  props: {
    name: {},
    class: { default: "" },
    size: { default: 16 },
    color: {},
    strokeWidth: { default: 2 }
  },
  setup(__props) {
    const props = __props;
    const className = computed(() => cn("h-4 w-4", props.class));
    const icon = computed(() => {
      const iconName = props.name.charAt(0).toUpperCase() + props.name.slice(1);
      return icons[iconName];
    });
    return (_ctx, _push, _parent, _attrs) => {
      ssrRenderVNode(_push, createVNode(resolveDynamicComponent(icon.value), mergeProps({
        class: className.value,
        size: _ctx.size,
        "stroke-width": _ctx.strokeWidth,
        color: _ctx.color
      }, _attrs), null), _parent);
    };
  }
});
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/Icon.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "AttendanceHistory",
  __ssrInlineRender: true,
  setup(__props) {
    const today = /* @__PURE__ */ new Date();
    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    const selectedDate = ref([startOfMonth, today]);
    const absens = ref([]);
    const loading = ref(true);
    const fetchAbsens = async () => {
      loading.value = true;
      const [startDate, endDate] = selectedDate.value.map((d) => d == null ? void 0 : d.toISOString().split("T")[0]);
      try {
        const response = await axios.get("/history/findmany", {
          params: {
            start_date: startDate,
            end_date: endDate
          }
        });
        absens.value = response.data;
        console.log;
      } catch (error) {
        console.error("Gagal fetch data absens:", error);
      } finally {
        loading.value = false;
      }
    };
    onMounted(fetchAbsens);
    watch(selectedDate, fetchAbsens);
    const breadcrumbs = [
      { title: "Riwayat Absen", href: "/absensi" }
    ];
    function badgeClass(status) {
      switch (status) {
        case "Hadir":
          return "bg-green-100 text-green-800";
        case "Terlambat":
          return "bg-yellow-100 text-yellow-800";
        case "Tidak Hadir":
          return "bg-red-100 text-red-800";
        default:
          return "bg-gray-100 text-gray-800";
      }
    }
    const exportExcel = () => {
      const [start, end] = selectedDate.value.map((d) => d.toISOString().split("T")[0]);
      const url = `/history/export?start_date=${start}&end_date=${end}`;
      window.open(url, "_blank");
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(_sfc_main$2, mergeProps({ breadcrumbs }, _attrs), {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="p-6 space-y-6"${_scopeId}><div class="flex justify-between items-center"${_scopeId}><h2 class="text-2xl font-bold"${_scopeId}>Riwayat Absen</h2><button class="flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$1, { name: "download" }, null, _parent2, _scopeId));
            _push2(` Download </button></div><div class="w-3xs"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(Datepicker), {
              modelValue: selectedDate.value,
              "onUpdate:modelValue": ($event) => selectedDate.value = $event,
              range: true,
              "enable-time-picker": false,
              "max-date": /* @__PURE__ */ new Date()
            }, null, _parent2, _scopeId));
            _push2(`</div><div class="overflow-x-auto rounded shadow border"${_scopeId}><table class="min-w-full text-sm text-left"${_scopeId}><thead class="bg-gray-50"${_scopeId}><tr${_scopeId}><th class="px-4 py-3"${_scopeId}>Tanggal</th><th class="px-4 py-3"${_scopeId}>Absen Masuk</th><th class="px-4 py-3"${_scopeId}>Absen Pulang</th><th class="px-4 py-3"${_scopeId}>Keterangan</th></tr></thead><tbody${_scopeId}>`);
            if (loading.value) {
              _push2(`<tr${_scopeId}><td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500"${_scopeId}> Loading data... </td></tr>`);
            } else if (absens.value.length) {
              _push2(`<!--[-->`);
              ssrRenderList(absens.value, (r) => {
                _push2(`<tr class="border-t"${_scopeId}><td class="px-4 py-3"${_scopeId}>${ssrInterpolate(r.date)}</td><td class="px-4 py-3"${_scopeId}>${ssrInterpolate(r.clock_in)}</td><td class="px-4 py-3"${_scopeId}>${ssrInterpolate(r.clock_out)}</td><td class="px-4 py-3"${_scopeId}><span class="${ssrRenderClass([badgeClass(r.status), "px-2 py-1 text-xs font-medium rounded"])}"${_scopeId}>${ssrInterpolate(r.status)}</span></td></tr>`);
              });
              _push2(`<!--]-->`);
            } else {
              _push2(`<tr${_scopeId}><td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500"${_scopeId}> Data absen kosong. </td></tr>`);
            }
            _push2(`</tbody></table></div></div>`);
          } else {
            return [
              createVNode("div", { class: "p-6 space-y-6" }, [
                createVNode("div", { class: "flex justify-between items-center" }, [
                  createVNode("h2", { class: "text-2xl font-bold" }, "Riwayat Absen"),
                  createVNode("button", {
                    class: "flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600",
                    onClick: exportExcel
                  }, [
                    createVNode(_sfc_main$1, { name: "download" }),
                    createTextVNode(" Download ")
                  ])
                ]),
                createVNode("div", { class: "w-3xs" }, [
                  createVNode(unref(Datepicker), {
                    modelValue: selectedDate.value,
                    "onUpdate:modelValue": ($event) => selectedDate.value = $event,
                    range: true,
                    "enable-time-picker": false,
                    "max-date": /* @__PURE__ */ new Date()
                  }, null, 8, ["modelValue", "onUpdate:modelValue", "max-date"])
                ]),
                createVNode("div", { class: "overflow-x-auto rounded shadow border" }, [
                  createVNode("table", { class: "min-w-full text-sm text-left" }, [
                    createVNode("thead", { class: "bg-gray-50" }, [
                      createVNode("tr", null, [
                        createVNode("th", { class: "px-4 py-3" }, "Tanggal"),
                        createVNode("th", { class: "px-4 py-3" }, "Absen Masuk"),
                        createVNode("th", { class: "px-4 py-3" }, "Absen Pulang"),
                        createVNode("th", { class: "px-4 py-3" }, "Keterangan")
                      ])
                    ]),
                    createVNode("tbody", null, [
                      loading.value ? (openBlock(), createBlock("tr", { key: 0 }, [
                        createVNode("td", {
                          colspan: "4",
                          class: "px-4 py-3 text-center text-sm text-gray-500"
                        }, " Loading data... ")
                      ])) : absens.value.length ? (openBlock(true), createBlock(Fragment, { key: 1 }, renderList(absens.value, (r) => {
                        return openBlock(), createBlock("tr", {
                          key: r.id,
                          class: "border-t"
                        }, [
                          createVNode("td", { class: "px-4 py-3" }, toDisplayString(r.date), 1),
                          createVNode("td", { class: "px-4 py-3" }, toDisplayString(r.clock_in), 1),
                          createVNode("td", { class: "px-4 py-3" }, toDisplayString(r.clock_out), 1),
                          createVNode("td", { class: "px-4 py-3" }, [
                            createVNode("span", {
                              class: ["px-2 py-1 text-xs font-medium rounded", badgeClass(r.status)]
                            }, toDisplayString(r.status), 3)
                          ])
                        ]);
                      }), 128)) : (openBlock(), createBlock("tr", { key: 2 }, [
                        createVNode("td", {
                          colspan: "4",
                          class: "px-4 py-3 text-center text-sm text-gray-500"
                        }, " Data absen kosong. ")
                      ]))
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/pages/AttendanceHistory.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
