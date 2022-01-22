<template>
  <div class="btn-group mb-1">
    <button type="button" class="btn btn-outline-secondary py-0" >{{onPageDirection && onPageDirection !== '-' ? onPageDirection : 'Staus' }}</button>
    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu">
      <a @click="filteringBy('status','-')" :class="{active: onPageDirection === '-'}"    class="dropdown-item" href="#">All</a>
      <a @click="filteringBy('status','active')" :class="{active: onPageDirection === 'active'}"   class="dropdown-item" href="#">Active</a>
      <a @click="filteringBy('status','inactive')" :class="{active: onPageDirection === 'inactive'}"   class="dropdown-item" href="#">Inactive</a>
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
      this.$emit('filteringByEmitter', [name, direction])
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