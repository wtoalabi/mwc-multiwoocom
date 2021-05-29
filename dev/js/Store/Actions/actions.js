import Requests from "@/utils/forms/StatefulRequest";
export default {
  async loadDomains(store) {
    await Requests("get-domains", {
      action: "get",
      store: store,
      mutator: "commitMetaData",
      onSuccessCallback: (response) => {
        store.commit("setSettings", response.body.settings)
      }
    })
  }
}
