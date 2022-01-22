<template>
  <div class="btn-group mb-1">
    <button type="button" class="btn btn-outline-secondary py-0" >{{onPageDirection && paged === true ? onPageDirection : 'Show on page' }}</button>
    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
    <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu">
    <a @click="showNumber('no_per_page', 5)" :class="{active: onPageDirection === 5}"  class="dropdown-item" href="#">5</a>
    <a @click="showNumber('no_per_page', 10)" :class="{active: onPageDirection === 10}"  class="dropdown-item" href="#">10</a>
    <a @click="showNumber('no_per_page', 20)" :class="{active: onPageDirection === 20}"  class="dropdown-item" href="#">20</a>
    <a @click="showNumber('no_per_page', 50)" :class="{active: onPageDirection === 50}"  class="dropdown-item" href="#">50</a>
    <a @click="showNumber('no_per_page', 100)" :class="{active: onPageDirection === 100}"  class="dropdown-item" href="#">100</a>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      onPageDirection: null,
      paged: false,
    }
  },
  methods: {
    showNumber: function(no_per_page, direction) {
      this.onPageDirection = direction
      this.paged = true;
      this.$emit('showNumberEmitter', [no_per_page, direction])
    }
  }
}
</script>

<style scoped>
  .active {
    color:white !important;
  }
</style>