import Errors from "./Errors";

let errors = new Errors;


export default async function Requests(url, {
  data = {},
  action = "get",
  stopLoadingBar = false,
  showNotification = false,
  showInnerLoading = false,
  mergeQueries = true,
  onSuccessCallback = () => {
  },
  onErrorCallback = () => {
  },
  mutator = null,
  store = null,
  load = true,
  state=null
} = {}) {

  showInnerLoading ? store.commit("startLoading") : "";
  let prefix = globals.siteRestUrl;
  await axios[action](`${prefix}/${url}`, data).then(response => {
    let data = response.data
    if (mutator) {
      store.commit(mutator, data.body);
    }
    showInnerLoading ? store.commit("stopLoading") : null;
    onSuccessCallback(data);
    if(showNotification){
      store.commit("showNotification", [data.response, 'success'])
    }
  }).catch(errorData => {
    if (errorData.response && errorData.response.status === 403 ){
      location.assign(`${aps_globals.admin_url}`);
      return ;
    }
    console.dir(errorData)
    errors.record(errorData.response.data.errors || errorData.response.data.message);
    onErrorCallback(errorData.response.data.message || errorData.response.data.errors);
    if(showNotification){
      store.commit("showNotification", [errorData.response.data.message,'error'])
    }
    return store.commit("stopLoading", errors)
  })
}
function updateQueryPagination(pagination, store,state) {
  if(aps_globals._.isNotEmpty(pagination)){
    store.commit("setQueryPagination",[pagination, state])
  }
}
