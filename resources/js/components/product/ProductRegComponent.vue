<template>
  <div>
     <div v-if="successful" class="alert alert-success alert-highlighted " role="alert">
       You have successfully created a new product
     </div>
     <div v-if="failed" class="alert alert-danger alert-highlighted" role="alert">
        Server Error!.. Unable to complete your request.
     </div>
    <form @submit.prevent="handleSubmit" @change="emptyField()">
      <label class="text-dark font-weight-medium" for="name">Name</label>
      <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="mdi mdi-account"></i>
            </span>
        </div>
        <input :disabled="loading !== 'neutral'" id="name" name="name" type="text" :class="{'is-invalid' : nameErrors.length > 0, 'is-inv' : nameErrors.length > 0, 'form-control':true }" placeholder="John" aria-label="name" v-model="name" @input="disabling(name, nameErrors )">
      </div>
      <ul v-if="nameErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="nameError in nameErrors" :key="nameError" class="form-error" > {{ nameError   }}</li>
      </ul>

      <label class="text-dark font-weight-medium" for="short_description">Short Description</label>
      <div class="mb-4">
        <textarea id="short_description" class="form-control" v-model="short_description" width="100%"></textarea>
        <!-- <input :disabled="loading !== 'neutral'" id="name" name="name" type="text" :class="{'is-invalid' : nameErrors.length > 0, 'is-inv' : nameErrors.length > 0, 'form-control':true }" placeholder="John" aria-label="name" v-model="name" @input="disabling(name, nameErrors )"> -->
      </div>

      <label class="text-dark font-weight-medium" for="category">Category</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-shopping"></i> 
              </span>
          </div>
          <select :disabled="loading !== 'neutral'" class="form-control" id="category" v-model="category"  :class="{'is-invalid' : categoryErrors.length > 0, 'is-inv' : categoryErrors.length > 0}"  @change="disabling(category, categoryErrors )">
            <option disabled value="">Select Category</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
          </select>
      </div>
      <ul v-if="categoryErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="categoryError in categoryErrors" :key="categoryError" class="form-error"> {{ categoryError }}</li>
      </ul>

      
      <label class="text-dark font-weight-medium" for="regular_price">Regular Price</label>
      <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                ₦
            </span>
        </div>
        <input :disabled="loading !== 'neutral'" id="regular_price" name="regular_price" type="number" step="0.01" :class="{'is-invalid' : regular_priceErrors.length > 0, 'is-inv' : regular_priceErrors.length > 0, 'form-control':true }" placeholder="0.00" aria-label="name" v-model="regular_price" @input="disabling(regular_price, regular_priceErrors )">
      </div>
      <ul v-if="regular_priceErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="regular_priceError in regular_priceErrors" :key="regular_priceError" class="form-error" > {{ regular_priceError   }}</li>
      </ul>

      
      <label class="text-dark font-weight-medium" for="sale_price">Sale Price</label>
      <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                ₦
            </span>
        </div>
        <input :disabled="loading !== 'neutral'" id="sale_price" name="sale_price" type="number" step="0.01" :class="{'is-invalid' : sale_priceErrors.length > 0, 'is-inv' : sale_priceErrors.length > 0, 'form-control':true }" @input="disabling(sale_price, sale_priceErrors )" placeholder="0.00" aria-label="sale_price" v-model="sale_price">
      </div>
      <ul v-if="sale_priceErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="sale_priceError in sale_priceErrors" :key="sale_priceError" class="form-error" > {{ sale_priceError   }}</li>
      </ul>

      
      <label class="text-dark font-weight-medium" for="quantity">Quantity</label>
      <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="mdi mdi-format-list-numbers"></i>
            </span>
        </div>
        <input :disabled="loading !== 'neutral'" id="quantity" name="quantity" type="number" :class="{'is-invalid' : quantityErrors.length > 0, 'is-inv' : quantityErrors.length > 0, 'form-control':true }" placeholder="10" aria-label="quantity" v-model="quantity" @input="disabling(quantity, quantityErrors )">
      </div>
      <ul v-if="quantityErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="quantityError in quantityErrors" :key="quantityError" class="form-error" > {{ quantityError   }}</li>
      </ul> 

      <label class="text-dark font-weight-medium" for="editor">Description</label>
      <div class="mb-3">       
        <!-- <client-only> -->
          <vue-editor :disabled="loading !== 'neutral'" v-model="description"></vue-editor>
        <!-- </client-only> -->
      </div>

      <button v-if="loading === 'neutral'" type="submit" class="  btn btn-primary mb-4" :disabled="disable"> Create</button>
      <button v-else-if="loading === 'loading'" disabled class="buttonload btn btn-primary">Loading.. <i class=" ml-2 fa fa-circle-o-notch fa-spin fa-1x"></i></button>
      <button v-else-if="loading === 'loaded'" disabled class="buttonload btn btn-primary">Done <i class=" ml-2 fa fa-check fa-1x"></i></button>
    </form>
  </div>
</template>

