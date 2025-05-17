<template>
    <v-app>
      <side-bar></side-bar>
      <v-main>
        <div class="pa-3">
          <router-view></router-view>
        </div>
      </v-main>
    </v-app>
  </template>

  <script>
  import SideBar from "./common/Sidebar.vue";
  export default {
    name: "App",

    components: {
      "side-bar": SideBar,
    },
  };
  </script>
