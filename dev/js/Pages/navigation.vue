<template>
  <div>
    <v-navigation-drawer
        absolute
        v-model="drawer"
        app
        clipped
        style="top:64px"
        color="grey lighten-4"
    >
      <v-list
          dense
          class="grey lighten-4"
      >
        <template v-for="(item, i) in items">
          <v-list-item
              :key="i"
              link
              :to="item.link"
          >
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title class="grey--text">
                {{ item.text }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        drawer: null,
        items: [
          { icon: 'mdi-group', text: 'Domains',link: '/' },
          { icon: 'mdi-cash', text: 'Attach Prices', link: 'prices' },
          { icon: 'mdi-looks', text: 'Domain Themes', link: 'themes' },
        ],
      }
    },
    methods: {},
    computed: {}
  }

</script>

<style>
  #keep .v-navigation-drawer__border {
    display: none
  }
</style>

