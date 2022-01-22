<template>
  <div class="btn-group mb-1">
    <button type="button" class="btn btn-outline-secondary py-0" >{{onPageDirection && onPageDirection !== '-' ? onPageDirection : 'Role' }}</button>
    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu">
      <a @click="filteringBy('role','-')" :class="{active: onPageDirection === '-'}"    class="dropdown-item" href="#">All</a>
      <a @click="filteringBy('role','customer')" :class="{active: onPageDirection === 'customer'}"   class="dropdown-item" href="#">Customer</a>
      <a @click="filteringBy('role','guest')" :class="{active: onPageDirection === 'guest'}"   class="dropdown-item" href="#">Guest Customer</a>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      onPageDirection: null,
    }
  },
  methods: {
    filteringBy: function(name, direction) {
      this.onPageDirection = direction
      this.$emit('roleFilterEmitter', [name, direction])
    }
  }
}
</script>

<style scoped>
  .active {
    color:white !important;
  }
  .btn-outline-secondary {
  padding-top: 3px;
  padding-bottom: 3px;
}


</style>