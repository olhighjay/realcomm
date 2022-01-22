<template>
<section>
  <div class="input-group my-search-group">
    <comp-element-overlay v-if="fullElementOverlay"></comp-element-overlay>
    <input type="text" class="form-control search" @input=" isTyping = true" placeholder="Search for..." aria-label="search" v-model="searchQuery">
    <span  v-show="searchQuery.length > 0" @click="clearSearchField" class="mdi mdi-close-circle my-mdi"></span>
    <div class="input-group-append">
      <span class="input-group-text bg-primary"> <span class="mdi mdi-database-search"></span></span>
    </div>
    <!-- {{ searchQuery }} -->
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
      searchQuery: "",
      isTyping: false,
      searchResult: [],
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
    searchQuery: _.debounce(function() {
      this.isTyping = false;
    }, 1000),
    isTyping: function(value) {
      if (!value) {
        this.searchUser(this.searchQuery);
      }
    }
  },
  methods: {
    searchUser: function(searchQuery) {
    	this.isLoading = true;
      this.fullElementOverlay = true
      axios.get(this.modelUrl+'?search=' + searchQuery)
        .then(response => {    
        	this.isLoading = false;
          console.log(response.data);
          // this.searchResult = response.data.buyers.data;
          // this.$emit('updatedSearchedData', [response.data.buyers.data, response.data.buyers, this.searchQuery])
          this.$emit('updatedSearchedData', [response.data, this.searchQuery])
        });
      this.fullElementOverlay = false
    },
    clearSearchField(){
      this.searchQuery = "";
      this.searchUser('')
    }
  }
}
</script>

<style scoped>
.input-group > .search {
  height: 30px !important;
}

.input-group > .input-group-append > .input-group-text.bg-primary {
    height: 30px !important;
}

.my-search-group {
    position: relative;
}
.my-mdi {
    position: absolute;
    color: red;
    cursor: pointer;
    right: 50px;
    top: 5px;
}
.search {
    padding-right: 30px;
}
</style>