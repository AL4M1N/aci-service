<template>
  <div class="pa-4">
    <h1 class="text-bootstrap-primary">Welcome to Dashboard</h1>
  </div>
</template>

  <script>
export default {
  data() {
    return {
      drawer: true,
      rail: true,
    };
  },
};
</script>

  <style scoped>
.text-bootstrap-primary {
  color: var(--bs-primary) !important;
}
</style>
