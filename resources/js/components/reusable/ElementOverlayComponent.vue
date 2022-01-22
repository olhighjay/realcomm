<template>
      <div class="element-overlay" style="text-align:center"><h3 class="element-overlay-text" style="color:#000">Processing..</h3></div>
</template>

<style >
  .element-overlay{
  position: absolute;
    top:0px;
    right:0px;
    width:100%;
    height:100%;
    background-color:#ffffff;
    /* background-image:url('ajax-loader.gif'); */
    background-size: 50px;
    background-repeat:no-repeat;
    background-position:center;
    z-index:99;
    opacity: 0.4;
    filter: alpha(opacity=40);
  }
  .element-overlay-text{
    /* margin: auto; */
    left: 50%;
      position: absolute;
      top: 50%;
      transform: translate(-50%, -50%);
      z-index:1000;
      
  }
</style>