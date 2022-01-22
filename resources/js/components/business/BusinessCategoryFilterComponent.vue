<template>
  <div class="btn-group mb-1">
    <button type="button" class="btn btn-outline-secondary py-0" >{{onPageDirection && categoryName !== '-' ? categoryName : 'Category' }}</button>
    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu">
      <a @click="filteringBy('category_id','-','-')" :class="{active: onPageDirection === '-'}"    class="dropdown-item" href="#">All</a>
      <span v-for="businessCat in businessCats" :key="businessCat.id">
        <a @click="filteringBy('category_id', businessCat.id, businessCat.name)" :class="{active: onPageDirection === businessCat.id}"   class="dropdown-item" href="#">{{businessCat.name}}</a>
      </span>
     </div>
  </div>
</template>

<script>

export default {
  props: {
    businessCats: {
      type: Array,
      required: false,
    }
  },
  data() {
    return {
      onPageDirection: null,
      categoryName: null,
    }
  },
  methods: {
    filteringBy: function(name, direction, categoryName) {
      this.categoryName = categoryName;
      this.onPageDirection = direction;
      this.$emit('categoryFilterEmitter', [name, direction])
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