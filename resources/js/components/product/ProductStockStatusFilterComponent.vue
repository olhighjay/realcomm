<template>
  <div class="btn-group mb-1">
    <button type="button" class="btn btn-outline-secondary py-0" >{{onPageDirection && onPageDirection !== '-' ? onPageDirection : ' Stock Status' }}</button>
    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu">
      <a @click="filteringBy('stock_status','-')" :class="{active: onPageDirection === '-'}"    class="dropdown-item" href="#">All</a>
      <a @click="filteringBy('stock_status','in stock')" :class="{active: onPageDirection === 'in stock'}"   class="dropdown-item" href="#">In stock</a>
      <a @click="filteringBy('stock_status','low stock')" :class="{active: onPageDirection === 'low stock'}"   class="dropdown-item" href="#">Low stock</a>
      <a @click="filteringBy('stock_status','out of stock')" :class="{active: onPageDirection === 'out of stock'}"   class="dropdown-item" href="#">Out of stock</a>
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
      this.$emit('stockFilterEmitter', [name, direction])
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