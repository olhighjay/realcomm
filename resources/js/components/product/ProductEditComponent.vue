<template>
  <div>
      <div v-if="successful" class="alert alert-success alert-highlighted " role="alert">
        You have successfully update this business
      </div>
      <div v-if="failed" class="alert alert-danger alert-highlighted" role="alert">
          Server Error!.. Unable to complete your request.
      </div>
      <form @submit.prevent="handleSubmit" @change="emptyField()">
        <div class="form-group row justify-content-center">
        <div class="channel-avatar">
          <img v-if="imageUrl !== ''" :src="imageUrl" class="image">
          <span v-else-if="logo !== null" ><img :src="'/images/business_logo/thumbnail/'+logo" alt="" class="image"></span>
          <img v-else :src="'/assets/app/img/logo-word.png'" alt="" class="image">
          <div onclick="document.getElementById('image').click()" class="channel-avatar-overlay" >
            <span class="icon" title="User Profile">
              <span class="mdi mdi-camera"></span>
            </span>   
          </div>
        </div>
      </div>
      <input @change="onImagePicked" class="d-none" id="image" type="file" name="logo" accept="image/*">

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

      <label class="text-dark font-weight-medium" for="editor">Description</label>
      <div class="mb-3">       
        <!-- <client-only> -->
          <vue-editor v-model="description"></vue-editor>
        <!-- </client-only> -->
      </div>

      <!-- <label class="text-dark font-weight-medium" for="vendor">Vendor</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-source-commit-start"></i> 
              </span>
          </div>
          <select :disabled="loading !== 'neutral'" class="form-control" id="vendor" v-model="vendor"  :class="{'is-invalid' : vendorErrors.length > 0, 'is-inv' : vendorErrors.length > 0}"  @change="disabling(vendor, vendorErrors )">
            <option disabled value="">Select Vendor</option>
            <option v-for="vendor in vendors" :key="vendor.id" :value="vendor.id">{{vendor.first_name + ' ' + vendor.last_name}}</option>
          </select>
      </div>
      <ul v-if="vendorErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="vendorError in vendorErrors" :key="vendorError" class="form-error"> {{ vendorError }}</li>
      </ul> -->

      <label class="text-dark font-weight-medium" for="category">Business Category</label>
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

      <label class="text-dark font-weight-medium" for="subscription">Subscription</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-package-variant-closed"></i> 
              </span>
          </div>
          <select :disabled="loading !== 'neutral'" class="form-control" id="subscription" v-model="subscription"  :class="{'is-invalid' : subscriptionErrors.length > 0, 'is-inv' : subscriptionErrors.length > 0}"  @change="disabling(subscription, subscriptionErrors )">
            <option disabled value="">Select Subscription</option>
            <option v-for="subscription in subscriptions" :key="subscription.id" :value="subscription.id">{{subscription.name}}</option>
          </select>
      </div>
      <ul v-if="subscriptionErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="subscriptionError in subscriptionErrors" :key="subscriptionError" class="form-error"> {{ subscriptionError }}</li>
      </ul>

      <label class="text-dark font-weight-medium" for="bank_name">Bank Name</label>
      <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="mdi mdi-account"></i>
            </span>
        </div>
        <input :disabled="loading !== 'neutral'" id="bank_name" name="bank_name" type="text" placeholder="Access bank" aria-label="bank_name" v-model="bank_name" class="form-control">
      </div>
      
      <label class="text-dark font-weight-medium" for="account_name">Account Name</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-account"></i>
              </span>
          </div>
          <input :disabled="loading !== 'neutral'" id="account_name" name="account_name" type="text" class="form-control" placeholder="James John Jamiu" aria-label="account_name" v-model="account_name" >
      </div>

      <label class="text-dark font-weight-medium" for="account_number">Account Number</label>
      <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="mdi mdi-barcode"></i>
            </span>
        </div>
        <input :disabled="loading !== 'neutral'" id="account_number" name="account_number" type="text" :class="{'is-invalid' : accountNumberErrors.length > 0, 'is-inv' : accountNumberErrors.length > 0, 'form-control':true }" placeholder="0124990358" aria-label="account_number" v-model="account_number" @input="disabling(account_number, accountNumberErrors )">
      </div>
      <ul v-if="accountNumberErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="accountNumberError in accountNumberErrors" :key="accountNumberError" class="form-error" > {{ accountNumberError   }}</li>
      </ul>

      <button v-if="loading === 'neutral'" type="submit" class="  btn btn-primary mb-4" :disabled="disable"> Update</button>
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
      id: {
        required: true,
        default: () => ('')
      },
      // vendors:{
      // type: Array,
      // required: true,
      // },
      categories:{
      type: Array,
      required: true,
      },
      subscriptions:{
      type: Array,
      required: true,
      }
    },
    data() {
      return {
        business: {},
        name:'',
        description:'',
        // vendor:'',
        category: '',
        subscription: '',
        account_number: '',
        account_name: '',
        bank_name: '',
        nameErrors: [],
        // vendorErrors: [],
        categoryErrors: [],
        subscriptionErrors: [],
        accountNumberErrors: [],
        disable: false,
        button_clicked: false,
        loading: 'neutral',
        successful: false,
        failed: false,
        imageUrl: '', 
        logo: null
      }
    },
    mounted() {
      this.loadBusiness();
    },
    methods: {
      loadBusiness() {
        axios.get('/businesses/'+this.id+'?edit=true')
        .then(res => {
          this.business = res.data.business;
          // console.log(this.business.logo);
          this.name = this.business.name
          this.description = this.business.description
          // this.vendor = this.business.user_id
          this.category = this.business.business_category_id
          this.subscription = this.business.subscription_id
          this.account_number = this.business.bank_account_number
          this.account_name = this.business.bank_account_name
          this.bank_name = this.business.bank_name
          this.logo = this.business.logo
          // console.log(this.account_number);
        })
      },
      onImagePicked (event) {
        const files = event.target.files
        let filename = files[0].name
        const fileReader = new FileReader()
        fileReader.onload = e => {
          this.imageUrl = e.target.result;
        };
        fileReader.readAsDataURL(files[0])
        this.logo = files[0]
      },
      handleSubmit() {
        this.nameErrors= [];
        // this.vendorErrors = [];
        this.categoryErrors= [];
        this.subscriptionErrors = [];
        this.accountNumberErrors = [];
        this.checkErrors();
        this.button_clicked = true;
        this.loading = 'neutral';
        this.successful= false;
        this.failed= false;

        if(this.button_clicked && this.nameErrors.length < 1 && this.categoryErrors.length < 1 && this.subscriptionErrors.length < 1 && this.accountNumberErrors.length < 1) {

          var url = '';
          url = '/businesses/'+this.id+'/edit'
          
          this.loading = 'loading';
          const config = {
          headers: {
          'content-type': 'multipart/form-data',
          // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          }
        }
          // form data
        let formData = new FormData();
        if(this.logo){
          formData.append('logo', this.logo);
        }
        formData.append('name', this.name);
        this.description !== null ? formData.append('description', this.description): '';
        // formData.append('vendor', this.vendor);
        formData.append('category', this.category);
        formData.append('subscription', this.subscription);
        this.bank_name !== null ? formData.append('bank_name', this.bank_name): '';
        this.account_name !== null ? formData.append('account_name', this.account_name): '';
        this.account_number !== null ? formData.append('account_number', this.account_number): '';
        formData.append('type', 'save');
        // send upload request
        axios.post(url, formData, config)
          .then(response => {
            console.log(response.status)
            if(response.status === 200) {
              this.loading = 'loaded';
              setTimeout(() => this.successful= true, 500);
              setTimeout(() => window.location.replace("/businesses"), 2000);
            }else{
              setTimeout(() => {
                Alt.alternative({
                  status:'error',
                  title:'Error!!',
                  text:'There was something wrong with your request'
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
            // } else if(field === this.vendor){
            //   this.vendorErrors = [];
            } else if(field === this.category) {
              this.categoryErrors= [];
            } else if(field === this.subscription) {
              this.subscriptionErrors= [];
            } else if(field === this.account_number) {
              this.accountNumberErrors= [];
            }

            // if(this.nameErrors.length < 1 && this.vendorErrors.length < 1 && this.categoryErrors.length < 1 && this.subscriptionErrors.length < 1 && this.accountNumberErrors.length < 1) {
            if(this.nameErrors.length < 1 && this.categoryErrors.length < 1 && this.subscriptionErrors.length < 1 && this.accountNumberErrors.length < 1) {
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
            if(this.nameErrors.length < 1 && this.categoryErrors.length < 1 && this.subscriptionErrors.length < 1 && this.accountNumberErrors.length < 1) {
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

        // Check vendor error
        // if(this.vendor.length < 1) {
        //   if(this.vendorErrors.length > 0){
        //     this.vendorErrors[this.vendorErrors.length - 1] = 'vendor is required';
        //   } else {
        //     this.vendorErrors.push('vendor is required ');
        //   }
        // } else{
        //   this.vendorErrors = [];
        // }

        // check category error
        if(this.category.length < 1) {
          if(this.categoryErrors.length > 0){
            this.categoryErrors[this.categoryErrors.length - 1] = 'Business category is required ';
          } else {
            this.categoryErrors.push('Business category is required');
          }
        } else {
          this.categoryErrors = [];
        }

        // Check subscription error
        if(this.subscription.length < 1) {
          if(this.subscriptionErrors.length > 0){
            this.subscriptionErrors[this.subscriptionErrors.length - 1] = 'Subscription is required';
          } else {
            this.subscriptionErrors.push('Subscription is required ');
          }
        } else{
          this.subscriptionErrors = [];
        }

        // Check account number error
        if(this.account_number && this.account_number.length > 0){
          if (/\D/.test(this.account_number)) {
            if(this.accountNumberErrors.length > 0){
              this.accountNumberErrors[this.accountNumberErrors.length - 1] = 'Account number must be numbers only.';
            } else {
              this.accountNumberErrors.push('Account number must be numbers only.');
            }
          } else{
            this.accountNumberErrors = [];
          }
        }

        this.disable = true;
      }
    }
  }
</script>



