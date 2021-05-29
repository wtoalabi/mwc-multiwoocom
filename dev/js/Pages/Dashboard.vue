<template>
  <v-app id="keep">
    <v-app-bar
        app
        absolute
        clipped-left
        color="primary"
    >
      <span class="title ml-3 mr-5">MultiWooCom</span>
      <v-spacer></v-spacer>
    </v-app-bar>
    <navigation></navigation>
    <v-main style="top:0; padding-top: 64px;" class="m-0 fill-height">
      <transition
          name="custom-classes-transition"
          enter-active-class="animate__animated animate__fadeInUp">
        <div class="m-0 fill-height">
          <router-view/>
        </div>
      </transition>
    </v-main>
  </v-app>
</template>

<script>
  import navigation from "./navigation";

  export default {
    mounted(){
      this.$store.dispatch("loadDomains")
    },
    name: "Dashboard",
    component: {navigation},
    props: {
      source: String,
    },
    data: () => ({}),
  }
</script>
