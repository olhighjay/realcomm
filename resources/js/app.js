/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require("vue").default;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// REUSABLE
Vue.component('custom-pagination', require('./components/reusable/PaginationComponent.vue').default);
Vue.component('search', require('./components/reusable/SearchComponent.vue').default);
Vue.component('price-filter', require('./components/reusable/PriceFilterComponent.vue').default);
Vue.component('showonpage', require('./components/reusable/ShowOnPageComponent.vue').default);
Vue.component('sorting', require('./components/reusable/SortingByComponent.vue').default);
Vue.component('element-overlay', require('./components/reusable/ElementOverlayComponent.vue').default);
Vue.component('full-element-overlay', require('./components/reusable/FullElementOverlayComponent.vue').default);
Vue.component('comp-element-overlay', require('./components/reusable/FullComponentElementOverlayComponent.vue').default);
Vue.component('footer-component', require('./components/reusable/FooterComponent.vue').default);

// ADMIN
Vue.component('admin-reg-component', require('./components/admin/AdminRegComponent.vue').default);
Vue.component('admin-edit-component', require('./components/admin/AdminEditComponent.vue').default);
Vue.component('admin-table-component', require('./components/admin/AdminTableComponent.vue').default);
Vue.component('filtering', require('./components/admin/AdminFilterByComponent.vue').default);
Vue.component('admin-pagination', require('./components/admin/AdminPaginationComponent.vue').default);


// VENDOR
Vue.component('vendor-table-component', require('./components/vendor/VendorTableComponent.vue').default);
Vue.component('vendor-registration', require('./components/vendor/VendorRegComponent.vue').default);
Vue.component('vendor-edit', require('./components/vendor/VendorEditComponent.vue').default);
Vue.component('vendor-status-filter', require('./components/vendor/VendorStatusFilterComponent.vue').default);
Vue.component('vendor-gender-filter', require('./components/vendor/VendorGenderFilterComponent.vue').default);
Vue.component('vendor-state-filter', require('./components/vendor/VendorStateFilterComponent.vue').default);
Vue.component('vendor-pagination', require('./components/vendor/VendorPaginationComponent.vue').default);


// BUYER
Vue.component('buyer-registration', require('./components/buyer/BuyerRegComponent.vue').default);
Vue.component('buyer-edit', require('./components/buyer/BuyerEditComponent.vue').default);
Vue.component('buyer-table-component', require('./components/buyer/BuyerTableComponent.vue').default);
Vue.component('buyer-status-filter', require('./components/buyer/BuyerStatusFilterComponent.vue').default);
Vue.component('buyer-role-filter', require('./components/buyer/BuyerRoleFilterComponent.vue').default);
Vue.component('buyer-gender-filter', require('./components/buyer/BuyerGenderFilterComponent.vue').default);
Vue.component('buyer-state-filter', require('./components/buyer/BuyerStateFilterComponent.vue').default);
Vue.component('buyer-pagination', require('./components/buyer/BuyerPaginationComponent.vue').default);


// BUSINESS CATEGORY
Vue.component('bc-reg-component', require('./components/business-category/BCRegComponent.vue').default);
Vue.component('bc-edit-component', require('./components/business-category/BCEditComponent.vue').default);
Vue.component('bc-table-component', require('./components/business-category/BCTableComponent.vue').default);
Vue.component('bc-filter', require('./components/business-category/BCFilterByComponent.vue').default);
Vue.component('bc-pagination', require('./components/business-category/BCPaginationComponent.vue').default);



// BUSINESS
Vue.component('business-reg-component', require('./components/business/BusinessRegComponent.vue').default);
Vue.component('business-edit-component', require('./components/business/BusinessEditComponent.vue').default);
Vue.component('business-table-component', require('./components/business/BusinessTableComponent.vue').default);
Vue.component('business-status-filter', require('./components/business/BusinessStatusFilterComponent.vue').default);
Vue.component('business-category-filter', require('./components/business/BusinessCategoryFilterComponent.vue').default);
Vue.component('business-pagination', require('./components/business/BusinessPaginationComponent.vue').default);


// SUBSCRIPTION
Vue.component('sub-reg-component', require('./components/subscription/SubRegComponent.vue').default);
Vue.component('sub-edit-component', require('./components/subscription/SubEditComponent.vue').default);
Vue.component('sub-table-component', require('./components/subscription/SubTableComponent.vue').default);
Vue.component('sub-filter', require('./components/subscription/SubFilterByComponent.vue').default);
Vue.component('sub-pagination', require('./components/subscription/SubPaginationComponent.vue').default);



// PRODUCT
Vue.component('product-reg-component', require('./components/product/ProductRegComponent.vue').default);
Vue.component('product-edit-component', require('./components/product/ProductEditComponent.vue').default);
Vue.component('product-table-component', require('./components/product/ProductTableComponent.vue').default);
Vue.component('product-status-filter', require('./components/product/ProductStatusFilterComponent.vue').default);
Vue.component('product-stock-status-filter', require('./components/product/ProductStockStatusFilterComponent.vue').default);
Vue.component('product-category-filter', require('./components/product/ProductCategoryFilterComponent.vue').default);
Vue.component('product-pagination', require('./components/product/ProductPaginationComponent.vue').default);


// PRODUCT CATEGORY
Vue.component('pc-reg-component', require('./components/product-category/PCRegComponent.vue').default);
Vue.component('pc-edit-component', require('./components/product-category/PCEditComponent.vue').default);
Vue.component('pc-table-component', require('./components/product-category/PCTableComponent.vue').default);
Vue.component('pc-filter', require('./components/product-category/PCFilterByComponent.vue').default);
Vue.component('pc-pagination', require('./components/product-category/PCPaginationComponent.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    
});
