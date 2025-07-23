import { defineComponent, ref, useSSRContext } from "vue";
import { ssrRenderAttrs } from "vue/server-renderer";
import "@inertiajs/vue3";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "SettingProfile",
  __ssrInlineRender: true,
  setup(__props) {
    ref(null);
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<form${ssrRenderAttrs(_attrs)}><div class="mb-4"><label class="block mb-1 font-medium">Foto Profil</label><input type="file"></div><button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded"> Simpan </button></form>`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/pages/settings/SettingProfile.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
