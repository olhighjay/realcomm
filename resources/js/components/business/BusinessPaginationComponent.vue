<template>
      <!-- This is a reusable pagination component -->
    <nav aria-label="Page navigation example" class="mb-4">
    <comp-element-overlay v-if="fullElementOverlay"></comp-element-overlay>
      <!-- Only show this component if the number of the number overall data is greater than number of data to show per page -->
      <ul v-if="incomingData.total > incomingData.to" class="custom-pagination pagination-info pagination align-items-stretch d-flex">
        <!-- first page which is represented by the the sign << and it appears only if there is more than 1 page -->
        <span class="custom-pagination pagination-info pagination align-items-stretch d-flex">
          <li class="page-item"><a v-if="(clickedPagination && newIncomingData.current_page !== 1) || (!clickedPagination && incomingData.current_page !== 1)" @click="getPaginated(`${modelUrl}?search=${searchQuery}&&page=1`)" class="page-link"  href="#"> &laquo; </a></li>
        </span>

         <!-- if none of the pagination links has been clicked, then newIncomingData is empty and the data is fresly in incomingData. clickedPagination is still false so we are looping through incomingData -->
        <span v-show="clickedPagination === false" v-for="link in incomingData.links" :key="link[0]">
            <!-- Previous link-->
          <li  v-if="link === incomingData.links[0]" class="page-item"><a v-if="(clickedPagination && newIncomingData.current_page !== 1) || (!clickedPagination && incomingData.current_page !== 1)" @click="getPaginated(newIncomingData.prev_page_url === null ? newIncomingData.prev_page_url : `${modelUrl}?search=${searchQuery}&&page=${newIncomingData.current_page - 1}`)"  class="page-link" href="#">Prev</a></li>
            <!-- Next Link -->
          <li v-else-if="link === incomingData.links[incomingData.links.length - 1]" class="page-item"><a v-if="(clickedPagination && newIncomingData.next_page_url !== null) || (!clickedPagination && incomingData.next_page_url !== null)"  @click="getPaginated(incomingData.next_page_url === null ? incomingData.next_page_url : `${modelUrl}?search=${searchQuery}&&page=${incomingData.current_page + 1 }`)" class="page-link" href="#">Next</a></li>
            <!-- Numberical link -->
          <li v-else class="page-item show-item" :class="{active: incomingData.current_page == link.label} "><a @click="getPaginated(`${modelUrl}?search=${searchQuery}&&page=${link.label}`)" class="page-link"  href="#"> {{ link.label   }}</a></li>
        </span>
        
         <!-- once any of the pagination links is clicked, then newIncomingData is populated with the latest data and the data in incomingData in outdated. clickedPagination is now true so we are looping through newIncomingData -->
        <span v-show="clickedPagination === true" v-for="link in newIncomingData.links" :key="link[0]">
            <!-- Previous link-->
          <li  v-if="link === newIncomingData.links[0]" class="page-item"><a v-if="newIncomingData.current_page !== 1" @click="getPaginated(newIncomingData.prev_page_url === null ? newIncomingData.prev_page_url : `${modelUrl}?search=${searchQuery}&&page=${newIncomingData.current_page - 1}`)" class="page-link" href="#">Prev</a></li>
            <!-- Next Link -->
          <li v-else-if="link === newIncomingData.links[newIncomingData.links.length - 1]" class="page-item"><a v-if="newIncomingData.next_page_url !== null"  @click="getPaginated(newIncomingData.next_page_url === null ? newIncomingData.next_page_url : `${modelUrl}?search=${searchQuery}&&page=${newIncomingData.current_page + 1}`)" class="page-link" href="#">Next</a></li>
            <!-- Numberical link -->
          <li v-else-if="link.label !== 'Next &raquo;'" class="page-item show-item" :class="{active: newIncomingData.current_page == link.label} "><a @click="getPaginated(`${modelUrl}?search=${searchQuery}&&page=${link.label}`)" class="page-link"  href="#"> {{ link.label   }}</a></li>
        </span>
        
         <!-- last page which is represented by the the sign >> and it does not appears if the current page is the last page -->
        <span v-if="(clickedPagination && newIncomingData.next_page_url !== null) || (!clickedPagination && incomingData.next_page_url !== null)" class="custom-pagination pagination-info pagination align-items-stretch d-flex">
            <li class="page-item"><a @click="getPaginated(`${modelUrl}?search=${searchQuery}&&page=${clickedPagination ? newIncomingData.last_page : incomingData.last_page}`)" class="page-link"  href="#"> &raquo; </a></li>
        </span> 
      </ul>
      <div v-if="clickedPagination === true">
        showing {{newIncomingData.to}} out of {{newIncomingData.total}}
      </div>
      <div v-else-if="clickedPagination === false">
        showing {{incomingData.to}} out of {{incomingData.total}}
      </div>
    </nav>
