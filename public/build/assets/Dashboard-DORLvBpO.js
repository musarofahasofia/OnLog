import { defineComponent, unref, withCtx, createVNode, useSSRContext, mergeProps, renderSlot, createBlock, createCommentVNode, openBlock, toDisplayString, computed, ref, onMounted, createTextVNode } from "vue";
import { ssrRenderComponent, ssrRenderSlot, ssrInterpolate, ssrRenderStyle, ssrRenderAttr, ssrRenderClass, ssrIncludeBooleanAttr } from "vue/server-renderer";
import { _ as _sfc_main$4, a as _sfc_main$5, b as _sfc_main$6, c as _sfc_main$7, d as _sfc_main$8, e as _sfc_main$9, f as _sfc_main$a, g as _sfc_main$b, h as _sfc_main$c, i as _sfc_main$d, j as _sfc_main$e, k as _sfc_main$f, l as _sfc_main$g } from "./AppSidebarHeader-B_TpS-cF.js";
import { Link, usePage, router } from "@inertiajs/vue3";
import { User } from "lucide-vue-next";
import "./AppLogoIcon-DWigOKpl.js";
import "class-variance-authority";
import "clsx";
import "tailwind-merge";
import "reka-ui";
import "@vueuse/core";
import "./Input-CVdQgNF2.js";
const _sfc_main$3 = /* @__PURE__ */ defineComponent({
  __name: "AppSidebarAdmin",
  __ssrInlineRender: true,
  setup(__props) {
    const mainNavItems = [
      {
        title: "Dashboard",
        href: "/admin/dashboard",
        icon: User
      }
    ];
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(_sfc_main$4), {
        collapsible: "icon",
        variant: "inset"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(ssrRenderComponent(unref(_sfc_main$5), null, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(ssrRenderComponent(unref(_sfc_main$6), null, {
                    default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                      if (_push4) {
                        _push4(ssrRenderComponent(unref(_sfc_main$7), null, {
                          default: withCtx((_4, _push5, _parent5, _scopeId4) => {
                            if (_push5) {
                              _push5(ssrRenderComponent(unref(_sfc_main$8), {
                                size: "lg",
                                "as-child": ""
                              }, {
                                default: withCtx((_5, _push6, _parent6, _scopeId5) => {
                                  if (_push6) {
                                    _push6(ssrRenderComponent(unref(Link), {
                                      href: _ctx.route("admin.dashboard")
                                    }, {
                                      default: withCtx((_6, _push7, _parent7, _scopeId6) => {
                                        if (_push7) {
                                          _push7(ssrRenderComponent(_sfc_main$9, null, null, _parent7, _scopeId6));
                                        } else {
                                          return [
                                            createVNode(_sfc_main$9)
                                          ];
                                        }
                                      }),
                                      _: 1
                                    }, _parent6, _scopeId5));
                                  } else {
                                    return [
                                      createVNode(unref(Link), {
                                        href: _ctx.route("admin.dashboard")
                                      }, {
                                        default: withCtx(() => [
                                          createVNode(_sfc_main$9)
                                        ]),
                                        _: 1
                                      }, 8, ["href"])
                                    ];
                                  }
                                }),
                                _: 1
                              }, _parent5, _scopeId4));
                            } else {
                              return [
                                createVNode(unref(_sfc_main$8), {
                                  size: "lg",
                                  "as-child": ""
                                }, {
                                  default: withCtx(() => [
                                    createVNode(unref(Link), {
                                      href: _ctx.route("admin.dashboard")
                                    }, {
                                      default: withCtx(() => [
                                        createVNode(_sfc_main$9)
                                      ]),
                                      _: 1
                                    }, 8, ["href"])
                                  ]),
                                  _: 1
                                })
                              ];
                            }
                          }),
                          _: 1
                        }, _parent4, _scopeId3));
                      } else {
                        return [
                          createVNode(unref(_sfc_main$7), null, {
                            default: withCtx(() => [
                              createVNode(unref(_sfc_main$8), {
                                size: "lg",
                                "as-child": ""
                              }, {
                                default: withCtx(() => [
                                  createVNode(unref(Link), {
                                    href: _ctx.route("admin.dashboard")
                                  }, {
                                    default: withCtx(() => [
                                      createVNode(_sfc_main$9)
                                    ]),
                                    _: 1
                                  }, 8, ["href"])
                                ]),
                                _: 1
                              })
                            ]),
                            _: 1
                          })
                        ];
                      }
                    }),
                    _: 1
                  }, _parent3, _scopeId2));
                } else {
                  return [
                    createVNode(unref(_sfc_main$6), null, {
                      default: withCtx(() => [
                        createVNode(unref(_sfc_main$7), null, {
                          default: withCtx(() => [
                            createVNode(unref(_sfc_main$8), {
                              size: "lg",
                              "as-child": ""
                            }, {
                              default: withCtx(() => [
                                createVNode(unref(Link), {
                                  href: _ctx.route("admin.dashboard")
                                }, {
                                  default: withCtx(() => [
                                    createVNode(_sfc_main$9)
                                  ]),
                                  _: 1
                                }, 8, ["href"])
                              ]),
                              _: 1
                            })
                          ]),
                          _: 1
                        })
                      ]),
                      _: 1
                    })
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(unref(_sfc_main$a), null, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(ssrRenderComponent(_sfc_main$b, { items: mainNavItems }, null, _parent3, _scopeId2));
                } else {
                  return [
                    createVNode(_sfc_main$b, { items: mainNavItems })
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(unref(_sfc_main$c), null, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(ssrRenderComponent(_sfc_main$d, null, null, _parent3, _scopeId2));
                } else {
                  return [
                    createVNode(_sfc_main$d)
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
          } else {
            return [
              createVNode(unref(_sfc_main$5), null, {
                default: withCtx(() => [
                  createVNode(unref(_sfc_main$6), null, {
                    default: withCtx(() => [
                      createVNode(unref(_sfc_main$7), null, {
                        default: withCtx(() => [
                          createVNode(unref(_sfc_main$8), {
                            size: "lg",
                            "as-child": ""
                          }, {
                            default: withCtx(() => [
                              createVNode(unref(Link), {
                                href: _ctx.route("admin.dashboard")
                              }, {
                                default: withCtx(() => [
                                  createVNode(_sfc_main$9)
                                ]),
                                _: 1
                              }, 8, ["href"])
                            ]),
                            _: 1
                          })
                        ]),
                        _: 1
                      })
                    ]),
                    _: 1
                  })
                ]),
                _: 1
              }),
              createVNode(unref(_sfc_main$a), null, {
                default: withCtx(() => [
                  createVNode(_sfc_main$b, { items: mainNavItems })
                ]),
                _: 1
              }),
              createVNode(unref(_sfc_main$c), null, {
                default: withCtx(() => [
                  createVNode(_sfc_main$d)
                ]),
                _: 1
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`<!--]-->`);
    };
  }
});
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/AppSidebarAdmin.vue");
  return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const _sfc_main$2 = /* @__PURE__ */ defineComponent({
  __name: "AdminAppSidebarLayout",
  __ssrInlineRender: true,
  props: {
    breadcrumbs: { default: () => [] }
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(_sfc_main$e, mergeProps({ variant: "sidebar" }, _attrs), {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(ssrRenderComponent(_sfc_main$3, null, null, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$f, { variant: "sidebar" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(ssrRenderComponent(_sfc_main$g, { breadcrumbs: _ctx.breadcrumbs }, null, _parent3, _scopeId2));
                  ssrRenderSlot(_ctx.$slots, "default", {}, null, _push3, _parent3, _scopeId2);
                } else {
                  return [
                    createVNode(_sfc_main$g, { breadcrumbs: _ctx.breadcrumbs }, null, 8, ["breadcrumbs"]),
                    renderSlot(_ctx.$slots, "default")
                  ];
                }
              }),
              _: 3
            }, _parent2, _scopeId));
          } else {
            return [
              createVNode(_sfc_main$3),
              createVNode(_sfc_main$f, { variant: "sidebar" }, {
                default: withCtx(() => [
                  createVNode(_sfc_main$g, { breadcrumbs: _ctx.breadcrumbs }, null, 8, ["breadcrumbs"]),
                  renderSlot(_ctx.$slots, "default")
                ]),
                _: 3
              })
            ];
          }
        }),
        _: 3
      }, _parent));
    };
  }
});
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/layouts/app/AdminAppSidebarLayout.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const _sfc_main$1 = /* @__PURE__ */ defineComponent({
  __name: "AdminAppLayout",
  __ssrInlineRender: true,
  props: {
    breadcrumbs: { default: () => [] }
  },
  setup(__props) {
    const page = usePage();
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(_sfc_main$2, mergeProps({ breadcrumbs: _ctx.breadcrumbs }, _attrs), {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          var _a, _b;
          if (_push2) {
            ssrRenderSlot(_ctx.$slots, "default", {}, null, _push2, _parent2, _scopeId);
            if ((_a = unref(page).props.flash) == null ? void 0 : _a.message) {
              _push2(`<div class="p-4 text-green-700 bg-green-100 rounded"${_scopeId}>${ssrInterpolate(unref(page).props.flash.message)}</div>`);
            } else {
              _push2(`<!---->`);
            }
          } else {
            return [
              renderSlot(_ctx.$slots, "default"),
              ((_b = unref(page).props.flash) == null ? void 0 : _b.message) ? (openBlock(), createBlock("div", {
                key: 0,
                class: "p-4 text-green-700 bg-green-100 rounded"
              }, toDisplayString(unref(page).props.flash.message), 1)) : createCommentVNode("", true)
            ];
          }
        }),
        _: 3
      }, _parent));
    };
  }
});
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/layouts/AdminAppLayout.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Dashboard",
  __ssrInlineRender: true,
  setup(__props) {
    var _a;
    ((_a = document.querySelector('meta[name="csrf-token"]')) == null ? void 0 : _a.getAttribute("content")) ?? "";
    const page = usePage();
    const attendanceToday = computed(() => page.props.attendanceToday);
    const summary = computed(() => page.props.summary);
    page.props.todayDate;
    const user = page.props.auth.user;
    const clientIp = page.props.userIp;
    console.log(page.props, "attendanceToday");
    const now = ref("");
    function updateDateTime() {
      const waktu = /* @__PURE__ */ new Date();
      const options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
      };
      now.value = new Intl.DateTimeFormat("id-ID", options).format(waktu);
    }
    onMounted(() => {
      updateDateTime();
      setInterval(updateDateTime, 1e3);
    });
    const isOnOfficeNetwork = computed(() => clientIp.startsWith("172.29.") || clientIp.startsWith("10.") || clientIp === "kantor-static-ip");
    const absen = (type) => {
      router.post("/absen", { type }, {
        preserveScroll: true,
        onSuccess: () => {
          router.reload({ only: ["attendanceToday", "summary"] });
        },
        onError: (err) => console.error("Absen gagal", err)
      });
    };
    const breadcrumbs = [
      {
        title: "Profile",
        href: "/Profile"
      }
    ];
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(_sfc_main$1, mergeProps({ breadcrumbs }, _attrs), {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          var _a2, _b, _c, _d, _e, _f, _g, _h, _i, _j, _k, _l, _m, _n, _o, _p, _q, _r;
          if (_push2) {
            _push2(`<div class="p-6 space-y-6 text-gray-800"${_scopeId}><div class="rounded-xl shadow overflow-hidden"${_scopeId}><div class="p-6 flex flex-col items-center text-center text-white" style="${ssrRenderStyle({ "background-color": "#7C81AD" })}"${_scopeId}><img${ssrRenderAttr("src", unref(user).photo ? `storage/${unref(user).photo}` : `https://ui-avatars.com/api/?name=${unref(user).name}`)} alt="Foto Profil" class="w-32 h-32 rounded-full object-cover border-4 border-white mb-2"${_scopeId}><h2 class="text-xl font-semibold"${_scopeId}>${ssrInterpolate(unref(user).name)}</h2><p class="text-sm opacity-90"${_scopeId}>Manajer</p></div></div><div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2"${_scopeId}><h3 class="font-semibold text-lg"${_scopeId}>Status Hari Ini</h3>`);
            if (attendanceToday.value) {
              _push2(`<div${_scopeId}><p${_scopeId}><span class="mr-2"${_scopeId}> Masuk : </span>`);
              if ((_a2 = attendanceToday.value) == null ? void 0 : _a2.clock_in) {
                _push2(`<span class="${ssrRenderClass({ "text-green-600": attendanceToday.value.status === "Hadir", "text-yellow-600": attendanceToday.value.status === "Terlambat" })}"${_scopeId}>${ssrInterpolate(attendanceToday.value.clock_in)}</span>`);
              } else {
                _push2(`<span${_scopeId}> - </span>`);
              }
              _push2(`</p><p${_scopeId}><span class="mr-2"${_scopeId}> Pulang : </span>`);
              if ((_b = attendanceToday.value) == null ? void 0 : _b.clock_out) {
                _push2(`<span class="text-red-600"${_scopeId}>${ssrInterpolate(attendanceToday.value.clock_out)}</span>`);
              } else {
                _push2(`<span${_scopeId}> - </span>`);
              }
              _push2(`</p><p${_scopeId}><span class="mr-2"${_scopeId}> Status : </span><span class="${ssrRenderClass([{
                "text-green-600": attendanceToday.value.status === "Hadir",
                "text-yellow-600": attendanceToday.value.status === "Terlambat",
                "text-red-600": attendanceToday.value.status === "Tidak Hadir"
              }, "font-bold"])}"${_scopeId}>${ssrInterpolate(attendanceToday.value.status)}</span></p></div>`);
            } else {
              _push2(`<div${_scopeId}><p class="text-red-600"${_scopeId}>Belum ada absen hari ini</p></div>`);
            }
            _push2(`</div><div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2"${_scopeId}><p class="text-black-600"${_scopeId}>${ssrInterpolate(now.value)}</p><p${_scopeId}>IP: <span class="font-mono"${_scopeId}>${ssrInterpolate(unref(clientIp))}</span></p><p class="${ssrRenderClass(isOnOfficeNetwork.value ? "text-green-600" : "text-yellow-600")}"${_scopeId}>${ssrInterpolate(isOnOfficeNetwork.value ? "Jaringan kantor!" : "Jaringan di luar kantor!")}</p></div><div class="flex flex-col sm:flex-row gap-4"${_scopeId}><button${ssrIncludeBooleanAttr(!isOnOfficeNetwork.value || ((_c = attendanceToday.value) == null ? void 0 : _c.clock_in)) ? " disabled" : ""} class="${ssrRenderClass([
              "rounded-xl px-4 py-2 font-semibold shadow",
              !isOnOfficeNetwork.value || ((_d = attendanceToday.value) == null ? void 0 : _d.clock_in) ? "bg-gray-300 text-gray-600 cursor-not-allowed" : "bg-green-500 text-white hover:bg-green-600"
            ])}"${_scopeId}> ABSEN MASUK </button><button${ssrIncludeBooleanAttr(!isOnOfficeNetwork.value || ((_e = attendanceToday.value) == null ? void 0 : _e.clock_out)) ? " disabled" : ""} class="${ssrRenderClass([
              "rounded-xl px-4 py-2 font-semibold shadow",
              !isOnOfficeNetwork.value || ((_f = attendanceToday.value) == null ? void 0 : _f.clock_out) ? "bg-gray-300 text-gray-600 cursor-not-allowed" : "bg-red-500 text-white hover:bg-red-600"
            ])}"${_scopeId}> ABSEN PULANG </button></div><div class="text-center space-y-2"${_scopeId}><h3 class="text-xl font-semibold"${_scopeId}>Laporan Kehadiran</h3><p class="text-sm text-gray-500 dark:text-gray-400"${_scopeId}>Lihat data absensi real-time</p><button class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 text-sm"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(Link), {
              href: _ctx.route("history"),
              prefetch: "",
              class: "bg-black text-white px-4 py-2 rounded hover:bg-gray-800 text-sm"
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(` Lihat Selengkapnya `);
                } else {
                  return [
                    createTextVNode(" Lihat Selengkapnya ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</button></div><div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 grid grid-cols-3 gap-4 text-center"${_scopeId}><div${_scopeId}><p class="text-lg font-bold"${_scopeId}>${ssrInterpolate(((_g = summary.value) == null ? void 0 : _g.presence) ?? 0)}</p><p${_scopeId}>Total Kehadiran</p></div><div${_scopeId}><p class="text-lg font-bold"${_scopeId}>${ssrInterpolate(((_h = summary.value) == null ? void 0 : _h.absence) ?? 0)}</p><p${_scopeId}>Total Tidak Hadir</p></div><div${_scopeId}><p class="text-lg font-bold"${_scopeId}>${ssrInterpolate(((_i = summary.value) == null ? void 0 : _i.late) ?? 0)}</p><p${_scopeId}>Total Terlambat</p></div></div></div>`);
          } else {
            return [
              createVNode("div", { class: "p-6 space-y-6 text-gray-800" }, [
                createVNode("div", { class: "rounded-xl shadow overflow-hidden" }, [
                  createVNode("div", {
                    class: "p-6 flex flex-col items-center text-center text-white",
                    style: { "background-color": "#7C81AD" }
                  }, [
                    createVNode("img", {
                      src: unref(user).photo ? `storage/${unref(user).photo}` : `https://ui-avatars.com/api/?name=${unref(user).name}`,
                      alt: "Foto Profil",
                      class: "w-32 h-32 rounded-full object-cover border-4 border-white mb-2"
                    }, null, 8, ["src"]),
                    createVNode("h2", { class: "text-xl font-semibold" }, toDisplayString(unref(user).name), 1),
                    createVNode("p", { class: "text-sm opacity-90" }, "Manajer")
                  ])
                ]),
                createVNode("div", { class: "bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2" }, [
                  createVNode("h3", { class: "font-semibold text-lg" }, "Status Hari Ini"),
                  attendanceToday.value ? (openBlock(), createBlock("div", { key: 0 }, [
                    createVNode("p", null, [
                      createVNode("span", { class: "mr-2" }, " Masuk : "),
                      ((_j = attendanceToday.value) == null ? void 0 : _j.clock_in) ? (openBlock(), createBlock("span", {
                        key: 0,
                        class: { "text-green-600": attendanceToday.value.status === "Hadir", "text-yellow-600": attendanceToday.value.status === "Terlambat" }
                      }, toDisplayString(attendanceToday.value.clock_in), 3)) : (openBlock(), createBlock("span", { key: 1 }, " - "))
                    ]),
                    createVNode("p", null, [
                      createVNode("span", { class: "mr-2" }, " Pulang : "),
                      ((_k = attendanceToday.value) == null ? void 0 : _k.clock_out) ? (openBlock(), createBlock("span", {
                        key: 0,
                        class: "text-red-600"
                      }, toDisplayString(attendanceToday.value.clock_out), 1)) : (openBlock(), createBlock("span", { key: 1 }, " - "))
                    ]),
                    createVNode("p", null, [
                      createVNode("span", { class: "mr-2" }, " Status : "),
                      createVNode("span", {
                        class: ["font-bold", {
                          "text-green-600": attendanceToday.value.status === "Hadir",
                          "text-yellow-600": attendanceToday.value.status === "Terlambat",
                          "text-red-600": attendanceToday.value.status === "Tidak Hadir"
                        }]
                      }, toDisplayString(attendanceToday.value.status), 3)
                    ])
                  ])) : (openBlock(), createBlock("div", { key: 1 }, [
                    createVNode("p", { class: "text-red-600" }, "Belum ada absen hari ini")
                  ]))
                ]),
                createVNode("div", { class: "bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2" }, [
                  createVNode("p", { class: "text-black-600" }, toDisplayString(now.value), 1),
                  createVNode("p", null, [
                    createTextVNode("IP: "),
                    createVNode("span", { class: "font-mono" }, toDisplayString(unref(clientIp)), 1)
                  ]),
                  createVNode("p", {
                    class: isOnOfficeNetwork.value ? "text-green-600" : "text-yellow-600"
                  }, toDisplayString(isOnOfficeNetwork.value ? "Jaringan kantor!" : "Jaringan di luar kantor!"), 3)
                ]),
                createVNode("div", { class: "flex flex-col sm:flex-row gap-4" }, [
                  createVNode("button", {
                    onClick: ($event) => absen("masuk"),
                    disabled: !isOnOfficeNetwork.value || ((_l = attendanceToday.value) == null ? void 0 : _l.clock_in),
                    class: [
                      "rounded-xl px-4 py-2 font-semibold shadow",
                      !isOnOfficeNetwork.value || ((_m = attendanceToday.value) == null ? void 0 : _m.clock_in) ? "bg-gray-300 text-gray-600 cursor-not-allowed" : "bg-green-500 text-white hover:bg-green-600"
                    ]
                  }, " ABSEN MASUK ", 10, ["onClick", "disabled"]),
                  createVNode("button", {
                    onClick: ($event) => absen("pulang"),
                    disabled: !isOnOfficeNetwork.value || ((_n = attendanceToday.value) == null ? void 0 : _n.clock_out),
                    class: [
                      "rounded-xl px-4 py-2 font-semibold shadow",
                      !isOnOfficeNetwork.value || ((_o = attendanceToday.value) == null ? void 0 : _o.clock_out) ? "bg-gray-300 text-gray-600 cursor-not-allowed" : "bg-red-500 text-white hover:bg-red-600"
                    ]
                  }, " ABSEN PULANG ", 10, ["onClick", "disabled"])
                ]),
                createVNode("div", { class: "text-center space-y-2" }, [
                  createVNode("h3", { class: "text-xl font-semibold" }, "Laporan Kehadiran"),
                  createVNode("p", { class: "text-sm text-gray-500 dark:text-gray-400" }, "Lihat data absensi real-time"),
                  createVNode("button", { class: "bg-black text-white px-4 py-2 rounded hover:bg-gray-800 text-sm" }, [
                    createVNode(unref(Link), {
                      href: _ctx.route("history"),
                      prefetch: "",
                      class: "bg-black text-white px-4 py-2 rounded hover:bg-gray-800 text-sm"
                    }, {
                      default: withCtx(() => [
                        createTextVNode(" Lihat Selengkapnya ")
                      ]),
                      _: 1
                    }, 8, ["href"])
                  ])
                ]),
                createVNode("div", { class: "bg-white dark:bg-gray-800 rounded-xl shadow p-6 grid grid-cols-3 gap-4 text-center" }, [
                  createVNode("div", null, [
                    createVNode("p", { class: "text-lg font-bold" }, toDisplayString(((_p = summary.value) == null ? void 0 : _p.presence) ?? 0), 1),
                    createVNode("p", null, "Total Kehadiran")
                  ]),
                  createVNode("div", null, [
                    createVNode("p", { class: "text-lg font-bold" }, toDisplayString(((_q = summary.value) == null ? void 0 : _q.absence) ?? 0), 1),
                    createVNode("p", null, "Total Tidak Hadir")
                  ]),
                  createVNode("div", null, [
                    createVNode("p", { class: "text-lg font-bold" }, toDisplayString(((_r = summary.value) == null ? void 0 : _r.late) ?? 0), 1),
                    createVNode("p", null, "Total Terlambat")
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/pages/admin/Dashboard.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
