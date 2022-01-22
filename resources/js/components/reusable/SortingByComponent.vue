<template>
  <div class="btn-group mb-1">
    <button type="button" class="btn btn-outline-secondary">{{onPageDirection ? directionRedefined : 'Sort by' }}</button>
    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu">
      <a @click="sortingBy('created_at','down')" :class="{active: onPageDirection === 'down'}"  class="dropdown-item" href="#">Newest</a>
      <a @click="sortingBy('created_at','up')" :class="{active: onPageDirection === 'up'}" class="dropdown-item" href="#">Oldest</a>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      onPageDirection: null,
      directionRedefined: null
    }
  },
  methods: {
    sortingBy: function(name, direction) {
      this.onPageDirection = direction
      if(direction === 'down'){
        this.directionRedefined = 'Newest';
      }else if(direction === 'up'){
        this.directionRedefined = 'Oldest';
      }
      this.$emit('sortingByEmitter', [name, direction])
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