</template>

<script>

import FullComponentElementOverlay from '../reusable/FullComponentElementOverlayComponent.vue'

export default {
  components: {
    FullComponentElementOverlay
  },
   props: {
    incomingData: {
      type: Object,
      required: true,
    },
    searchQuery: {
      type: String,
      required: false,
    },
    modelUrl: {
      type: String,
      required: false,
    }
  },
  data() {
    return {
      paginatedData : {},
      newIncomingData : {
        current_page : 1
      },
      clickedPagination: false,
      fullElementOverlay : false
    }
  },
  watch: {
    incomingData: function(value) {
      if (value) {
        this.clickedPagination = false;
      }
    }
  },
  methods: {
    getPaginated(paged_url){
      this.fullElementOverlay = true
      this.clickedPagination = true;
      axios.get(paged_url)
        .then(response => {
          if(response.status === 200) {
            this.paginatedData = response.data.businesses.data;
            this.newIncomingData = response.data.businesses;
            // console.log(respponse.data);
            // console.log(this.newIncomingData);
            this.$emit('updatePaginatedData', this.paginatedData)
          }
      this.fullElementOverlay = false
        })
    }
  }
}

</script>
<style scoped>

/* Pagination */
.custom-pagination {
  font-size: 13px; }
  .custom-pagination .page-item .page-link {
    color: #000;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    line-height: 40px;
    padding: 0;
    margin: 0 2px;
    text-align: center; }
    .custom-pagination .page-item .page-link:active, .custom-pagination .page-item .page-link:focus, .custom-pagination .page-item .page-link:hover {
      outline: none;
      -webkit-box-shadow: none;
      box-shadow: none; }
  .custom-pagination .page-item span.page-link {
    color: #6c757d;
    letter-spacing: .1rem; }
    .custom-pagination .page-item span.page-link:hover {
      background: none !important; }
  .custom-pagination.pagination-primary .page-item.active .page-link {
    background-color: #f34573;
    color: #fff;
    -webkit-box-shadow: 0 2px 5px 0 rgba(243, 69, 115, 0.2);
    box-shadow: 0 2px 5px 0 rgba(243, 69, 115, 0.2); }
  .custom-pagination.pagination-secondary .page-item.active .page-link {
    background-color: #6c757d;
    color: #fff;
    -webkit-box-shadow: 0 2px 5px 0 rgba(108, 117, 125, 0.2);
    box-shadow: 0 2px 5px 0 rgba(108, 117, 125, 0.2); }
  .custom-pagination.pagination-success .page-item.active .page-link {
    background-color: #7fbb00;
    color: #fff;
    -webkit-box-shadow: 0 2px 5px 0 rgba(127, 187, 0, 0.2);
    box-shadow: 0 2px 5px 0 rgba(127, 187, 0, 0.2); }
  .custom-pagination.pagination-danger .page-item.active .page-link {
    background-color: #ec1c24;
    color: #fff;
    -webkit-box-shadow: 0 2px 5px 0 rgba(236, 28, 36, 0.2);
    box-shadow: 0 2px 5px 0 rgba(236, 28, 36, 0.2); }
  .custom-pagination.pagination-warning .page-item.active .page-link {
    background-color: #ffd900;
    color: #fff;
    -webkit-box-shadow: 0 2px 5px 0 rgba(255, 217, 0, 0.2);
    box-shadow: 0 2px 5px 0 rgba(255, 217, 0, 0.2); }
  .custom-pagination.pagination-info .page-item.active .page-link {
    background-color: #1cc7d0;
    color: #fff;
    -webkit-box-shadow: 0 2px 5px 0 rgba(28, 199, 208, 0.2);
    box-shadow: 0 2px 5px 0 rgba(28, 199, 208, 0.2); }

.bg-image {
  height: 80vh;
  background-size: cover;
  background-position: center center; }


</style>