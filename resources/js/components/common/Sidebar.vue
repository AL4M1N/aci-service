<template>
  <div>
    <v-navigation-drawer
      app
      color="#303F9F"
      active-color="#006064"
      v-model="drawer"
      class="bg_gradient"
      width="300"
    >
      <v-list density="comfortable" color="#303F9F" class="">
        <v-list-item
          link
          router
          :to="{ name: 'Dashboard' }"
          prepend-icon="mdi-view-dashboard"
          title="Dashboard"
          value="Dashboard"
        >
        </v-list-item>

        <v-list-item
          link
          router
          :to="{ name: 'Service' }"
          prepend-icon="mdi-view-dashboard"
          title="Service"
          value="Service"
        >
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app color="#303F9F" flat class="bg_gradient">
      <v-app-bar-nav-icon
        @click="drawer = !drawer"
        color="#ffffff"
      ></v-app-bar-nav-icon>
      <v-spacer></v-spacer>
      <v-toolbar-title>Admin Panel</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon @click="toggle()">
        <v-icon v-if="fullscreen" color="#ffffff">mdi-fullscreen</v-icon>
        <v-icon v-else color="#ffffff">mdi-fullscreen-exit</v-icon>
      </v-btn>
    </v-app-bar>
  </div>
</template>

<script>
export default {
  data() {
    return {
      fullscreen: true,
      drawer: true,
    };
  },

  methods: {},

  created() {},
};
</script>

<style scoped>
a:hover {
  text-decoration: none;
}
.v-list-item--active {
  color: #000 !important;
  background-color: #80cbc4;
}

#logo-item {
  background: transparent !important;
  color: #fff !important;
}
</style>
