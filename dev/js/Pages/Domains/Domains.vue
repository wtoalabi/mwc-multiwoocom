<template>
  <v-card>
    <v-card-title>
      Supported Domains
      <v-spacer></v-spacer>
      <v-btn color="primary" rounded elevation="5"><v-icon left>
        mdi-plus-box
      </v-icon>
        <span class="text--white">Add New Domain</span>
        </v-btn>
    </v-card-title>
    <v-data-table
        hide-default-footer
        :headers="headers"
        :items="desserts"
        :items-per-page="5"
        class="elevation-1"
    >
      <template v-slot:item.url="{ item }">
        <a :href="item.url" target="_blank">{{item.url}}</a>
      </template>
      <template v-slot:item.actions="{ item }">
        <span style="display: flex;justify-content: flex-end;align-items: center;">
          <v-icon small @click="editSingleDomain(item)" style="margin:20px">
            mdi-pencil
          </v-icon>
          <v-icon small @click="deleteSingleGateway(item)">
            mdi-delete
          </v-icon>
        </span>
      </template>

    </v-data-table>

  </v-card>
</template>
<script>
  export default {
    data() {
      return {
        headers: [
          {
            text: 'Url',
            align: 'start',
            sortable: false,
            value: 'url',
          },{
            text: 'Country',
            align: 'start',
            sortable: false,
            value: 'country',
          },
          {text: '', value: 'actions', sortable: false, align: 'end',}

        ],
        desserts: [
          {url: 'https://golden.loc/en-us', country: "US"},
          {url: 'https://golden.loc/en-eu', country: "Europe"},
        ],
      }
    },
    methods:{
      editSingleDomain(item){

      },
      deleteSingleGateway(item){

      }
    }
  }
</script>