<script>
  import axios from 'axios'
  import { VueEditor, Quill } from "vue2-editor";

  export default {
    components: {
      VueEditor
    },
    props: {
      business:{
      type: String,
      required: true,
      },
      categories:{
      type: Array,
      required: true,
      },
    },
    data() {
      return {
        name:'',
        description:'',
        short_description:'',
        regular_price: '',
        sale_price: '',
        category: '',
        quantity: '',
        nameErrors: [],
        categoryErrors: [],
        sale_priceErrors: [],
        regular_priceErrors: [],
        quantityErrors: [],
        disable: false,
        button_clicked: false,
        loading: 'neutral',
        successful: false,
        failed: false
      }
    },
    methods: {
      handleSubmit() {
        this.nameErrors= [];
        this.categoryErrors= [];
        this.sale_priceErrors = [];
        this.regular_priceErrors = [];
        this.quantityErrors = [];
        this.checkErrors();
        this.button_clicked = true;
        this.loading = 'neutral';
        this.successful= false;
        this.failed= false;

        var data = {};
        if(this.button_clicked && this.nameErrors.length < 1 && this.categoryErrors.length < 1 && this.sale_priceErrors.length < 1 && this.regular_priceErrors.length < 1 && this.quantityErrors.length < 1) {
          data = {
            name: this.name,
            description: this.description ,
            short_description: this.short_description ,
            category: this.category,
            regular_price: this.regular_price,
            sale_price: this.sale_price,
            quantity: this.quantity,
            business: this.business,
            type: 'save'
          }

          var url = '';
          url = '/products/'+this.business
          
          this.loading = 'loading';
          axios.post(url, data)
          .then(response => {
            console.log(response.status)
            if(response.status === 201) {
              this.loading = 'loaded';
              setTimeout(() => this.successful= true, 500);
              setTimeout(() => window.location.replace("/products"), 2000);
            }else if(response.status == 200) {
              setTimeout(() => {
                Alt.alternative({
                  status:'error',
                  title:'Error!!',
                  text:"Product quantity can't be less than 1"
                })
              },200)
              this.loading = 'neutral';
              this.disable = false;
            }
            })
          .catch(error => {
              console.log(error.response)
              this.failed = true;
              setTimeout(() => {
                this.loading = 'neutral';
                this.disable = false;
              }, 1000);
          })
        } 
      
      },
      disabling(field, fieldError) {
        this.disable;
        if( fieldError.length > 0) {
          if(field.length > 0) {
            if(field === this.name) {
              this.nameErrors = [];
            } else if(field === this.category) {
              this.categoryErrors= [];
            } else if(field === this.regular_price) {
              this.regular_priceErrors= [];
            } else if(field === this.sale_price) {
              this.sale_priceErrors= [];
            }else if(field === this.quantity) {
              this.quantityErrors= [];
            }

          if(this.button_clicked && this.nameErrors.length < 1 && this.categoryErrors.length < 1 && this.sale_priceErrors.length < 1 && this.regular_priceErrors.length < 1 && this.quantityErrors.length < 1) {
            this.disable = false;
          }
            
          } else if(field === ''){
            this.disable = true;
          }
        }
      },
      emptyField() {
        
        if (this.button_clicked) {
          this.checkErrors();
          if(this.button_clicked && this.nameErrors.length < 1 && this.categoryErrors.length < 1 && this.sale_priceErrors.length < 1 && this.regular_priceErrors.length < 1 && this.quantityErrors.length < 1) {
            this.disable = false;
          }
        }
        
      },
      checkErrors() {
          // check name error
        if(this.name.length < 1) {
          if(this.nameErrors.length > 0){
            this.nameErrors[this.nameErrors.length - 1] = 'Name is required';
          } else {
            this.nameErrors.push('Name is required ');
          }        
        } else{
          this.nameErrors = [];
        }
        
        // check category error
        if(this.category.length < 1) {
          if(this.categoryErrors.length > 0){
            this.categoryErrors[this.categoryErrors.length - 1] = 'Product category is required ';
          } else {
            this.categoryErrors.push('Product category is required');
          }
        } else {
          this.categoryErrors = [];
        }

        // Check regular price error
        if(this.regular_price.length < 1) {
          if(this.regular_priceErrors.length > 0){
            this.regular_priceErrors[this.regular_priceErrors.length - 1] = 'Regular price is required';
          } else {
            this.regular_priceErrors.push('Regular price is required ');
          }
        } else{
          this.regular_priceErrors = [];
        }

        // Check sale price error
        if(this.sale_price.length > 0) {
          if(parseInt(this.sale_price) > parseInt(this.regular_price)) {      
            if(this.sale_priceErrors.length > 0){
              this.sale_priceErrors[this.sale_priceErrors.length - 1] = 'Sale price cannot be higher than the regular price';
            } else {
              this.sale_priceErrors.push('Sale price cannot be higher than the regular price');
            }
          }
        } else{
          this.sale_priceErrors = [];
        }

        // Check quantity error
        if(this.quantity.length < 1) {
          if(this.quantityErrors.length > 0){
            this.quantityErrors[this.quantityErrors.length - 1] = 'Product Quantity is required';
          } else {
            this.quantityErrors.push('Product Quantity is required ');
          }
        }else if(this.quantity.length > 0){
          if (/\D/.test(this.quantity)) {
            if(this.quantityErrors.length > 0){
              this.quantityErrors[this.quantityErrors.length - 1] = 'Product Quantity must be numbers only.';
            } else {
              this.quantityErrors.push('Product Quantity must be numbers only.');
            }
          } else{
            this.quantityErrors = [];
          }
        }

        this.disable = true;
      }
    }
  }
</script>


