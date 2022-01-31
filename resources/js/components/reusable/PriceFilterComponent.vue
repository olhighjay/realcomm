<template>
  <section>
    <div class="row justify-content-center text-center  d-flex">
      <comp-element-overlay v-if="fullElementOverlay"></comp-element-overlay>

      <div class="col-lg-5"></div>
      <div class="col-lg-2 col-md-12 col-sm-12 filter-by-price" style="font-size:16px; padding-right:0"><b> Filter by Price:</b> </div>
      <div class="col-lg-2 col-md-3 col-sm-5 mb-2 input-group justify-content-center" ><label class="text-dark font-weight-medium" for="editor">Min: </label> &nbsp;<input class="form-control" type="number" name="min" @input=" isTyping = true" v-model="minPrice" style="max-width:120px; height:30px; text-align:center" placeholder="Min"></div>
      <div class="col-lg-3 col-md-3 col-sm-5 mb-2 input-group justify-content-center" style="    margin-bottom: 0; padding-bottom:0;"><label class="text-dark font-weight-medium" for="editor">Max: </label> &nbsp;<input class="form-control" type="number" name="max" @input=" isTyping = true" v-model="maxPrice"  style="max-width:120px; height:30px; text-align:center" placeholder="Max">
      <!-- <div class="col-lg-2 col-md-3 col-sm-5  input-group justify-content-center" style="    margin-bottom: 0; padding-bottom:0;"><label class="text-dark font-weight-medium" for="editor">Max: </label> &nbsp;<input class="form-control" type="number" name="max" @input=" isTyping = true" v-model="maxPrice"  style="max-width:120px; height:30px; text-align:center" placeholder="Max"></div> -->
    <!-- <span  v-show="searchQuery.length > 0" @click="clearSearchField" class="mdi mdi-close-circle my-mdi"></span> -->
      <span v-show=" minPrice > 0 || maxPrice > 0" class="mdi mdi-close-box my-mdi" @click="clearSearchField"></span></div>
      <!-- <div class="col-lg-1 col-md-1 col-sm-12 mb-2 "><span  class="mdi mdi-close-box my-mdi"></span></div> -->
    </div>
  </section>
</template>

<script>
  import FullComponentElementOverlay from './FullComponentElementOverlayComponent.vue'

export default {
  components: {
    FullComponentElementOverlay
  },
  data() {
    return {
      minPrice: 0,
      maxPrice: 0,
      isTyping: false,
      isLoading: false,
      fullElementOverlay : false
    }
  },
  props:{
    modelUrl: {
      type: String,
      required: false,
    }
  },
  watch: {
    minPrice: _.debounce(function() {
      this.isTyping = false;
    }, 2000),
    maxPrice: _.debounce(function() {
      this.isTyping = false;
    }, 2000),
    isTyping: function(value) {
      if (!value) {
        this.filterPrice(this.minPrice, this.maxPrice);
      }
    }
  },
  methods: {
    filterPrice: function(minPrice, maxPrice) {
    	this.isLoading = true;
      this.fullElementOverlay = true
      axios.get(this.modelUrl+'?price_filter=' + minPrice + '-' + maxPrice)
        .then(response => {    
        	this.isLoading = false;
          this.$emit('updatedPriceFilterData', [response.data, this.minPrice, this.maxPrice])
        });
      this.fullElementOverlay = false
    },
    clearSearchField(){
      this.minPrice = 0;
      this.maxPrice = 0;
      this.filterPrice(0,0)
    }
  }
}
</script>

<style scoped>
.my-mdi {
    position: absolute;
    color: red;
    cursor: pointer;
    /* left: 10px; */
    right: -2px;
    top: -8px;
    font-size: 30px;
}
@media screen and (max-width: 1200px ) {
  .my-mdi {
    right: -20px;
  }
}

@media screen and (max-width: 576px) {
  .my-mdi {
    right: 50px !important;
  }
} 

@media screen and (max-width: 414px) {
  .my-mdi {
    right: -15px !important;
  }
} 
</style>