<template>
  <div class="btn-group mb-1">
    <button type="button" class="btn btn-outline-secondary py-0" >{{onPageDirection && onPageDirection !== '-' ? onPageDirection : 'Gender' }}</button>
    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu">
      <a @click="filteringBy('gender','-')" :class="{active: onPageDirection === '-'}"    class="dropdown-item" href="#">All</a>
      <a @click="filteringBy('gender',' male')" :class="{active: onPageDirection === ' male'}"   class="dropdown-item" href="#">Male</a>
      <a @click="filteringBy('gender','female')" :class="{active: onPageDirection === 'female'}"   class="dropdown-item" href="#">Female</a>
      <a @click="filteringBy('gender','other')" :class="{active: onPageDirection === 'other'}"   class="dropdown-item" href="#">Other</a>
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
      this.$emit('genderFilterEmitter', [name, direction])
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